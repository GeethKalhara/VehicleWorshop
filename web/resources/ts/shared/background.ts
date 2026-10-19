/**
 * Approaching-car background for the auth layout.
 * Canvas 2D, no dependencies.
 *
 * Returns a cleanup function that stops the loop and removes all listeners.
 */

type Particle = { x: number; y: number; z: number; speed: number };
type Point = readonly [number, number];

// Projection / world
const FOCAL = 320;
const FAR_Z = 1500;          // particle spawn depth
const CAR_RESET_Z = 1400;    // car respawn depth (horizon)
const CAR_END_Z = 30;        // car despawn depth (at camera)
const PARTICLE_COUNT = 70;

// Road dashes: DASH_COUNT dashes, DASH_SPACING apart, on a 0..1000 phase track.
// The offset wraps at DASH_SPACING so the pattern repeats seamlessly.
const DASH_COUNT = 18;
const DASH_SPACING = 55;

// Motion constants below were tuned per frame at 60 Hz; scale by elapsed time.
const FRAME_MS = 1000 / 60;
const MAX_STEP_MS = 50;      // clamp after tab switches / long stalls

// Car geometry in car-local units (scaled by perspective at draw time).
const CABIN: readonly Point[] = [[-32, -42], [-24, -65], [24, -65], [32, -42]];
const BODY: readonly Point[] = [
   [-60, -12], [-50, -30], [-34, -38], [34, -38], [50, -30],
   [60, -12], [55, 2], [40, 5], [-40, 5], [-55, 2],
];
const GRILLE: readonly Point[] = [[-28, -15], [28, -15], [24, 0], [-24, 0]];
const MIRROR_L: readonly Point[] = [[-36, -38], [-48, -40], [-44, -34]];
const MIRROR_R: readonly Point[] = [[36, -38], [48, -40], [44, -34]];

const clamp = (v: number, lo: number, hi: number): number => Math.min(Math.max(v, lo), hi);
const orange = (a: number): string => `rgba(249, 115, 22, ${a})`;

function tracePolygon(ctx: CanvasRenderingContext2D, pts: readonly Point[], s: number): void {
   ctx.beginPath();
   pts.forEach(([x, y], i) => (i === 0 ? ctx.moveTo(x * s, y * s) : ctx.lineTo(x * s, y * s)));
   ctx.closePath();
}

function spawnParticle(z: number): Particle {
   return {
      x: (Math.random() - 0.5) * 2000,
      y: (Math.random() - 0.5) * 1200,
      z,
      speed: Math.random() * 8 + 6,
   };
}

export function initCarBackgroundAnimation(): () => void {
   const canvas = document.getElementById('car-bg-canvas') as HTMLCanvasElement | null;
   const ctx = canvas?.getContext('2d');
   if (!canvas || !ctx) return () => {};
   return run(canvas, ctx);
}

