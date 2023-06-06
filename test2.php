<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
    </head>
    <!-- pour les icones -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <style>
        .multi-checkbox .check {
            display: inline-block;
            vertical-align: top;
            width: 20px;
            height: 20px;
            border: 1px solid #333;
            margin: 3px;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
        }

        .multi-checkbox .check.unchecked i {
            display: none;
        }

        .multi-checkbox .check.partial i.fa-minus {
            display: none;
        }

        .multi-checkbox .check.checked i.fa-plus {
            display: none;
        }
    </style>
    <!-- exécuteur js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- récupréré sur stackoverflow -->
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

    <body>
        <?php
            $mysqli = ConnectionDatabase();

            // Effectuer la recherche en fonction des aliments
            $sql = "SELECT nom_ingredient FROM ingredient";
        ?>
        <h1>Test</h1>
        <form method="post" style="user-select: none;">
            <?php
                $result = $mysqli->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="multi-checkbox">
                        <span class="check unchecked">
                            <i class="fa fa-plus"></i>
                            <i class="fa fa-minus"></i>
                        </span>
                        <input type="hidden" class="form-check-input choice-jr" name="aliments[]" style="display: none; user-select: none;" value="' . $row['nom_ingredient'] . '">' . $row['nom_ingredient'] . '
                        <input type="hidden" name="etat_bouton[]" value="unchecked">
                    </div>
                    <br>';
                }
            ?>
            <input type="submit" name="bouton" value="Rechercher">
        </form>
        <?php
            if (!empty($_POST['aliments']) && !empty($_POST['etat_bouton'])) { // Vérifie si la clé 'aliments' existe dans $_POST
                $aliments = $_POST['aliments'];
                $etatButton = $_POST['etat_bouton'];
                // var_dump($aliments);
                // var_dump($etatButton);

                foreach ($aliments as $index => $aliment) {
                    // Sépare les valeurs en fonction de la virgule
                    $options = explode(',', $aliment);

                    // Vérifie les valeurs sélectionnées
                    if ($etatButton[$index] == "partial") {
                        // L'option "+" a été sélectionnée (case cochée avec la classe "partial" du span)
                        // Récupère les noms et les images des recettes qui contiennent l'ingrédient spécifié par la variable $aliment
                        $sql = "SELECT nom_recette, image_recette FROM recette WHERE nom_recette IN (SELECT nom_recette FROM recette_ingredient WHERE nom_ingredient = '$aliment')";
                        echo 'Inclure : ' . $aliment . '<br>';
                    } else if ($etatButton[$index] == "checked") {
                        // L'option "-" a été sélectionnée (case cochée avec la classe "checked" du span)
                        // Récupère les noms et les ingrédients des recettes qui ne contiennent pas l'ingrédient spécifié $aliment
                        $sql = "SELECT nom_recette, image_recette FROM recette WHERE nom_recette NOT IN (SELECT nom_recette FROM recette_ingredient WHERE nom_ingredient = '$aliment')";
                        echo 'Exclure : ' . $aliment . '<br>';
                    } else {
                        // Aucune option sélectionnée (case non cochée avec la classe "unchecked" du span)
                        echo 'Aucune option sélectionnée pour : ' . $aliment . '<br>';
                    }
                }
            }
        ?>
    </body>
</html>