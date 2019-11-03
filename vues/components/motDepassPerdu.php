<?php
//CHANGER LE MOT DE PASSE

//Si on click sur le bouton reset
if(isset($_POST['resetPass'])){
    if(!empty($_POST['monMail']) && !empty($_POST['oldPassWord']) && !empty($_POST['neWpassWord']) && !empty($_POST['neWpassWordAgain'])){
        //Vérifier si on est connecté à la bd
        
        try{
            $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e){
        die('Erreur : ' .$e->getMessage());
        }
    
        //$oldPassword = htmlspecialchars($_POST['oldPassword']);
        //Intéroger la base de données
        $req = $db->prepare("select * from users
                              where email = :monMail
                              AND password = :oldPassWord");
    
        $req->execute(array('monMail' => $_POST['monMail'], 'oldPassWord' => $_POST['oldPassWord']));
        $resultat = $req->fetch();

        $req->closeCursor();

        //Vérifier si les données entrées par l'utilisateur correspondent à celles de la base des données
        if($_POST['monMail'] != $resultat['email'] && $_POST['oldPassWord'] != $resultat['password']){
            
           $mSgErr = '';
            echo $mSgErr = 'Your email or your oldpassword doesn\'t exist in our database';
        }

        //Vérifier si le nouveau mot de passe corresond à la répétition du mot de passe
        if($_POST['neWpassWord'] != $_POST['neWpassWordAgain']){
            echo 'Your new passwords doenst correspond. Try again.';
        }else{
            //Mise à jour de la base des données
            $req = $db->prepare("update users set password = :neWpassWord where email = :monMail");
            $req->execute(array('neWpassWord' => $_POST['neWpassWord'], 'monMail' => $_POST['monMail']));
            echo 'You succed to change your password';
        }
    
    }else{
        echo 'Invalid input';
    }

    


}

//MOT DE PASSE PERDU
if(isset($_POST['resetMail'])){
    if(!empty($_POST['monMail'])){
        //Connexion à la base des données
        try{
            $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e){
        die('Erreur : ' .$e->getMessage());
        }

        //Requette à la data base
        $req = $db->prepare("select count(*) from users where email = :unemail");
        $req->execute(array('unemail' =>$_POST['monMail']));
        $resultat = $req->fetch();
        $req->closeCursor();

        //Est-ce que le mail existe dans la database ?
        if($resultat[0] > 0){
            function generatePassword($size=10){
                $passwd = strtolower(md5(uniqid(rand())));
                $passwd = substr($passwd,2,$size);
                $passwd = strtr(
                    $passwd,
                    'o0ODQGCiIl15Ss7',
                    'BEFHJKMNPRTUVWX'
                );
                return $passwd;
            }

            for ($i=1 ; $i < 10 ; $i++) {
                $newPassword = generatePassword();
            }
            
            //Envoi de l'email à l'utilisateur

            //use PHPMailer\PHPMailer\PHPMailer;
            require_once 'PHPMailer/PHPMailer.php';
            require_once 'PHPMailer/SMTP.php';
            require_once 'PHPMailer/Exception.php'; 
            require_once 'PHPMailer/class.phpmailer.php';
            require_once 'PHPMailer/class.smtp.php';

            $mail = new PHPMailer();
            
            //SMTP Settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'peekswift@gmail.com';
            $mail->Password = 'SwiftPeek123';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';

            //Email Settings
            $mail->setFrom($_POST['monMail']);
            $mail->addAddress('peekswift@gmail.com');
            $mail->Subject = 'Recovery lost password';
            $mail->Body = 'Dear'.', '.$_POST['monMail'].' '.'here your new password'.':'.' '. generatePassword(). '.'.' '.'Remember to change your new password, for a password you can remember easily.';

            if($mail->Send()){
                echo 'The email was sent !';
            }else{
                echo 'Something went wrong, the email was not sent !';
            }


            //$to = $_POST['monMail'];
            //$ubject = 'Recovery lost password';
            //$body ='Dear'.', '.$to.' '.'here your new password'.' '. generatePassword(). '.'.' '.'Remember to change your new password, for a password you can remember easily.';
            //mail($to, $ubject, $body);

            //Mise à jour de la base des données
            $req = $db->prepare('update users set password = :password
                                where email = :monMail');

            $req->execute(array('password' => $newPassword, 'monMail' => $_POST['monMail']));
            echo'A new password has been sent to you, check your email.'.'<br>'.' For security, be sure to change it immediatly.';
;        }else{
            echo 'Sorry, this email does not exist in our database';
        }
        

    }else{
        //Champ email n'a pas été remplie
        echo 'Please be sure your input email is filled.';
        
    }

}





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="vues/css/recoveryMdp.css">
    <title>Changermot de passe et Mot de passe perdu</title>
</head>
<body>
    <!--title1-->
    <h1>Change your password</h1>
    <form action="" method="POST">
        <input type="mail" name="monMail" placeholder="Enter your email">
        <input type="password" name="oldPassWord" placeholder="Enter your old password">
        <input type="password" name="neWpassWord" placeholder="Enter a new password">
        <input type="password" name="neWpassWordAgain" placeholder="Repeat the new pass">
        <input type="submit" name="resetPass" value="Reset your password">
    </form>

    <!--title2-->
    <h1>Forgot your password</h1>
    <form action="" method="POST">
        <input type="mail" name="monMail" placeholder="Enter your email">
        <input type="submit" name="resetMail" value="New password">
    </form>

    <form action="" method="POST">
        <input type="submit" name="reTourAconnexio" value="Back to connexion" class="retourConnex">
    </form>
</body>
</html>