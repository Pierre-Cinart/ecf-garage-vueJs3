<!-- info de connection -->
<?php
    if (isset($_SESSION['log-in'])){
        echo '<div class="connect-info">';
        echo '<div class="btn-connect"></div>';
        echo '<p>Connecté en tant que <?php echo $_SESSION["user"]?></p></div>';
    }
    

// pop up message erreur ou succès 

    if (isset($_SESSION["info"])){
        echo  '<div id = "popUp" class = "'.$_SESSION["info-type"].'">';
            echo' <p>'.$_SESSION["info"].'</p>';
        echo'</div>';
        unset($_SESSION['info']);
    }

?>