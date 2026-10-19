/**
 * Password visibility toggle handler
 */
export function initPasswordToggle(): void {
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
