<?php
//$index declared to set a trigger for a post pull query in db_info.php if no search is set
$index = true;
//Connect to database
include_once('db_info.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Blog</title>
        <!--Bootstrap-->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
        <!--Customizable Stylesheet-->
        <link href="style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="row">
            <div class="col-xs-1 col-sm-2">&nbsp</div>
            <nav class="navbar navbar-default col-xs-10 col-sm-8">
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

                        <p class="navbar-text hidden-sm">by Jerry Krusinski</p>

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
            <div class="col-xs-1 col-sm-2">&nbsp</div>
        </div>

        <div class="row">
            <div class="col-xs-1 col-sm-2">&nbsp</div>
            <div class="panel panel-info col-xs-10 col-sm-8" id="entry-index">
                <div class="panel-heading">
                    <h1 class="panel-title">
                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp&nbspEntry Index
                    </h1>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-xs-8 col-sm-3 col-md-2">Title</th>
                                <th class="hidden-xs hidden-sm col-md-2">Author</th>
                                <th class="hidden-xs col-sm-2 col-md-2">Date Added</th>
                                <th class="hidden-xs col-sm-4 col-md-3">Preview</th>
                                <th class="hidden-xs col-sm-1 col-md-1">Delete</th>
                                <th class="hidden-xs col-sm-1 col-md-1">Edit</th>
                                <th class="col-xs-4 col-sm-1 col-md-1">View</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        while($get_posts->fetch()){ ?>
                            <tr>
                                <td class="title col-xs-8 col-sm-3 col-md-2"><?php echo $title; ?></td>
                                <td class="hidden-xs hidden-sm col-md-2"><?php echo $author; ?></td>
                                <td class="hidden-xs col-sm-2 col-md-2"><?php echo $date; ?></td>
                                <td class="hidden-xs col-sm-4 col-md-3"><?php
                                    $preview = substr($contents, 0, 49);
                                    echo $preview;
                                    if (strlen($contents) > 50) {
                                        echo '...';
                                    }
                                    ?>
                                </td>
                                <td class="hidden-xs col-sm-1 col-md-1">
                                    <button class="btn btn-danger post-delete" data-post-id="<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td class="hidden-xs col-sm-1 col-md-1">
                                    <a class="btn btn-warning" href="edit_post.php?postid=<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>
                                </td>
                                <td class="col-xs-4 col-sm-1 col-md-1">
                                    <a class="btn btn-success" href="view_post.php?postid=<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <?php
                    if(isset($_GET['search'])){
                        echo "<a href='index.php' class='btn btn-primary'>Home</a>";
                    }
                    ?>
                    <a href="new_post.php" class="btn btn-default">Add New Post</a>
                </div>
            </div>
            <div class="col-xs-1 col-sm-2">&nbsp</div>
        </div>


        <!--todo - add search by tag-->
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
