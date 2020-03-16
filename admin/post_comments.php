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
                            delete_comment();
                            header("Location: post_comments.php?comment_post_id={$_GET['comment_post_id']}");

                        }
                        ?>
                        <?php
                        
                        if (isset($_GET['reject'])) {
                            $comment_status = 'unapproved';
                            $comment_id = $_GET['reject'];
                            update_comment_status($comment_status, $comment_id);
                            header("Location: post_comments.php?comment_post_id={$_GET['comment_post_id']}");
                        }
                        if (isset($_GET['approve'])) {
                            $comment_status = 'approved';
                            $comment_id = $_GET['approve'];
                            update_comment_status($comment_status, $comment_id);
                            header("Location: post_comments.php?comment_post_id={$_GET['comment_post_id']}");
                        }
                        ?>
                        <?php include "includes/view_all_post_comments.php"; ?>
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