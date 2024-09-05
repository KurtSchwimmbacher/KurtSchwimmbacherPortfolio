<?php
// Include config file
include_once '../includes/config.php';

// Get database connection
$conn = getDatabaseConnection();

// Check if project ID is provided
if (isset($_GET['id'])) {
    $projectID = intval($_GET['id']);

    // Query to fetch the project details
    $sql = "SELECT * FROM projects WHERE projectID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $projectID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Define the media type as a variable
    $mediaType = 'image';

    // Query to fetch the PDF associated with the project
    $pdfSQL = "SELECT * FROM media WHERE projectID = ? AND mediaType = ?";
    $pdfSTMT = $conn->prepare($pdfSQL);
    $pdfSTMT->bind_param("is", $projectID,$mediaType);
    $pdfSTMT->execute();
    $pdfResult = $pdfSTMT->get_result();

    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
    } else {
        echo "Project not found.";
        exit();
    }

    if ($pdfResult->num_rows > 0) {
        $projectPDF = $pdfResult->fetch_assoc();
    } else {
        $projectPDF = null; // Handle the case where no PDF is found
    }

    $stmt->close();
    $pdfSTMT->close();

} else {
    echo "No project ID provided.";
    exit();
}

$conn->close();
?>

<!-- link to css -->
<link href="../css/header.css" rel="stylesheet">
<link href="../css/singleProject.css" rel="stylesheet">  

<!-- include header -->
<?php include_once '../includes/header.php'; ?>

<!-- link to js -->
<script src="../js/singleUXLogic.js"></script>


<!-- Modal Structure -->
<div id="image-modal" class="modal">
    <span class="close">&times;</span>
    <img src="../<?php echo htmlspecialchars($projectPDF['mediaPath']); ?>" class="modal-content" id="full-image">
</div>


<main class="main-content">
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <h1 ><?php echo htmlspecialchars($project['title']); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <?php if ($projectPDF): ?>
                <!-- Case study img if available -->
                <img class="case-study-img-thumbnail" src="../<?php echo htmlspecialchars($project['thumbnail']); ?>"  alt="<?php echo htmlspecialchars($project['title']); ?>">
                <?php else: ?>
                <p>No Case Study available for this project.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <h1 class="single-prod-title">Prototypes</h1>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-4">
                <iframe class="figma-prototype" style="border: 1px solid rgba(0, 0, 0, 0.1);"  src="https://www.figma.com/embed?embed_host=share&url=https%3A%2F%2Fwww.figma.com%2Fproto%2FVq8dkbpL9Su0nukx7CIQo1%2FUX200-T3%3Fpage-id%3D26%253A3%26node-id%3D591-1262%26node-type%3DFRAME%26viewport%3D455%252C367%252C0.08%26t%3DJnS53JMb2yA9tdHU-1%26scaling%3Dscale-down%26content-scaling%3Dfixed%26starting-point-node-id%3D591%253A1262" allowfullscreen></iframe>
            </div>
            <div class="col-4">
                <iframe class="figma-prototype" style="border: 1px solid rgba(0, 0, 0, 0.1);"  src="https://www.figma.com/embed?embed_host=share&url=https%3A%2F%2Fwww.figma.com%2Fproto%2FVq8dkbpL9Su0nukx7CIQo1%2FUX200-T3%3Fpage-id%3D704%253A848%26node-id%3D704-849%26node-type%3DFRAME%26viewport%3D504%252C775%252C0.16%26t%3D84qkMZC5DygzrdNW-1%26scaling%3Dscale-down%26content-scaling%3Dfixed%26starting-point-node-id%3D704%253A849"ed%26starting-point-node-id%3D591%253A1262" allowfullscreen></iframe>
            </div>
            <div class="col-4">
                <iframe class="figma-prototype" style="border: 1px solid rgba(0, 0, 0, 0.1);"  src="https://www.figma.com/embed?embed_host=share&url=https%3A%2F%2Fwww.figma.com%2Fproto%2FVq8dkbpL9Su0nukx7CIQo1%2FUX200-T3%3Fpage-id%3D704%253A1080%26node-id%3D704-1085%26node-type%3DFRAME%26viewport%3D477%252C521%252C0.08%26t%3D3g1Kielfn8cqkza9-1%26scaling%3Dscale-down-width%26content-scaling%3Dfixed%26starting-point-node-id%3D704%253A1085" allowfullscreen></iframe>
            </div>
        </div>

    </div>
</main>