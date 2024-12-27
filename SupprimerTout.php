<?php
if(isset($_POST["ck"])){
    //echo $_GET["id"];
    require_once("cnx.php");
    $reqs=mysqli_query($id,"select * FROM stagiaire WHERE id in(".implode(",",$_POST["ck"]).")");
    while($row=mysqli_fetch_assoc($reqs)){
    unlink($row["avatar_path"]);
    unlink($row["fiche_path"]);
}
    $req=mysqli_query($id,"DELETE FROM stagiaire WHERE id in(".implode(",",$_POST["ck"]).")");
    if($req){
        header("location:affichage.php");
    }
}
//DELETE FROM stagiaire WHERE id = 1