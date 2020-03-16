<?php include "includes/header.php";?>
<?php include "includes/db.php";?>

<!-- Navigation -->
<?php include "includes/navigation.php";?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-lg-8">

            <?php 
                if (isset($_GET['p_id'])) {
                    $post_id = escape($_GET['p_id']);
                }else{
                    header("Location: index.php");
                }
                
                $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '{$post_id}' ";
                $view_count_inc_result = mysqli_query($connection, $query);

                $query = "SELECT * FROM posts WHERE post_id = '{$post_id}' ";
                $selected_posts = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($selected_posts)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    $post_date = $row['post_date'];

                    ?>
                    
                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p ><?php echo $post_content; ?></p>
                    <hr>
                    
                    <?php
                }
            
            ?>     

            <?php
                // Creating comments
                if (isset($_POST['submit_comment'])) {
                    $comment_author = escape($_POST['comment_author']);
                    $comment_email = escape($_POST['comment_email']);
                    $comment_content = escape($_POST['comment_content']);

                    $post_id = escape($_GET['p_id']);

                    if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                        $query = "INSERT INTO comments(
                            comment_post_id, comment_author,
                            comment_email, comment_content,
                            comment_status, comment_date 
                            ) ";
                        $query .= "VALUES (
                            $post_id, '{$comment_author}',
                            '{$comment_email}', '{$comment_content}',
                            'approved', now()
                        )";
    
                        $create_comment_result = mysqli_query($connection,$query);
                        confirm_query($create_comment_result);
    
                        $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = '{$post_id}' ";
                        $increment_comment_count_result = mysqli_query($connection,$query);
                        confirm_query($increment_comment_count_result);
                    } else {
                        echo "<script>alert('Fields cannot be empty.')</script>";
                    } 
                }
            ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" method="post" action="#">
                    <div class="form-group">
                        <label for="comment_author">Name</label>
                        <input type="text" name="comment_author" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="comment_email">Email</label>
                        <input type="email" name="comment_email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="comment_content">Comment</label>
                        <textarea class="form-control" name="comment_content" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <?php
                // Getting comments
            $query = "SELECT * FROM comments WHERE comment_post_id = '{$post_id}' ";
            $query .= "AND comment_status = 'approved' ORDER BY comment_id DESC";
            $selected_comment = mysqli_query($connection,$query);
            confirm_query($selected_comment);

            while ($row = mysqli_fetch_assoc($selected_comment)) {
                $comment_author = $row['comment_author'];
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];

            ?>
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"> <?php echo $comment_author; ?>
                        <small><?php echo $comment_date; ?></small>
                    </h4>
                    <?php echo $comment_content; ?>
                </div>
            </div>

            <?php
            }
            ?>

            

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

<?php include "includes/footer.php";?>
 