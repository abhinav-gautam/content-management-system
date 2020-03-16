<?php

// Insert categories
function insert_categories() {
    global $connection;
     
    $query = "SELECT * FROM categories";
    $selected_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($selected_categories)) {
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        
        echo "
            <tr>
                <td>{$cat_id}</td>
                <td>{$cat_title}</td>
                <td><a onClick = \" javascript: return confirm('Are you sure you want to delete?') \" href='categories.php?delete={$cat_id}'>Delete</a></td>
                <td><a href='categories.php?edit={$cat_id}'>Edit</a></td>
            </tr>
        ";
    }
}

// Confirm Query
function confirm_query($result){
    global $connection;
    if(!$result){
        die("Query Failed:".mysqli_error($connection));
    }
}

// Count number of users online
function users_online(){
    
    if (isset($_GET['onlineusers'])) {
        session_start();
        include "../includes/db.php";
        $session = session_id();
        $time = time();
        $time_out_in_seconds = 30;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection,$query);
        confirm_query($send_query);
        $count = mysqli_num_rows($send_query);

        if($count == NULL){
            mysqli_query($connection,"INSERT INTO users_online(session, time) VALUES('$session','$time') ");
        }else{
            mysqli_query($connection,"UPDATE users_online SET `time` = '$time' WHERE session = '$session' ");
        }

        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE `time` > '$time_out' ");
        echo mysqli_num_rows($users_online_query);
    }  
}
users_online();

// Escaping
function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection,trim($string));
}

// Delete Post
function delete_post($post_id){
    global $connection;
    $post_id = escape($post_id);
    $query = "DELETE FROM posts WHERE post_id = '{$post_id}' ";
    $delete_post_result = mysqli_query($connection,$query);
    confirm_query($delete_post_result);
    $query = "DELETE FROM comments WHERE comment_post_id = '{$post_id}' ";
    $delete_comment_result = mysqli_query($connection,$query);
    confirm_query($delete_comment_result);
    header("Location: posts.php");
}

// Delete User
function delete_user(){
    global $connection;
    $user_id = escape($_GET['delete']);
    $query = "DELETE FROM users WHERE user_id = '{$user_id}' ";
    $delete_result = mysqli_query($connection,$query);
    header("Location: users.php");
}

// Delete Comment
function delete_comment(){
    global $connection;
    $comment_id = escape($_GET['delete']);
    $post_id = escape($_GET['p_id']);
    $query = "DELETE FROM comments WHERE comment_id = '{$comment_id}' ";
    $delete_result = mysqli_query($connection,$query);
    $query = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = '{$post_id}' ";
    $decrement_comment_count_result = mysqli_query($connection,$query);
    confirm_query($decrement_comment_count_result);
}

// Insert posts
function insert_posts(){
    global $connection;

    if ($_SESSION['user_role']=='admin') {
        $query = "SELECT * FROM posts ORDER BY post_id DESC";
    }else{
        $query = "SELECT * FROM posts WHERE post_author='{$_SESSION['username']}' ORDER BY post_id DESC";
    }       
    $selected_posts = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($selected_posts)) {
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
        $post_views_count = $row['post_views_count'];

        
        echo "
            <tr>
                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='{$post_id}'></td>
                <td>{$post_id}</td>
                <td><a href='../post.php?p_id={$post_id}&pa={$post_author}'>$post_title</a></td>
                <td>{$post_author}</td>
            ";
            
        $query = "SELECT * FROM categories WHERE cat_id = '{$post_category_id}' ";
        $selected_categories = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($selected_categories);
        $cat_title = $row['cat_title'];
            
        echo "<td>{$cat_title}</td>";
                
                
        echo "
                <td>{$post_status}</td>
                <td><img src='../images/{$post_image}' width='100'></td>
                <td>{$post_tags}</td>
                <td>{$post_date}</td>
                <td><a href='post_comments.php?comment_post_id={$post_id}'>{$post_comment_count}</a></td>               
                <td><a href = 'posts.php?source=reset_views&post_id={$post_id}'>{$post_views_count}</a></td>
                <td><a href='posts.php?source=publish_post&post_id={$post_id}'>Publish</a></td>
                <td><a href='posts.php?source=draft_post&post_id={$post_id}'>Draft</a></td>
                <td><a onClick = \" javascript: return confirm('Are you sure you want to delete?') \" href='posts.php?delete={$post_id}'>Delete</a></td>
                <td><a href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a></td>
            </tr>
        ";
    }
}

// Reset Views Count
function reset_views($post_id){
    global $connection;
    $post_id = escape($post_id);
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = '{$post_id}' ";
    $view_count_reset_result = mysqli_query($connection, $query);
    header("Location: posts.php");
}

// Update post status
function update_post_status($post_status, $post_id){
    global $connection;
    $post_id = escape($post_id);
    $post_status = escape($post_status);
    $query = "UPDATE posts SET post_status = '{$post_status}' WHERE post_id = '{$post_id}' ";
    $update_post_result = mysqli_query($connection,$query);
    confirm_query($update_post_result);
    header("Location: posts.php");
}

