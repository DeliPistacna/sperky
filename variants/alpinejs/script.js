function action() {
    return {
        value: 0,
        targetValue: 0,
        showResponse: false,
        animation: null,
        animationTime: 500,
        incrementValue: null,

        // Submit event
        getItemsCount(formEvent) {
            let post = new FormData(formEvent.target);
            post.append("action", "getWarehouseValue");

            try {
                fetch('/action.php', {
                    method: "POST",
                    body: post,
                })
                    .then(data => data.json())
                    .then((data) => {

                        if (!data.success || isNaN(data.response)) {
                            throw new Error('Action failed - ' + data.response);
                        }

                        // HANDLE DATA
                        this.displayMessage(data.response);
                    });
            } catch (error) {
                console.error(error.message);
            }
        },

        // -- Animation related functions --

        // Show response and start animation
        displayMessage(value = 0) {
            this.showResponse = true;
            this.targetValue = value;
            this.value = 0;
            this.incrementValue = null;
            this.animation = setInterval(() => this.animationFrame(), this.getAnimationInterval());
        },


        // Animation loop
        animationFrame() {
            if (this.value < this.targetValue) {
                this.value += this.getIncrementValue();
            } else {
                this.value = this.targetValue;
                clearInterval(this.animation);
            }
        },

        // Get interval for setInterval()
        getAnimationInterval() {
            return Math.floor(this.animationTime / this.targetValue);
        },

        // Get increment value for single animation frame
        getIncrementValue() {
            if (this.incrementValue) {
                return this.incrementValue;
            }
            return this.incrementValue = Math.max(1, this.targetValue / 101);
        },

        currencyValue() {
            return new Intl.NumberFormat('sk-SK', {
                style: 'currency',
                currency: 'EUR'
            }).format(
                this.value,
            );
        }
    }
}