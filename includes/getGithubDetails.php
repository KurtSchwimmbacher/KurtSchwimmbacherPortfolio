<?php
require '../includes/Parsedown.php'; // Include Parsedown

// GitHub repository details
$username = 'KurtSchwimmbacher';
$repository = 'DV200T3PHPProject';
$branch = 'main'; // Replace with the correct branch if different

// GitHub API URL to fetch the README file
$url = "https://api.github.com/repos/$username/$repository/contents/README.md?ref=$branch";

// cURL setup
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: PHP Script', // GitHub requires a User-Agent header
]);

$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response
$data = json_decode($response, true);

// Check if content is found
if (isset($data['content'])) {
    // Decode the Base64 encoded content
    $readmeContent = base64_decode($data['content']);

    // Convert Markdown to HTML
    $parsedown = new Parsedown();
    $htmlContent = $parsedown->text($readmeContent);

    // Display the HTML content
    echo $htmlContent;
} else {
    echo "Failed to fetch README.";
}
?>
