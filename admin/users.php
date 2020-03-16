<?php include "includes/admin_header.php" ?>
<?php if($_SESSION['user_role'] != 'admin') header("Location: index.php"); ?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

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
                            if ($_SESSION['user_role'] == 'admin') {
                                delete_user();
                            }
                        }
                        if (isset($_GET['change_to_sub'])) {
                            if ($_SESSION['user_role'] == 'admin') {
                                update_user_role("subscriber",$_GET['change_to_sub']);
                            }                            
                        }
                        if (isset($_GET['change_to_admin'])) {
                            if ($_SESSION['user_role'] == 'admin') {
                                update_user_role("admin",$_GET['change_to_admin']);
                            }                           
                        }

                        ?>
                        <?php
                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                        }else {
                            $source = "";
                        }
                        switch ($source) {
                            case 'add_users':
                                include "includes/add_users.php";
                                break;
                            case 'edit_user':
                                include "includes/edit_user.php";
                                break;
                            
                            default:
                                include "includes/view_all_users.php";
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