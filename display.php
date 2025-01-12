<?php
$con = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
$is_logged_in = isset($_SESSION['username']);

$category_filter = isset($_GET['category']) ? $_GET['category'] : 'All';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC'; // Default sort by ascending price


$query = "SELECT * FROM image";


if ($category_filter != 'All') {
    $query .= " WHERE category = '$category_filter'";
}

$query .= " ORDER BY price $sort_order";


$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .category-filter {
            text-align: center;
            margin-bottom: 20px;
        }

        .category-filter select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 20px; 
        }

        .category-filter label {
            font-size: 16px;
        }

        .gallery {
    display: grid;
    grid-template-columns: repeat(4, 1fr); 
    gap: 15px; 
    margin-top: 20px;
}


        .gallery .image-container {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background-color: white;
            text-align: center;
        }

        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            transition: transform 0.3s ease-in-out;
        }

        .gallery img:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .image-container .price-and-button {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 5%;
            padding-bottom: 4%
        }

        .price-and-button .price {
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            background-color: #cf3708;
            color: white;
            margin-right: 10px;
            padding: 8px 15px;

        }

        .buy-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4f4c4c;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
        }

        .buy-button:hover {
            background-color: black;
        }



        .no-records {
            text-align: center;
            color: #888;
            font-size: 20px;
            margin-top: 30px;
        }


        h1 {
            text-align: center;
        }

        .sold-out {
            display: inline-block;
            padding: 10px 20px;
            background-color: #9e9e9e;
            color: white;
            font-size: 14px;
            border-radius: 5px;
            text-align: center;
            width: 40%;
        }
        .header {
    contain-intrinsic-block-size: auto 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background-color: #f4f4f4;
    color: black;
    border-radius: 8px;
    box-shadow: 0px;
    margin-bottom: 20px;
    width: 61%;
    margin-left: 209px;
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
#headernavlogin{
    visibility: hidden;
}
    </style>
</head>
<body>
<div class="header" style="margin-left: <?php echo $is_logged_in ? '342px' : '209px'; ?>;">
            <div class="logo">
                <i class="fas fa-home"></i>
                <span>UrbanLens</span>
            </div>
            <div class="nav">
            <a href="index2.html"style="visibility: <?php echo $is_logged_in ? 'visible' : 'hidden';?>;">
            <button>Home</button>
            </a>
            
            <a href="profile.php" id="headernavprofile" style="visibility: <?php echo $is_logged_in ? 'visible' : 'hidden'; ?>;">
                <button>Profile</button>
            </a>
            <a href="logout.php" id="headernavlogout" style="visibility: <?php echo $is_logged_in ? 'visible' : 'hidden'; ?>;">
                <button>Logout</button>
            </a>
            
            <a href="entry.html" id="headernaventry" style="visibility: <?php echo !$is_logged_in ? 'visible' : 'hidden'; ?>;">
                <button>Home</button>
            </a>
            <a href="login.php" id="headernavlogin" style="visibility: <?php echo !$is_logged_in ? 'visible' : 'hidden'; ?>;">
                <button>Login</button>
            </a>
            
    </div>
    </div>
    <div class="container">
        <h1>Image Gallery</h1>
        
        <div class="category-filter">
            <form action="" method="get">
                <label for="category">Filter by Category: </label>
                <select name="category" id="category" onchange="this.form.submit()">
                    <option value="All" <?php echo $category_filter == 'All' ? 'selected' : ''; ?>>All</option>
                    <option value="Nature" <?php echo $category_filter == 'Nature' ? 'selected' : ''; ?>>Nature</option>
                    <option value="Graffiti" <?php echo $category_filter == 'Graffiti' ? 'selected' : ''; ?>>Grafitti</option>
                    <option value="Abstract" <?php echo $category_filter == 'Abstract' ? 'selected' : ''; ?>>Abstract</option>
                    <option value="Artitecture" <?php echo $category_filter == 'Artitecture' ? 'selected' : ''; ?>>Artitecture</option>
                    <option value="Cityscape" <?php echo $category_filter == 'Cityscape' ? 'selected' : ''; ?>>Cityscape</option>
                    <option value="Street art" <?php echo $category_filter == 'Street art' ? 'selected' : ''; ?>>Street art</option>
                </select>
               
                
                <label for="sort_order">Sort by Price: </label>
                <select name="sort_order" id="sort_order" onchange="this.form.submit()">
                    <option value="ASC" <?php echo $sort_order == 'ASC' ? 'selected' : ''; ?>>Low to High</option>
                    <option value="DESC" <?php echo $sort_order == 'DESC' ? 'selected' : ''; ?>>High to Low</option>
                </select>
            </form>
        </div>


        <div class="gallery">
            <?php
            if (mysqli_num_rows($result) > 0) {
               
                while ($row = mysqli_fetch_assoc($result)) {
                    $image_url = $row['file']; 
                    $category = $row['category']; 
                    $price = $row['price']; 
                    $image_id = $row['pic_id']; 
                    $quantity = $row['quantity']; 

                    $sold_query = "SELECT COUNT(*) as sold_count FROM bought WHERE pic_id = '$image_id'";
                    $sold_result = mysqli_query($con, $sold_query);
                    $sold_data = mysqli_fetch_assoc($sold_result);
                    $sold_count = $sold_data['sold_count'];


                    $link_url = "description.php?pic_id=" . $image_id; 
                    ?>
                    <div class="image-container">
                        <div style="height: 88%;">
                        <a href="<?php echo $link_url; ?>" target="_blank">
                            <img src="<?php echo $image_url; ?>" alt="Image in <?php echo $category; ?>" />
                        </a>
                        </div>
                        <div class="price-and-button">
                            <span class="price"> $ <?php echo number_format($price, 2); ?> </span>
                            <?php if($sold_count < $quantity) : ?>
                                <a href="<?php echo $link_url; ?>" target="_blank" class="buy-button">Buy</a>
                            <?php else : ?>
                                <div class="sold-out">
                                    Sold Out
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                }
            } 
            else {
                echo "<p class='no-records'>No images found in this category.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>
<?php include("footer.php");?>