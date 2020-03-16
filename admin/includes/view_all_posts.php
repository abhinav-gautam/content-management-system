<?php 

if(isset($_POST['checkBoxArray'])){
    foreach ($_POST['checkBoxArray'] as $checkBoxValue) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'publish':
                $checkBoxValue = escape($checkBoxValue);
                $query = "UPDATE posts SET post_status = 'published' WHERE post_id = '{$checkBoxValue}'";
                $query_result = mysqli_query($connection,$query);
                confirm_query($query_result);
                break;

            case 'draft':
                $checkBoxValue = escape($checkBoxValue);
                $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = '{$checkBoxValue}'";
                $query_result = mysqli_query($connection,$query);
                confirm_query($query_result);
                break;
                
            case 'delete':
                $checkBoxValue = escape($checkBoxValue);
                $query = "DELETE FROM posts WHERE post_id = '{$checkBoxValue}' ";
                $query_result = mysqli_query($connection,$query);
                confirm_query($query_result);
                break;

            case 'clone':
                $checkBoxValue = escape($checkBoxValue);
                $query = "SELECT * FROM posts WHERE post_id = '{$checkBoxValue}' ";
                $query_result = mysqli_query($connection,$query);
                confirm_query($query_result);
                $row = mysqli_fetch_assoc($query_result);

                $post_category_id = $row['post_category_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = 0;
                $post_status = $row['post_status'];
                $post_content = $row['post_content'];

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
                break;

            
           
        }
    }
}
?>
<form action="" method="post">

    <div class="col-xs-4" id="bulkOptionContainer" style="padding-left:15px;">
        <select name="bulk_options" id="" class="form-control">
            <option value="">Select Options</option>
            <option value="publish">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" value="Apply" class="btn btn-success" name="submit">
        <a href="./posts.php?source=add_posts" class="btn btn-primary">Add New</a>
    </div>
    <div class="col-lg-12 table-responsive">
        <table class="table table-bordered table-hover table-light ">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAllBoxes"></th>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Date</th>
                    <th>Comments</th>
                    <th>Views</th>
                    <th>Publish</th>
                    <th>Draft</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>

                <?php insert_posts(); ?>

            </tbody>
        </table>
    
    </div>
    
</form>