// Update comment status
function update_comment_status($comment_status, $comment_id){
    global $connection;
    $comment_status = escape($comment_status);
    $comment_id = escape($comment_id);
    $query = "UPDATE comments SET comment_status = '{$comment_status}' WHERE comment_id = '{$comment_id}' ";
    $update_comment_result = mysqli_query($connection,$query);
    confirm_query($update_comment_result);
}

// Update user role
function update_user_role($user_role,$user_id){
    global $connection;
    $user_id = escape($user_id);
    $user_role = escape($user_role);
    $query = "UPDATE users SET user_role = '{$user_role}' WHERE user_id = '{$user_id}' ";
    $update_user_role_result = mysqli_query($connection,$query);
    confirm_query($update_user_role_result);
    header("Location: users.php");
}
// Insert comments
function insert_comments_core($result){
    global $connection;
    while ($row = mysqli_fetch_assoc($result)) {
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];
        

        
        echo "
            <tr>
                <td>{$comment_id}</td>
                <td>{$comment_author}</td>
                <td>{$comment_content}</td>
            
                <td>{$comment_email}</td>
                <td>{$comment_status}</td>
            ";

        $query = "SELECT * FROM posts WHERE post_id = '{$comment_post_id}' ";
        $selected_post = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($selected_post);
        $post_title = $row['post_title'];
        $post_id = $row['post_id'];
            
        echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

        echo "
                <td>{$comment_date}</td>
                <td><a href='comments.php?approve={$comment_id}'>Approve</a></td>
                <td><a href='comments.php?reject={$comment_id}'>Reject</a></td>
                <td><a onClick = \" javascript: return confirm('Are you sure you want to delete?') \" href='comments.php?delete={$comment_id}&p_id={$post_id}'>Delete</a></td>
            </tr>
        ";
    }
}

// Insert comments based on user role
function insert_comments(){
    global $connection;

    if ($_SESSION['user_role'] != 'admin') {
        
        $query = "SELECT post_id FROM posts WHERE post_author = '{$_SESSION['username']}'";
        $selected_comment_post_id_result = mysqli_query($connection,$query);
        while ($row = mysqli_fetch_assoc($selected_comment_post_id_result)){
            $post_id = $row['post_id'];
            $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
            $selected_comments = mysqli_query($connection, $query);
            insert_comments_core($selected_comments);
        }
    }else{
        $query = "SELECT * FROM comments";
        $selected_comments = mysqli_query($connection, $query);
        insert_comments_core($selected_comments);
    }
    
    
    
    
}

// Insert users
function insert_users(){
    global $connection;
     
    $query = "SELECT * FROM users";
    $selected_users = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($selected_users)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        
        

        
        echo "
            <tr>
                <td>{$user_id}</td>
                <td>{$username}</td>
                <td>{$user_firstname}</td>
                <td>{$user_lastname}</td>
                <td>{$user_email}</td>
            ";

        // $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id} ";
        // $selected_post = mysqli_query($connection, $query);
        // $row = mysqli_fetch_assoc($selected_post);
        // $post_title = $row['post_title'];
        // $post_id = $row['post_id'];
            
        // echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

        echo "
                <td>{$user_role}</td>
                <td><a href='users.php?change_to_sub={$user_id}'>Make Subscriber</a></td>
                <td><a href='users.php?change_to_admin={$user_id}'>Make Admin</a></td>
                <td><a onClick = \" javascript: return confirm('Are you sure you want to delete?') \" href='users.php?delete={$user_id}'>Delete</a></td>
                <td><a href='users.php?source=edit_user&user_id={$user_id}'>Edit</a></td>
            </tr>
        ";
    }
}
// Update category
function update_category(){
    global $connection;
    $cat_id = escape($_GET['edit']);
    $query = "SELECT * FROM categories WHERE cat_id = '{$cat_id}' ";
    $selected_categories = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($selected_categories);
    if (isset($_POST['update'])) {
        $cat_title = escape($_POST['cat_title']);
        $query = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = '{$cat_id}' ";
        $update_result = mysqli_query($connection,$query);
        if (!$update_result) {
            die("Query Failed:".mysqli_error($connection));
        }else{
            header("Location: categories.php");
        }
    }
    return $cat_title = $row['cat_title'];
    
}

// Add category
function add_category(){
    global $connection;
    $cat_title = escape($_POST['cat_title']);
    if ($cat_title=="" || empty($cat_title)) {
        echo "<p class='text-danger'>This field should not be empty</p>";
    }else{
        $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
        $create_category_result = mysqli_query($connection,$query);
        if (!$create_category_result) {
            die("Query Failed:".mysqli_error($connection));
        }
    }
}

// Delete category
function delete_category(){
    global $connection;
    $cat_id = escape($_GET['delete']);
    $query = "DELETE FROM categories WHERE cat_id = '{$cat_id}' ";
    $delete_result = mysqli_query($connection,$query);
    header("Location: categories.php");
}
?>

