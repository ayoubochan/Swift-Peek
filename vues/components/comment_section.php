<?php
session_start();
$itWork = $_SESSION['pseudo'];

?>
<section class="ajoutcomms"> 
  <form method="post" id="sendCommentaryForm">
    <p id="pseudoAdded"><label>Your Pseudo : </label><input type="text" id="addpseudo" name="addpseudo" value="<?php echo $itWork ?>" ></p>
    <p id="commentAdded"><label>Your Commentary : </label><input type="text" id="addcomment" name="addcomment" placeholder="your commentary here ..."></p>
    <p id="commentButton"><input type="submit" name="sendcomment" value="Send your commentary" id=sendcomment/></p>
  </form>
</section>
