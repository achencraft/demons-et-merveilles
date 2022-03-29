<?php
//Si lutilisateur est connecte, on lui donne un lien pour modifier ses informations, pour voir ses messages et un pour se deconnecter
if(isset($_SESSION['username']))
{
?>


    <ul id="menu_horizontal">
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Accueil</a></li>
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/infos.php">Informations</a></li>
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/tables">S'inscrire à un JDR</a></li>
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/tables/new_table">Proposer un JDR</a></li>
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/partenaires.php">Partenaires</a></li>

    <li class="menu_droite"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/membres/connexion.php">Deconnexion</a></li>
    <li class="menu_droite"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/membres/edit_infos.php">Profil</a></li>
    </ul>



<?php
}
else
{
//Sinon, on lui donne un lien pour sinscrire et un autre pour se connecter
?>


    <ul id="menu_horizontal">
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Accueil</a></li>
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/infos.php">Informations</a></li>
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/tables">S'inscrire à un JDR</a></li>
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/tables/new_table">Proposer un JDR</a></li>
    <li class="menu_gauche"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/partenaires.php">Partenaires</a></li>

    <li class="menu_droite"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/membres/connexion.php">Connexion</a></li>
    <li class="menu_droite"><a href="https://<?php echo $_SERVER['SERVER_NAME']?>/membres/sign_up.php">Inscription</a></li>
    </ul>



<?php
}
?>
