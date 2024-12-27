<?php

$nbr=5;
if(isset($_GET["nbrpagebloc"]))
{
    $nbr=(int)$_GET["nbrpagebloc"];
}
require_once("cnx.php");
$req_grp=mysqli_query($id,"select * from groupe");
if(isset($_GET["reset"])){
unset($_GET);
}

if(isset($_GET["nomR"])){
    extract($_GET);
    if($idgroupe=="-1" or $idgroupe==""){
    $req_stagiaires=mysqli_query($id,"select * from stagiaire where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%')");   
    }
    else{
    $req_stagiaires=mysqli_query($id,"select * from stagiaire where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') and idgroupe=".$idgroupe);   
   }
}
else{
$req_stagiaires=mysqli_query($id,"select * from stagiaire");
}


$nbrSt=mysqli_num_rows($req_stagiaires);
if($nbrSt%$nbr==0){
    $nbrpage=$nbrSt/$nbr;
}else
{
    $nbrpage=ceil($nbrSt/$nbr);
}


// echo "$nbrSt==>$nbrpage";
if(isset($_GET["page"])){
    $numPage=(int)$_GET["page"];
    $offset=($numPage-1)*$nbr;
    $req_stagiaires=mysqli_query($id,"select * from stagiaire limit $nbr offset $offset");
    if($idgroupe=="-1" or $idgroupe==""){
        $req_stagiaires=mysqli_query($id,"select * from stagiaire where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') limit $nbr offset $offset");   
       }
       else  if($idgroupe!=""){
        $req_stagiaires=mysqli_query($id,"select * from stagiaire where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') and idgroupe=".$idgroupe." limit $nbr offset $offset");   
       }
}
else if(isset($_GET["nomR"])){
    if($idgroupe=="-1" or $idgroupe==""){
        $req_stagiaires=mysqli_query($id,"select * from stagiaire where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') limit $nbr");   
       }
       else{
        $req_stagiaires=mysqli_query($id,"select * from stagiaire where upper(nom) like upper('%".$nomR."%') and upper(prenom) like upper('%".$prenomR."%') and idgroupe=".$idgroupe." limit $nbr");   
       }
}
else{
$req_stagiaires=mysqli_query($id,"select * from stagiaire limit $nbr");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de Stagiaires</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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
</head>
<body>
    <a href="formulaire.php">Page1</a>
    <h1>Tableau de Stagiaires</h1>
    <fieldset style="margin-bottom:20px;padding:10px;width:75%;height:40px;border:1px black solid;">
    <legend>Recherche:</legend>
    <form method="get">
<input type="text" name="nomR" placeholder="nom..." style="width:25%;" value="<?=@$_GET["nomR"]?>">
<input type="text" name="prenomR" placeholder="prenom..." style="width:25%;" value="<?=@$_GET["prenomR"]?>">
<select name="idgroupe" style="width:25%;">
<option value="-1"><--selectionner Tout--></option>
<?php while($row=mysqli_fetch_assoc($req_grp)){ ?>
    <option value="<?=$row["id"]?>" <?php if(@$row["id"]==@$_GET["idgroupe"]) echo "selected";?>><?=$row["libelle"]?></option>
<?php }?>
</select>
<!-- <input type="hidden" name="nbrpagebloc" value=<?=$nbr?>> -->
<input type="submit" name="sbR" value="Rechercher" style="margin-left:20px;">
<input type="submit" name="reset" value="Initialiser" style="margin-left:20px;">
    </form>
    </fieldset>
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
<form action="SupprimerTout.php" method="post">
    <button onclick="return confirm('Attention!Opération irréversible!!!!');" style="margin-bottom:20px;">Supprimer Tout</button>
<br>
<br>
<span style="font-size:x-large;font-weight:bold;"><?=$nbrSt?> Stagiaire(s)</span>
    <table>
        <tr>
            <th><input type="checkbox" id="ckall" onclick="checkAll(this)"></th>
            <th>Action</th>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de naissance</th>
            <th>ID Groupe</th>
            <th>Compétences</th>
            <th>Avatar Path</th>
            <th>Avatar Type</th>
            <th>Fiche Path</th>
            <th>Fiche Type</th>
     
        </tr>
<?php
while($row=mysqli_fetch_assoc($req_stagiaires))
{?>        
        <tr>
        <td><input type="checkbox" name="ck[]" onclick="check()" value="<?=$row["id"]?>"></td>
        <td><a href="suppressionSt.php?id=<?=$row["id"]?>" onclick="return confirm('Voulez-vous supprimer le stagiaire <?php echo $row['nom'].' '.$row['prenom'];?> ?')">Supprimer</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="formulaire.php?id=<?=$row["id"]?>">Modifier</a></td>
            <td><?=$row["id"]?></td>
            <td><?=$row["nom"]?></td>
            <td><?=$row["prenom"]?></td>
            <td><?=$row["date_nais"]?></td>
            <td><?=$row["idgroupe"]?></td>
            <td><?=$row["compétences"]?></td>
            <td><img src="<?php if($row["avatar_path"]!=""){echo $row["avatar_path"];}else{echo "empty.png";}?>" style="width:60px;height:60px;" title="<?php echo $row["nom"]." ".$row["prenom"];?>" ></td>
            <td><?=$row["avatar_type"]?></td>
            <td><a href="<?=$row["fiche_path"]?>" download><?php echo substr(str_replace("files/","",$row["fiche_path"]),0,15);
            echo (strlen(str_replace("files/","",$row["fiche_path"]))<=15? "":"...")?></a></td>
            <td><?=$row["fiche_type"]?></td>
            
        </tr>
<?php } ?>        
    </table>
</form>

</body>
</html>
