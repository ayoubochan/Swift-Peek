<?php
 
if(isset($_SESSION['pseudo'])){
 $itsConnect =  $_SESSION['pseudo'];
echo 'GGGGGGGGGGGGGGGGGGGGGGGGGGGGG';
?>
<section class="ajoutcomms"> 
  <form method="post" id="sendCommentaryForm">
    <p id="pseudoAdded"><?php echo  $_SESSION['pseudo'] ?></p>
    <p id="commentAdded"><label>Your Commentary : </label><input type="text" id="addcomment" name="addcomment" placeholder="your commentary here ..."></p>
    <p id="commentButton"><input type="submit" name="sendcomment" value="Send your commentary" id=sendcomment/></p>
  </form>
</section>
<?php 
} else {echo 'SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS';}
?>