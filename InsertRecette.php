<?php
    require 'Function.php';
?>

<?php
    $mysqli = ConnectionDatabase();

    $query_user = "INSERT INTO user(nom_user, prenom_user, pseudo_user, mail_user, tel_user, password_user)
                VALUES ('Admin', 'Admin', 'Admin', 'AdminGastronoMix@gmail.com', '0000000000', 'AdminGastronoMix');";

    $result_user = $mysqli->query($query_user);

    //ajout des categories n'exitant pas dans la database
    $query_categorie = "INSERT INTO categorie(libelle_categorie) 
                        VALUES ('entree'), ('plat'), ('dessert'), ('boisson');";

    $result_categorie = $mysqli->query($query_categorie);
    
    
    $entreeJson = json_decode(file_get_contents("newentree.json"));
    $platJson = json_decode(file_get_contents("newplat.json"));
    $dessertJson = json_decode(file_get_contents("newdessert.json"));
    $boissonJson = json_decode(file_get_contents("newboisson.json"));

    $recetteJson = [$entreeJson, $platJson, $dessertJson, $boissonJson];
    
    foreach($recetteJson as $index_nom_json => $nom_json) {
        foreach($nom_json as $index_recette => $recette) {
            //recup l'id_categorie selon le nom de la categorie (tiens Léa PEDRA c'est pour toi ça)
            $query_id_categorie = "SELECT id_categorie FROM categorie WHERE libelle_categorie = \"$recette->categorie\";";
            $result_id_categorie = $mysqli->query($query_id_categorie);

            $result_id_categorie = $result_id_categorie->fetch_assoc();
            $id_categorie = $result_id_categorie['id_categorie'];

            //affiche que la premiere recette
            
            $query_recette = "INSERT INTO recette(titre, source, categorie_recette, image_recette, nb_personne, temps_prep_recette, temps_total_recette, difficulte, id_categorie)
                            VALUES(\"$recette->nom\", \"$recette->source\", \"$recette->categorie\", \"$recette->image\", \"$recette->nombredepersonne\", \"$recette->tempspreparation\", \"$recette->tempstotal\", \"$recette->difficulte\", $id_categorie);";

            $result_recette = $mysqli->query($query_recette);

            //echo "ajout avec succes  : " . $query_recette . "\n";


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
                    //echo "ajout avec succes  : " . $query_ajout_unite . "\n";
                    }
                //}
            }

            
            foreach($recette->ingredients as $key_ingredient => $ingredient) {
                foreach($recette->ingredients_recherche as $ingredient_recherche) {
                    $query = "SELECT * FROM ingredient WHERE nom_ingredient = \"$ingredient\";";
                    $result_ingredient = $mysqli->query($query);

                    //recupere les resultats sous forme de tableau
                    $result_ingredient = $result_ingredient->fetch_assoc();

                    //ajout des ingredients n'exitant pas dans la database
                    if($result_ingredient == false) {
                        $unite = $recette->unite[$key_ingredient];
                        $ingredient_recherche = $recette->ingredients_recherche[$key_ingredient];

                        if($unite != "") {
                            $query_id_unite = "SELECT id_unite FROM unite where libelle_unite = \"$unite\";";
                            $result_id_unite = $mysqli->query($query_id_unite);
        
                            //recupere l'id_unite sous forme de tableau
                            $result_id_unite = $result_id_unite->fetch_assoc();
                            $id_unite = $result_id_unite['id_unite'];
                        }

                        $query_ingredient = "INSERT INTO ingredient(nom_ingredient, ingredients_recherche, id_unite)
                                            VALUES(\"$ingredient\", \"$ingredient_recherche\",\"$id_unite\");";

                        $result_ingredient = $mysqli->query($query_ingredient);
                        echo "ajout avec succes  : " . $query_ingredient . "\n";
                    }
                }
            }
            
            //recup l'id_recette selon le nom de la recette
            $query_id_recette = "SELECT id_recette FROM recette WHERE titre = \"$recette->nom\";";
            $result_id_recette = $mysqli->query($query_id_recette);

            $result_id_recette = $result_id_recette->fetch_assoc();
            $id_recette = $result_id_recette['id_recette'];

            foreach($recette->quantite as $key_quantite => $quantite) {
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

                //echo "ajout avec succes  : " . $query_quantite . "\n";
            }


            //ajout des etapes
            foreach($recette->etapes as $key_etapes => $texte_etapes) {
                $key_etapes++;
                $query_etape = "INSERT INTO etape(id_etape, texte_etape, id_recette)
                                VALUES($key_etapes, \"$texte_etapes\", $id_recette);";

                $result_etape = $mysqli->query($query_etape);

                //echo "ajout avec succes  : " . $query_etape . "\n";
            }
        }
    }

    $mysqli->close();
?>