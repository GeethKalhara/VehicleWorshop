/// <reference types="bun" />
/// <reference types="node" />

/**
 * resources build pipeline
 * ------------------------
 * Builds css, ts and static/ into assets for the browser, and writes a
 * manifest PHP's Assets uses to map source paths to hashed files.
 *
 *    web/resources  =>  web/public/assets/
 *                     + web/resources/build/assets.json
 *
 *    css/staff.css        => staff-x4j2av4s.css
 *    static/img/logo.png  => static/img/logo-k3j9x2a1.png
 *
 * static/ is hashed and copied as-is; it never goes through the bundler.
 * Images and fonts imported from CSS/TS are emitted by Bun under media/.
 *
 * Usage:
 *    bun run web/resources/build.config.ts                  production
 *    bun run web/resources/build.config.ts --dev            development (readable, source maps)
 *    bun run web/resources/build.config.ts --dev --watch    rebuild on every change
 */
import type { BuildOutput } from 'bun';
import { watch as watchfs } from 'fs';
import { mkdir, readdir, rename, rm } from 'fs/promises';
import { dirname, join, relative, resolve } from 'path';
import rawentrypoints from './entrypoints.json';

const entries = new Set<string>(rawentrypoints);
const flags = {
   dev: process.argv.includes('--dev'),
   watch: process.argv.includes('--watch'),
};

const srcdir = import.meta.dir;                              // web/resources
const outdir = join(srcdir, '../public/assets');             // served by Caddy at /assets/
const manifestout = join(srcdir, 'build/assets.json');       // read by PHP, never served

/**
 * Hashes and copies {srcdir}/static/ into {outdir}/static/, adding each file to the manifest.
 * Returns the paths written (or already present with the same hash).
 */
async function copyStatic(srcdir: string, outdir: string, manifest: Record<string, string>): Promise<Set<string>> {
   const produced = new Set<string>();
   const dirents = await readdir(join(srcdir, 'static'), { recursive: true, withFileTypes: true })
      .catch(e => { if (e.code === 'ENOENT') return []; throw e; });

   for (const dirent of dirents) {
      if (!dirent.isFile())
         continue;

      const src = join(dirent.parentPath, dirent.name);
      const rel = relative(srcdir, src);                        // static/img/logo.png
      const bytes = await Bun.file(src).bytes();
      const hash = Bun.hash(bytes).toString(36).slice(0, 8);
      const out = rel.replace(/(\.[^./]+)?$/, `-${hash}$1`);    // static/img/logo-k3j9x2a1.png
      const dest = join(outdir, out);

      if (!(await Bun.file(dest).exists()))                     // hash in the name: same name, same bytes
         await Bun.write(dest, bytes);

      manifest[rel] = out;
      produced.add(dest);
   }
   return produced;
}

/**
 * Maps each entry point (relative to srcdir) to its output file.
 * Lazy import() modules have an entryPoint too, but aren't in entries, so they're skipped.
 */
function createManifest(result: BuildOutput, srcdir: string, entries: Set<string>): Record<string, string> {
   const manifest: Record<string, string> = {};
   for (const [file, output] of Object.entries(result.metafile!.outputs)) {
      if (!output.entryPoint)
         continue;                                              // shared chunk
      const source = relative(srcdir, resolve(process.cwd(), output.entryPoint));
      if (entries.has(source))
         manifest[source] = file.replace(/^\.\//, '');
   }
   return manifest;
}

/** Builds everything and writes the manifest. Returns the files produced, or null on failure. */
async function build(srcdir: string, outdir: string, manifestout: string): Promise<Set<string> | null> {
   const started = performance.now();

   const result = await Bun.build({
      root: srcdir,
      entrypoints: [...entries].map(e => join(srcdir, e)),
      outdir,
      target: 'browser',
      format: 'esm',
      splitting: true,
      minify: !flags.dev,
      naming: {
         entry: '[name]-[hash].[ext]',
         chunk: 'chunks/[hash].[ext]',                          // a shared chunk's name is just whichever entry Bun saw first
         asset: 'media/[name]-[hash].[ext]',
      },
      sourcemap: flags.dev ? 'external' : 'none',
      define: { __DEV__: JSON.stringify(flags.dev) },
      loader: {
         '.png': 'file', '.jpg': 'file', '.jpeg': 'file', '.webp': 'file',
         '.gif': 'file', '.svg': 'file', '.ico': 'file', '.woff2': 'file',
         '.txt': 'text',
      },
      publicPath: '/assets/',
      metafile: true,
      drop: flags.dev ? [] : ['console', 'debugger'],
      throw: false,
   });

   if (!result.success) {
      for (const log of result.logs)
         console.error(log);
      return null;
   }

   const manifest = createManifest(result, srcdir, entries);
   const produced = await copyStatic(srcdir, outdir, manifest);
   for (const output of result.outputs)
      produced.add(output.path);

   // Write then rename: PHP never reads a half-written file
   await mkdir(dirname(manifestout), { recursive: true });
   await Bun.write(`${manifestout}.tmp`, JSON.stringify(manifest, null, 2));
   await rename(`${manifestout}.tmp`, manifestout);

   console.log(`Built in ${Math.round(performance.now() - started)} ms`);
   return produced;
}

/** Deletes every file under outdir that isn't in keep. */
async function prune(outdir: string, keep: Set<string>): Promise<void> {
   const dirents = await readdir(outdir, { recursive: true, withFileTypes: true });
   await Promise.all(dirents
      .filter(d => d.isFile())
      .map(d => join(d.parentPath, d.name))
      .filter(file => !keep.has(file))
      .map(file => rm(file, { force: true })));
}

/**
 * Rebuilds on every change under srcdir.
 *
 * Saves arriving within 50 ms become one rebuild; a change during a build
 * triggers exactly one more build after it. The previous build's files are
 * kept for one more round, so a page loaded just before a rebuild still works.
 */
async function watch(build: () => Promise<Set<string> | null>): Promise<void> {
   let previous = new Set<string>();
   let building = false;
   let pending = false;
   let timer: Timer | undefined;

   async function rebuild(): Promise<void> {
      if (building) {
         pending = true;
         return;
      }
      building = true;
      try {
         do {
            pending = false;
            const produced = await build();
            if (produced) {
               await prune(outdir, new Set([...previous, ...produced]));
               previous = produced;
            }
         } while (pending);
      } catch (e) {
         console.error(e);
      } finally {
         building = false;
      }
   }

   await rebuild();

   watchfs(srcdir, { recursive: true }, (_, filename) => {
      if (filename?.startsWith('build/'))                       // our own manifest write would retrigger forever
         return;
      clearTimeout(timer);
      timer = setTimeout(() => void rebuild(), 50);
   });

   console.log(`Watching ${srcdir} for changes…`);
}

// --- main --------------------------------------------------------------------

const run = () => build(srcdir, outdir, manifestout);

if (flags.watch) {
   await watch(run);
} else {
   const produced = await run();
   if (produced)
      await prune(outdir, produced);
   process.exit(produced ? 0 : 1);
}
