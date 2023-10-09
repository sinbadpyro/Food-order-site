<?php include('partials/menu.php') ?>

<?php
//check whether ID is set or not
if (isset($_GET['id'])) {
    //Get all the details
    $id = $_GET['id'];

    //Sql query to get selected food
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

    //Execute the query
    $res2 = mysqli_query($conn, $sql2);

    //Get the value based on query executed
    $row2 = mysqli_fetch_assoc($res2);

    //Get the individual value of selected food
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    //redirect to manage food
    header('location' . SITEURL . 'admin/manage-food.php');
}
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Desctiption:</td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            //image not available
                            echo "<div class='error'>Image not available.</div>";
                        } else {
                            //image available
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            //Query to get active categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //Execute the query
                            $res = mysqli_query($conn, $sql);
                            //count rows
                            $count = mysqli_num_rows($res);

                            //check whether category available or not
                            if ($count > 0) {
                                //category available
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    //echo "<option value='$category_id'>$category_title</option>";
                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?php echo $category_id; ?>"><?php echo $category_title ?></option>
                            <?php
                                }
                            } else {
                                //category not available
                                echo "<option value = '0'>Category Not available.</option>";
                            }
                            ?>
                            <option value="0">Test Category</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == 'Yes') {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == 'No') {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == 'Yes') {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == 'No') {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php
        if (isset($_POST['submit'])) {
            //1. Get all the details from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2.Upload the image if selected
            //check whether upload button is clicked or not
            if (isset($_FILES['image']['name'])) {
                //upload button clicked
                $image_name = $_FILES['image']['name']; //New image name
                //check whether the file is available
                if ($image_name != "") {
                    //image is available
                    //A.uploading new image
                    //rename the image
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    //Gets the extension of the page

                    $image_name = "Food-Name-" . rand(0000, 9999) . '.' . $ext; //this will be renamed image

                    //Get the source path and destination path
                    $src_path = $_FILES['image']['tmp_name']; //Source path
                    $dest_path = "../images/food/" . $image_name; //destination path

                    //upload the image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    //check whether the image is uploaded or not
                    // Check if a new image was uploaded
                    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                        // New image upload logic here...

                        // Remove the current image if it exists
                        if ($current_image !== "") {
                            // current image is available
                            $remove_path = "../images/food/" . $current_image;

                            // Check if the file exists before attempting to delete it
                            if (file_exists($remove_path)) {
                                $remove = unlink($remove_path);
                                // check whether the image is removed or not
                                if ($remove == false) {
                                    // failed to remove current image
                                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current Image.</div>";
                                    // Redirect to manage Food
                                    header('location:' . SITEURL . 'admin/manage-food.php');
                                    // stop the process
                                    die();
                                }
                            } else {
                                // The image file doesn't exist, so there's no need to delete it.
                                $image_name = $current_image;
                            }
                        }
                    } else {
                        // No new image was uploaded, so keep the current image name
                        $image_name = $current_image;
                    }
                }
            }
            //4.Update food in database
            $sql3 = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active'
            WHERE id=$id";


            //Execute the SQL Query
            $res3 = mysqli_query($conn, $sql3);

            //check whether the query is executed or not
            if ($res3 == true) {
                //Query executed and Food updated
                $_SESSION['update'] = "<div class='success'>Food Updated Sucessfully.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                //Failed to update Food 
                $_SESSION['update'] = "<div class='sucess'>Failed to update Food .</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        }
        ?>
    </div>
</div>




<?php include('partials/footer.php') ?>