<?php
//open $session
session_start();
//if user is not logged in, go to login index
if(!isset($_SESSION['user'])) {
    header('Location: user/login.php');
}

//Connect to database
include_once('db_info.php');

//grab global tags
$gTags = grab_all_tags();
//todo - clean up and comment index.php
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cloud Journal</title>
        <!--Bootstrap-->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
        <!--Customizable Stylesheet-->
        <link href="style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="#">Cloud Journal</a>
                            </div>
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                                <p class="navbar-text hidden-sm">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    <?php echo $_SESSION['user']; ?>
                                </p>

                                <ul class="nav navbar-nav">
                                    <li><a href="user/logout.php">Logout</a></li>
                                </ul>

                                <form action ="index.php" method="get" class="navbar-form navbar-right" role="search">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Search" name="term">
                                    </div>
                                    <button type="submit" class="btn btn-default">Submit</button>
                                    <input type="hidden" name="search">
                                </form>

                            </div>
                        </div>
                    </nav>
                </div>
            </div>





            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-info" id="entry-index">
                        <div class="panel-heading">
                            <h1 class="panel-title">
                                <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp&nbspEntry Index
                            </h1>
                        </div>
                        <?php
                        if(isset($_GET['search'])){ ?>
                            <div class="panel-body">
                                <h4>Posts That Contain: <em><?php echo $_GET['term']; ?></em></h4>
                            </div>
                        <?php }
                        if(isset($_GET['tSearch'])){ ?>
                            <div class="panel-body">
                                <h4>Posts With Tag: <em><?php echo $_GET['tSearch']; ?></em></h4>
                            </div>
                        <?php } ?>

                        <?php
                        //SEARCH / LIST POSTS
                        //  Controls index.php
                        //  If search is set, query is prepared using SELECT WHERE and LIKE
                        //  Parameters are bound with the search term
                        //  Executed
                        //  Finally ->bind_result is used to retrieve results
                        //  If no search is entered, a simple SELECT query is prepared to list all posts
                        //  This is set up in a ->prepare->execute->bind_result formula to keep index.php HTML simple
                        //  ->fetch() is called in the index.php page
                        if (isset($_GET['search'])) {
                            $get_posts = $db->prepare("SELECT * FROM posts WHERE author=? AND contents LIKE ?");
                            $p_search = "%" . $_GET['term'] . "%";
                            $get_posts->bind_param('ss', $_SESSION['user'], $p_search);
                        } else if (isset($_GET['tSearch'])) {
                            $lg_query = 'SELECT posts.id, posts.title, posts.author, posts.date, ';
                            $lg_query .= 'posts.date_mod, posts.contents ';
                            $lg_query .= 'FROM posts, tags, posts_to_tags ';
                            $lg_query .= 'WHERE posts.id = posts_to_tags.post_id ';
                            $lg_query .= 'AND tags.id = posts_to_tags.tag_id ';
                            $lg_query .= 'AND tags.id = ? ';
                            $lg_query .= 'AND posts.author = ?';
                            $get_posts = $db->prepare($lg_query);
                            $get_posts->bind_param('is', $_GET['tagID'], $_SESSION['user']);
                        } else {
                            $get_posts = $db->prepare('SELECT * FROM posts WHERE author=?');
                            $get_posts->bind_param('s', $_SESSION['user']);
                        }
                        $get_posts->execute();
                        $get_posts->bind_result($id, $title, $author, $date, $date_mod, $contents);

                        $get_posts->store_result(); //needed for num_rows
                        $rows = $get_posts->num_rows;

                        //check if there are any posts
                        if($rows == 0){
                            if(isset($_GET['search'])){
                                echo "<div class='panel-body'>";
                                echo "<h4>No posts found.</h4>";
                                echo "</div>";
                            } else if(isset($_GET['tSearch'])){
                                echo "<div class='panel-body'>";
                                echo "<h4>No posts found with this tag.</h4>";
                                echo "</div>";
                            } else {
                                echo "<div class='panel-body'>";
                                echo "<h4>Add your first post!</h4>";
                                echo "</div>";
                            }
                        } else {

                        ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-8 col-sm-3">Title</th>
                                        <th class="hidden-xs col-sm-2">Date</th>
                                        <th class="hidden-xs col-sm-4">Preview</th>
                                        <th class="hidden-xs col-sm-1">Delete</th>
                                        <th class="hidden-xs col-sm-1">Edit</th>
                                        <th class="col-xs-4 col-sm-1">View</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                while($get_posts->fetch()){ ?>
                                    <tr>
                                        <td class="title col-xs-8 col-sm-3"><?php echo $title; ?></td>
                                        <td class="hidden-xs col-sm-2"><?php echo substr($date, 0, -7); ?></td>
                                        <td class="hidden-xs col-sm-4"><?php
                                            $preview = substr($contents, 0, 39);
                                            echo $preview;
                                            if (strlen($contents) > 40) {
                                                echo '...';
                                            }
                                            ?>
                                        </td>
                                        <td class="hidden-xs col-sm-1">
                                            <button class="btn btn-danger post-delete" data-post-id="<?php echo $id; ?>">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </td>
                                        <td class="hidden-xs col-sm-1">
                                            <a class="btn btn-warning" href="edit_post.php?postid=<?php echo $id; ?>">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </a>
                                        </td>
                                        <td class="col-xs-4 col-sm-1">
                                            <a class="btn btn-success" href="view_post.php?postid=<?php echo $id; ?>">
                                                <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                                            </a>
                                        </td>
                                    </tr>

                                <?php
                                }
                                $get_posts->close();

                                ?>
                                </tbody>
                            </table>
                        </div>

                        <?php } ?>

                        <div class="panel-footer">
                            <a href="new_post.php" class="btn btn-default">Add New Post</a>
                            <?php
                            if(isset($_GET['search']) || isset($_GET['tSearch'])){
                                echo "<a href='index.php' class='btn btn-primary'>Clear Search</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-primary" id="tag-sort-panel">
                        <div class="panel-heading">
                            <h1 class="panel-title"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Sort By Tag</h1>
                        </div>
                        <div class="panel-body">
                            <?php
                            if(!$gTags){
                                echo "<h4>Tags will appear here.</h4>";
                            } else {
                                foreach($gTags as $id => $tag) { //sTag = sort tag ?>
                                    <form action="index.php" method="get" class="tag-sort">
                                        <input type="submit" name="tSearch" class="btn btn-default" value="<?php echo $tag; ?>">
                                        <input type="hidden" name="tagID" value="<?php echo $id; ?>">
                                    </form>
                                <?php }
                            } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="delete-warning" class="hidden">
            <div class="panel panel-danger col-xs-10 col-sm-4">
                <div class="panel-heading"><h1 class="panel-title">WARNING</h1></div>
                <div class="panel-body">
                    Are you sure you want to delete this post? This change is permanent and cannot be undone.
                </div>
                <div class="panel-footer">
                    <button class="btn btn-danger delete" id="deleteID">I'm sure</button>
                    <button class="btn btn-default pull-right" id="nevermind">Nevermind</button>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Include app.js -->
        <script src="app.js"></script>
    </body>
</html>
