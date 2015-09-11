<?php
include_once('../db_info.php');
session_start();
if (isset($_SESSION['user'])) {
    header('Location: ../index.php'); //if user logged in, go to index
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cloud Journal - New User</title>
        <!--Bootstrap-->
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" />
        <!--Customizable Stylesheet-->
        <link href="../style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <form action="new_user.php" method="post">
                <div class="row">

                    <div class="hidden-xs col-sm-2 col-md-3">&nbsp;</div>
                    <div class="col-xs-12 col-sm-8 col-md-6">
                        <div class="panel panel-warning" id="new-usr-panel">
                            <div class="panel-heading">
                                <h1 class="panel-title">Create New Account</h1>
                            </div>
                            <div class="panel-body">

                                <div class="input-group bottom-space">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                    <input type="text" name="username" class="form-control" placeholder="Username"><br />
                                </div>

                                <div class="input-group bottom-space">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                                    <input type="password" name="password" class="form-control" placeholder="Password"><br />
                                </div>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></div>
                                    <input type="password" name="pass_check" class="form-control" placeholder="Re-Enter Password"><br />
                                </div>




                                <?php
                                //add new user + form validation
                                if (isset($_POST['new_user'])) {
                                    $username = strtolower($_POST['username']); //case insensitive
                                    $password = $_POST['password'];             //case sensitive
                                    $pass_check = $_POST['pass_check'];

                                    //if empty todo - make validation real-time with js
                                    if ($username == '' || $password == '' || $pass_check == '') {
                                        echo '<p>Please Fill In All Fields</p>';
                                    }

                                    //if passwords do not match
                                    else if ($pass_check != $password) {
                                        echo '<p>Please Make Sure Passwords Match</p>';
                                    }

                                    //if illegal characters used
                                    else if (!preg_match("#^[a-zA-Z0-9]+$#", $username) || !preg_match("#^[a-zA-Z0-9]+$#", $password)) {
                                        echo '<p>Usernames and passwords must be made of numbers and letters only.</p>';
                                    }

                                    //check if username already exists in system
                                    else {
                                        //make sure username doesn't already exist
                                        $check = $db->prepare('SELECT * FROM user_logins WHERE username=?');
                                        $check->bind_param('s', $username);
                                        $check->execute();
                                        $check->store_result();
                                        $rows = $check->num_rows;
                                        if ($rows == 1) {                                //if a row was returned, the username was found
                                            echo '<p>That username already exists</p>';
                                        } else {    //                                   //otherwise insert
                                            $new_usr = $db->prepare('INSERT INTO user_logins (username, password) VALUE (?,?)');
                                            $new_usr->bind_param('ss', $username, $password);
                                            $new_usr->execute();
                                            $_SESSION['user'] = $username;
                                            header('Location: ../index.php');
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="panel-footer">
                                <a href="login.php" class="btn btn-danger">Cancel</a>
                                <input type="submit" name="new_user" value="Create" class="btn btn-warning pull-right">
                            </div>
                        </div>
                    </div>

                    <div class="hidden-xs col-sm-2 col-md-3">&nbsp;</div>

                </div>
            </form>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <!-- Include app.js -->
        <script src="/app.js"></script>
    </body>
</html>
