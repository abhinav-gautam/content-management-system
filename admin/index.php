<?php include "includes/admin_header.php" ?>

<div id="wrapper">
    

    <!-- Navigation -->
    <?php 
        if ($_SESSION['user_role']=='admin') {
            include "includes/admin_navigation.php" ;
        }else{
            include "includes/subscriber_navigation.php"; 
        }
    ?>

    <div id="page-wrapper">

        <div class="container-fluid">
        
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome To Admin
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->

                   
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                <?php 
                                    $query = "SELECT * FROM posts";
                                    $selected_posts_result = mysqli_query($connection,$query);
                                    $post_count = mysqli_num_rows($selected_posts_result);
                                    echo "<div class='huge'>{$post_count}</div>";
                                ?>
                                


                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                <?php 
                                    $query = "SELECT * FROM comments";
                                    $selected_comments_result = mysqli_query($connection,$query);
                                    $comments_count = mysqli_num_rows($selected_comments_result);
                                    
                                    echo "<div class='huge'>{$comments_count}</div>";
                                ?>

                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">


                                <?php 
                                    $query = "SELECT * FROM users";
                                    $selected_users_result = mysqli_query($connection,$query);
                                    $users_count = mysqli_num_rows($selected_users_result);
                                    echo "<div class='huge'>{$users_count}</div>";
                                ?>

                                    
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">


                                <?php 
                                    $query = "SELECT * FROM categories";
                                    $selected_categories_result = mysqli_query($connection,$query);
                                    $categories_count = mysqli_num_rows($selected_categories_result);
                                    echo "<div class='huge'>{$categories_count}</div>";
                                ?>


                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->



                <?php

                $query = "SELECT * FROM posts WHERE post_status = 'draft'";
                $selected_draft_post_result = mysqli_query($connection,$query);
                $draft_post_count = mysqli_num_rows($selected_draft_post_result);               

                $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                $selected_unapproved_comments_result = mysqli_query($connection,$query);
                $unapproved_comments_count = mysqli_num_rows($selected_unapproved_comments_result);          
                
                $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                $selected_subscribers_result = mysqli_query($connection,$query);
                $subscribers_count = mysqli_num_rows($selected_subscribers_result);   
                
                $active_post_count = $post_count - $draft_post_count;
                $admins_count = $users_count - $subscribers_count;
                $active_comment_count = $comments_count - $unapproved_comments_count;
                
                ?>

                <div class="row">
                <script type="text/javascript">
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['Data', 'Count'],
                    <?php
                    
                    $elements_text = ['Active Posts','Draft Posts', 'Active Comments','Pending Comments','Admins','Subscribers','Categories'];
                    $elements_count = [$active_post_count,$draft_post_count, $active_comment_count,$unapproved_comments_count,$admins_count,$subscribers_count,$categories_count];

                    for ($i=0; $i < 7; $i++) { 
                        echo "['{$elements_text[$i]}',{$elements_count[$i]}],";
                    }
                    
                    
                    ?>
                    ]);

                    var options = {
                    chart: {
                        title: '',
                        subtitle: '',
                    }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
                </script> 

                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "includes/admin_footer.php" ?>   