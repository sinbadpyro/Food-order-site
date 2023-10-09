<?php include('./partials-front/menu.php') ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <?php
        // Get the search Keyword
        $search = $_POST['search'];
        ?>
        <h2>Foods on Your Search <a href="#" class="text-white"><?php echo htmlspecialchars($search); ?></a></h2>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Include your database connection code here
        // Example: $conn = mysqli_connect("localhost", "username", "password", "dbname");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get the search Keyword
        $search = mysqli_real_escape_string($conn, $_POST['search']);

        // SQL Query to Get Foods based on search keyword using prepared statement
        $sql = "SELECT * FROM tbl_food WHERE title LIKE ? OR description LIKE ?";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            // Bind the parameters and set the search values
            $searchParam = "%" . $search . "%";
            mysqli_stmt_bind_param($stmt, "ss", $searchParam, $searchParam);

            // Execute the prepared statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Check whether food is available or not
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Get the details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
        ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            // Check whether image name is available or not
                            if ($image_name == "") {
                                // Image not available
                                echo "<div class='error'>Image not available.</div>";
                            } else {
                                // Image available
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                            <?php
                            }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo htmlspecialchars($title); ?></h4>
                            <p class="food-price">$<?php echo htmlspecialchars($price); ?></p>
                            <p class="food-detail">
                                <?php echo htmlspecialchars($description); ?>
                            </p>
                            <br>
                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
        <?php
                }
            } else {
                // Food not available
                echo "<div class='error'>Food not Found.</div>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle the error if the statement preparation fails
            echo "<div class='error'>Error in preparing the SQL statement.</div>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('./partials-front/footer.php') ?>
