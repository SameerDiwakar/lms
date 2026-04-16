<?php
include '../backend/db.php';

$lesson_id = $_GET['id'];

$sql = "SELECT * FROM lessons WHERE id='$lesson_id'";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Lesson not found");
}

$lesson = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lesson['title']; ?></title>
</head>
<body>

<h2><?php echo $lesson['title']; ?></h2>

<?php 
if (!empty($lesson['video_url'])) {

    $video_url = trim($lesson['video_url']);
    $video_id = '';

    // Case 1: youtube.com/watch?v=
    if (strpos($video_url, 'watch?v=') !== false) {
        parse_str(parse_url($video_url, PHP_URL_QUERY), $params);
        $video_id = $params['v'] ?? '';
    }

    // Case 2: youtu.be/
    elseif (strpos($video_url, 'youtu.be/') !== false) {
        $parts = explode('/', $video_url);
        $video_id = end($parts);
    }

    // Debug (remove later if needed)
    // echo "Video ID: " . $video_id;

    if (!empty($video_id)) {
?>
        <iframe width="700" height="400"
            src="https://www.youtube.com/embed/<?php echo $video_id; ?>"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
<?php 
    } else {
        echo "<p>Invalid video URL</p>";
    }
}
?>

<p><?php echo $lesson['content']; ?></p>

</body>
</html>


<!-- <?php
include '../backend/db.php'; -->

$lesson_id = $_GET['id'];

$sql = "SELECT * FROM lessons WHERE id='$lesson_id'";
$lesson = $conn->query($sql)->fetch_assoc();
?>

<h2><?php echo $lesson['title']; ?></h2>

<?php 
if ($lesson['video_url']) {

    $video_url = $lesson['video_url'];

    // Extract video ID safely
    parse_str(parse_url($video_url, PHP_URL_QUERY), $params);
    $video_id = $params['v'] ?? '';

    if ($video_id) {
?>
        <iframe width="600" height="300"
            src="https://www.youtube.com/embed/<?php echo $video_id; ?>"
            frameborder="0"
            allowfullscreen>
        </iframe>
<?php 
    }
}
?>

<p><?php echo $lesson['content']; ?></p> -->