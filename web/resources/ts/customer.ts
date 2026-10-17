// Entry point — compiled by Bun into public/assets/index.js.

import { createSSEClient } from "@flamefrontend/sse-runtime-core";

console.log("vwork .ts (.js) loaded");

type Events = {
   dummy: {
      message: string;
   }
}

const client = createSSEClient<Events>({
   key: ['greeting'],
   url: '/greeting',
   events: {
      dummy: (m) => {
         if (window.location.pathname === '/dummy') {
            var element = document.getElementById('msg')
            if (element !== null) {
               element.textContent = m.message;
            }
         }
      }
   },
   coordination: {
      enabled: true,
      mode: 'single-tab'
   }
});

client.connect();

// Customer Portal Initialization
document.addEventListener('DOMContentLoaded', () => {
   initPasswordToggle();
   initCarBackgroundAnimation();
});

/**
 * Password visibility toggle handler
 */
function initPasswordToggle(): void {
   const toggleBtn = document.getElementById('toggle-password');
   const passwordInput = document.getElementById('password') as HTMLInputElement | null;
   const eyeIcon = document.getElementById('eye-icon');
   const eyeOffIcon = document.getElementById('eye-off-icon');

   if (toggleBtn && passwordInput && eyeIcon && eyeOffIcon) {
      toggleBtn.addEventListener('click', () => {
         const isPassword = passwordInput.type === 'password';
         passwordInput.type = isPassword ? 'text' : 'password';
         eyeIcon.classList.toggle('hidden', isPassword);
         eyeOffIcon.classList.toggle('hidden', !isPassword);
      });
   }
}

/**
 * 3D Approaching Car Background Animation
 * Pure native HTML5 Canvas - 0 external dependencies.
 */
