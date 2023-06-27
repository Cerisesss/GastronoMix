<?php
    require 'Function.php';
    session_start();

    if (isset($_GET['pseudo'])) {
        $pseudo = $_GET['pseudo'];
        $_SESSION['pseudo_user'] = $pseudo;
    }

    if (isset($_SESSION['pseudo_user'])) {
        if($_SESSION['pseudo_user'] == "admin" || $_SESSION['pseudo_user'] == "Admin") {
            MenuDeroulantAdmin($pseudo);
        }else {
            MenuDeroulantCompte($pseudo);
        }
    } else {
        echo '<a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $query_strings = array();
        $categorie = $_POST['categorie'];

        if (!empty($categorie)) {
            $query_strings[] = http_build_query(array('categorie' => $categorie));
        }

        // Vérifie si la clé 'aliments' existe dans $_POST
        if (!empty($_POST['aliments']) && !empty($_POST['etat_bouton'])) {
            $aliments = $_POST['aliments'];
            $etatButton = $_POST['etat_bouton'];

            $aliments_ok = array();
            $aliments_ko = array();

            foreach ($aliments as $index => $aliment) {
                // Sépare les valeurs en fonction de la virgule
                $options = explode(',', $aliment);

                // Vérifie les valeurs sélectionnées
                if ($etatButton[$index] == "partial") {
                    $aliments_ok[] .= $aliment;
                } else if ($etatButton[$index] == "checked") {
                    $aliments_ko[] .= $aliment;
                }
            }

            if (!empty($aliments_ok)) {
                $query_strings[] = http_build_query(array('aliments_ok' => $aliments_ok));
            }

            if (!empty($aliments_ko)) {
                $query_strings[] = http_build_query(array('aliments_ko' => $aliments_ko));
            }
        }

        $query_string = implode('&', $query_strings);
        $url = "resultat_recherche_avancee.php?" . $query_string;
        header("Location: " . $url);
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Recherche avancée</title>
        <!-- pour les icones -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="recherche_avancee.css">
        <!-- exécuteur js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- récupéré sur stackoverflow -->
        <script>
            $(function() {
                $(".check").data("state", 0).addClass("unchecked");
                $(".multi-checkbox").click(function() {
                    var states = ["unchecked", "partial", "checked"];
                    var curState = $(this).find(".check").data("state");
                    curState++;
                    $(this).find(".check").removeClass("unchecked partial checked").addClass(states[curState % states.length]).data("state", curState % states.length);
                    $(this).find("input[name='etat_bouton[]']").val(states[curState % states.length]);
                });
            });
        </script>
        <script src="Function.js"></script>
    </head>

    <body>
    <button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>
        <div id="menu">
            <ul>
                </br>
                <?php
                    if (isset($_SESSION['pseudo_user'])) {
                        MenuDeroulantConnecter($pseudo);
                    } else {
                        MenuDeroulantDeconnecter();
                    }
                ?>
            </ul>
        </div>


        <div id="Rechercher">
        <a href="http://localhost/gastronomix/recherche_avancee.php"><button id="Recherche_avancee" class="Button"><img src="Images/filtre.png" alt="Image"></button></a>

            <form action="resultat_recherche_avancee.php" method="GET">
                <input id="RechercherBarre" type="text" name="recherche" value="">
                <button id="RechercherButton" class="Button" type="submit">🔍</button>
            </form>
        </div>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <h1>GastronoMix</h1>
        <h2>Recherche avancée</h2>
        <form method="post" style="user-select: none;">
            <div class="centered">
                <select name="categorie">
                    <option value="null" selected>...</option>
                    <option value="entree">Entrée</option>
                    <option value="plat">Plat</option>
                    <option value="dessert">Dessert</option>
                    <option value="boisson">Boisson</option>
                </select>
            </div>
            <br>
            <?php
                $mysqli = ConnectionDatabase();
                $alphabet = range('a', 'z');

                foreach ($alphabet as $letter) {
                    echo '<h2>' . strtoupper($letter) . '</h2>';

                    $sql = "SELECT DISTINCT TRIM(ingredients_recherche) 
                    FROM ingredient 
                    WHERE TRIM(ingredients_recherche) LIKE '$letter%' 
                    ORDER BY TRIM(ingredients_recherche) ASC;";

                    $result = $mysqli->query($sql);

                    $ingredients = array();

                    while ($row = $result->fetch_assoc()) {
                        $ingredients_recherche = $row['TRIM(ingredients_recherche)'];
                        $ingredients[] = $ingredients_recherche;
                    }

                    // Affiche les ingrédients
                    foreach ($ingredients as $ingredient) {
                        echo '
                            <div class="multi-checkbox" id="form-multi-checkbox">
                                <span class="check unchecked">
                                    <i class="fa fa-plus"></i>
                                    <i class="fa fa-minus"></i>
                                </span>
                                <input type="hidden" class="form-check-input choice-jr" name="aliments[]" style="display: none; user-select: none;" value="' . $ingredient . '">' . $ingredient . '
                                <input type="hidden" name="etat_bouton[]" value="unchecked">
                            </div>
                            <br>';
                    } 
                }
            ?>
            <div class="centered">
                <input type="submit" name="bouton" value="Rechercher">
            </div>
        </form>
    </body>
</html>