<?php
require_once("cnx.php");
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["delete"])){
    // echo $_POST['nomR'];
    // echo $_POST['prenomR'];
    // echo $_POST['idgroupe'];

    if(!empty($_POST['nomR']) && !empty($_POST['prenomR']) && !empty($_POST['idgroupe'])){

        $nom = $_POST['nomR'];
        $prenom = $_POST['prenomR'];
        $idgroupe = $_POST['idgroupe'];

        if($idgroupe == '-1'){
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where nom LIKE '%$nom%' AND prenom LIKE %$prenom%'");
            while($row=mysqli_fetch_assoc($reqs)){
                 unlink("../assets/".$row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom LIKE '%$nom%' AND prenom LIKE '%$prenom%'");
            if($req){
                header("location:../assets/affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where nom like '%$nom%' AND prenom LIKE '%$prenom%'  AND idgroupe='$idgroupe' ");
            while($row=mysqli_fetch_assoc($reqs)){
                 unlink("../assets/".$row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where  nom LIKE '%$nom%' AND prenom LIKE '%$prenom%' AND idgroupe='$idgroupe'");
            if($req){
                header("location:../assets/affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    }


    elseif(!empty($_POST['nomR']) && empty($_POST['prenomR'])  && !empty($_POST['idgroupe'])){

        $nom = $_POST['nomR'];
        $idgroupe = $_POST['idgroupe'];

        if($idgroupe == '-1'){
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where nom like '%$nom%'");
            while($row=mysqli_fetch_assoc($reqs)){
                 unlink("../assets/".$row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom LIKE '%$nom%' ");
            if($req){
                header("location:../assets/affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where nom like '%$nom%'  AND idgroupe='$idgroupe' ");
            while($row=mysqli_fetch_assoc($reqs)){
                 unlink("../assets/".$row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom LIKE '%$nom%' AND idgroupe='$idgroupe'");
            if($req){
                header("location:../assets/affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } 
    
    
    elseif(empty($_POST['nomR']) && !empty($_POST['prenomR'])  && !empty($_POST['idgroupe'])){

        $prenom = $_POST['prenomR'];
        $idgroupe = $_POST['idgroupe'];

        if($idgroupe == '-1'){
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where  prenom LIKE '%$prenom%' ");
            while($row=mysqli_fetch_assoc($reqs)){
                 unlink("../assets/".$row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where prenom LIKE '%$prenom%' ");
            if($req){
                header("location:../assets/affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where  prenom LIKE '%$prenom%' AND idgroupe='$idgroupe' ");
            while($row=mysqli_fetch_assoc($reqs)){
                 unlink("../assets/".$row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire  where prenom LIKE '%$prenom%' AND idgroupe='$idgroupe'");
            if($req){
                header("location:../assets/affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } 
    
    elseif(!empty($_POST['idgroupe'])) {
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire where  idgroupe='$idgroupe' ");
            while($row=mysqli_fetch_assoc($reqs)){
                 unlink("../assets/".$row["avatar_path"]);
            }
            $idgroupe=$_POST['idgroupe'];
            $req=mysqli_query($id,"DELETE FROM stagiaire  where idgroupe=$idgroupe");
            if($req){
                header("location:../assets/affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
        
    elseif (empty($_POST['idgroupe'])){
            $reqs=mysqli_query($id,"SELECT * FROM stagiaire");
            while($row=mysqli_fetch_assoc($reqs)){
                 unlink("../assets/".$row["avatar_path"]);
            }
            $req=mysqli_query($id,"DELETE FROM stagiaire ");
            if($req){
                header("location:../assets/affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } 
    
?>
