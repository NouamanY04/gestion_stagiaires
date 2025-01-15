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
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom LIKE '%$nom%' AND prenom LIKE '%$prenom%'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $req=mysqli_query($id,"DELETE FROM stagiaire  where  nom LIKE '%$nom%' AND prenom LIKE '%$prenom%' AND idgroupe='$idgroupe'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    }


    elseif(!empty($_POST['nomR']) && empty($_POST['prenomR'])  && !empty($_POST['idgroupe'])){

        $nom = $_POST['nomR'];
        $idgroupe = $_POST['idgroupe'];

        if($idgroupe == '-1'){
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom LIKE '%$nom%' ");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $req=mysqli_query($id,"DELETE FROM stagiaire  where nom LIKE '%$nom%' AND idgroupe='$idgroupe'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } 
    
    
    elseif(empty($_POST['nomR']) && !empty($_POST['prenomR'])  && !empty($_POST['idgroupe'])){

        $prenom = $_POST['prenomR'];
        $idgroupe = $_POST['idgroupe'];

        if($idgroupe == '-1'){
            $req=mysqli_query($id,"DELETE FROM stagiaire  where prenom LIKE '%$prenom%' ");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }else{
            $req=mysqli_query($id,"DELETE FROM stagiaire  where prenom LIKE '%$prenom%' AND idgroupe='$idgroupe'");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } 
    
    elseif(!empty($_POST['idgroupe'])) {
            $idgroupe=$_POST['idgroupe'];
            $req=mysqli_query($id,"DELETE FROM stagiaire  where idgroupe=$idgroupe");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
        
    elseif (empty($_POST['idgroupe'])){
            $req=mysqli_query($id,"DELETE FROM stagiaire ");
            if($req){
                header("location:affichage.php");
                setcookie('deletesuccess','1',time()+1,'/');
            }
        }
    } 
    
?>
