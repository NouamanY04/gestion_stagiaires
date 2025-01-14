<?php
require_once("cnx.php");
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["delete"])){
    if(!empty($_POST['nomR']) && !empty($_POST['prenomR']) && isset($_POST['idgroupe'])){

        $nom = $_POST['nomR'];
        $prenom = $_POST['prenomR'];
        $idgroupe = $_POST['idgroupe'];

        if($idgroupe == '-1'){
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where nom='$nom' AND prenom='$prenom'");
            while($row=mysqli_fetch_assoc($reqs)){
                unlink($row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom='$nom' AND prenom='$prenom'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where nom='$nom' AND prenom='$prenom' AND idgroupe='$idgroupe'");
            while($row=mysqli_fetch_assoc($reqs)){
                unlink($row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom='$nom' AND prenom='$prenom' AND idgroupe='$idgroupe'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } elseif(!empty($_POST['nomR']) && empty($_POST['prenomR'])  && isset($_POST['idgroupe'])){

        $nom = $_POST['nomR'];
        $idgroupe = $_POST['idgroupe'];

        if($idgroupe == '-1'){
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where nom='$nom'");
            while($row=mysqli_fetch_assoc($reqs)){
                unlink($row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom='$nom' ");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where nom='$nom' AND idgroupe='$idgroupe'");
            while($row=mysqli_fetch_assoc($reqs)){
                unlink($row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom='$nom' AND idgroupe='$idgroupe'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } elseif(empty($_POST['nomR']) && !empty($_POST['prenomR'])  && isset($_POST['idgroupe'])){

        $prenom = $_POST['prenomR'];
        $idgroupe = $_POST['idgroupe'];

        if($idgroupe == '-1'){
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where prenom='$prenom'");
            while($row=mysqli_fetch_assoc($reqs)){
                unlink($row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where prenom='$prenom' ");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where prenom='$prenom' AND idgroupe='$idgroupe'");
            while($row=mysqli_fetch_assoc($reqs)){
                unlink($row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where prenom='$prenom' AND idgroupe='$idgroupe'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } elseif($_POST['idgroupe']=='-1'){
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire");
            while($row=mysqli_fetch_assoc($reqs)){
                unlink($row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
    } elseif ($_POST['idgroupe'] != '-1'){
            $idgroupe=$_POST['idgroupe'];
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where idgroupe='$idgroupe'");
            while($row=mysqli_fetch_assoc($reqs)){
                unlink($row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire where idgroupe='$idgroupe'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
    }
}
?>
