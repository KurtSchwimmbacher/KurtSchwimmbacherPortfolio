$(document).ready(function () {
    // When the user clicks on the thumbnail, show the modal and the spinner
    $('.case-study-img-thumbnail').click(function () {


        // Show the modal
        $('#image-modal').fadeIn();
    });


    // When the user clicks on the close button, hide the modal
    $('.close').click(function () {
        $('#image-modal').fadeOut();
    });

    // Close the modal when the user clicks anywhere outside of the image
    $(window).click(function (event) {
        if ($(event.target).is('#image-modal')) {
            $('#image-modal').fadeOut();
        }
    });
});
