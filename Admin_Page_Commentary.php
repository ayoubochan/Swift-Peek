<?php
try{
    $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
die('Erreur : ' .$e->getMessage());
}
?>

<form method="POST">
<input type="submit" id="CommSee" name="CommSee" value="See all comments">
<input type="submit" id="CommStop" name="CommStop" value="Hide all comments">
</form>

<?php
if(isset($_POST['CommSee'])){

//Prendre les commentaires pour la page Admin
$commAdm=$db->query('SELECT * FROM comments ORDER BY pseudo');    
while ($Admcomms = $commAdm->fetch()){
?>

<form method="POST">
<input type="text" id="Admid" name="Admid" value="<?php echo ($Admcomms['id']) ?>" >
<input type="text" id="Admdate" name="Admdate" value="<?php echo ($Admcomms['date']) ?>" >
<input type="text" id="Admpseudo" name="Admpseudo" value="<?php echo ($Admcomms['pseudo']) ?>" >
<input type="text" id="Admmovie" name="Admmovie" value="<?php echo ($Admcomms['movie']) ?>" >
<input type="text" id="Admcomment" name="Admcomment" value="<?php echo ($Admcomms['comment']) ?>" >
<input type="submit" id="commentdelete" name="commentdelete" value="supprimer">
</form>

<?php
}
$commAdm->closeCursor(); // Termine le traitement de la requête
}
     
    if ( isset($_POST['commentdelete'])) {
        
    $toDel = $db->prepare('DELETE FROM comments WHERE id = ?');
    $toDel ->execute(array($_REQUEST['Admid']));
    $toDel ->closeCursor();
    }
    if(isset($_POST['CommStop'])){
        echo "";
    }
?>

