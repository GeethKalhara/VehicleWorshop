import { initCarBackgroundAnimation} from "@/shared/background";
import { initPasswordToggle } from "@/shared/password-toggle";

console.log("We are in auth.php layout");

document.addEventListener('DOMContentLoaded', () => {
   initPasswordToggle();
   initCarBackgroundAnimation();
});
