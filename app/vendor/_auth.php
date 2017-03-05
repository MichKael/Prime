<?php

// **********************REGISTER**********************//

/**
 * [registerValidator description]
 * @return [type] [description]
 */
function registerValidator(){

    $errors = [];
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        //Extraire les variables du $_POST
        extract($_POST);

        if(empty($_POST['firstName']) || !preg_match('/^[a-zA-Z0-9_éèà -]+$/', $_POST['firstName'])){
            $errors['firstName'] = "Nom invalide (alphanumérique)";
        }

        if(empty($_POST['lastName']) || !preg_match('/^[a-zA-Z0-9_éèà -]+$/', $_POST['lastName'])){
            $errors['lastName'] = "Prenom invalide (alphanumérique)";
        }

        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Votre adresse email n'est pas invalide";
        }else{
            if (exist($email,'email')) {
                $errors['email'] = "Adresse email déjà utilisée";
            } 
        }

        if(empty($password) || $password != $confirmPassword){
            $errors['password'] = "Vous devez rentrer un mot de passe valide";
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error;
            }
        }else{
            register_user($firstName,$lastName,$email,$password);
            
        }

    }
}

/**
 * [register_user description]
 * @param  [string] $firstName [description]
 * @param  [string] $lastName  [description]
 * @param  [string] $email     [description]
 * @param  [string] $password  [description]
 * @return [type]            [description]
 */
function register_user($firstName,$lastName,$email,$password){
    global $db;

    $q = $db->prepare("INSERT INTO users SET firstName = ?, lastName = ?, email = ?, password = ?, confirmation_token = ?, role_id = 4");

    $pass = password_hash($password, PASSWORD_BCRYPT);

    $token = random(60);

    $q->execute([$firstName,$lastName,$email,$pass,$token]);

    $user_id = $db->lastInsertId();

    //Envoie du mail d'activation

    $subject = "CONFIRMATION DE VOTRE COMPTE";
    $msg = "Afin de valider votre compte merci de cliquer sur ce lien ci-dessous\n\nhttp://localhost/lost/?p=active&id=$user_id&token=$token";

    mail($email, $subject, $msg);

    //Stockage du message de succes dans la session

    flash_message("Un email de confirmation vous a été envoyé");

    header('Location: ?p=login');

}

// **********************LOGIN**********************//

/**
 * [log_in description]
 * @return [type] [description]
 */
function log_in(){

    $errors = [];
    if ($_SERVER["REQUEST_METHOD"]=="POST") {

        if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){

            //Extraire les variables du $_POST
            extract($_POST);
            
            global $db;

            $sql = "SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL";

            $q = $db->prepare($sql);
            $q->execute([$email]);
            $user = $q->fetch();

            if($user){
                if(password_verify($password, $user->password)){

                    $_SESSION['auth'] = $user;
                    $_SESSION['message'] = "Vous êtes maintenant connecté";

                    if(isset($remember)){
                        $remember_token = random(250);

                        $q = $db->prepare("UPDATE users 
                            SET remember_token = ? 
                            WHERE id = ?");
                        $q->execute([$remember_token, $user->id]);
                        setcookie('remember', $user->id. '//' . $remember_token . sha1($user->id . 'losthing'), time() + 60 * 60 * 24 * 7);
                    }
                            //
                    return header("Location: ?p=account&id=$user->id");
                    exit();

                }else{
                    $errors['password'] = "Identifiant ou mot de passe incorrect";
                }
            }else{
                $errors['user'] = "Identifiant ou mot de passe incorrect";
            }
        }

    }
}

// **********************LOGOUT**********************//

function logout(){
    setcookie('remember', NULL,-1);
    unset($_SESSION['auth']);
    ob_clean();
    $_SESSION['flash']['success'] = "Vous êtes maintenant déconnecter";
    header('Location: ?p=login');
}

// **********************LOGOUT**********************//

function auto_reconnect(){
    
}