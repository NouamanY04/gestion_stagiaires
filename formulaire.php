<?php
require_once("cnx.php");

$req_grp=mysqli_query($id,"select * from groupe");
$req_cpt=mysqli_query($id,"select * from competence");
if(isset($_GET["id"])){
    $req_st=mysqli_query($id,"select * from stagiaire where id=".$_GET["id"]); 
    if(mysqli_num_rows($req_st)==1){
        $st=mysqli_fetch_assoc($req_st);
        extract($st);
    }
}

if(isset($_POST["sb"])){
    
extract($_POST);
//  print_r($_FILES["avatar"]);
$competences=implode("|",$competences);

if($_POST["sb"]=="Ajouter"){
if(!file_exists("images")){
    mkdir("images");
}
if(!file_exists("files")){
    mkdir("files");
}
$avatar_path=($_FILES["avatar"]["error"]==0)?"images/".$_FILES["avatar"]["name"]:"";
$avatar_type=$_FILES["avatar"]["type"];
$fiche_path=($_FILES["fiche"]["error"]==0)?"files/".$_FILES["fiche"]["name"]:""; 
$fiche_type=$_FILES["fiche"]["type"];

$req_ins_st=mysqli_query($id,"INSERT INTO stagiaire ( nom, prenom, date_nais, idgroupe, compétences, avatar_path, avatar_type, fiche_path, fiche_type) VALUES ('$nom', '$prenom', '$date_nais', '$idgroupe', '$competences', '$avatar_path', '$avatar_type', '$fiche_path', '$fiche_type' )");
if($req_ins_st){
move_uploaded_file($_FILES["avatar"]["tmp_name"],$avatar_path);
move_uploaded_file($_FILES["fiche"]["tmp_name"],$fiche_path);
$newest_id=mysqli_insert_id($id);
unset($nom);
unset($prenom);
unset($date_nais);
unset($idgroupe);
unset($competences);
unset($avatar_path);
unset($avatar_type);
unset($fiche_path);
unset($fiche_type); 

}
}
else{
    //UPDATE stagiaire SET nom = 'elmiraoui1', prenom = 'asmae1', date_nais = '1999-12-30', compétences = 'JS|JAVA|VBSCRIPT&' WHERE id = 2
$req_mod_st=mysqli_query($id,"UPDATE stagiaire SET nom = '$nom', prenom = '$prenom', date_nais = '$date_nais',idgroupe=$idgroupe, compétences = '$competences' WHERE id =".$idst);

if($_FILES["avatar"]["error"]==0){
    $avatar_path="images/".$_FILES["avatar"]["name"];
    $avatar_type=$_FILES["avatar"]["type"];
    $req_mod_av_st=mysqli_query($id,"UPDATE stagiaire SET avatar_path='$avatar_path',avatar_type='$avatar_type' WHERE id =".$idst);
    if($req_mod_av_st){
        move_uploaded_file($_FILES["avatar"]["tmp_name"],$avatar_path);
    }
}
if($_FILES["fiche"]["error"]==0){
    $fiche_path="files/".$_FILES["fiche"]["name"];
    $fiche_type=$_FILES["fiche"]["type"];
    $req_mod_fc_st=mysqli_query($id,"UPDATE stagiaire SET fiche_path='$fiche_path',fiche_type='$fiche_type' WHERE id =".$idst);
    if($req_mod_fc_st){
        move_uploaded_file($_FILES["fiche"]["tmp_name"],$fiche_path);
    }
}
if($req_mod_st){
    header("location:affichage.php");
}

}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de saisie</title>
    <script type="text/javascript">
        function displayUploadDialg(){
            document.getElementById("avatar").click();
        }
        function loadImage(p){
            document.getElementById("avatarPr").src=URL.createObjectURL(p.files[0]);
        }
        function displayPdf(p){
            document.getElementById("pdfId").href=URL.createObjectURL(p.files[0]);
            document.getElementById("pdfId").textContent=p.value.replace("C:\\fakepath\\","");
        }
        </script>
</head>
<body>
<a href="affichage.php">Page2</a>
    <h1>Formulaire de saisie</h1>

    <?php if(isset($newest_id)) echo "<span style='color:green;'>stagiaire (id=$newest_id) ajouté(e) avec succés</span><br>";?>
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idst" value="<?=@$_GET["id"]?>">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" value="<?=@$nom?>" style="width:250px;"><br><br>

        <label for="prenom">Prénom:</label><br>
        <input type="text" id="prenom" name="prenom" value="<?=@$prenom?>" style="width:250px;"><br><br>

        <label for="date_nais">Date de naissance:</label><br>
        <input type="date" id="date_nais" name="date_nais" value="<?=@$date_nais?>"  style="width:250px;"><br><br>

        <label for="idgroupe">ID Groupe:</label><br>
<select name="idgroupe" style="width:250px;">
<?php while($row=mysqli_fetch_assoc($req_grp)){ ?>
    <option value="<?=$row["id"]?>" <?php if(@$row["id"]==@$idgroupe) echo "selected";?>><?=$row["libelle"]?></option>
<?php }?>
</select>
        <br><br>

        <label for="competences">Compétences:</label><br>
        
<?php

@$competencesTab=explode("|",@$compétences);
$i=0;
while($row=mysqli_fetch_assoc($req_cpt)){ 
    

    if(($i%3==0) && ($i!=0)){
        
        echo "</div><div style='float:left;'>";
    }
    else if($i==0){
        
        echo "<div style='float:left;'>";
    }
    
    ?>

<input type="checkbox" name="competences[]" value="<?=$row["libelle"]?>"  <?php if(in_array($row["libelle"],$competencesTab)) echo "checked";?>><?=$row["libelle"]?><br>

<?php 
$i++;
}?>     
</div><div style="clear:both;"></div>  
        <br><br>

        <label for="avatar">Avatar:</label><br>
        <input type="file" id="avatar" name="avatar" accept=".jpg,.jpeg,.png"style="width:250px;display:none;" onchange="loadImage(this)">
        <!-- <img src="add.png" onclick="displayUploadDialg()" style="width:40px;height:40px;">-->
        <img src="<?php if(isset($avatar_path)&& $avatar_path!=""){echo $avatar_path;}else{echo "empty.png";}?>" onclick="displayUploadDialg()"  id="avatarPr" style="width:120px;height:120px;"><br><br> 

        <label for="fiche">Fiche:</label><br>
        <input type="file" id="fiche" name="fiche" accept=".pdf"style="width:250px;" onchange="displayPdf(this)">
        <a href="<?php if(isset($fiche_path)&& $fiche_path!=""){echo $fiche_path;}else{echo "#";}?>" id="pdfId" target="_blank"><?php if(isset($fiche_path)&& $fiche_path!=""){echo str_replace("files/","",$fiche_path);}?></a><br><br>

        <input type="submit" name="sb" value="<?php if(isset($_GET["id"])) echo "Modifier" ; else echo "Ajouter";?>">
    </form>
</body>
</html>
