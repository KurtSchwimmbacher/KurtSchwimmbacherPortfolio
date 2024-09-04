<?php
// Include config file
include_once '../includes/config.php';

// Get database connection
$conn = getDatabaseConnection();

// Query to fetch UX projects
$sql = "SELECT * FROM projects WHERE category = 'UX'";
$result = $conn->query($sql);

$projects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
} else {
    echo "No projects found.";
}

$conn->close();
?>

<!-- link to css -->
<link href="../css/header.css" rel="stylesheet">
<link href="../css/card.css" rel="stylesheet">  

<!-- include header -->
<?php include_once '../includes/header.php'; ?>

<main class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-12 title-col mt-5">
                <h1>User Experience Projects</h1>
            </div>
        </div>

        <!-- load UX Case Studies -->
        <div class="row mt-5">
            <?php foreach ($projects as $project): ?>
            <div class="col-4">
                <div class="card">
                    <!-- Link to singleProjectUX.php with project ID -->
                    <a href="singleProjectUX.php?id=<?php echo urlencode($project['projectID']); ?>">
                        <img src="../<?php echo htmlspecialchars($project['thumbnail']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($project['title']); ?>">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h4>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</main>
