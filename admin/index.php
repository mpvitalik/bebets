<?php

session_start();

if(isset($_SESSION['admin']) && $_SESSION['admin']==true){
    header("Location:prognozi.php");
}

if($_SERVER['REQUEST_METHOD']=="POST"){

    $login = isset($_POST['login'])? $_POST['login'] : header("Location:".$_SERVER['PHP_SELF']);
    $pass = isset($_POST['pass'])? $_POST['pass'] : header("Location:".$_SERVER['PHP_SELF']);

    if($login == "prognozi" && $pass == "prognozi"){
        $_SESSION['admin']=true;
        header("Location:prognozi.php");
    }else{
        header("Location:".$_SERVER['PHP_SELF']);
    }
}



?>




<!doctype html>
<html>
<head>
    <meta charset="utf-8">
        <!-- Latest compiled and minified CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>



<div class="container" style="margin-top: 100px;">

    <div class="row">

        <div class="col-md-4 col-md-offset-4">

            <div class="panel panel-primary">
                <div class="panel-heading">Вход</div>
                <div class="panel-body">
                    <center>
                    <form action="index.php" method="post">
                        <strong>Login:</strong><br>
                        <input name="login" type="text"><br>
                        <strong>Password:</strong><br>
                        <input name="pass" type="password"><br><br>
                        <button class="btn btn-primary" type="submit">Enter</button>
                    </form>
                    </center>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>


