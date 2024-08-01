export class Animator {
    constructor(elementSelector, animationTime = 500) {
        this.element = document.querySelector(elementSelector);
        this.currentValue = 0;
        this.targetValue = 0;
        this.animationTime = animationTime;
        this.animationFrame = null;
        this.incrementValue = null;
    }

    countUp(targetValue) {
        this.targetValue = targetValue;
        this.currentValue = 0;
        this.incrementValue = null;
        this.element.parentElement.style.overflow = 'hidden';
        this.updateDisplay();
        if (this.animationFrame) {
            clearInterval(this.animationFrame);
        }
        this.animationFrame = setInterval(() => this.animate(), this.getAnimationInterval());
    }

    // Method to handle the animation step
    animate() {
        if (this.currentValue < this.targetValue) {
            this.currentValue = Math.min(this.currentValue + this.getIncrementValue(), this.targetValue);
            this.updateDisplay();
        } else {
            clearInterval(this.animationFrame);
        }
    }

    // Method to update the display element
    updateDisplay() {
        this.element.textContent = new Intl.NumberFormat('sk-SK', {style: 'currency', currency: 'EUR'}).format(
            this.currentValue,
        );
    }

    getAnimationInterval() {
        return Math.floor(this.animationTime / this.targetValue);
    }

    getIncrementValue() {
        if (this.incrementValue) {
            return this.incrementValue;
        }
        return this.incrementValue = Math.max(1, this.targetValue / 101);
    }
}