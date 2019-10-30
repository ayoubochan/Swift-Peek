<section class="ajoutcomms"> 
  <form method="post" id="sendCommentaryForm">
    <p id="pseudoAdded"><label>Your Pseudo : </label><input type="text" id="addpseudo" name="addpseudo"></p>
    <p id="commentAdded"><label>Your Commentary : </label><input type="text" id="addcomment" name="addcomment" placeholder="your commentary here ..."></p>
    <p id="commentButton"><input type="submit" name="sendcomment" value="Send your commentary" id=sendcomment/></p>
  </form>
</section>
<style>
  .ajoutcomms{
    border: 2px solid darkred;
    border-radius : 10px;
    background-color: rgb(34, 33, 33);
    color : white;
    font-size : 15pt;
    padding-left : 15px;
}
#addpseudo{
  background-color : rgb(50,50,50);
  border : 2px solid rgb(20,30,30);
}
  </style>