<?php
$niveau = "../../";

include($niveau . "inc/config.inc.php");

if (isset($_GET['id']) == true) {
    $intIdAnimale = $_GET['id'];
} else {
    $intIdAnimale = 0;
}

$strRequete = "SELECT especes.id AS id, especes.nom_francais AS nom_francais, especes.nom_scientifique AS nom_scientifique, especes.`autres_noms_francais`, especes.description, especes.repartition, especes.habitat, especes.alimentation, especes.etat_situation, especes.alimentation, especes.reproduction, especes.menaces, especes.statut_LEMV AS statut, groupes.nom_groupe AS groupe, groupes.id AS groupeid, images.nom_image, images.`bas-de-vignette` FROM especes INNER JOIN groupes ON especes.groupe_id = groupes.id INNER JOIN images ON especes.id = images.espece_id WHERE images.nom_image LIKE 'IMG%' AND especes.id = $intIdAnimale";

$pdosResultat = $pdoConnexion->query($strRequete);

$arrAnimale = $pdosResultat->fetch();

$intIdGroupe = $arrAnimale["groupeid"];

$pdosResultat->closecursor();

$strRequete = "SELECT DISTINCT especes.id AS id, especes.nom_francais AS nom_francais, especes.nom_scientifique AS nom_scientifique, especes.statut_LEMV AS statut, groupes.nom_groupe AS groupe, images.nom_image, images.`bas-de-vignette` FROM especes INNER JOIN groupes ON especes.groupe_id = groupes.id INNER JOIN images ON especes.id = images.espece_id WHERE images.nom_image LIKE 'IMG%' AND groupes.id = $intIdGroupe AND especes.id != $intIdAnimale";

$pdosResultat = $pdoConnexion->prepare($strRequete);
$pdosResultat->execute();

$arrAnimauxSug = array();
$ligne = $pdosResultat->fetch();
for ($intCptEnr = 0; $intCptEnr < $pdosResultat->rowCount(); $intCptEnr++) {
    $arrAnimauxSug[$intCptEnr]['id'] = $ligne['id'];
    $arrAnimauxSug[$intCptEnr]['nom_francais'] = $ligne['nom_francais'];
    $arrAnimauxSug[$intCptEnr]['nom_scientifique'] = $ligne['nom_scientifique'];
    $arrAnimauxSug[$intCptEnr]['statut'] = $ligne['statut'];
    $arrAnimauxSug[$intCptEnr]['groupe'] = $ligne['groupe'];
    $arrAnimauxSug[$intCptEnr]['nom_image'] = $ligne['nom_image'];
    $arrAnimauxSug[$intCptEnr]['bas-de-vignette'] = $ligne['bas-de-vignette'];
    $ligne = $pdosResultat->fetch();
}
if (count($arrAnimauxSug) < 3) {
    $nbAnimauxSug = count($arrAnimauxSug);
} else {
    $nbAnimauxSug = 3;
}
$arrAnimauxChoisis = array();
for ($intCptPart = 0; $intCptPart < $nbAnimauxSug; $intCptPart++) {
    $intIndexHazard = rand(0, count($arrAnimauxSug) - 1);
    array_push($arrAnimauxChoisis, $arrAnimauxSug[$intIndexHazard]);
    array_splice($arrAnimauxSug, $intIndexHazard, 1);
}
$pdosResultat->closeCursor();
?>

<head>
    <title>Objectif biodiversité - <?= $arrAnimale['nom_francais'] ?></title>
</head>
<?php include($niveau . "inc/fragments/header.html") ?>
<main class="contenu-principal">
    <div class="contenu-principal__fiche">
        <h1 class="fiche__nom-francais qc-container" id="main"><?= $arrAnimale['nom_francais'] ?></h1>
        <div class="fiche__infos-rapides qc-container">
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
        <div class="contenu-principal__textes qc-container">
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
        <h2 class="especes__titre-secondaire qc-container">Espèces du même groupe</h2>
        <ul class="especes__liste-cartes liste-cartes qc-container">
            <?php for ($cptAnimale = 0; $cptAnimale < count($arrAnimauxChoisis); $cptAnimale++) { ?>
                <li class="liste-cartes__item">
                    <div class="item__container">
                        <picture class="item__container-image">
                            <img class="container-image__image"
                                src="<?= $niveau ?>assets/images/<?= $arrAnimauxChoisis[$cptAnimale]['nom_image'] ?>"
                                alt="<?= $arrAnimauxChoisis[$cptAnimale]['bas-de-vignette'] ?>">
                        </picture>
                        <div class="item__infos-espece">
                            <h3 class="infos-espece__nom-francais">
                                <?php
                                echo $arrAnimauxChoisis[$cptAnimale]['nom_francais'];
                                if (count(explode(" ", $arrAnimauxChoisis[$cptAnimale]['nom_francais'])) >= 5) {
                                    echo " ...";
                                }
                                ?>
                            </h3>
                            <p class="infos-espece__nom-scientifique">
                                <?= $arrAnimauxChoisis[$cptAnimale]['nom_scientifique'] ?>
                            </p>
                            <div class="infos-espece__section-pastilles">
                                <div class="section-pastilles__groupe pastille">
                                    <?= $arrAnimauxChoisis[$cptAnimale]['groupe'] ?>
                                </div>
                                <div class="section-pastilles__statut pastille
                            <?php
                            if ($arrAnimauxChoisis[$cptAnimale]['statut'] == "Menacée") {
                                echo "pastille-rouge";
                            } else if ($arrAnimauxChoisis[$cptAnimale]['statut'] == "Vulnérable") {
                                echo "pastille-jaune";
                            } else {
                                echo "pastille-verte";
                            }
                            ?>">
                                    <?= $arrAnimauxChoisis[$cptAnimale]['statut'] ?>
                                </div>
                            </div>
                            <div>
                                <a class="qc-button qc-secondary infos-espece__btn"
                                    href="fiche/index.php?id=<?php echo $arrAnimauxChoisis[$cptAnimale]['id'] ?>">Consulter la
                                    fiche</a>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</main>
<?php include($niveau . "inc/fragments/footer.html") ?>
</body>