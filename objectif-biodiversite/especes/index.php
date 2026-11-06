<?php
$niveau = "../";

include($niveau . "inc/config.inc.php");

$strRequete = "SELECT especes.id AS id, especes.nom_francais AS nom_francais, especes.nom_scientifique AS nom_scientifique, especes.statut_LEMV AS statut, groupes.nom_groupe AS groupe, images.nom_image, images.`bas-de-vignette` FROM especes INNER JOIN groupes ON especes.groupe_id = groupes.id INNER JOIN images ON especes.id = images.espece_id WHERE images.nom_image LIKE 'IMG%' ORDER BY nom_francais";

$pdosResultat = $pdoConnexion->query($strRequete);

$arrAnimaux = array();
for ($cptEnr = 0; $ligne = $pdosResultat->fetch(); $cptEnr++) {
    $arrAnimaux[$cptEnr]['id'] = $ligne['id'];
    $arrAnimaux[$cptEnr]['nom_francais'] = $ligne['nom_francais'];
    $arrAnimaux[$cptEnr]['nom_scientifique'] = $ligne['nom_scientifique'];
    $arrAnimaux[$cptEnr]['statut'] = $ligne['statut'];
    $arrAnimaux[$cptEnr]['groupe'] = $ligne['groupe'];
    $arrAnimaux[$cptEnr]['nom_image'] = $ligne['nom_image'];
    $arrAnimaux[$cptEnr]['bas-de-vignette'] = $ligne['bas-de-vignette'];

    $arrNomFrancais = explode(" ", (string) $ligne['nom_francais']);
    if(count($arrNomFrancais) > 5){
        array_splice($arrNomFrancais, 5, count($arrNomFrancais));
    }
    $arrAnimaux[$cptEnr]['nom_francais'] = implode(" ", $arrNomFrancais);
}
$pdosResultat->closecursor();
?>

<!DOCTYPE html>
<html lang="fr-ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objectif biodiversite liste des espèces</title>

    <!-- Liens css -->
    <link rel="stylesheet" href="<?php echo $niveau ?>assets/css/style-liste.css">
    <link rel="stylesheet" href="<?php echo $niveau ?>assets/sdg/dist/css/qc-sdg.min.css">

    <!-- Liens js -->
    <script src="<?php echo $niveau ?>assets/sdg/dist/js/qc-sdg.min.js" defer></script>
</head>

<body>
    <div id="pivEnteteExempleRecherchePersonnalisee">
        <qc-piv-header title-text="Titre du site ou du service" title-url alt-logo="Accédez à Québec.ca"
            enable-search="true" show-search="true">
            <ul slot="links">
                <li><a href="#fakeEnglish">English</a>
                </li>
                <li><a href="#">Nous joindre</a>
                </li>
            </ul>

            <form slot="search-zone" method="get" action="https://www.google.ca/search">
                <qc-search-bar name="q" piv-background></qc-search-bar>
            </form>
        </qc-piv-header>
    </div>
    <?php include($niveau . "inc/fragments/navigation.html") ?>
    <h1>Liste des espèces</h1>
    <main class="contenu-principal">
        <ul class="contenu-principal__liste-cartes">
            <?php for ($cptAnimale = 0; $cptAnimale < count($arrAnimaux); $cptAnimale++) { ?>
                <li class="liste-cartes__item">
                    <div class="item__container">
                        <picture class="item__container-image">
                            <img class="container-image__image" src="../assets/images/<?= $arrAnimaux[$cptAnimale]['nom_image'] ?>"
                                alt="<?= $arrAnimaux[$cptAnimale]['bas-de-vignette'] ?>">
                        </picture>
                        <div class="item__infos-espece">
                            <h3 class="infos-espece__nom-francais">
                                <?php
                                    echo $arrAnimaux[$cptAnimale]['nom_francais'];
                                    if(count(explode(" ", $arrAnimaux[$cptAnimale]['nom_francais'])) >= 5){ 
                                        echo " ...";
                                    }
                                ?>
                            </h3>
                            <p class="infos-espece__nom-scientifique">
                                <?= $arrAnimaux[$cptAnimale]['nom_scientifique'] ?>
                            </p>
                            <div class="infos-espece__section-pastilles">
                                <div class="section-pastilles__groupe pastille">
                                    <?= $arrAnimaux[$cptAnimale]['groupe'] ?>
                                </div>
                                <div class="section-pastilles__statut pastille
                            <?php
                            if ($arrAnimaux[$cptAnimale]['statut'] == "Menacée") {
                                echo "pastille-rouge";
                            } else if ($arrAnimaux[$cptAnimale]['statut'] == "Vulnérable") {
                                echo "pastille-jaune";
                            } else {
                                echo "pastille-verte";
                            }
                            ?>">
                                    <?= $arrAnimaux[$cptAnimale]['statut'] ?>
                                </div>
                            </div>
                            <div>
                                <a class="qc-button qc-secondary infos-espece__btn"
                                    href="fiche/index.php?id=<?php echo $arrAnimaux[$cptAnimale]['id'] ?>">Consulter la
                                    fiche</a>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </main>
</body>

</html>