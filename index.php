<?php
session_start();
require_once 'classes/DeezerAPI.php';
require_once 'classes/SongRenderer.php';

// Handle AJAX Request for Load Next
if (isset($_GET['ajax']) && $_GET['ajax'] == 'true') {
    if (!isset($_SESSION['data']) || !isset($_SESSION['counter'])) {
        exit;
    }

    $artist = $_SESSION['data'];
    $trackCounter = $_SESSION['counter'];

    $api = new DeezerAPI();
    $data = $api->searchQuery($artist, $trackCounter);

    echo SongRenderer::renderList($data, $trackCounter, $artist);

    $_SESSION['counter'] = $trackCounter;
    exit;
}

$cache_expire = 60 * 60 * 24 * 365;
header("Pragma: public");
header("Cache-Control: maxage=" . $cache_expire);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cache_expire) . ' GMT');

$initialHtml = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["artist"])) {
    $artist = $_POST["artist"];
    $trackCounter = 0;

    $api = new DeezerAPI();
    $data = $api->searchQuery($artist, $trackCounter);

    $initialHtml = SongRenderer::renderList($data, $trackCounter, $artist);

    $_SESSION['data'] = $artist;
    $_SESSION['counter'] = $trackCounter;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Song Previews</title>

    <!-- Base tag for subpath deployment -->
    <base href="<?php echo htmlspecialchars(getenv('BASE_URL') ?: '/'); ?>">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Favicon -->
    <link rel="icon" href="data/favicon.svg">
</head>
<body class="bg-light">

<audio id="audio">
    <source src="" type="audio/mpeg">
</audio>

<div class="position-fixed bottom-0 start-0 p-3" style="z-index: 1000;">
    <a href="https://github.com/pascalyazid/SongPreviews/tree/main" target="_blank" class="text-decoration-none">
        <img src="https://cdn.iconscout.com/icon/free/png-256/github-3215409-2673827.png" alt="githubIcon" width="50" height="50">
    </a>
</div>

<div id="load" class="position-fixed bottom-0 end-0 p-3" style="display: none; z-index: 1000;">
    <button onclick="loadNext()" class="btn btn-primary shadow-sm rounded-pill px-4 py-2">Load Next 25</button>
</div>

<div class="container pb-5">
    <div class="row pt-4 pb-2">
        <div class="col text-center">
            <h1 class="display-4 fw-bold text-primary">Song Previews</h1>
        </div>
    </div>

    <div id="banner" class="sticky-top bg-light py-3 mb-4" style="z-index: 999;">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form method="post" action="index.php" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white">
                    <input class="form-control border-0 shadow-none px-4 py-3" type="text" placeholder="Search for an artist..." name="artist" autofocus required>
                    <button type="submit" name="submit" class="btn btn-primary px-4 fw-semibold rounded-0">Search</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Results Container -->
    <div id="results-container">
        <?php echo $initialHtml; ?>
    </div>

</div>

<!-- Bootstrap 5.3.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<!-- Custom JS -->
<script src="js/script.js" charset="utf-8"></script>
</body>
</html>