function initCarBackgroundAnimation(): void {
   const canvas = document.getElementById('car-bg-canvas') as HTMLCanvasElement | null;
   if (!canvas) return;

   const ctx = canvas.getContext('2d');
   if (!ctx) return;

   let width = 0;
   let height = 0;
   let dpr = 1;

   function resize(): void {
      if (!canvas) return;
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      width = window.innerWidth;
      height = window.innerHeight;
      canvas.width = Math.floor(width * dpr);
      canvas.height = Math.floor(height * dpr);
   }

   window.addEventListener('resize', resize);
   resize();

   // Mouse parallax
   let mouseX = 0;
   let targetMouseX = 0;
   window.addEventListener('mousemove', (e) => {
      targetMouseX = (e.clientX / window.innerWidth - 0.5) * 80;
   });

   // Speed particle field for 3D depth perception
   const particleCount = 70;
   const particles: Array<{ x: number; y: number; z: number; speed: number }> = [];
   for (let i = 0; i < particleCount; i++) {
      particles.push({
         x: (Math.random() - 0.5) * 2000,
         y: (Math.random() - 0.5) * 1200,
         z: Math.random() * 1500 + 50,
         speed: Math.random() * 8 + 6,
      });
   }

   // Car 3D state
   let carZ = 1300; // starts far away
   let carSpeed = 4.5;
   let roadOffset = 0;
   let time = 0;

   function render(): void {
      if (!ctx || !canvas) return;

      time += 0.02;
      mouseX += (targetMouseX - mouseX) * 0.05;

      // Clear with subtle dark blue fade
      ctx.save();
      ctx.scale(dpr, dpr);

      const grad = ctx.createLinearGradient(0, 0, 0, height);
      grad.addColorStop(0, '#020617'); // slate-950
      grad.addColorStop(0.5, '#0b1120');
      grad.addColorStop(1, '#020617');
      ctx.fillStyle = grad;
      ctx.fillRect(0, 0, width, height);

      const focalLength = 320;
      const vX = width * 0.5 + mouseX * 0.3;
      const vY = height * 0.44;

      // 1. Draw 3D Perspective Road & Grid
      const roadBottomWidth = Math.max(width * 0.75, 500);
      const roadTopWidth = 6;
      const roadBottomY = height;

      // Road asphalt surface
      ctx.beginPath();
      ctx.moveTo(vX - roadTopWidth, vY);
      ctx.lineTo(vX + roadTopWidth, vY);
      ctx.lineTo(vX + roadBottomWidth, roadBottomY);
      ctx.lineTo(vX - roadBottomWidth, roadBottomY);
      ctx.closePath();
      const roadGrad = ctx.createLinearGradient(0, vY, 0, roadBottomY);
      roadGrad.addColorStop(0, 'rgba(15, 23, 42, 0.4)');
      roadGrad.addColorStop(1, 'rgba(30, 41, 59, 0.7)');
      ctx.fillStyle = roadGrad;
      ctx.fill();

      // Road edge glowing lines (Orange/amber neon)
      ctx.lineWidth = 1.5;
      ctx.strokeStyle = 'rgba(249, 115, 22, 0.35)';
      ctx.beginPath();
      ctx.moveTo(vX - roadTopWidth, vY);
      ctx.lineTo(vX - roadBottomWidth, roadBottomY);
      ctx.moveTo(vX + roadTopWidth, vY);
      ctx.lineTo(vX + roadBottomWidth, roadBottomY);
      ctx.stroke();

      // Moving road markings (dashes)
      roadOffset = (roadOffset + 8) % 100;
      ctx.lineWidth = 2.5;
      for (let i = 0; i < 18; i++) {
         const t = ((i * 55 + roadOffset) % 1000) / 1000;
         const pY = vY + (roadBottomY - vY) * Math.pow(t, 2.2);
         const dashLen = 22 * t * t + 3;
         const alpha = Math.min(Math.max((t - 0.1) / 0.9, 0), 0.6);

         ctx.strokeStyle = `rgba(255, 255, 255, ${alpha})`;
         ctx.beginPath();
         ctx.moveTo(vX, pY);
         ctx.lineTo(vX, pY + dashLen);
         ctx.stroke();
      }

      // 2. Draw Speed Particles (Atmospheric Depth)
      for (const p of particles) {
         p.z -= p.speed;
         if (p.z <= 10) {
            p.z = 1500;
            p.x = (Math.random() - 0.5) * 2000;
            p.y = (Math.random() - 0.5) * 1200;
         }

         const pScale = focalLength / p.z;
         const sX = vX + p.x * pScale;
         const sY = vY + p.y * pScale;

         if (sX >= 0 && sX <= width && sY >= 0 && sY <= height) {
            const size = Math.max(pScale * 1.8, 0.8);
            const alpha = Math.min(Math.max((1 - p.z / 1500), 0), 0.5);
            ctx.fillStyle = `rgba(251, 146, 60, ${alpha})`;
            ctx.beginPath();
            ctx.arc(sX, sY, size, 0, Math.PI * 2);
            ctx.fill();
         }
      }

      // 3. Move & Draw Approaching 3D Car
      carZ -= carSpeed;
      // Gentle acceleration as it gets closer for dramatic perspective
      if (carZ < 600) {
         carSpeed = 6.5;
      }
      if (carZ <= 30) {
         // Reset seamlessly to horizon
         carZ = 1400;
         carSpeed = 4.2;
      }

      const carScale = focalLength / (focalLength + carZ);
      const swayX = Math.sin(time * 1.5) * 6 * (1 - carZ / 1400);
      const carX = vX + swayX + (mouseX * 0.15);
      const carY = vY + (roadBottomY - vY) * (1 - Math.pow(carZ / 1400, 1.6)) * 0.92;

      // Draw Volumetric Headlight Beams (casting across the ground towards viewer)
      const beamAlpha = Math.min(Math.max(1 - (carZ / 1400), 0.15), 0.75);
      const beamSpread = 220 * carScale;
      const beamLength = 480 * carScale;
      const headlightOffsetY = -10 * carScale;
      const headlightSpacing = 48 * carScale;

      // Left & Right Headlight Volumetric Cones
      [-headlightSpacing, headlightSpacing].forEach(offset => {
         const hX = carX + offset;
         const hY = carY + headlightOffsetY;

         const beamGrad = ctx.createRadialGradient(
            hX, hY, 4 * carScale,
            hX, hY + beamLength * 0.6, beamLength
         );
         beamGrad.addColorStop(0, `rgba(255, 255, 255, ${beamAlpha * 0.85})`);
         beamGrad.addColorStop(0.2, `rgba(249, 115, 22, ${beamAlpha * 0.4})`);
         beamGrad.addColorStop(0.6, `rgba(251, 146, 60, ${beamAlpha * 0.12})`);
         beamGrad.addColorStop(1, 'rgba(249, 115, 22, 0)');

         ctx.save();
         ctx.beginPath();
         ctx.moveTo(hX, hY);
         ctx.lineTo(hX - beamSpread * 0.6, hY + beamLength);
         ctx.lineTo(hX + beamSpread * 0.6, hY + beamLength);
         ctx.closePath();
         ctx.fillStyle = beamGrad;
         ctx.fill();
         ctx.restore();
      });

      // Car Ground Shadow
      const shadowW = 150 * carScale;
      const shadowH = 20 * carScale;
      const shadowGrad = ctx.createRadialGradient(carX, carY, 5, carX, carY, shadowW);
      shadowGrad.addColorStop(0, 'rgba(0, 0, 0, 0.9)');
      shadowGrad.addColorStop(1, 'rgba(0, 0, 0, 0)');
      ctx.fillStyle = shadowGrad;
      ctx.beginPath();
      ctx.ellipse(carX, carY + 4 * carScale, shadowW, shadowH, 0, 0, Math.PI * 2);
      ctx.fill();

      // 4. Car Body 3D Silhouette & Cyber/Sports Lines
      ctx.save();
      ctx.translate(carX, carY);

      const s = carScale;
      const carAlpha = Math.min(Math.max((1 - carZ / 1500) * 1.4, 0.2), 1);

      // Body Silhouette - Main Frame
      ctx.fillStyle = '#090d16';
      ctx.strokeStyle = `rgba(249, 115, 22, ${carAlpha * 0.85})`;
      ctx.lineWidth = Math.max(1.5 * s, 1);

      // Cabin / Windshield
      ctx.beginPath();
      ctx.moveTo(-32 * s, -42 * s);
      ctx.lineTo(-24 * s, -65 * s); // Roof pillar left
      ctx.lineTo(24 * s, -65 * s);  // Roof top
      ctx.lineTo(32 * s, -42 * s);  // Roof pillar right
      ctx.closePath();
      ctx.fillStyle = '#060a12';
      ctx.fill();
      ctx.stroke();

      // Windshield glass reflection highlight
      ctx.strokeStyle = `rgba(255, 255, 255, ${carAlpha * 0.4})`;
      ctx.lineWidth = 1 * s;
      ctx.beginPath();
      ctx.moveTo(-20 * s, -62 * s);
      ctx.lineTo(12 * s, -45 * s);
      ctx.stroke();

      // Hood & Lower Body
      ctx.fillStyle = '#0f172a';
      ctx.strokeStyle = `rgba(249, 115, 22, ${carAlpha * 0.9})`;
      ctx.lineWidth = Math.max(2 * s, 1.2);
      ctx.beginPath();
      ctx.moveTo(-60 * s, -12 * s); // left wheel arch
      ctx.lineTo(-50 * s, -30 * s); // left fender
      ctx.lineTo(-34 * s, -38 * s); // hood left
      ctx.lineTo(34 * s, -38 * s);  // hood right
      ctx.lineTo(50 * s, -30 * s);  // right fender
      ctx.lineTo(60 * s, -12 * s);  // right wheel arch
      ctx.lineTo(55 * s, 2 * s);    // right bumper
      ctx.lineTo(40 * s, 5 * s);    // right front splitter
      ctx.lineTo(-40 * s, 5 * s);   // left front splitter
      ctx.lineTo(-55 * s, 2 * s);   // left bumper
      ctx.closePath();
      ctx.fill();
      ctx.stroke();

      // Front Honeycomb Grille
      ctx.fillStyle = '#030712';
      ctx.beginPath();
      ctx.moveTo(-28 * s, -15 * s);
      ctx.lineTo(28 * s, -15 * s);
      ctx.lineTo(24 * s, 0 * s);
      ctx.lineTo(-24 * s, 0 * s);
      ctx.closePath();
      ctx.fill();
      ctx.strokeStyle = `rgba(255, 255, 255, ${carAlpha * 0.25})`;
      ctx.lineWidth = 1 * s;
      ctx.stroke();

      // AutoCare Center Emblem (Minimal Glowing Orange Glyph)
      ctx.fillStyle = '#f97316';
      ctx.beginPath();
      ctx.arc(0, -7 * s, Math.max(3.5 * s, 1.5), 0, Math.PI * 2);
      ctx.fill();

      // Twin Aggressive LED DRL Headlights (Intense Glow)
      [-headlightSpacing, headlightSpacing].forEach(side => {
         // Headlight Housing
         ctx.save();
         ctx.shadowColor = '#f97316';
         ctx.shadowBlur = 18 * s;

         // Bright LED projector lens
         ctx.fillStyle = '#ffffff';
         ctx.beginPath();
         ctx.ellipse(side, headlightOffsetY, 7 * s, 4 * s, side > 0 ? 0.2 : -0.2, 0, Math.PI * 2);
         ctx.fill();

         // LED daytime running light wing (DRL blade)
         ctx.strokeStyle = '#fb923c';
         ctx.lineWidth = 2.5 * s;
         ctx.beginPath();
         if (side < 0) {
            ctx.moveTo(side - 14 * s, headlightOffsetY - 4 * s);
            ctx.lineTo(side + 6 * s, headlightOffsetY);
         } else {
            ctx.moveTo(side - 6 * s, headlightOffsetY);
            ctx.lineTo(side + 14 * s, headlightOffsetY - 4 * s);
         }
         ctx.stroke();
         ctx.restore();
      });

      // Side Mirrors
      ctx.fillStyle = '#0f172a';
      ctx.strokeStyle = `rgba(249, 115, 22, ${carAlpha * 0.7})`;
      ctx.lineWidth = 1.2 * s;
      // Left mirror
      ctx.beginPath();
      ctx.moveTo(-36 * s, -38 * s);
      ctx.lineTo(-48 * s, -40 * s);
      ctx.lineTo(-44 * s, -34 * s);
      ctx.closePath();
      ctx.fill();
      ctx.stroke();
      // Right mirror
      ctx.beginPath();
      ctx.moveTo(36 * s, -38 * s);
      ctx.lineTo(48 * s, -40 * s);
      ctx.lineTo(44 * s, -34 * s);
      ctx.closePath();
      ctx.fill();
      ctx.stroke();

      ctx.restore(); // end car translate

      ctx.restore(); // end canvas scale

      // Smooth 60fps loop, pauses when tab is hidden
      if (!document.hidden) {
         requestAnimationFrame(render);
      }
   }

   // Pause animation when tab is inactive to preserve CPU / battery
   document.addEventListener('visibilitychange', () => {
      if (!document.hidden) {
         requestAnimationFrame(render);
      }
   });

   requestAnimationFrame(render);
}

