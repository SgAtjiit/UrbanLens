<?php
$con = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
$user_id = $_SESSION['username'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $image = $_FILES['image'];
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $description = mysqli_real_escape_string($con, $_POST['description']);  

    if (empty($description)) {
        $description = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Exercitationem qui fuga ipsum fugiat illo eaque ipsa aliquid adipisci minus reprehenderit pariatur reiciendis delectus beatae nostrum dolorum veritatis blanditiis quasi deleniti, aperiam explicabo quisquam quis? Hic deserunt quos laboriosam non accusantium at unde suscipit possimus, nihil consequuntur odit impedit nesciunt illum rem sequi blanditiis voluptatibus reiciendis fuga nisi libero. Maiores, accusantium facilis. Pariatur aspernatur rem omnis minus nam possimus eos fuga suscipit reprehenderit! Corrupti inventore eveniet neque totam mollitia consequuntur at nam perferendis iure voluptatibus, minima quae labore officiis debitis corporis doloremque aperiam nesciunt. Accusantium, in! A iusto amet corrupti rem quaerat ut eveniet labore voluptatum consequatur. Cum a iusto velit esse sit quibusdam eum blanditiis, repudiandae incidunt totam autem corrupti ad ducimus nesciunt sunt, nulla iure! Accusamus repudiandae ab eaque voluptatem voluptatibus sapiente delectus, laudantium explicabo recusandae iusto labore adipisci minus nobis, reprehenderit quasi, animi corrupti perspiciatis mollitia ut ipsam saepe deserunt libero. In ipsam neque dolor. Eius dolore consectetur ut sit incidunt aliquid totam placeat, nulla maxime quibusdam fugit ea et? Beatae, ea mollitia commodi rem et placeat libero est aspernatur temporibus esse porro, iure in perferendis iusto laborum, maxime veritatis iste repellat itaque? Deserunt dolore voluptate alias dolorum?";
    }
    if (strlen($description) > 5000) {
        $error = "Description cannot be more than 5000 characters.";
    }
    if ($image['error'] !== UPLOAD_ERR_OK) {
        $error = "There was an error uploading the image.";
    }

    if (empty($error)) {
        $upload_dir = "images/";

        $image_name = basename($image['name']);
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $unique_image_name = time() . '_' . $image_name;
        $folder = $upload_dir . $unique_image_name;

        if (move_uploaded_file($image['tmp_name'], $folder)) {
            $success = "Form submitted successfully! Image uploaded.";

            $upload_date = date("Y-m-d H:i:s");
            $query = "INSERT INTO image(uname, file, category, price, quantity, description, upload_date) 
                      VALUES ('$user_id', '$folder', '$category', '$price', '$quantity', '$description', '$upload_date')";
            $data = mysqli_query($con, $query);

            if ($data) {
                $success = "File information saved to the database.";
            } else {
                $error = "Failed to save image information to the database.";
            }
        } else {
            $error = "Failed to upload the image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
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
        input[type="text"], input[type="file"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .radio-group {
            display: flex;
            gap: 15px;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        .btn {
            background-color: #1e1a1a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delbtn {
            background-color: red;
            color: white;
            padding: 10px 22px;
            border: none;
            border-radius: 4px;
            margin-top: 2px;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #615e5e;
        }
        .delbtn:hover {
            background-color: #de0000;
        }
        .error {
            color: #ff1313;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-records {
            color: #888;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }
        .header {
    contain-intrinsic-block-size: auto 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background-color: #f4f7f9;
    color: black;
    border-radius: 8px;
    box-shadow: 0px;
    margin-bottom: 20px;
    width: 47%;
    margin-left: 305px;
}

.header .logo {
    display: flex;
    align-items: center;
    font-size: 24px;
    font-weight: bold;
}

.header .logo i {
    font-size: 30px; 
    margin-right: 15px;
    color: black;
}

.header .logo span {
    font-size: 22px;
    color: black;
}

.header .nav {
    display: flex;
    gap: 15px;
}

.header .nav a {
    text-decoration: none;
}

.header .nav button {
    background-color:#141516; 
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease; 
}

.header .nav button:hover {
    background-color: #141516bf; 
    transform: translateY(-3px);
}

.header .nav button:active {
    transform: translateY(1px); 
}
    </style>
</head>
<body>
<div class="header">
            <div class="logo">
                <i class="fas fa-home"></i>
                <span>UrbanLens</span>
            </div>
            <div class="nav">
                <a href= "index2.html"><button>Home</button></a>
                <a href="profile.php"><button>Profile</button></a>
                <a href="logout.php"><button>Logout</button></a>
                
                
            </div>
    </div>
    <div class="container">
        <h2 style="padding-left: 33%;"> Upload Your Image </h2>
        
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="#" method="POST" enctype="multipart/form-data">
           

            <div class="form-group">
                <label for="image">Select Image:</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>

            <div class="form-group">
                <label>Image Category:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="category" value="Abstract" required> Abstract
                    </label>
                    <label>
                        <input type="radio" name="category" value="Street Art" required> Street Art
                    </label>
                    <label>
                        <input type="radio" name="category" value="Graffiti" required> Graffiti
                    </label>
                    <label>
                        <input type="radio" name="category" value="Cityscape" required> Cityscape
                    </label>
                    <label>
                        <input type="radio" name="category" value="Nature" required> Nature
                    </label>
                    <label>
                        <input type="radio" name="category" value="Artitecture" required> Artitecture
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="price">Set Price:</label>
                <input type="text" name="price" id="price" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" min="1" value="1" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="4" maxlength="5000" ></textarea>
                <small>Max 5000 characters</small>
            </div>

            <button type="submit" class="btn">Submit</button>
        </form>

        <h3>Previously Uploaded Images</h3>
        <?php 

          
            $query = "SELECT * FROM image WHERE uname = '$user_id' ORDER BY upload_date";
            $result = mysqli_query($con, $query); 
            if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Upload Date</th>
                        <th>Actions</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><img src='" . $row['file'] . "' alt='Image' width='100'></td>";
                        echo "<td>" . $row['category'] . "</td>";
                        $price_display = $row['price'] == 0 ? "Free" : $row['price'];
                        echo "<td>" . $price_display . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['upload_date'] . "</td>";
                        echo "<td>";
                        echo "<a href='update_photo.php?id=" . $row['pic_id'] . "' target='_blank'> <button class='btn'> Update </button> </a> ";
                        echo "<a href='delete_photo.php?id=" . $row['pic_id'] . "' target='_blank'> <button class='delbtn'> Delete </button> </a>";
                        echo "</td>";
                    
                        echo "</tr>";
                    }   
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-records">No records found. Please upload an image.</p>
        <?php endif; ?>


    </div>

</body>
</html>
<?php include("footer.php"); ?>