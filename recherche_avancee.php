<?php
    require 'Function.php';

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
    </head>

    <body>
        <h1>Recherche avancée</h1>
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
                $sql = "SELECT ingredients_recherche FROM ingredient ORDER BY ingredients_recherche ASC";

                $result = $mysqli->query($sql);

                $ingredients = array();

                while ($row = $result->fetch_assoc()) {
                    $ingredients_recherche = $row['ingredients_recherche'];
                    $cleaned_nom = $ingredients_recherche;

                    // Vérifie si le nom d'ingrédient se termine par 's'
                    $fin_en_s = (substr($ingredients_recherche, -1) === 's');

                    $retirer_paranthese = strpos($ingredients_recherche, '(');
                    if ($retirer_paranthese !== false) {
                        $cleaned_nom = trim(substr($ingredients_recherche, 0, $retirer_paranthese));
                    }

                    // Vérifie si l'ingrédient existe déjà dans le tableau
                    if (!in_array($cleaned_nom, $ingredients)) {
                        // Vérifie si le nom d'ingrédient se termine par 's' et s'il existe une autre version sans 's'
                        if ($fin_en_s) {
                            $fin_sans_s = rtrim($cleaned_nom, 's');
                            if (in_array($fin_sans_s, $ingredients)) {
                                // Ignore l'ingrédient s'il existe déjà avec une version au singulier
                                continue; // Ignore l'ingrédient s'il existe déjà avec une version singulière
                            }
                        }
                        $ingredients[] = $cleaned_nom;
                    }
                }

                // Trie les ingrédients par ordre alphabétique
                sort($ingredients);

                // Affiche les ingrédients
                foreach ($ingredients as $ingredient) {
                    echo '
                        <div class="multi-checkbox">
                            <span class="check unchecked">
                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>
                            </span>
                            <input type="hidden" class="form-check-input choice-jr" name="aliments[]" style="display: none; user-select: none;" value="' . $ingredient . '">' . $ingredient . '
                            <input type="hidden" name="etat_bouton[]" value="unchecked">
                        </div>
                        <br>';
                }
            ?>
            <div class="centered">
                <input type="submit" name="bouton" value="Rechercher">
            </div>
        </form>
    </body>
</html>