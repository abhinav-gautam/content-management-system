<?php
// Putting values from database to fields 
if (isset($_GET['post_id'])) {
    $post_id = escape($_GET['post_id']);
    $query = "SELECT * FROM posts WHERE post_id = '{$post_id}'";
    $selected_post = mysqli_query($connection, $query);
    
    confirm_query($selected_post);
    $row = mysqli_fetch_assoc($selected_post);
    $post_category_id = $row['post_category_id'];
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];
    $post_status = $row['post_status'];
  
    
}

?>
<?php
// Delete post
if (isset($_POST['delete_post'])) {
    delete_post($post_id);
}
// Updating database 
if (isset($_POST['update_post'])) {
    $post_title = escape($_POST['post_title']);
    $post_author = escape($_POST['post_author']);
    $post_category_id = escape($_POST['post_category']);
    $post_status = escape($_POST['post_status']);
    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);

    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_date = date('d-m-y');
    $post_comment_count = 4;

    move_uploaded_file($post_image_temp,"../images/$post_image");

    if (empty($post_image)) {
        $query = "SELECT * from posts WHERE post_id = '{$post_id}' ";
        $selected_image = mysqli_query($connection,$query);
        $row = mysqli_fetch_assoc($selected_image);
        $post_image = $row['post_image'];
    }

    $query = "UPDATE posts SET ";
    $query .= "
        post_title = '{$post_title}',
        post_author = '{$post_author}',
        post_category_id = '{$post_category_id}',
        post_status = '{$post_status}',
        post_tags = '{$post_tags}',
        post_content = '{$post_content}',
        post_image = '{$post_image}',
        post_date = now()
        ";
    $query .= "WHERE post_id = '{$post_id}' ";

    $update_post_result = mysqli_query($connection,$query);

    confirm_query($update_post_result);

    echo "<p class='bg-success'>Post Updated: <a href='../post.php?p_id={$post_id}&pa={$post_author}'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
}

?>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="post_title">Post Title</label>
    <input type="text" name="post_title" class="form-control" value="<?php echo $post_title ?>">
</div>

<div class="form-group">
    <label for="post_category">Post Category</label>
    <select name="post_category" id="post_category">

        <?php
            // Fetching categories
            $query = "SELECT * FROM categories";
            $selected_categories = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($selected_categories)) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                
                echo "
                    <option value = '{$cat_id}'>{$cat_title}</option>
                ";
            }

        ?>
    </select>
</div>

<div class="form-group">
    <label for="post_author">Post Author</label>
    <input type="text" name="post_author" class="form-control" value="<?php echo $post_author ?>">
</div>

<div class="form-group">
    <label for="post_status">Post Status</label>
    <select name="post_status" id="post_status">
        <option value = 'draft' <?php if ($post_status=='draft') echo "selected"; ?>>Draft</option>
        <option value = 'published' <?php if ($post_status=='published') echo "selected"; ?>>Published</option>
    </select>
</div>

<div class="form-group">
    <label for="post_image">Post Image</label>  
    <input type="file" name="post_image">
    <img width="200" src="../images/<?php echo $post_image;?>" alt="">
</div>
<div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" name="post_tags" class="form-control" value="<?php echo $post_tags ?>">
</div>
<div class="form-group">
    <label for="title">Post Content</label>
    <textarea id="body" cols="30" rows="10" type="text" name="post_content" class="form-control"><?php echo $post_content ?></textarea>
</div>

<div class="form-group">
    <input type="submit" name="update_post" value ="Update Post" class="btn btn-primary">
    <input type="submit" name="delete_post" value ="Delete Post" class="btn btn-danger">
</div>

</form>