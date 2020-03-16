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

                    if (isset($_POST['submit'])) {
                        $search = escape($_POST['search']);

                        $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                        $search_result = mysqli_query($connection, $query);
                        $row_count = mysqli_num_rows($search_result);

                        if (! $search_result) {
                            die("Query Failed:".mysqli_error($connection));
                        }

                        if ($row_count==0) {
                            echo "<h3>NO RESULT</h3>";
                        }else {
                            while ($row = mysqli_fetch_assoc($search_result)) {
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_image = $row['post_image'];
                                $post_content = $row['post_content'];
                                $post_date = $row['post_date'];
                                $post_status = $row['post_status'];

                                if ($post_status == 'published') {

                                    ?>
                                    
                                    <!-- First Blog Post -->
                                    <h2>
                                        <a href="#"><?php echo $post_title; ?></a>
                                    </h2>
                                    <p class="lead">
                                        by <a href="index.php"><?php echo $post_author; ?></a>
                                    </p>
                                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                                    <hr>
                                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                                    <hr>
                                    <p><?php echo $post_content; ?></p>
                                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                                    <hr>
                    
                                    <?php
                                }
                            }
                        }
                    }
           
                ?>

                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php";?>
 