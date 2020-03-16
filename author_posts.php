<?php include "includes/header.php";?>
<?php include "includes/db.php";?>
<!-- Navigation -->
<?php include "includes/navigation.php";?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

        

            <?php 

                if (isset($_GET['author'])) {
                    $post_author = escape($_GET['author']);
                    $query = "SELECT * FROM posts WHERE post_author = '{$post_author}'";
                    $selected_posts = mysqli_query($connection, $query);
                    if (!$selected_posts) {
                        die("Query Failed:".mysqli_error($connection));
                    }
                    while ($row = mysqli_fetch_assoc($selected_posts)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,100);
                        $post_date = $row['post_date'];
                        $post_status = $row['post_status'];

                        if ($post_status == "published") {
                            

                        ?>
                        
                        <!-- First Blog Post -->
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="#"><?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                        <hr>
                        <a href="post.php?p_id=<?php echo $post_id; ?>&pa=<?php echo $post_author; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                        
                        <hr>
                        <p ><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>&pa=<?php echo $post_author; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                        
                            <?php
                        }
                    }             
                }
                // Getting posts
                       
                
            ?>     

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>
 