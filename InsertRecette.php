<?php
    require 'Function.php';
?>

<?php
    $mysqli = ConnectionDatabase();
    
    //fileJsonToDatabase($mysqli, "entree.json", "recette");

    /*fs.writeFileSync("new" + fichier_json + ".json", JSON.stringify([
        { "nom": "", "source": "Marmiton", "difficulte": "", "quantite": [], "unite": [], "ingredients": [], "image": "", "etapes": [], "tempspreparation": "", "tempstotal": "", "nombredepersonne": "", "categorie": "" }
    ]), "UTF-8");
    */

    
    $entreeJson = json_decode(file_get_contents("newentree.json"));
    $platJson = json_decode(file_get_contents("newplat.json"));
    $dessertJson = json_decode(file_get_contents("newdessert.json"));
    $boissonJson = json_decode(file_get_contents("newboisson.json"));

    $recetteJson = [$entreeJson, $platJson, $dessertJson, $boissonJson];


    foreach($recetteJson as $index_recette => $nom_json) {
        foreach($nom_json as $index_nom_json => $recette) {

            //affiche que la premiere recette
            
            $query_recette = "INSERT INTO recette(titre, source, categorie_recette, image_recette, nb_personne, temps_prep_recette, temps_total_recette, difficulte)
                            VALUES(\"$recette->nom\", \"$recette->source\", \"$recette->categorie\", \"$recette->image\", \"$recette->nombredepersonne\", \"$recette->tempspreparation\", \"$recette->tempstotal\", \"$recette->difficulte\");";

            $result_recette = $mysqli->query($query_recette);

            echo "ajout avec succes  : " . $query_recette . "\n";

            
            foreach($recette->ingredients as $ingredient) {
                foreach($recette->unite as $index_unite) {
                $query = "SELECT * FROM ingredient WHERE nom_ingredient = \"$ingredient\";";
                $result_ingredient = $mysqli->query($query);

                //recupere les resultats sous forme de tableau
                $result_ingredient = $result_ingredient->fetch_assoc();

                if($result_ingredient === false) {
                    $query_unite = "SELECT id_unite FROM unite where libelle_unite = \"$index_unite\";";
                    $id_unite = $mysqli->query($query_unite);

                    //recupere l'id_unite sous forme de tableau
                    $id_unite = $id_unite->fetch_assoc();
                    
                    $query_ingredient = "INSERT INTO ingredient(nom_ingredient, id_unite)
                    VALUES(\"$ingredient\", \"$id_unite\");";

                    $result_ingredient = $mysqli->query($query_ingredient);
                    echo "ajout avec succes  : " . $query_ingredient . "\n";
                    }
                }
            }

            
            foreach($recette->quantite as $key_quantite => $quantite) {
                //foreach($recette->ingredients as $ingredient) {
                $ingredient = $recette->ingredients[$key_quantite];
                
                
                $query = "SELECT id_ingredient FROM ingredient WHERE nom_ingredient = \"$ingredient\";";
                    $id_ingredient = $mysqli->query($query);

                    //recupere l'id_ingredient sous forme de tableau
                    $result_id_ingredient = $id_ingredient->fetch_assoc();

                    //recupere l'id_ingredient
                    $result_id_ingredient = $result_id_ingredient['id_ingredient'];
                
                    $query_quantite = "INSERT INTO quantite(id_recette, id_ingredient, quantite)
                                    VALUES(\"$index_recette\", \"$result_id_ingredient\", \"$key_quantite\");";
                                    
                    $result_quantite = $mysqli->query($query_quantite);

                    echo "ajout avec succes  : " . $query_quantite . "\n";
                //}
            }


            foreach($recette->etapes as $key_etapes => $texte_etapes) {
                $query_etape = "INSERT INTO etape(id_etape, texte_etape, id_recette)
                                VALUES($key_etapes, \"$texte_etapes\", $index_recette);";

                $result_etape = $mysqli->query($query_etape);

                echo "ajout avec succes  : " . $query_etape . "\n";
            }
        }
    }

    $mysqli->close();
?>