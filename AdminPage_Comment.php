<?php

// Take all users and comments from the DB to handle them on admin interface

try{
    $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
die('Erreur : ' .$e->getMessage());
}
include 'vues/css/adminpage.css'
?>

<form class="seeThem" method="POST">
<input type="submit" id="CommSee" name="CommSee" value="See all comments" >
<input type="submit" id="CommStop" name="CommStop" value="Hide all comments">
</form>


<?php
if(isset($_POST['CommSee'])){

$commAdm=$db->query('SELECT * FROM comments ORDER BY pseudo');    
while ($Admcomms = $commAdm->fetch()){
?>

<form class="admforComms" method="POST">
<input type="text" id="Admid" name="Admid" value="<?php echo ($Admcomms['id']) ?>" >
<input type="text" id="Admdate" name="Admdate" value="<?php echo ($Admcomms['date']) ?>" >
<input type="text" id="Admpseudo" name="Admpseudo" value="<?php echo ($Admcomms['pseudo']) ?>" >
<input type="text" id="Admmovie" name="Admmovie" value="<?php echo ($Admcomms['movie']) ?>" >
<input type="text" id="Admcomment" name="Admcomment" size="70px" value="<?php echo ($Admcomms['comment']) ?>" >
<input type="submit" id="commentdelete" name="commentdelete" value="supprimer">
</form>

<?php
}
$commAdm->closeCursor();
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

<form class="seeThem" method="POST">
<input type="submit" id="userSee" name="userSee" value="See all users">
<input type="submit" id="UserStop" name="UserStop" value="Hide all users">
</form>

<?php

if(isset($_POST['userSee'])){
    $userAdm=$db->query('SELECT * FROM users ORDER BY pseudo');    
    while ($Admuser = $userAdm->fetch()){
    ?>
    
    <form class="admforUsers" method="POST">
    <input type="text" id="userid" name="userid" value="<?php echo ($Admuser['id']) ?>" >
    <input type="text" id="userpseudal" name="userpseudal" value="<?php echo ($Admuser['pseudo']) ?>" >
    <input type="text" id="usermdp" name="usermdp" value="<?php echo ($Admuser['password']) ?>" >
    <input type="text" id="usermail" name="usermail" value="<?php echo ($Admuser['email']) ?>" >
    <input type="submit" id="userdelete" name="userdelete" value="supprimer">
    </form>

    <?php
}
$userAdm->closeCursor();
}
     
    if ( isset($_POST['userdelete'])) {
        
    $toDel = $db->prepare('DELETE FROM users WHERE id = ?');
    $toDel ->execute(array($_REQUEST['userid']));
    $toDel ->closeCursor();
    }
    if(isset($_POST['UserStop'])){
        echo "";
    }
    ?>
   <a href="index.php">Back</a>


