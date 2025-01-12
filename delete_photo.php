<?php
$con = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) 
{
    $image_id = $_GET['id'];

    $query = "SELECT file FROM image WHERE pic_id = '$image_id'";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $image_path = $row['file'];
        if (file_exists($image_path)) {
            unlink($image_path); 
        }
    }

    
    $query = "DELETE FROM image WHERE pic_id = '$image_id'";
    $data = mysqli_query($con, $query);

    if ($data) 
    {
        $success = "Image deleted successfully.";
        header("Location:upload.php");
        exit();
    } 
    else 
    {
        $error = "Failed to delete image.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Image</title>
</head>
<body>
    <div class="container">
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>