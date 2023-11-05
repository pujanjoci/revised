    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

$(document).ready(function() {
    const itemContainer = $('#item-container');
    const slideLeftButton = $('#slide-left-button');
    const slideRightButton = $('#slide-right-button');
    const itemWidth = 300;
    let currentPosition = 0;

    // Function to update the slider position
    function updateSliderPosition() {
        const maxPosition = itemContainer.width() - itemContainer.parent().width();

        if (currentPosition < 0) {
            currentPosition = 0;
        } else if (currentPosition > maxPosition) {
            currentPosition = maxPosition;
        }

        itemContainer.animate({
            left: -currentPosition
        }, 500);
    }

    // Event handler for the left button
    slideLeftButton.on('click', function() {
        currentPosition -= itemWidth;
        updateSliderPosition();
    });

    // Event handler for the right button
    slideRightButton.on('click', function() {
        currentPosition += itemWidth;
        updateSliderPosition();
    });

    // Initialize the slider position
    updateSliderPosition();
});


