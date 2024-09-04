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

    // Query to fetch the PDF associated with the project
    $pdfSQL = "SELECT * FROM media WHERE projectID = ?";
    $pdfSTMT = $conn->prepare($pdfSQL);
    $pdfSTMT->bind_param("i", $projectID);
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
<link href="../css/project.css" rel="stylesheet">

<!-- include header -->
<?php include_once '../includes/header.php'; ?>

<!-- Include PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<main class="main-content">
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <h1><?php echo htmlspecialchars($project['title']); ?></h1>
            </div>
        </div>
        <div class="col-12 mt-4">
            <?php if ($projectPDF): ?>
            <!-- Embed PDF if available -->
            <div id="pdf-viewer" class="pdf-viewer"></div>

            <script>
                var url = '../<?php echo htmlspecialchars($projectPDF['mediaPath']); ?>';

                // Asynchronous download of PDF
                var loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function(pdf) {
                    console.log('PDF loaded');

                    // Fetch the first page
                    pdf.getPage(1).then(function(page) {
                        console.log('Page loaded');

                        var scale = 1.5;
                        var viewport = page.getViewport({scale: scale});

                        // Prepare canvas using PDF page dimensions
                        var canvas = document.createElement('canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        document.getElementById('pdf-viewer').appendChild(canvas);

                        // Render PDF page into canvas context
                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        var renderTask = page.render(renderContext);
                        renderTask.promise.then(function() {
                            console.log('Page rendered');
                        });
                    });
                }, function (reason) {
                    console.error('Error loading PDF:', reason);
                });
            </script>

            <?php else: ?>
            <p>No PDF available for this project.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
