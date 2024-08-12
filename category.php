<?php

include 'config.php';
session_start();

// Fetch recipes data from database
$i = 1;
$rows = mysqli_query($conn, "SELECT * FROM recipe");
$recipe = mysqli_fetch_assoc($rows);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Category Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/category.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="asset/cookingmainlogo.png" height="50px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="category.php">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                </ul>
                <?php
                if (isset($_SESSION['username'])) {
                    // User is signed in, show logout button
                    echo '<button class="btn2 mx-2" onclick="location.href=\'logout.php\'" type="submit">Log Out</button>';
                } else {
                    // User is not signed in, show sign in and sign up buttons
                    echo '<button class="btn1 mx-2" onclick="location.href=\'signin.php\'" type="submit">Sign In</button>';
                    echo '<button class="btn2 mx-2" onclick="location.href=\'signup.php\'" type="submit">Sign Up</button>';
                }
                ?>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Start Sidebar drawer -->

    <!-- Start Sidebar drawer -->
    <div class="container">
        <div class="row">
            <aside class="col-md-3 mt-3">
                <div class="card">
                    <article class="filter-group">
                        <header class="card-header">
                            <h4 class="title mt-2">Categories</h4>
                        </header>
                        <div class="filter-content collapse show" id="collapse_1">
                            <div class="card-body">
                                <form class="pb-3" method="get" action="">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-light" name="submit" type="submit"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                if (isset($_GET['submit']) || isset($_POST['submit'])) {
                                    $search = $_GET['search'];

                                    $sql = "SELECT * FROM recipe WHERE recipe_name LIKE '%" . $_GET['search'] . "%'";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            echo '<div class="text-start"><p>Show Result "' . $search . '"</p></div>';
                                        }
                                    }
                                }
                                ?>
                                <ul class="list-menu">
                                    <a href="category.php" class="<?php echo !isset($_GET['cat_id']) ? 'active' : ''; ?>" style="<?php echo !isset($_GET['cat_id']) ? 'color: #E8B832;' : ''; ?>">All</a>
                                    <?php
                                    $categories = [
                                        ['cat_id' => 1, 'cat_name' => 'Appetizer'],
                                        ['cat_id' => 2, 'cat_name' => 'Main Dish'],
                                        ['cat_id' => 3, 'cat_name' => 'Dessert'],
                                        ['cat_id' => 4, 'cat_name' => 'Drinks']
                                    ];
                                    foreach ($categories as $category) {
                                        $cat_id = $category['cat_id'];
                                        $category_name = $category['cat_name'];
                                        $active_class = (isset($_GET['cat_id']) && $cat_id == $_GET['cat_id']) ? 'active' : '';
                                    ?>
                                        <li>
                                            <a href="category.php?cat_id=<?php echo $cat_id; ?>" class="<?php echo $active_class; ?>" style="<?php echo $active_class ? 'color: #E8B832;' : ''; ?>"><?php echo $category_name; ?></a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div> <!-- card-body.// -->
                        </div>
                    </article> <!-- filter-group  .// -->
                </div> <!-- card.// -->
            </aside>
            <main class="col-md-9">
                <div class="row p-3 gap-0 row-gap-4 text-center">
                    <?php
                    if (isset($_GET['submit'])) {
                        $search = $_GET['search'];

                        $sql = "SELECT * FROM recipe WHERE recipe_name LIKE '%" . $_GET['search'] . "%'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                while ($fetch_recipe = mysqli_fetch_assoc($result)) {
                    ?>
                                    <div class="col-6 col-md-6 col-lg-3" onclick="location.href='recipe.php?recipe_id=<?php echo $fetch_recipe['recipe_id']; ?>'">
                                        <div class="card text-center">
                                            <img class="card-img-top" src="img/<?php echo $fetch_recipe['recipe_img']; ?>" alt="">
                                            <div class="card-body" name="recipe_name">
                                                <h6><?php echo $fetch_recipe['recipe_name']; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            } else {
                                echo '<p class="empty">No recipes found</p>';
                            }
                        }
                    } else if (isset($_GET['cat_id'])) {
                        $cat_id = $_GET['cat_id'];
                        $cat_recipe = mysqli_query($conn, "SELECT * FROM `recipe` WHERE cat_id = '$cat_id'") or die('query failed');
                        if (mysqli_num_rows($cat_recipe) > 0) {
                            while ($fetch_recipe = mysqli_fetch_assoc($cat_recipe)) {
                                ?>
                                <div class="col-6 col-md-6 col-lg-3" onclick="location.href='recipe.php?recipe_id=<?php echo $fetch_recipe['recipe_id']; ?>'">
                                    <div class="card text-center">
                                        <img class="card-img-top" src="img/<?php echo $fetch_recipe['recipe_img']; ?>" alt="">
                                        <div class="card-body" name="recipe_name">
                                            <h6><?php echo $fetch_recipe['recipe_name']; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            echo '<p class="empty">No recipes found for this category</p>';
                        }
                    } else {
                        // Display all recipes when no specific category is selected
                        $all_recipe = mysqli_query($conn, "SELECT * FROM `recipe`") or die('query failed');
                        if (mysqli_num_rows($all_recipe) > 0) {
                            while ($fetch_recipe = mysqli_fetch_assoc($all_recipe)) {
                            ?>
                                <div class="col-6 col-md-6 col-lg-3" onclick="location.href='recipe.php?recipe_id=<?php echo $fetch_recipe['recipe_id']; ?>'">
                                    <div class="card text-center">
                                        <!-- <form action="recipe.php"> -->
                                        <img class="card-img-top" src="img/<?php echo $fetch_recipe['recipe_img']; ?>" alt="">
                                        <div class="card-body">
                                            <h6><?php echo $fetch_recipe['recipe_name']; ?></h6>
                                        </div>
                                        <!-- </form> -->
                                    </div>
                                </div>
                    <?php
                            }
                        } else {
                            echo '<p class="empty">No recipes found</p>';
                        }
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>

    <!-- End Sidebar Drawer -->
    </main>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>