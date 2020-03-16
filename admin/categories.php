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

                    

                    <?php 
                        // Add category
                        if (isset($_POST['submit'])) {
                            add_category();
                        }
                    ?>

                    <?php 
                        // Delete category
                        if (isset($_GET['delete'])) {
                            delete_category();
                        }
                    ?>
                    

                    <div class="col-xs-6">
                        <form action="" method="post">
                            <label for="cat_title">Add Category</label>
                            <div class="form-group">
                                <input type="text" name="cat_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                            </div>
                        </form><!--Add Category Form-->

                        <?php 
                        // Edit Category
                        if (isset($_GET['edit'])) {
                            
                            $cat_title = update_category();
                            ?>

                            <form action="" method="post">
                                <label for="cat_title">Update Category</label>
                                <div class="form-group">
                                    <input value="<?php echo $cat_title; ?>" type="text" name="cat_title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="update" value="Update Category" class="btn btn-primary">
                                </div>
                            </form><!--Update Category Form-->
                            <?php
                        }
                        ?>
                    </div>

                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php insert_categories(); ?>
                
                            </tbody>
                        </table>
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