

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">
  
  <title>form</title>
</head>
<body>


<!--La séction du formulaire de connection-->  
<!--Lebouton Connexion--> 
<input type="button" class="idenTification" onclick="identiFyyourSlef()" name ="idenTification" value="Connexion">
<section id="jeMidentifie" class="inscrConncet">
    <fieldset class="toutLeform">
    <form class="leconnecteur" action="" method="POST">
      <!--Affichage des messages d'erreur-->
      <p class="leMessage">
      <?php
          echo verifyUserData($db);
      ?>
      </p>
      </div>
        <input type="text" name="monPseudo" placeholder="Enter your id or your email" class="lePseudo"><br><br>
        <input type="password" name="monMotDepass" placeholder="Enter your password" class="lePass"><br><br>

        <input type="submit" name="onEnvoi" value="Login" class="leNnvoi">
        <input type="submit" name="onSedeconnect" value="Logout" class="laDeconnect">
        <input type="submit" name="lostPassWord" value="Forgot your password ?" class="lostP">
      </form>
    </fieldset>
</section>

<!---Javascript-->
<script>
  function identiFyyourSlef(){
    let leForm = document.getElementById("jeMidentifie");
    if (leForm.style.display === "none") {
      leForm.style.display = "block";
  } else {
    leForm.style.display = "none";
  }
    
  }
  identiFyyourSlef();

</script>
</body>
</html>

