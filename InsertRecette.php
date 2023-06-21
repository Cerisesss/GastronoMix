<?php
    require 'Function.php';
?>

<?php
    $mysqli = ConnectionDatabase();
    
    $entreeJson = json_decode(file_get_contents("newentree.json"));
    $platJson = json_decode(file_get_contents("newplat.json"));
    $dessertJson = json_decode(file_get_contents("newdessert.json"));
    $boissonJson = json_decode(file_get_contents("newboisson.json"));

    $recetteJson = [$entreeJson, $platJson, $dessertJson, $boissonJson];
    
    foreach($recetteJson as $index_nom_json => $nom_json) {
        foreach($nom_json as $index_recette => $recette) {

            //affiche que la premiere recette
            
            $query_recette = "INSERT INTO recette(titre, source, categorie_recette, image_recette, nb_personne, temps_prep_recette, temps_total_recette, difficulte)
                            VALUES(\"$recette->nom\", \"$recette->source\", \"$recette->categorie\", \"$recette->image\", \"$recette->nombredepersonne\", \"$recette->tempspreparation\", \"$recette->tempstotal\", \"$recette->difficulte\");";

            $result_recette = $mysqli->query($query_recette);

            echo "ajout avec succes  : " . $query_recette . "\n";


            //ajout des unites n'exitant pas dans la database
            foreach($recette->unite as $key_unite => $index_unite) {
                    $query_unite = "SELECT * FROM unite WHERE libelle_unite = \"$index_unite\";";
                    $result_unite = $mysqli->query($query_unite);
    
                    //recupere les resultats sous forme de tableau
                    $result_unite = $result_unite->fetch_assoc();

                if($result_unite == false && $index_unite != "") {
                    $query_ajout_unite = "INSERT INTO unite(libelle_unite)
                                        VALUES(\"$index_unite\");";

                    $result_ajout_unite = $mysqli->query($query_ajout_unite);
                    echo "ajout avec succes  : " . $query_ajout_unite . "\n";
                    }
                //}
            }

            
            foreach($recette->ingredients as $key_ingredient => $ingredient) {
                $query = "SELECT * FROM ingredient WHERE nom_ingredient = \"$ingredient\";";
                $result_ingredient = $mysqli->query($query);

                //recupere les resultats sous forme de tableau
                $result_ingredient = $result_ingredient->fetch_assoc();

                //ajout des ingredients n'exitant pas dans la database
                if($result_ingredient == false) {
                    $unite = $recette->unite[$key_ingredient];

                    if($unite != "") {
                        $query_id_unite = "SELECT id_unite FROM unite where libelle_unite = \"$unite\";";
                        $result_id_unite = $mysqli->query($query_id_unite);
    
                        //recupere l'id_unite sous forme de tableau
                        $result_id_unite = $result_id_unite->fetch_assoc();
                        $id_unite = $result_id_unite['id_unite'];
                    }

                    $query_ingredient = "INSERT INTO ingredient(nom_ingredient, id_unite)
                                        VALUES(\"$ingredient\", \"$id_unite\");";

                    $result_ingredient = $mysqli->query($query_ingredient);
                    echo "ajout avec succes  : " . $query_ingredient . "\n";
                }
            }

            $query_id_recette = "SELECT id_recette FROM recette WHERE titre = \"$recette->nom\";";
            $result_id_recette = $mysqli->query($query_id_recette);

            $result_id_recette = $result_id_recette->fetch_assoc();
            $id_recette = $result_id_recette['id_recette'];

            foreach($recette->quantite as $key_quantite => $quantite) {
                //foreach($recette->ingredients as $ingredient) {
                //recupere le nom de l'ingredient selon l'indice de la quantite
                $ingredient = $recette->ingredients[$key_quantite];  
                
                //recupere l'id_ingredient selon le nom de l'ingredient
                $query_id_ingredient = "SELECT id_ingredient FROM ingredient WHERE nom_ingredient = \"$ingredient\";";
                $result_id_ingredient = $mysqli->query($query_id_ingredient);

                $result_id_ingredient = $result_id_ingredient->fetch_assoc();
                $id_ingredient = $result_id_ingredient['id_ingredient'];

                $query_quantite = "INSERT INTO quantite(id_recette, id_ingredient, quantite)
                                VALUES(\"$id_recette\", \"$id_ingredient\", \"$quantite\");";
                                
                $result_quantite = $mysqli->query($query_quantite);

                echo "ajout avec succes  : " . $query_quantite . "\n";
                //}
            }


            foreach($recette->etapes as $key_etapes => $texte_etapes) {
                $key_etapes++;
                $query_etape = "INSERT INTO etape(id_etape, texte_etape, id_recette)
                                VALUES($key_etapes, \"$texte_etapes\", $id_recette);";

                $result_etape = $mysqli->query($query_etape);

                echo "ajout avec succes  : " . $query_etape . "\n";
            }
        }
    }

    $mysqli->close();
?>