<?php include "db.php"; ?>
<?php session_start(); ?>

<?php 
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);


    $query = "SELECT * FROM users WHERE username = '{$username}'; ";
    $select_user_result = mysqli_query($connection,$query);

    if (!$select_user_result) {
        die("Query Failed:".mysqli_error($connection));
    }

    while ($row = mysqli_fetch_assoc($select_user_result)) {
        $db_user_id = $row['user_id'];
        $db_user_password = $row['user_password'];
        $db_username = $row['username'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        $db_email = $row['user_email'];
     
    }

    if(password_verify($password,$db_user_password)){
        $_SESSION['username'] = $db_username;
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        $_SESSION['user_password'] = $db_user_password;
        $_SESSION['user_email'] = $db_user_email;

        if ($_SESSION['user_role']=='admin') {
            header("Location: ../admin");
        }else{
            header("Location: ../admin/posts.php");
        }
        
    }else {
        header("Location: ../index.php");
    }
    
}
?>