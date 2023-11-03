 <div class="connect-info">
            <div class="btn-connect"></div>
            <p>Connecté en tant que <?php echo $_SESSION["user"]?></p>
        </div>
        <?php 
            if (isset($_SESSION["info"])){
                echo  '<div id = "popUp" class = "'.$_SESSION["info-type"].'">';
                    echo' <p>'.$_SESSION["info"].'</p>';
                echo'</div>';
                    unset($_SESSION['info']);
                }

            ?>