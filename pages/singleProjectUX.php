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

    // Define the media type for images
    $mediaType = 'image';

    // Query to fetch the images associated with the project
    $pdfSQL = "SELECT * FROM media WHERE projectID = ? AND mediaType = ?";
    $pdfSTMT = $conn->prepare($pdfSQL);
    $pdfSTMT->bind_param("is", $projectID, $mediaType);
    $pdfSTMT->execute();
    $pdfResult = $pdfSTMT->get_result();

    // Define the media type for prototypes
    $protoType = 'prototype';

    // Query to fetch the prototypes associated with the project
    $protoSQL = "SELECT * FROM media WHERE projectID = ? AND mediaType = ?";
    $protoSTMT = $conn->prepare($protoSQL);
    $protoSTMT->bind_param("is", $projectID, $protoType);
    $protoSTMT->execute();
    $protoResult = $protoSTMT->get_result();

    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
    } else {
        echo "Project not found.";
        exit();
    }

    if ($pdfResult->num_rows > 0) {
        $projectPDF = $pdfResult->fetch_assoc();
    } else {
        $projectPDF = null; // Handle the case where no images are found
    }

    $stmt->close();
    $pdfSTMT->close();
    $protoSTMT->close();

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
                <h1><?php echo htmlspecialchars($project['title']); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <?php if ($projectPDF): ?>
                    <!-- Case study img if available -->
                    <img class="case-study-img-thumbnail" src="../<?php echo htmlspecialchars($project['thumbnail']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
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
            <?php if ($protoResult->num_rows > 0): ?>
                <?php while ($prototype = $protoResult->fetch_assoc()): ?>
                    <div class="col-4">
                        <iframe class="figma-prototype" style="border: 1px solid rgba(0, 0, 0, 0.1);" src="<?php echo htmlspecialchars($prototype['mediaPath']); ?>" allowfullscreen></iframe>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No Prototypes available for this project.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
