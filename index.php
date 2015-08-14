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

                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                        <li><a href="#">Link</a></li>
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



        <div class="panel panel-info" id="entry-index">
            <div class="panel-heading">
                <h1 class="panel-title">Entry Index</h1>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-sm-2">Title</th>
                            <th class="col-sm-2">Author</th>
                            <th class="col-sm-2">Date Added</th>
                            <th class="col-sm-3">Preview</th>
                            <th class="col-sm-1">Delete</th>
                            <th class="col-sm-1">Edit</th>
                            <th class="col-sm-1">View</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($get_posts->fetch()){ ?>
                        <tr>
                            <td class="title"><?php echo $title; ?></td>
                            <td><?php echo $author; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><?php
                                $preview = substr($contents, 0, 49);
                                echo $preview;
                                if (strlen($contents) > 50) {
                                    echo '...';
                                }
                                ?>
                            </td>
                            <td><!--todo - get these stupid buttons to center-->
                                <a class="btn btn-danger" href="delete_post.php?postid=<?php echo $id; ?>">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-warning" href="edit_post.php?postid=<?php echo $id; ?>">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </a>
                            </td>
                            <td>
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
                    echo "<a href='index.php' class='btn btn-default'>Home</a>";
                }
                ?>
                <a href="new_post.php" class="btn btn-default">Add New Post</a>
            </div>
        </div>



        <!--todo - add search by tag-->




        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
