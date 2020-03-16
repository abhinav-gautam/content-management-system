<?php

if (isset($_POST['create_post'])) {
    $post_title = escape($_POST['post_title']);
    if ($_SESSION['user_role']=='admin') {
        $post_author = escape($_POST['post_author']);
    }else{
        $post_author = escape($_SESSION['username']);
    }
    
    $post_category_id = escape($_POST['post_category']);
    $post_status = escape($_POST['post_status']);
    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);

    $post_image = escape($_FILES['post_image']['name']);
    $post_image_temp = escape($_FILES['post_image']['tmp_name']);
    $post_date = date('d-m-y');
    $post_comment_count = 0;

    move_uploaded_file($post_image_temp,"../images/$post_image");

    $query = "INSERT INTO posts(
        post_category_id, post_title,
        post_author, post_date,
        post_image, post_content,
        post_tags, post_comment_count,
        post_status) ";
    $query .= "VALUES(
        {$post_category_id}, '{$post_title}',
        '{$post_author}', now(),
        '{$post_image}', '{$post_content}',
        '{$post_tags}', {$post_comment_count},
        '{$post_status}' )";

    $add_post_result = mysqli_query($connection, $query);
    confirm_query($add_post_result);

    $post_id = mysqli_insert_id($connection);

    echo "<p class='bg-success'>Post Created: <a href='../post.php?p_id={$post_id}&pa={$post_author}'>View Post</a> or <a href='posts.php?source=edit_post&post_id={$post_id}'>Edit Post</a></p>";
}

?>



<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="post_title" class="form-control">
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

    <?php
    if ($_SESSION['user_role']=='admin') {
        ?>
        <div class="form-group">
            <label for="post_author">Post Author</label>
            <input type="text" name="post_author" class="form-control">
        </div>
        <?php
    }
    
    ?>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status">
            <option value = 'draft' selected>Draft</option>
            <option value = 'published'>Published</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" name="post_tags" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="body" cols="30" rows="10" type="text" name="post_content" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" name="create_post" value ="Publish Post" class="btn btn-primary">
    </div>

</form>