<?php
require_once("cnx.php");
//recuperer les liste de groupes pour le formulaire search
$req_grp=mysqli_query($id,"select * from groupe");


$nbr=5;
if(isset($_GET["nbrpagebloc"]))
{
    $nbr=(int)$_GET["nbrpagebloc"];
}

//if reset button in search form is clicked
if(isset($_GET["reset"])){
    unset($_GET);
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
if($nbrSt%$nbr==0){
    $nbrpage=$nbrSt/$nbr;
}else
{
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
        function checkAll(ca){
            let cks=document.getElementsByName("ck[]");
            cks.forEach(elt=>{
                elt.checked=ca.checked;
            })
        }
        function check(){
            document.getElementById("ckall").checked=true;
            let cks=document.getElementsByName("ck[]");
            cks.forEach(elt=>{
                if(elt.checked==false){
                    document.getElementById("ckall").checked=false;
                    return;
                }
            })
        }
    </script>
    <link rel="stylesheet" href="affichage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=edit" />
</head>

<body>
    <section id='main'>
        


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
                <input type="submit" name="reset" value="Cancel" id='resetbtn'>
            </form>
        </div>


        <form method="get" id="blc">
            <select name="nbrpagebloc" onchange="document.getElementById('blc').submit()">
                <option <?php if($nbr==5) echo "selected";?>>5</option>
                <option <?php if($nbr==10) echo "selected";?>>10</option>
                <option <?php if($nbr==20) echo "selected";?>>20</option>
            </select>
        
            <input type="hidden" name="nomR" value="<?=@$nomR?>">
            <input type="hidden" name="prenomR" value="<?=@$prenomR?>">
            <input type="hidden" name="idgroupe" value="<?=@$idgroupe?>">
                

            <?php
            for($i=1;$i<=$nbrpage;$i++){?>

            <a href="affichage.php?page=<?=$i?>&nomR=<?=@$nomR?>&prenomR=<?=@$prenomR?>&idgroupe=<?=@$idgroupe?>&nbrpagebloc=<?=$nbr?>" <?php if(($i==((int)@$_GET["page"]))or($i==1 and isset($_GET) and !array_key_exists("page",$_GET))or($i==1 and !isset($_GET))) {?> style="padding-left:20px;padding-right:20px;font-size:x-large;color:red;background-color:gray;" <?php }?>><?=$i?></a>
            <?php }?>
        </form>
        <br><br>
        
        <div id="actions">
                <!-- <form action="SupprimerTout.php" method="post">
                    <button onclick="return confirm('Attention!Opération irréversible!!!!');" id='btn-d'>Supprimer Tout</button>
                </form><br><br> -->

                <button id='addBtn'><a href="formulaire.php">Ajouter Stagiaire</a></button>
        </div>

        <span style="font-size:x-large;font-weight:bold;"><?=$nbrSt?> Stagiaire(s)</span>
            <table>
                <tr>
                    <th><input type="checkbox" id="ckall" onclick="checkAll(this)"></th>
                    <th>Action</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Groupe</th>
                    <th>Compétences</th>
                    <th>Image</th>
                </tr>

                <?php
                    while($row=mysqli_fetch_assoc($req_stagiaires))        
                {?>    
                <tr>
                    <td><input type="checkbox" name="ck[]" onclick="check()" value="<?=$row["id"]?>"></td>
                    <td><a href="suppressionSt.php?id=<?=$row["id"]?>" onclick="return confirm('Voulez-vous supprimer le stagiaire <?php echo $row['nom'].' '.$row['prenom'];?> ?')">
                                    <button id='btn-d'>DELETE</button>
                        </a>
                        <a href="formulaire.php?id=<?=$row["id"]?>"><button id='btn-e'>UPDATE</button></a>
                    </td>
                    <td><?=$row["nom"]?></td>
                    <td><?=$row["prenom"]?></td>
                    <td><?=$row["date_nais"]?></td>
                    <td><?=$row["libelle"]?></td>
                    <td><?=$row["compétences"]?></td>
                    <td><img src="<?php if($row["avatar_path"]!=""){echo $row["avatar_path"];}else{echo "empty.png";}?>" style="width:20px;height:20px;" title="<?php echo $row["nom"]." ".$row["prenom"];?>" ></td>
                </tr>
                <?php } ?>    
            </table>
    </section>
    

</body>
</html>
