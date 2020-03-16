<div class="table-responsive">

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response to </th>
                <th>Date</th>
                <th>Approve</th>
                <th>Reject</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

            <?php 
                $comment_post_id = escape($_GET['comment_post_id']);
                $query = "SELECT * FROM comments WHERE comment_post_id = '{$comment_post_id}'";
                $selected_comments = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($selected_comments)) {
                    $comment_id = $row['comment_id'];
                    $comment_post_id = $row['comment_post_id'];
                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];
                    $comment_email = $row['comment_email'];
                    $comment_status = $row['comment_status'];
                    $comment_date = $row['comment_date'];
                    
            
                    
                    echo "
                        <tr>
                            <td>{$comment_id}</td>
                            <td>{$comment_author}</td>
                            <td>{$comment_content}</td>
                        
                            <td>{$comment_email}</td>
                            <td>{$comment_status}</td>
                        ";
            
                    $query = "SELECT * FROM posts WHERE post_id = '{$comment_post_id}' ";
                    $selected_post = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($selected_post);
                    $post_title = $row['post_title'];
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                        
                    echo "<td><a href='../post.php?p_id={$post_id}&pa={$post_author}'>{$post_title}</a></td>";
            
                    echo "
                            <td>{$comment_date}</td>
                            <td><a href='post_comments.php?approve={$comment_id}&comment_post_id={$comment_post_id}'>Approve</a></td>
                            <td><a href='post_comments.php?reject={$comment_id}&comment_post_id={$comment_post_id}'>Reject</a></td>
                            <td><a onClick = \" javascript: return confirm('Are you sure you want to delete?') \" href='post_comments.php?delete={$comment_id}&p_id={$post_id}&comment_post_id={$comment_post_id}'>Delete</a></td>
                        </tr>
                    ";
                }
            
            ?>

        </tbody>
    </table>
</div>
