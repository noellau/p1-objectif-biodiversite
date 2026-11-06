<?php
$niveau = "../../";

include($niveau . "inc/config.inc.php");

$strRequete = "SELECT especes.id AS id, especes.nom_francais AS nom_francais, especes.nom_scientifique AS nom_scientifique, especes.`autres_noms_francais`, especes.description, especes.repartition, especes.habitat, especes.alimentation, especes.etat_situation, especes.alimentation, especes.reproduction, especes.menaces, especes.statut_LEMV AS statut, groupes.nom_groupe AS groupe, images.nom_image, images.`bas-de-vignette` FROM especes INNER JOIN groupes ON especes.groupe_id = groupes.id INNER JOIN images ON especes.id = images.espece_id WHERE images.nom_image LIKE 'IMG%' AND especes.id =" . $_GET['id'];

$pdosResultat = $pdoConnexion->query($strRequete);

$arrAnimale = $pdosResultat->fetch();

$pdosResultat->closecursor();
?>

<!DOCTYPE html>
<html lang="fr-ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $arrAnimale['nom_francais'] ?></title>

    <!-- Liens css -->
    <link rel="stylesheet" href="<?= $niveau ?>assets/sdg/dist/css/qc-sdg.min.css">
    <link rel="stylesheet" href="<?= $niveau ?>assets/css/style-liste.css">
    <link rel="stylesheet" href="<?= $niveau ?>assets/css/style-fiche.css">

    <!-- Liens js -->
    <script src="<?php echo $niveau ?>assets/sdg/dist/js/qc-sdg.min.js" defer></script>
</head>

<body>
    <?php include($niveau . "inc/fragments/navigation.html") ?>
    <main class="contenu-principal qc-container">
        <div class="contenu-principal__fiche">
            <h1 class="fiche__nom-francais"><?= $arrAnimale['nom_francais'] ?></h1>
            <div class="fiche__infos-rapides">
                <figure class="infos-rapides__figure">
                    <img class="figure__image" src="<?= $niveau ?>assets/images/<?= $arrAnimale['nom_image'] ?>"
                        alt="<?= $arrAnimale['bas-de-vignette'] ?>">
                    <figcaption class="figure__caption">
                        <?= $arrAnimale['bas-de-vignette'] ?>
                    </figcaption>
                </figure>
                <p class="infos-rapides__info"><span class="infos-rapides-titres">Nom scientifique :
                    </span><?= $arrAnimale['nom_francais'] ?></p>
                <p class="infos-rapides__info"><span class="infos-rapides-titres">Autres noms français :
                    </span><?= $arrAnimale['autres_noms_francais'] ?></p>
                <div class="infos-rapides__groupe infos-rapides__pastille">
                    <p class="groupe__titre infos-rapides-titres">Groupe : </p>
                    <div class="groupe__pastille pastille">
                        <?= $arrAnimale['groupe'] ?>
                    </div>
                </div>
                <div class="infos-rapides__statut infos-rapides__pastille">
                    <p class="statut__titre infos-rapides-titres">Statut : </p>
                    <div class="statut__pastille pastille <?php
                    if ($arrAnimale['statut'] == "Menacée") {
                        echo "pastille-rouge";
                    } else if ($arrAnimale['statut'] == "Vulnérable") {
                        echo "pastille-jaune";
                    } else {
                        echo "pastille-verte";
                    }
                    ?>">
                        <?= $arrAnimale['statut'] ?>
                    </div>
                </div>
            </div>
            <div class="contenu-principal__textes">
                <div class="textes__description">
                    <?= $arrAnimale['description'] ?>
                </div>
                <details class="textes__details">
                    <summary class="details__titre">Répartition</summary>
                    <div class="details__infos"> <?= $arrAnimale['repartition'] ?> </div>
                </details>
                <details class="textes__details">
                    <summary class="details__titre">Habitat</summary>
                    <div class="details__infos"> <?= $arrAnimale['habitat'] ?> </div>
                </details>
                <details class="textes__details">
                    <summary class="details__titre">État de la situation</summary>
                    <div class="details__infos"> <?= $arrAnimale['etat_situation'] ?> </div>
                </details>
                <details class="textes__details">
                    <summary class="details__titre">Alimentation</summary>
                    <div class="details__infos"> <?= $arrAnimale['alimentation'] ?> </div>
                </details>
                <details class="textes__details">
                    <summary class="details__titre">Reproduction</summary>
                    <div class="details__infos"> <?= $arrAnimale['reproduction'] ?> </div>
                </details>
                <details class="textes__details">
                    <summary class="details__titre">Menaces</summary>
                    <div class="details__infos"> <?= $arrAnimale['menaces'] ?> </div>
                </details>
            </div>
        </div>
        <div class="contenu-principal__especes">

        </div>
    </main>
</body>