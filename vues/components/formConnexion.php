<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <title>form</title>
</head>
<body>
<section>
    <fieldset class="toutLeform">
      <!--Ici s'affichera le message d'érreur pour le champ pseudo-->
      

    <form class="leconnecteur" action="" method="POST">
      <p>
      <?php
          echo verifyUserData($db);

      ?>
      </p>
      </div>
        <input type="text" name="monPseudo" placeholder="Enter your id or your email"><br><br>
        <input type="password" name="monMotDepass" placeholder="Enter your password"><br><br>

        <input type="submit" name="onEnvoi" value="Connexion">
      </form>

    </fieldset>
</section>
</body>
</html>

