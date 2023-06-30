<?php
    require 'Function.php';
    session_start();

    if (isset($_GET['pseudo'])) {
        $pseudo = $_GET['pseudo'];
        $_SESSION['pseudo_user'] = $pseudo;
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
        $url = "resultat_recherche_avancee.php?pseudo=" . $pseudo . "&". $query_string;

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
        <?php
            if (isset($_SESSION['pseudo_user'])) {
                if($_SESSION['pseudo_user'] == "admin" || $_SESSION['pseudo_user'] == "Admin") {
                    MenuDeroulantAdmin($pseudo);
                }else {
                    MenuDeroulantCompte($pseudo);
                }
                
                MenuDeroulantConnecter($pseudo);
                RechercheAvanceeConnecter($pseudo);
            } else {
                MenuDeroulantDeconnecter();
                RechercheAvancee();

                echo '<a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>';
            }
        ?>

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
                    echo '<div class="colonne">';
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
                    echo'</div>'; 
                }
            ?>
            <div class="centered">
                <input type="submit" name="bouton" value="Rechercher">
            </div>
        </form>
    </body>
</html>