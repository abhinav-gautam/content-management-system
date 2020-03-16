<div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" name="submit" type="Submit">
                                    <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </span>
                        </div>
                        <!-- /.input-group -->
                    </form>                   
                </div>

                <?php 
                if (!isset($_SESSION['user_id'])) {
                    ?>
                    <!-- Login Form -->
                    <div class="well">
                       <h4>Login</h4>
                       <form action="includes/login.php" method="post">
                           <div class="form-group">
                               <input type="text" name="username" class="form-control" placeholder="Username">
                           </div>
                           <div class="input-group">
                               <input type="password" name="password" class="form-control" placeholder="Password">
                               <span class="input-group-btn">
                                   <button class="btn btn-primary" name="login" type="Submit">
                                       Login
                                   </button>
                               </span>
                           </div>
                       </form>                   
                   </div> 
                   <?php
                }
                
                ?>
                 

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">

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
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <!-- <?php // include "widget.php"; ?> -->

            </div>