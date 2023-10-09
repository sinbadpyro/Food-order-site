<?php include('./partials/menu.php'); ?>

<div class="content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        } // add this code to manage-category.php as well

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        } // add this code to manage-category.php as well
        ?>
        <br>
        <br>
        <!--Add Category Form starts-->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!--Add Category Form starts-->

        <?php
        //check if the submit button is clicked or not
        if (isset($_POST['submit'])) {
            //echo "Clicked";

            //1. Get the Value from CAtegory Form
            $title = $_POST['title'];

            //For Radio input, we need to check whether the button is selected or not
            if (isset($_POST['featured'])) {
                //Get the VAlue from form
                $featured = $_POST['featured'];
            } else {
                //SEt the Default VAlue
                $featured = "No";
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }
            //check whether the image is selected or not and set the value for image name accordingly
            /*print_r($_FILES['image']);
            die(); //break the code here */

            if (isset($_FILES['image']['name'])) {
                //upload the image
                //to upload we need image name, source math and destination path
                $image_name = $_FILES['image']['name'];

                //upload the image only if image is selected
                if ($image_name != "") {


                    //auto rename our image
                    //get the extension of our image (jpg, png, gif, etc) e.g "special.foods.jpg"

                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);


                    //rename the image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;

                    //finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //check whether the image is uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error message
                    if ($upload == false) {
                        //set message 
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                        //redirect to add category page
                        header('location:' . SITEURL . 'admin/add-category.php');
                        //STop the Process
                        die();
                    }
                }
            } else {
                //Dont upload the image and set the image value as blank
                $image_name = "";
            }
            //2. Create SQL Query to insert category into database

            $sql = "INSERT INTO tbl_category SET title = '$title', featured = '$featured', image_name = '$image_name', active = '$active'";

            //3. Execute the query and save in database
            $res = mysqli_query($conn, $sql);
            //4. Check whether the query executed or not and data added or not
            if ($res == true) {
                //Query Executed and Category Added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                //Redirect to Manage Category Page
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //Failed to Add CAtegory
                $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";

                //Redirect to Manage Category Page
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }
        ?>
    </div>
</div>

<?php include('./partials/footer.php'); ?>