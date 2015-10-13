<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: ../index.php'); //if user logged in, go to index
}

include_once('../db_info.php');

//todo password isn't case sensitive for some reason
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cloud Journal - Login</title>
    <!--Bootstrap-->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <!--Customizable Stylesheet-->
    <link href="../style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div class="container">
    <form action="login.php" method="post">
        <div class="row">
            <div class="hidden-xs col-sm-3 col-md-4">&nbsp;</div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="panel panel-info" id="login-panel">

                    <div class="panel-heading">
                        <h1 class="panel-title">Cloud Journal - Login</h1>
                    </div>

                    <div class="panel-body">

                        <div class="input-group bottom-space">
                            <div class="input-group-addon" id="input-username"><span class="glyphicon glyphicon-user"
                                                                                     aria-hidden="true"></span></div>
                            <input type="text" name="username" class="form-control" placeholder="Username"
                                   aria-describedby="input-username"><br/>
                        </div>

                        <div class="input-group">
                            <div class="input-group-addon" id="input-password"><span class="glyphicon glyphicon-lock"
                                                                                     aria-hidden="true"></span></div>
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                   aria-describedby="input-password" autocomplete="off"><br/>
                        </div>

                        <?php

                        //if form submitted
                        if (isset($_POST['login'])) {
                            $username = $_POST['username'];
                            $password = $_POST['password'];

                            if ($username == '' || $password == '') {
                                echo '<p>Please Enter Your Username & Password</p>';
                            } else if (preg_match("#^[a-zA-Z0-9]+$#", $username) && preg_match("#^[a-zA-Z0-9]+$#", $password)) {
                                //find login credentials
                                $login = $db->prepare('SELECT * FROM user_logins WHERE username=? AND password=?');
                                $login->bind_param('ss', $username, $password);
                                $login->execute();
                                $login->store_result(); //needed for ->num_rows property
                                $rows = $login->num_rows; //if $rows is non-zero, username password combo matched
                                if ($rows == 1) {
                                    $_SESSION['user'] = $username;
                                    header('Location: ../index.php');
                                } else {
                                    echo "<p>Invalid Username or Password</p>";
                                }
                            }
                        } ?>
                    </div>

                    <div class="panel-footer">
                        <a href="new_user.php" class="btn btn-default">Create New User</a>
                        <input type="submit" name="login" value="Login" class="btn btn-success pull-right">
                    </div>
                </div>
            </div>
            <div class="hidden-xs col-sm-3 col-md-4">&nbsp;</div>
        </div>
    </form>

    <br/><br/><hr/><br/><br/>

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2 class="panel-title">Cloud Journal - Notes</h2>
                </div>

                <div class="panel-body">

                    <p class="lead">
                        Cloud Journal was built as a final project for the Austin Coding Academy
                        PHP Introduction class. The assignment was to utilize PHP and MySQL to create a database
                        driven web application.
                    </p>

                    <p>
                        To test out the site, you can either create a new account or use the credentials listed below
                        to load a sample profile.
                    </p>

                    <p class="center"><strong>Username: </strong>user123</p>
                    <p class="center"><strong>Password: </strong>developer</p>

                </div>
            </div>

        </div>
    </div>

</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- Include app.js -->
<script src="/app.js"></script>
</body>
</html>






