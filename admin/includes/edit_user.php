<?php
// Putting values from database to fields 
if (isset($_GET['user_id'])) {
    $user_id = escape($_GET['user_id']);
    $query = "SELECT * FROM users WHERE user_id = '{$user_id}' ";
    $selected_user = mysqli_query($connection, $query);
    
    confirm_query($selected_user);

    $row = mysqli_fetch_assoc($selected_user);
    $username = $row['username'];
    $user_role = $row['user_role'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_password = $row['user_password'];
    
}else{
    header("Location: users.php");
}

?>
<?php
// Updating database 
if (isset($_POST['update_user'])) {
    $username = escape($_POST['username']);
    $user_role = escape($_POST['user_role']);
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_email = escape($_POST['user_email']);
    $new_user_password = escape($_POST['user_password']);

    // $post_image = $_FILES['post_image']['name'];
    // $post_image_temp = $_FILES['post_image']['tmp_name'];
    // $post_date = date('d-m-y');
    // $post_comment_count = 4;

    // move_uploaded_file($post_image_temp,"../images/$post_image");

    // if (empty($post_image)) {
    //     $query = "SELECT * from posts WHERE post_id = {$post_id} ";
    //     $selected_image = mysqli_query($connection,$query);
    //     $row = mysqli_fetch_assoc($selected_image);
    //     $post_image = $row['post_image'];
    // }
    if (empty($new_user_password)) {
        $new_user_password = $user_password;
    } else {
        $new_user_password = password_hash($new_user_password,PASSWORD_BCRYPT,['cost' => 10]); 
    }
    


    $query = "UPDATE users SET ";
    $query .= "
        username = '{$username}',
        user_role = '{$user_role}',
        user_firstname = '{$user_firstname}',
        user_lastname = '{$user_lastname}',
        user_email = '{$user_email}',
        user_password = '{$new_user_password}' 
        ";
    $query .= "WHERE user_id = '{$user_id}' ";

    $update_user_result = mysqli_query($connection,$query);

    confirm_query($update_user_result);

    header("Location: users.php");
}

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" value="<?php echo $username ?>">
    </div>

    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" id="user_role">
            <option value = 'admin' <?php if ($user_role=='admin') echo "selected"; ?>>Admin</option>
            <option value = 'subscriber' <?php if ($user_role=='subscriber') echo "selected"; ?>>Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" name="user_firstname" class="form-control" value="<?php echo $user_firstname ?>">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" name="user_lastname" class="form-control" value="<?php echo $user_lastname ?>">
    </div>

    <!-- <div class="form-group">
        <label for="title">Post Image</label>
        <input type="file" name="post_image">
    </div> -->
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" name="user_email" class="form-control" value="<?php echo $user_email ?>">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" name="user_password" class="form-control"">
    </div>

    <div class="form-group">
        <input type="submit" name="update_user" value ="Update User" class="btn btn-primary">
    </div>

</form>