export class Action {
    constructor(action, callback) {
        this.action = action;
        this.value = 0;
    }

    execute(callback) {
        // Build POST request with provided action
        let post = new FormData();
        post.append("action", this.action);

        try {
            fetch('/action.php', {
                method: "POST",
                body: post,
            })
                .then(data => data.json()) // Get json object
                .then((data) => {


                    // Validate
                    if (!data.success) {
                        throw new Error('Action failed - ' + data.response);
                    }

                    if (isNaN(data.response)) {
                        throw new Error('Action did not return a number - ' + data.response);
                    }

                    // Set value and run callback
                    this.value = data.response;
                    callback(this.value);

                });

        } catch (error) {
            console.error(error.message);
        }
    }
}