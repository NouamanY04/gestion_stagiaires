<?php
if(isset($_GET["id"])){
    //echo $_GET["id"];
    require_once("cnx.php");
    $reqs=mysqli_query($id,"select * FROM stagiaire WHERE id =".$_GET["id"]);
    $row=mysqli_fetch_assoc($reqs);
        unlink($row["avatar_path"]);
        unlink($row["fiche_path"]);
    $req=mysqli_query($id,"DELETE FROM stagiaire WHERE id =".$_GET["id"]);
    if($req){
        header("location:affichage.php");
        setcookie('deletesuccess','1',time()+1,'/');
    }
}
//DELETE FROM stagiaire WHERE id = 1