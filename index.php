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
                $per_page = 5;

                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                }else{
                    $page = 1;
                }
                if ($page == 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }
                

                $query = "SELECT * FROM posts";
                $selected_posts = mysqli_query($connection, $query);
                $count = mysqli_num_rows($selected_posts);
                $count = ceil($count/$per_page);

                // Getting posts
                $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT {$page_1},{$per_page}";
                $selected_posts = mysqli_query($connection, $query);
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
                        by <a href="author_posts.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
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
                
            ?>     

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <ul class="pager">
    <?php

    for ($i=1; $i <= $count; $i++) { 
        if ($i == $page) {
            echo "<li><a class ='active-link' href='index.php?page={$i}'>{$i}</a></li>";
        } else {
            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
        }
        
    }
    
    ?>
    </ul>

<?php include "includes/footer.php";?>
 