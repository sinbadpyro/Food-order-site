<?php
//Include Constants File
include('../config/constants.php');

//echo "Delete Page";
//Check whether the id and image_name value is set or not
if (isset($_GET['id']) and isset($_GET['image_name'])) {

    //Get the Value and Delete
    // echo "Get Value and Delete";

    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    //remove the physical image if the file is available
    if ($image_name != "") {
        //image is available. so remove it
        $path = "../images/category/" . $image_name;
        //REmove the Image
        $remove = unlink($path);
        //if failed to remove image then add an error message and stop the process
        if ($remove == false) {
            //set the session message
            $_SESSION['remove'] = "<div class='error' Failed to remove category Image.</div>";
            //redirect to manage category page
            header('location:' . SITEURL . 'admin/manage-category.php');
            //stop the process
            die();
        }
    }
    //Delete data from database
    //SQL Query to delete data from database.

    $sql = "DELETE FROM tbl_category WHERE id=$id";
    //Execute the Query 
    $res = mysqli_query($conn, $sql);

    //Check whether the data is delete from database or not
    if ($res == true) {
        //SEt Success MEssage and REdirect
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>"; // add this code to manage-category.php
        //Redirect to Manage Category
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        //SEt Fail MEssage and Redirecs
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>"; //add this code to manage-category.php
        //Redirect to Manage Category
        header('location:' . SITEURL . 'admin/manage-category.php');
    }

    //redirect to manage category page with message
} else {
    //redirect to manage category page
    header('location:' . SITEURL . 'admin/manage-category.php');
}
