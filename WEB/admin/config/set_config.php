<?php
include('../../config.php');


//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){

        if($_SERVER['REQUEST_METHOD']=='POST'){
            //On verifie si le formulaire a ete envoye
        	if(isset($_POST['jour']))
        	{




                for($jour_id = 1; $jour_id <= 7; $jour_id++){
                    //echo "update configuration set valide = 0 where id=".$jour_id."<br>";
                    if(!mysql_query('update configuration set valide = 0 where id='.$jour_id)){
                        echo "erreur update 1";
                    }


                    foreach ($_POST['jour'] as $id) {
                        if($jour_id == $id){
                            //echo "update configuration set valide = 1 where id=".$jour_id."<br>";
                            if(!mysql_query('update configuration set valide = 1 where id='.$jour_id)){
                                echo "erreur update 2";
                            }
                        }
                    }

                        //-------------------

                    for($heure_id = 1+(($jour_id-1)*48)+7; $heure_id <= 48+(($jour_id-1)*48)+7;$heure_id++){
                        //echo "--> update configuration set valide = 0 where id=".$heure_id."<br>";
                        if(!mysql_query('update configuration set valide = 0 where id='.$heure_id)){
                            echo "erreur update 3";
                        }


                        $req = mysql_query("select * from configuration where id=".$jour_id);
                        $dnn = mysql_fetch_array($req);


                            foreach ($_POST['heure'] as $id2) {

                                if($heure_id == $id2 && $dnn['valide'] == 1){
                                    //echo "egalité";

                                        //echo "update configuration set valide = 1 where id=".$heure_id."<br>";
                                        if(!mysql_query('update configuration set valide = 1 where id='.$heure_id)){
                                            echo "erreur update 4";
                                        }

                                }
                            }


                    }



                }





                //un jour = 48 horaires
                //lundi va de 8 à 55  etc ...


                header('Location: index.php');




            }
        } else {
         echo "pas en requete POST";
        }

        } else {
        echo "Vous n'etes pas administrateur";
        }

} else {
    echo "Vous n'etes pas connecté";
}
?>