function run(canvas: HTMLCanvasElement, ctx: CanvasRenderingContext2D): () => void {
   const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

   // Viewport (recomputed on resize)
   let width = 0;
   let height = 0;
   let vY = 0;
   let bgGrad!: CanvasGradient;
   let roadGrad!: CanvasGradient;

   // Animation state
   let rafId: number | null = null;
   let lastTime = 0;
   let time = 0;
   let mouseX = 0;
   let targetMouseX = 0;
   let dashOffset = 0;
   let carZ = 1300;
   const particles: Particle[] = Array.from(
      { length: PARTICLE_COUNT },
      () => spawnParticle(Math.random() * (FAR_Z - 50) + 50),
   );

   // ---------------------------------------------------------------- sizing

   function resize(): void {
      const dpr = Math.min(window.devicePixelRatio || 1, 2);
      width = window.innerWidth;
      height = window.innerHeight;
      vY = height * 0.44;

      // Setting width/height resets the context, so the transform is set here once
      // instead of save/scale/restore on every frame.
      canvas.width = Math.floor(width * dpr);
      canvas.height = Math.floor(height * dpr);
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

      // Gradients depend only on height; build them once per resize, not per frame.
      bgGrad = ctx.createLinearGradient(0, 0, 0, height);
      bgGrad.addColorStop(0, '#020617');
      bgGrad.addColorStop(0.5, '#0b1120');
      bgGrad.addColorStop(1, '#020617');

      roadGrad = ctx.createLinearGradient(0, vY, 0, height);
      roadGrad.addColorStop(0, 'rgba(15, 23, 42, 0.4)');
      roadGrad.addColorStop(1, 'rgba(30, 41, 59, 0.7)');

      // When not looping (reduced motion, hidden tab), repaint the static frame.
      if (rafId === null) draw();
   }

   // ---------------------------------------------------------------- update

   /** @param k elapsed time in 60 Hz frames */
   function update(k: number): void {
      time += 0.02 * k;
      mouseX += (targetMouseX - mouseX) * (1 - Math.pow(0.95, k));
      dashOffset = (dashOffset + 8 * k) % DASH_SPACING;

      for (const p of particles) {
         p.z -= p.speed * k;
         if (p.z <= 10) Object.assign(p, spawnParticle(FAR_Z));
      }

      carZ -= (carZ < 600 ? 6.5 : 4.2) * k;
      if (carZ <= CAR_END_Z) carZ = CAR_RESET_Z;
   }

   // ---------------------------------------------------------------- draw

   function draw(): void {
      ctx.fillStyle = bgGrad;
      ctx.fillRect(0, 0, width, height);

      const vX = width * 0.5 + mouseX * 0.3;
      drawRoad(vX);
      drawParticles(vX);
      drawCar(vX);
   }

   function drawRoad(vX: number): void {
      const bottomHalf = Math.max(width * 0.75, 500);
      const topHalf = 6;

      // Asphalt
      ctx.beginPath();
      ctx.moveTo(vX - topHalf, vY);
      ctx.lineTo(vX + topHalf, vY);
      ctx.lineTo(vX + bottomHalf, height);
      ctx.lineTo(vX - bottomHalf, height);
      ctx.closePath();
      ctx.fillStyle = roadGrad;
      ctx.fill();

      // Edge lines
      ctx.lineWidth = 1.5;
      ctx.strokeStyle = orange(0.35);
      ctx.beginPath();
      ctx.moveTo(vX - topHalf, vY);
      ctx.lineTo(vX - bottomHalf, height);
      ctx.moveTo(vX + topHalf, vY);
      ctx.lineTo(vX + bottomHalf, height);
      ctx.stroke();

      // Centre dashes (t^2.2 spacing fakes perspective)
      ctx.lineWidth = 2.5;
      for (let i = 0; i < DASH_COUNT; i++) {
         const t = (i * DASH_SPACING + dashOffset) / 1000;
         const y = vY + (height - vY) * Math.pow(t, 2.2);
         ctx.strokeStyle = `rgba(255, 255, 255, ${clamp((t - 0.1) / 0.9, 0, 0.6)})`;
         ctx.beginPath();
         ctx.moveTo(vX, y);
         ctx.lineTo(vX, y + 22 * t * t + 3);
         ctx.stroke();
      }
   }

   function drawParticles(vX: number): void {
      for (const p of particles) {
         const ps = FOCAL / p.z;
         const sx = vX + p.x * ps;
         const sy = vY + p.y * ps;
         if (sx < 0 || sx > width || sy < 0 || sy > height) continue;

         ctx.fillStyle = `rgba(251, 146, 60, ${clamp(1 - p.z / FAR_Z, 0, 0.5)})`;
         ctx.beginPath();
         ctx.arc(sx, sy, Math.max(ps * 1.8, 0.8), 0, Math.PI * 2);
         ctx.fill();
      }
   }

   function drawCar(vX: number): void {
      // NOTE: the car does not use the particle projection (FOCAL / z); its scale and
      // screen Y are hand-tuned curves. Kept as-is to preserve the current look.
      const s = FOCAL / (FOCAL + carZ);
      const progress = 1 - carZ / CAR_RESET_Z;   // 0 at horizon → ~1 at camera
      const carX = vX + Math.sin(time * 1.5) * 6 * progress + mouseX * 0.15;
      const carY = vY + (height - vY) * (1 - Math.pow(carZ / CAR_RESET_Z, 1.6)) * 0.92;
      const carAlpha = clamp((1 - carZ / FAR_Z) * 1.4, 0.2, 1);
      const lampY = -10 * s;
      const lampDX = 48 * s;

      // Headlight beams (world space)
      const beamAlpha = clamp(progress, 0.15, 0.75);
      const beamHalf = 220 * s * 0.6;
      const beamLength = 480 * s;
      for (const dx of [-lampDX, lampDX]) {
         const hX = carX + dx;
         const hY = carY + lampY;
         const g = ctx.createRadialGradient(hX, hY, 4 * s, hX, hY + beamLength * 0.6, beamLength);
         g.addColorStop(0, `rgba(255, 255, 255, ${beamAlpha * 0.85})`);
         g.addColorStop(0.2, orange(beamAlpha * 0.4));
         g.addColorStop(0.6, `rgba(251, 146, 60, ${beamAlpha * 0.12})`);
         g.addColorStop(1, orange(0));
         ctx.fillStyle = g;
         ctx.beginPath();
         ctx.moveTo(hX, hY);
         ctx.lineTo(hX - beamHalf, hY + beamLength);
         ctx.lineTo(hX + beamHalf, hY + beamLength);
         ctx.closePath();
         ctx.fill();
      }

      // Ground shadow (world space)
      const shadowW = 150 * s;
      const shadowGrad = ctx.createRadialGradient(carX, carY, 5, carX, carY, shadowW);
      shadowGrad.addColorStop(0, 'rgba(0, 0, 0, 0.9)');
      shadowGrad.addColorStop(1, 'rgba(0, 0, 0, 0)');
      ctx.fillStyle = shadowGrad;
      ctx.beginPath();
      ctx.ellipse(carX, carY + 4 * s, shadowW, 20 * s, 0, 0, Math.PI * 2);
      ctx.fill();

      // Body (car-local space)
      ctx.save();
      ctx.translate(carX, carY);

      // Cabin
      ctx.fillStyle = '#060a12';
      ctx.strokeStyle = orange(carAlpha * 0.85);
      ctx.lineWidth = Math.max(1.5 * s, 1);
      tracePolygon(ctx, CABIN, s);
      ctx.fill();
      ctx.stroke();

      // Windshield reflection
      ctx.strokeStyle = `rgba(255, 255, 255, ${carAlpha * 0.4})`;
      ctx.lineWidth = s;
      ctx.beginPath();
      ctx.moveTo(-20 * s, -62 * s);
      ctx.lineTo(12 * s, -45 * s);
      ctx.stroke();

      // Hood + lower body
      ctx.fillStyle = '#0f172a';
      ctx.strokeStyle = orange(carAlpha * 0.9);
      ctx.lineWidth = Math.max(2 * s, 1.2);
      tracePolygon(ctx, BODY, s);
      ctx.fill();
      ctx.stroke();

      // Grille
      ctx.fillStyle = '#030712';
      ctx.strokeStyle = `rgba(255, 255, 255, ${carAlpha * 0.25})`;
      ctx.lineWidth = s;
      tracePolygon(ctx, GRILLE, s);
      ctx.fill();
      ctx.stroke();

      // Emblem
      ctx.fillStyle = '#f97316';
      ctx.beginPath();
      ctx.arc(0, -7 * s, Math.max(3.5 * s, 1.5), 0, Math.PI * 2);
      ctx.fill();

      // Headlights: lens + DRL blade, with glow
      ctx.shadowColor = '#f97316';
      ctx.shadowBlur = 18 * s;
      ctx.fillStyle = '#ffffff';
      ctx.strokeStyle = '#fb923c';
      ctx.lineWidth = 2.5 * s;
      for (const dx of [-lampDX, lampDX]) {
         const dir = Math.sign(dx);   // -1 left, +1 right
         ctx.beginPath();
         ctx.ellipse(dx, lampY, 7 * s, 4 * s, dir * 0.2, 0, Math.PI * 2);
         ctx.fill();

         ctx.beginPath();
         ctx.moveTo(dx + dir * 14 * s, lampY - 4 * s);   // outer end, raised
         ctx.lineTo(dx - dir * 6 * s, lampY);            // inner end
         ctx.stroke();
      }
      ctx.shadowBlur = 0;

      // Mirrors
      ctx.fillStyle = '#0f172a';
      ctx.strokeStyle = orange(carAlpha * 0.7);
      ctx.lineWidth = 1.2 * s;
      for (const mirror of [MIRROR_L, MIRROR_R]) {
         tracePolygon(ctx, mirror, s);
         ctx.fill();
         ctx.stroke();
      }

      ctx.restore();
   }

   // ---------------------------------------------------------------- loop

   function frame(now: number): void {
      const k = clamp(now - lastTime, 0, MAX_STEP_MS) / FRAME_MS;
      lastTime = now;
      update(k);
      draw();
      rafId = requestAnimationFrame(frame);
   }

   // Exactly one loop can exist: start is a no-op while running.
   function start(): void {
      if (rafId !== null || reducedMotion) return;
      lastTime = performance.now();
      rafId = requestAnimationFrame(frame);
   }

   function stop(): void {
      if (rafId === null) return;
      cancelAnimationFrame(rafId);
      rafId = null;
   }

   // ---------------------------------------------------------------- wiring

   const onMouseMove = (e: MouseEvent): void => {
      targetMouseX = (e.clientX / window.innerWidth - 0.5) * 80;
   };
   const onVisibility = (): void => (document.hidden ? stop() : start());

   window.addEventListener('resize', resize);
   window.addEventListener('mousemove', onMouseMove, { passive: true });
   document.addEventListener('visibilitychange', onVisibility);

   resize();                         // also paints the first (or only) frame
   if (!document.hidden) start();

   return () => {
      stop();
      window.removeEventListener('resize', resize);
      window.removeEventListener('mousemove', onMouseMove);
      document.removeEventListener('visibilitychange', onVisibility);
   };
}
