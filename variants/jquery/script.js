// EVENT LISTENERS
$(function () {
    $('#action').on('click', getItemsCount);
});

// ACTION getWarehouseValue
function getItemsCount() {
    try {

        // Fetch data
        $.post('/action.php', {
            action: 'getWarehouseValue',
        }).then(function (data) {

            // Validate
            if (!data.success || isNaN(data.response)) {
                throw new Error('Action failed - ' + data.response);
            }

            // Show data
            displayMessage(+data.response);
        });

    } catch (error) {
        console.error(error.message);
    }
}

// Show the result
function displayMessage(price = 0) {
    $('#response').slideDown(200);
    let value = 0;
    let targetValue = 0;

    // Animate
    $({value: 0}).animate({value: price}, {
        duration: 500, // Duration of the animation in milliseconds
        step: function (now) {
            // Update the displayed value
            $('#response #items').html(
                new Intl.NumberFormat('sk-SK', {style: 'currency', currency: 'EUR'}).format(
                    now,
                ),
            );
        },
        complete: function () {
            // After animation set correct value
            $('#response #items').html(
                new Intl.NumberFormat('sk-SK', {style: 'currency', currency: 'EUR'}).format(
                    price,
                ),
            );
        }
    });
}