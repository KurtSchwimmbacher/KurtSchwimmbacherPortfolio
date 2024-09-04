$(document).ready(function () {
    // Get the current page URL
    let currentUrl = window.location.pathname.replace(/\/$/, ""); // Remove trailing slash if present
    console.log(currentUrl);
    // Iterate over each nav link
    $('.nav-link').each(function () {
        let linkPath = $(this).attr('href').replace(/\/$/, ""); // Remove trailing slashes from link paths
        linkPath = linkPath.substring(3);
        console.log(linkPath);
        // Check if the linkPath is part of the currentUrl
        if (currentUrl.includes(linkPath)) {
            // Add the active class to the matching link
            $(this).addClass('nav-link-active');
            console.log(linkPath);
        } else {
            // Remove the active class from non-matching links
            $(this).removeClass('nav-link-active');
        }
    });
});
  