<?php
require_once("../backend/cnx.php");

$IncompletInfo=false;
//requete pour recuperer list de groupes et competences pour afficher dans formulaire
$req_grp=mysqli_query($id,"select * from groupe");
$req_cpt=mysqli_query($id,"select * from competence");


//recuperer id depuis lien pour l'action Update
if(isset($_GET["id"])){
    $req_st=mysqli_query($id,"select * from stagiaire where id=".$_GET["id"]); 
    if(mysqli_num_rows($req_st)==1){
        $st=mysqli_fetch_assoc($req_st);
        extract($st);
    }
}

//submit le formulaire pour l'ajout/modification des informations 
if(isset($_POST["sb"])){
    extract($_POST);
    
    if(empty($_POST['nom']) || empty($_POST['prenom'])){
        $IncompletInfo = true;
    } else {
        $competences = isset($_POST['competences']) ? $_POST['competences'] : [];
        $competences = !empty($competences) ? implode("|", $competences) : '';

        
        //si l'action et ajouter
        if($_POST["sb"]=="Ajouter"){

            //create the folder to store pictures sent from the forms
            if (!file_exists("pictures")) {
                if (!mkdir("pictures", 0777, true)) {
                    die("Erreur lors de la création du dossier pictures.");
                }
            }

            
            //definir des variables pour stocker le path et type de fichier
            $avatar_path=($_FILES["avatar"]["error"]==0)?"pictures/".$_FILES["avatar"]["name"]:"errorPicture";
            $avatar_type=$_FILES["avatar"]["type"];

            //requete pour inserer les informations vias formulaire
            $req_ins_st=mysqli_query($id,"INSERT INTO stagiaire ( nom, prenom, date_nais, idgroupe, compétences, avatar_path, avatar_type) VALUES ('$nom', '$prenom', '$date_nais', '$idgroupe', '$competences', '$avatar_path', '$avatar_type')");

            //si requete es executer avec succes 
            if($req_ins_st){
                move_uploaded_file($_FILES["avatar"]["tmp_name"],$avatar_path);
                $newest_id=mysqli_insert_id($id);
                unset($nom);
                unset($prenom);
                unset($date_nais);
                unset($idgroupe);
                unset($competences);
                unset($avatar_path);
                unset($avatar_type);
                setcookie('addsuccess','1',time()+1,'/');
                header("location:../assets/affichage.php");
            }


        //si l'action est update
        } else {
             //create the folder to store pictures sent from the forms
            if (!file_exists("pictures")) {
                if (!mkdir("pictures", 0777, true)) {
                    die("Erreur lors de la création du dossier pictures.");
                }
            }

            $avatar_path=($_FILES["avatar"]["error"]==0)?"pictures/".$_FILES["avatar"]["name"]:"errorPicture"; 
            $avatar_type=$_FILES["avatar"]["type"];

            $req_mod_st=mysqli_query($id,"UPDATE stagiaire SET nom = '$nom', prenom = '$prenom', date_nais = '$date_nais',idgroupe=$idgroupe, compétences = '$competences' ,avatar_path='$avatar_path',avatar_type='$avatar_type'  WHERE id =".$idst);

            if($req_mod_st){
                move_uploaded_file($_FILES["avatar"]["tmp_name"],$avatar_path);
            }
            
            if($req_mod_st){
                header("location:../assets/affichage.php");
                setcookie('modifysuccess','1',time()+1,'/');
            }
        }
    
}}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de saisie</title>

    <script type="text/javascript">
        function displayUploadDialg(event){
            //every button click in a form is a submit behavior
            event.preventDefault()
            document.getElementById("avatar").click();
        }
        function loadImage(input){
            //input.files[0] containes informations on the file loaded
            //it set the avatarPr source to a url created in the user systeme to display the image before submitting
            const avatar=document.getElementById("avatarPr");
            avatar.src=''
            avatar.src=URL.createObjectURL(input.files[0]);
            avatar.style.display="block"
        }
        document.addEventListener("DOMContentLoaded", () => {
            const avatar=document.getElementById("avatarPr");
            if(avatar.src.includes('nopicture')){
                avatar.style.display="none"
            }
        })
    </script>
    <link rel="stylesheet" href="../css/formstyle.css">
    <script src="https://cdn.jsdelivr.net/gh/smallvi/yoyoPopup@latest/dist/yoyoPopup.umd.min.js"></script>
    <style>
        body{
            font-family:sans-serif;
        }
        *{
            overflow:hidden
        }
    </style>
    </head>

