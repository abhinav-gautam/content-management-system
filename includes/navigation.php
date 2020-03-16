<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS</a>
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <?php 
                        $query = "SELECT * FROM categories";
                        $selected_categories = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($selected_categories)) {
                            $cat_title = $row['cat_title'];
                            $cat_id = $row['cat_id'];
                            
                            echo "
                                <li>
                                    <a href='category.php?cat_id={$cat_id}'>{$cat_title}</a>
                                </li>
                            ";
                        }
                    
                    ?>
                    <?php
                        if (isset($_SESSION['user_id'])) {
                            ?>
                             <li>
                                <a href="<?php if($_SESSION['user_role'] == 'admin') echo 'admin'; else echo 'admin/posts.php'; ?>">Admin</a>
                            </li>
                            <?php
                        }
                    ?>
                    <?php
                        if (!isset($_SESSION['user_id'])) {
                            ?>
                            <li>
                                <a href="registration.php">Registration</a>
                            </li>
                            <?php
                        }
                    ?>
                    
                    <?php 
                    
                    if(isset($_SESSION['user_id'])){
                        if (isset($_GET['p_id']) && isset($_GET['pa'])) {
                            $post_id = $_GET['p_id'];
                            $post_author =$_GET['pa'];
                            if ($_SESSION['user_role'] == 'admin') {
                                echo "
                                <li>
                                    <a href='admin/posts.php?source=edit_post&post_id={$post_id}'>Edit</a>
                                </li>
                                ";
                            }else if ($_SESSION['user_role'] != 'admin' && $_SESSION['username'] == $post_author) {
                                echo "
                                <li>
                                    <a href='admin/posts.php?source=edit_post&post_id={$post_id}'>Edit</a>
                                </li>
                                ";
                            }
                        }
                    }
                    ?>
                    
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>

                    <?php
                        if (isset($_SESSION['user_id'])) {
                            ?>
                             <li class="dropdown text-right">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="admin/profile.php"><i class="glyphicon glyphicon-user"></i> Profile</a>
                                    </li>               
                                    <li>
                                        <a href="includes/logout.php"><i class="glyphicon glyphicon-off"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>
                            
                            <?php
                        }
                    ?>
                     
                   

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>