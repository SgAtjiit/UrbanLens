<?php
$con = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];
    $query = "SELECT * FROM image WHERE pic_id = $image_id";
    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_assoc($result);
    $user_id = $row['uname'];
    $category = $row['category'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $description = $row['description'];
    $file = $row['file']; 
    
} 
else 
{
    $error = "No image ID provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($image_id)) {
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    $query = "UPDATE image SET category = '$category', price = '$price', quantity = '$quantity', description = '$description' WHERE pic_id = '$image_id'";
    $data = mysqli_query($con, $query);

    if ($data) {
        $success = "Image updated successfully!";
    } else {
        $error = "Failed to update image.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-size: 14px;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .btn {
            background-color: #94817A;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #f09e4d;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 style="text-align: center;">Update Image Details</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="update_photo.php?id=<?php echo $image_id; ?>" method="POST">
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($category); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" min="1" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" rows="4" maxlength="5000" required><?php echo htmlspecialchars($description); ?></textarea>
                <small>Max 5000 characters</small>
            </div>

            <button type="submit" class="btn">Update</button>
        </form>
    </div>

</body>
</html>