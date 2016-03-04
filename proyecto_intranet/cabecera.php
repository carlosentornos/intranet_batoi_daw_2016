<header>
    <div id="cabecera" class="borderedondo">
        <a href="controlPanel.php"><img src="css/mapaimagen.png" class="imagenflexible"></a>
        <div id="sesion">
            <?php
            if (!$_SESSION) {
                echo '<a href="login.php">Iniciar sesion</a>';
            } else {
                if (!isset($_SESSION['user'])) {
                    $_SESSION['error'] = "No puedes acceder a páginas de administración si no estas previamente identificado.";
                    //$_SESSION['error']="No pots accedir a págines d'adminitraçió si no estas previament identificat.";
                    header("Location: login.php");
                } else {
                    echo '<p>' . $_SESSION['user'] . ' ' . $_SESSION['apellido1'] . ' - ' . $_SESSION['userType'] . '</p>';

                    echo '<div class="alineacion_centrada"><a href="./login.php" class="azul"> <img class="iconopequeno" src="imagenes/home.svg"></a><a href="php/desconexion.php"> <img class="iconopequeno" src="imagenes/cerrarSesion.png"></a> </div>';
                }
            }
            ?>

        </div>
    </div>
</header>
