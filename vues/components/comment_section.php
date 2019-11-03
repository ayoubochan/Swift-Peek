<?php
 
if(isset($_SESSION['pseudo'])){

?>
<section class="ajoutcomms"> 
  <form method="post" id="sendCommentaryForm">
    <textarea type="text" id="addcomment" name="addcomment" placeholder="New comment"></textarea>
    <input type="submit" name="sendcomment" value="Send" id="sendcomment"/>
  </form>
</section>
<?php 
}
?>