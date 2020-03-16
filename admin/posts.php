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

                    <div class="col-xs-12">
                        <?php
                        
                        if (isset($_GET['delete'])) {
                            if (isset($_SESSION['user_id'])) {
                                $post_id = $_GET['delete'];
                                delete_post($post_id);
                            }
                        }
                        
                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                            
                        }else {
                            $source = "";
                        }
                        switch ($source) {
                            case 'add_posts':
                                if (isset($_SESSION['user_id'])) {
                                    include "includes/add_posts.php";
                                }
                                
                                break;
                            case 'edit_post':
                                if (isset($_SESSION['user_id'])) {
                                    include "includes/edit_post.php";
                                }
                                
                                break;
                            case 'publish_post':
                                if (isset($_SESSION['user_id'])) {
                                    $post_id = $_GET['post_id'];
                                    update_post_status('published',$post_id);
                                }
                                
                                break;
                            case 'draft_post':
                                if (isset($_SESSION['user_id'])) {
                                    $post_id = $_GET['post_id'];
                                    update_post_status('draft',$post_id);
                                }
                                
                                break;
                            case 'reset_views':
                                if (isset($_SESSION['user_id'])) {
                                    $post_id = $_GET['post_id'];
                                    reset_views($post_id);
                                }
                                
                                break;
                            default:
                                include "includes/view_all_posts.php";
                                break;
                        }
                        
                        ?>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "includes/admin_footer.php" ?>   