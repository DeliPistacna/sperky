import {Action} from "./action.js";
import {Animator} from "./animator.js";

document.addEventListener('DOMContentLoaded', () => {
    const target = '#items'; // Target <span>
    const animator = new Animator(target);
    const action = new Action('getWarehouseValue');
    const btn = document.querySelector('#action');

    // Register events
    btn.addEventListener('click', () => action.execute((value) => {
        // Show Response element
        document.querySelector(target).parentElement.classList.remove('hidden')

        // Start animator
        animator.countUp(value);
    }));
});






