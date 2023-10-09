<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <?php
        if (isset($_SESSION['add'])) { // checking whether session is set or not 
            echo $_SESSION['add']; //displaying session message
            unset($_SESSION['add']); // removing session message
        }
        ?>

        <br> <br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name">
                    </td>
                </tr>

               

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>

                <tr>

                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin " placeholder="Your Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
//Process the value from Form and save it in Database

//Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //1. Get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password encryption with MD5

    //2. SQL Query to save the data to database
    $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'      
    ";

    if ($conn->query($sql) === TRUE) {
        // echo "New record created successfully";
        //create a session variable to display message
        $_SESSION['add'] = "<div class='success'>Admin added sucessfully</div>";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        // echo "Error: " . $sql . "<br>" . $conn->error;
        //create a session variable to display message
        $_SESSION['add'] = "<div class='error'>Failed to add Admin</div> ";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
    mysqli_close($conn);
}
?>