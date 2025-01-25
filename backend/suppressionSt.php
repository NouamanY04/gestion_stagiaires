<?php
if(isset($_GET["id"])){
    //echo $_GET["id"];
    require_once("cnx.php");
    $reqs=mysqli_query($id,"select * FROM stagiaire WHERE id =".$_GET["id"]);
    $row=mysqli_fetch_assoc($reqs);
        unlink("../assets/".$row["avatar_path"]);
    $req=mysqli_query($id,"DELETE FROM stagiaire WHERE id =".$_GET["id"]);
    if($req){
        header("location:../assets/affichage.php");
        setcookie('deletesuccess','1',time()+1,'/');
    }
}
