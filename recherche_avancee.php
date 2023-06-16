<?php
    require 'Function.php';
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Recherche avancée</title>
        </head>
    <!-- pour les icones -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
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

    <body>
        <?php
            $mysqli = ConnectionDatabase();

            // Effectuer la recherche en fonction des aliments
            $sql = "SELECT nom_ingredient FROM ingredient";
        ?>
        <h1>Test</h1>
        <form method="post" style="user-select: none;">
            <select name="categorie">
                <option value="null" selected>...</option>
                <option value="entree">Entrée</option>
                <option value="plat">Plat</option>
                <option value="dessert">Dessert</option>
                <option value="boisson">Boisson</option>
            </select>
            <br>
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
                    // var_dump($aliments);
                    // var_dump($etatButton);

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
                            //} else {
                            //   echo 'Aucune option sélectionnée pour : ' . $aliment . '<br>';
                        }
                    }
                    //var_dump($aliments_ok);
                    //var_dump($aliments_ko);

                    if (!empty($aliments_ok)) {
                        $query_strings[] = http_build_query(array('aliments_ok' => $aliments_ok));
                    }
            
                    if (!empty($aliments_ko)) {
                        $query_strings[] = http_build_query(array('aliments_ko' => $aliments_ko));
                    }
                }
                $query_string = implode('&', $query_strings);
                $url = "http://localhost/gastronomix/res_recherche_avancee.php?" . $query_string;
                echo '<a href="' . $url . '">résultats</a>';
            }
        ?>
    </body>
</html>