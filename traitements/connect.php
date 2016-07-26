<?php
if((!isset($_POST['login'])) || (!isset($_POST['pass'])) || ($_POST['login'] == "") || ($_POST['pass'] == ""))
{
    echo 4;
}
else
{
        require('config.php'); // On réclame le fichier

        $login = htmlentities(addslashes($_POST['login']));
        $motdepasse = htmlentities(addslashes($_POST['pass']));

        $req = $bdd->prepare("SELECT * FROM users WHERE user='".$login."'");
        $req->execute();
        $req->setFetchMode(PDO::FETCH_OBJ);
        $res = $req->fetchAll();
        if (count($res)!=0)
            foreach($res as $data){
                if($data->nbr_connect == 3){
                    $lastconnection = date_create($data->dates);
                    $timeLeft = date_add($lastconnection, date_interval_create_from_date_string('10 seconds'));
                    $actuelle = new DateTime('NOW');
                    if($actuelle >= $timeLeft){
                        $id = $data->id;
                        $req = $bdd->prepare("UPDATE users SET nbr_connect=0, dates=NOW() WHERE id='".$id."'");
                        $req->execute();

                        echo 3;
                        exit();
                    }
                    else{
                        echo 2;
                    }
                }
                elseif(password_verify($motdepasse, $data->pass)){
                    $id = $data->id;
                    $req = $bdd->prepare("UPDATE users SET nbr_connect=0, dates=NOW() WHERE id='".$id."'");
                    $req->execute();
                    session_start();
                    $_SESSION['login'] = $data->user;
                    echo 1;
                }
                else
                    {
                        $nbr_essai = $data->nbr_connect;
                        $nbr_essai++;
                        $id = $data->id;
                        $req = $bdd->prepare("UPDATE users SET nbr_connect='".$nbr_essai."', dates=NOW() WHERE id='".$id."'");
                        $req->execute();

                        echo 3;
                        exit();

                    }
            }
        else{
            echo 0;
        }

}
?>
