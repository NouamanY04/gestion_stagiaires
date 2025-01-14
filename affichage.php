<?php
require_once("cnx.php");
//recuperer les liste de groupes pour le formulaire search
$req_grp=mysqli_query($id,"select * from groupe");

$nullresult=false;
$nbr=5;
if(isset($_GET["nbrpagebloc"]))
{
    $nbr=(int)$_GET["nbrpagebloc"];
}

//if reset button in search form is clicked
if(isset($_GET["reset"])){
    unset($_GET);
    header("location:affichage.php  ");
}

//si le nom pour la recherche est saisi
if(isset($_GET["nomR"])){
    extract($_GET);
    if($idgroupe=="-1" or $idgroupe==""){
        $req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%')");   
    } else {
        $req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') and idgroupe=".$idgroupe);   
   }
}else{
$req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe");
}


//controler nom des lignes des etudiants pour chaque page
$nbrSt=mysqli_num_rows($req_stagiaires);
// echo $nbrSt;
if(isset($_GET['sbR']) && $nbrSt == 0){
    $nullresult = true;
}
if($nbrSt%$nbr==0){
    $nbrpage=$nbrSt/$nbr;
} else {
    $nbrpage=ceil($nbrSt/$nbr);
}


if(isset($_GET["page"])){
    $numPage=(int)$_GET["page"];
    $offset=($numPage-1)*$nbr;
    $req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe limit $nbr offset $offset");
    if($idgroupe=="-1" or $idgroupe==""){
        $req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') limit $nbr offset $offset");   
       }
       else  if($idgroupe!=""){
        $req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') and idgroupe=".$idgroupe." limit $nbr offset $offset");   
       }
}
else if(isset($_GET["nomR"])){
    if($idgroupe=="-1" or $idgroupe==""){
        $req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') limit $nbr");   
       }
       else{
        $req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') and idgroupe=".$idgroupe." limit $nbr");   
       }
}else{
$req_stagiaires=mysqli_query($id,"SELECT  s.id , s.nom, s.prenom, s.date_nais, g.libelle, s.compétences, s.avatar_path
                                  from stagiaire  s 
                                  INNER JOIN  groupe g 
                                  ON g.id = s.idgroupe limit $nbr");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de Stagiaires</title>
    <style>
        body{
            font-family:sans-serif;
        }
    </style>
    <script type="text/javascript">
    

    </script>
    <link rel="stylesheet" href="affichage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=edit" />
    <script src="https://cdn.jsdelivr.net/gh/smallvi/yoyoPopup@latest/dist/yoyoPopup.umd.min.js"></script>
</head>

<body>
    <section id='main'>
        
        <!-- teste la cookie addsucces pour l'affichage d'une alert de succes de l'ajout -->
        <?php if (isset($_COOKIE['addsuccess'])) { ?>
            <script type="text/javascript">
                showYoyoPopup({
                                text: 'Etudiant ajouter avec Success.',
                                type: 'success',
                                timeOut:1500,
                })
            </script>
        <?php } ?>

        <!-- teste la cookie addsucces pour l'affichage d'une alert de succes de l'ajout -->
        <?php if (isset($_COOKIE['modifysuccess'])) { ?>
            <script type="text/javascript">
                showYoyoPopup({
                                text: 'Etudiant modifier avec Success.',
                                type: 'success',
                                timeOut:1500,
                })
            </script>
        <?php } ?>

        <!-- teste la cookie deletesuccess pour l'affichage d'une alert de succes de la suppression -->
        <?php if (isset($_COOKIE['deletesuccess'])) { ?>
            <script type="text/javascript">
                showYoyoPopup({
                                text: 'suppression avec Success.',
                                type: 'success',
                                timeOut:1500,
                })
            </script>
        <?php } ?>

        <section id="head">
            <div id='searchArea'> 
                <h3>&nbsp;&nbsp;&nbsp;Rechercher Etudiant</h3>
                <form method="get">
                    <input type="text" name="nomR" placeholder="nom..." style="width:25%;" value="<?=@$_GET["nomR"]?>">
                    <input type="text" name="prenomR" placeholder="prenom..." style="width:25%;" value="<?=@$_GET["prenomR"]?>">
                    <select name="idgroupe" style="width:25%;padding:8px;">
                        <option value="-1">All groups</option>
                        <?php while($row=mysqli_fetch_assoc($req_grp)){ ?>
                            <option value="<?=$row["id"]?>" <?php if(@$row["id"]==@$_GET["idgroupe"]) echo "selected";?>><?=$row["libelle"]?></option>
                            <?php }?>
                        </select> <br> <br>
                        <!-- <input type="hidden" name="nbrpagebloc" value=<?=$nbr?>> -->
                        <input type="submit" name="sbR" value="Rechercher" id='searchbtn'>
                        <?php if(isset($_GET['nomR'])) :?>
                            <input type="submit" name="reset" value="Cancel" id='resetbtn' style="background-color: #f1c40f;">    
                        <?php else :?>
                            <input type="submit" name="reset" value="Cancel" id='resetbtn' style="background-color:rgb(228, 209, 133);">
                        <?php endif; ?>
                    </form>
            </div>
            <div>
                <button id='logoutbtn'><a href="logout.php">Logout</a></button>
            </div>
        </section>
            

        <br><br>
        
        <div id="actions">
                <form  id="deleteAll" action="SupprimerTout.php" method="post">
                    <input type="hidden" name="delete" value="1">
                    <?php if ($nbrSt != 0) : ?>
                        <button 
                            type="button" 
                            name="delete" 
                            id="btn-d" 
                            value="delete" 
                            onclick="showYoyoPopup({
                                text: 'Are you sure? This can permanently delete the students.',
                                type: 'warning',
                                hasConfirmation: true,
                                confirmLabel: 'Yes, Continue',
                                confirmFunction: () => {
                                    console.log('Form submission triggered');
                                    document.getElementById('deleteAll').submit();
                                },
                                closeLabel: 'Close',
                                isStatic: true
                            });">
                            Supprimer Tout
                        </button>
                    <?php elseif ($nbrSt == 0) : ?>
                        <button 
                            type="button" 
                            name="delete" 
                            id="btn-d" 
                            value="delete" 
                            onclick="showYoyoPopup({
                                text: 'No students to delete.',
                                type: 'info',
                                timeOut: 1500
                            });">
                            Supprimer Tout
                        </button>
                    <?php endif; ?>

                
                <input type="hidden" name="nomR" value="<?=@$nomR?>">
                <input type="hidden" name="prenomR" value="<?=@$prenomR?>">
                <input type="hidden" name="idgroupe" value="<?=@$idgroupe?>">
                </form><br><br>

            <button id='addBtn'><a href="formulaire.php">Ajouter Etudiant</a></button>
        </div>

        <form method="get" id="blc"> 
            <div>
                <span style="font-size:x-large;font-weight:bold;"><?=$nbrSt?> Etudiant(s)</span>
            </div>
                 
            <div id='pag'>
                <?php
                for($i=1;$i<=$nbrpage;$i++){?>

                <a href="affichage.php?page=<?=$i?>&nomR=<?=@$nomR?>&prenomR=<?=@$prenomR?>&idgroupe=<?=@$idgroupe?>&nbrpagebloc=<?=$nbr?>"
                        class="<?php
                            if ($i == ((int)($_GET["page"] ?? 0)) || ($i == 1 && empty($_GET["page"]))) {
                                echo 'active';
                            } else {
                                echo 'disabled';
                            }
                        ?>">
                        <?=$i?>
                </a>
            <?php }?>
            </div>

            <div id="slctStudnt">
                Students Per Page:
                <select name="nbrpagebloc" id="nbrpage" onchange="document.getElementById('blc').submit()">
                    <option <?php if($nbr==5) echo "selected";?>>5</option>
                    <option <?php if($nbr==10) echo "selected";?>>10</option>
                    <option <?php if($nbr==20) echo "selected";?>>20</option>
                </select>
            </div>
        
            <input type="hidden" name="nomR" value="<?=@$nomR?>">
            <input type="hidden" name="prenomR" value="<?=@$prenomR?>">
            <input type="hidden" name="idgroupe" value="<?=@$idgroupe?>">
           
        </form>
            <?php if($nullresult){ ?>
                <script type="text/javascript">
                    showYoyoPopup({
                                text: 'aucun étudiant avec ces informations.',
                                type: 'danger',
                                timeOut:1500,
                    })
                </script>
            <?php } ?>
            <table>
                <tr>
                    <th>Action</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Groupe</th>
                    <th>Compétences</th>
                    <th>Image</th>
                </tr>

                <?php
                    while($row=mysqli_fetch_assoc($req_stagiaires)) { 
                ?>
                <tr>
                    <td><a id="todelete">
                        <button type="button" id="btn-d" onclick="showYoyoPopup({
                            text: 'Are you sure? This can permanently delete the student <?php echo $row['nom'] . ' ' . $row['prenom']; ?>.',
                            type: 'warning',
                            hasConfirmation: true,
                            confirmLabel: 'Yes, Continue',
                            confirmFunction: () => {
                                window.location.href = 'suppressionSt.php?id=<?=$row['id']?>';
                            },
                            closeLabel: 'Close',
                            isStatic: true,
                        })">
                            DELETE
                        </button>
                    </a>
                        <a href="formulaire.php?id=<?=$row["id"]?>"><button id='btn-e'>UPDATE</button></a>
                    </td>
                    <td><?=$row["nom"]?></td>
                    <td><?=$row["prenom"]?></td>
                    <td><?=$row["date_nais"]?></td>
                    <td><?=$row["libelle"]?></td>
                    <td><?=$row["compétences"]?></td>
                    <td><img  id="img" src="<?php if($row["avatar_path"]!=""){echo $row["avatar_path"];}else{echo "empty.png";}?>" style="width:50px;height:50px;" title="<?php echo $row["nom"]." ".$row["prenom"];?>" ></td>
                </tr>
                <?php } ?>   
            </table>
    </section>
    

</body>
</html>