<body>

        <form action="<?=$_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data">

            <input  name="idst" value="<?=@$_GET["id"]?>" style="display:none">

            <!--affichage message lorsque formulaire et icomplet -->
            <?php if($IncompletInfo) {?>
                <script type="text/javascript">
                    showYoyoPopup({
                                text: "veuillez remplir tous les informations personnels de l'etudiant.",
                                type: 'danger',
                                timeOut:2500,
                    })
                </script>
            <?php } ?>
                <section id='personelInformations'>

                    <h3>Informations Personnels</h3>
                    <div id="personalInput">
                        <input type="text" id="nom" name="nom" value="<?=@$nom?>"  placeholder="Nom"><br><br>
                        <input type="text" id="prenom" name="prenom" value="<?=@$prenom?>" placeholder="Prenom">
                    </div>
                    <br>
                    
                    <div id='birthdate'>
                        <label for="date-nais" style="width:20%">Date de naissance</label>
                        <input type="date" id="date_nais" name="date_nais" value="<?=@$date_nais?>" placeholder='date de naissaned'><br><br>
                    </div>

                </section>
                

                <section id='AcademicInformations'>

                    <h3>Informations Academiques</h3>
                        <div id='groupSelect'>
                            <label for="idgroupe">Groupe:</label><br>
                            <select name="idgroupe" style="width:90%;padding:8px;">
                                <?php while($row=mysqli_fetch_assoc($req_grp)){ ?>
                                    <option value="<?=$row["id"]?>" <?php if(@$row["id"]==@$idgroupe) echo "selected";?>><?=$row["libelle"]?></option>
                                <?php }?>
                            </select>
                        </div>
                        <br><br>

                    <label for="competences">Compétences:</label><br>
                    <?php
                    @$competencesTab=explode("|",@$compétences);
                    $i=0;
                    while($row=mysqli_fetch_assoc($req_cpt)){ 
                        if(($i%3==0) && ($i!=0)){
                            
                            echo "</div><div style='float:left;' class='blockCompetenses'>";
                        }
                        else if($i==0){
                            
                            echo "<div style='float:left;'>";
                        }
                    ?>
                    <input type="checkbox" name="competences[]" value="<?=$row["libelle"]?>"  <?php if(in_array($row["libelle"],$competencesTab)) echo "checked";?>><?=$row["libelle"]?><br>
                     <?php 
                        $i++;}
                    ?>     
                    </div><div style="clear:both;"></div>   <br><br>
                </section>

                <section id='image'>

                    <label for="img">Image:</label><br>
                    <img src="<?php  if(isset($avatar_path)){echo $avatar_path;} else{echo "nopicture";} ?>" id="avatarPr" style='width:150px;height:130px;margin-left:44%;'>

                    <input type="file" id="avatar" name="avatar" accept=".jpg,.jpeg,.png" style="width:250px;display:none;" onchange="loadImage(this)">
                    <button onclick="displayUploadDialg(event)" id="buttonUpload">Upload Image</button>
                   

                </section>
                <section id='submit'>
                    <button id='cancelBtn'><a href="affichage.php">Cancel</a></button>
                    <input type="submit" name="sb" value="<?php if(isset($_GET["id"])) echo "Modifier" ; else echo "Ajouter";?>">
                </section>
        </form>
</body>
</html>
