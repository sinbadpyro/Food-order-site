<?php
      //include constants.php file here
      include('../config/constants.php');

     // 1. Get the ID of the admin to be deleted
          $id = $_GET['id'];

     // 2. create SQL Query to delete admin
     $sql = "DELETE FROM tbl_admin WHERE id=$id";

     //Execute the Query
     $res = mysqli_query($conn, $sql);

     //Chceck whether the query executed successfully or nor
     if($res == true){
        //Query executed successfully and admin deleted
        //echo "admin deleted";
        $_SESSION['delete'] = "<div class='success'>admin deleted successfully.</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
     }else{
        //failed to delete admin
        //echo "failed to delete admin";
        $_SESSION['delete'] = "<div class='error'>failed to delete admin. Try again later</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
     }

     // 3. Redirect to manage admin page with message(sucess/error)
?>