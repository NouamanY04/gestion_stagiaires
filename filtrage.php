<?php
if(isset($_GET["sbR"])){
    if($_GET["idgroupe"]=="-1"){
        $req_stagiaires=mysqli_query($id,"select * from stagiaire where upper(nom) like upper('%".$_GET["nomR"]."%') and
        upper(prenom) like upper('%".$_GET["prenomR"]."%')");
}
else{
    $req_stagiaires=mysqli_query($id,"select * from stagiaire where upper(nom) like upper('%".$_GET["nomR"]."%') and
    upper(prenom) like upper('%".$_GET["prenomR"]."%') and idgroupe=".$_GET["idgroupe"]);
}
}
else{
$req_stagiaires=mysqli_query($id,"select * from stagiaire");
}
?>
<fieldset style="margin-bottom:20px;padding:10px;width:75%;height:40px;border:1px black solid;">
    <legend>Recherche:</legend>
    <form method="get">
        <input type="text" name="nomR" placeholder="nom..." style="width:25%;" value="<?=@$_GET["nomR"]?>">
        <input type="text" name="prenomR" placeholder="prenom..." style="width:25%;" value="<?=@$_GET["prenomR"]?>">
        <select name="idgroupe" style="width:25%;">
            <option value="-1">
                <--selectionner Tout-->
            </option>
            <?php while($row=mysqli_fetch_assoc($req_grp)){ ?>
            <option value="<?=$row["id"]?>" <?php if(@$row["id"]==@$_GET["idgroupe"]) echo "selected";?>>
                <?=$row["libelle"]?></option>
            <?php }?>
        </select>
        <input type="submit" name="sbR" value="Rechercher" style="margin-left:20px;">
        <input type="submit" name="reset" value="Rinitialiser" style="margin-left:20px;">
    </form>
</fieldset>