<?php
// Adding user to database
if (isset($_POST['add_user'])) {
    $username = escape($_POST['username']);
    $user_role = escape($_POST['user_role']);
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_email = escape($_POST['user_email']);
    $user_password = escape($_POST['user_password']);

    $password = password_hash($user_password,PASSWORD_BCRYPT,['cost' => 10]);

    // $post_image = $_FILES['post_image']['name'];
    // $post_image_temp = $_FILES['post_image']['tmp_name'];
    // $post_date = date('d-m-y');

    // move_uploaded_file($post_image_temp,"../images/$post_image");

    $query = "INSERT INTO users(
        username, user_role,
        user_firstname, user_lastname,
        user_email, user_password
        ) ";
    $query .= "VALUES(
        '{$username}', '{$user_role}',
        '{$user_firstname}', '{$user_lastname}',
        '{$user_email}', '{$password}' )";

    $add_user_result = mysqli_query($connection, $query);
    confirm_query($add_user_result);

    echo "User Created: " . "<a href = './users.php'>View Users</a>";
}

?>



<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" id="user_role">
            <option value = 'admin'>Admin</option>
            <option value = 'subscriber'>Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" name="user_firstname" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" name="user_lastname" class="form-control">
    </div>

    <!-- <div class="form-group">
        <label for="title">Post Image</label>
        <input type="file" name="post_image">
    </div> -->
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" name="user_email" class="form-control">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" name="user_password" class="form-control">
    </div>

    <div class="form-group">
        <input type="submit" name="add_user" value ="Add User" class="btn btn-primary">
    </div>

</form>