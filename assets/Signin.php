<?php
require_once('../backend/cnx.php');
$password_false;

if(($_SERVER["REQUEST_METHOD"]== "POST") && isset($_POST["sb"])){

    $username=htmlentities($_POST["login"]);
    $pwd=htmlentities($_POST["pwd"]);

    $query="SELECT * FROM administateur WHERE username='$username' AND password='$pwd'";
    $result=mysqli_query($id,$query);

    if(mysqli_num_rows($result) == 1){
        session_start();
        $getUserAdmin=mysqli_fetch_assoc($result);
        $_SESSION['admin']=$getUserAdmin['username'];
        header("location:../assets/affichage.php");
    } else {
        $password_false=true;
    }

}


mysqli_close($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign in</title>
    <link rel="stylesheet" href="../css/Signin.css">
    <style>
        body{
            font-family:sans-serif;
        }
    </style>
</head>
<body>
    <section>
        <div class="formlogin">
            <p>Se Connecter</p>
            <?php
                if(@$password_false){
                    echo '<h2 class=error>username or password incorrect</h2>';
                }
            ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method='POST'>
                <div id="areas">
                    <input type="text" name="login" id="login" placeholder="username">
                    <input type="password" name="pwd" id="pwd" placeholder="password">
                </div>
                <br>
                <div id='input'>
                    <input type="submit" name='sb' value="login">
                </div>
            </form> 
        </div>
    </section>
</body>
</html>