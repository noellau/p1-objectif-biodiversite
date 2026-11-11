<?php
$niveau = "../";
$blnGroupesIsset = isset($_GET['groupes']);
$blnStatusIsset = isset($_GET['statuts']);

include($niveau . "inc/config.inc.php");

$strRequete = "SELECT * FROM groupes";
$pdosResultat = $pdoConnexion->query($strRequete);

$arrGroupe = array();
for ($cptEnr = 0; $ligne = $pdosResultat->fetch(); $cptEnr++) {
    $arrGroupe[$cptEnr]['id'] = $ligne['id'];
    $arrGroupe[$cptEnr]['nom_groupe'] = $ligne['nom_groupe'];
}

$strRequete = "SELECT DISTINCT statut_LEMV FROM especes";
$pdosResultat = $pdoConnexion->query($strRequete);

$arrStatuts = array();
for ($cptEnr = 0; $ligne = $pdosResultat->fetch(); $cptEnr++) {
    $arrStatuts[$cptEnr]['statut_LEMV'] = $ligne['statut_LEMV'];
}

$intPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($intPage < 1) {
    $intPage = 1;
}
$intParPage = 10;

$intDepart = ($intPage - 1) * $intParPage;
$strRequete = "SELECT COUNT(*) AS total FROM especes INNER JOIN groupes ON especes.groupe_id = groupes.id INNER JOIN images ON especes.id = images.espece_id WHERE images.nom_image LIKE 'IMG%' ORDER BY nom_francais";
$pdosResultat = $pdoConnexion->query($strRequete);
$ligne = $pdosResultat->fetch();
$intTotal = (int) $ligne['total'];
$intNbPages = ceil($intTotal / $intParPage);
$strRequete = "SELECT especes.id AS id, especes.nom_francais AS nom_francais, especes.nom_scientifique AS nom_scientifique, especes.statut_LEMV AS statut, groupes.nom_groupe AS groupe, images.nom_image, images.`bas-de-vignette` FROM especes INNER JOIN groupes ON especes.groupe_id = groupes.id INNER JOIN images ON especes.id = images.espece_id WHERE images.nom_image LIKE 'IMG%'";

if ($blnGroupesIsset || $blnStatusIsset) {
    $strRequete .= " AND ";

    if ($blnGroupesIsset) {
        $arrGroupesChoisis = $_GET['groupes'];
        $strListeGroupes = implode(', ', $arrGroupesChoisis);
        $strRequete .= "groupes.nom_groupe IN('$strListeGroupes')";

        if ($blnStatusIsset) {
            $strRequete .= " AND ";
        }
    }

    if ($blnStatusIsset) {
        $arrStatutsChoisis = $_GET['statuts'];
        $strListeStatus = implode(', ', $arrStatutsChoisis);
        $strRequete .= "especes.statut_LEMV IN('$strListeStatus')";
    }
}

$strRequete .= " ORDER BY nom_francais LIMIT $intParPage OFFSET $intDepart";
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
    if (count($arrNomFrancais) > 5) {
        array_splice($arrNomFrancais, 5, count($arrNomFrancais));
    }
    $arrAnimaux[$cptEnr]['nom_francais'] = implode(" ", $arrNomFrancais);
}
$pdosResultat->closecursor();
?>

<head>
    <title>Objectif biodiversité - liste des espèces</title>
</head>
<?php include($niveau . "inc/fragments/header.html") ?>
<main class="contenu-principal" id="main">
    <qc-to-top></qc-to-top>
    <h1 class="contenu-prinicipal__titre qc-container">Liste des espèces</h1>
    <form action="index.php" class="contenu-principal__filtres qc-container">
        <qc-choice-group legend="Filtrer par groupe" name="options-multiples">
            <?php for ($intCpt = 0; $intCpt < count($arrGroupe); $intCpt++) { ?>
                <label for="<?= $arrGroupe[$intCpt]['id'] ?>">
                    <input type="checkbox" value="<?= $arrGroupe[$intCpt]['nom_groupe'] ?>" name="groupes[]"
                        id="<?= $arrGroupe[$intCpt]['id'] ?>">
                    <span><?= $arrGroupe[$intCpt]['nom_groupe'] ?></span>
                </label>
            <?php } ?>
        </qc-choice-group>
        <qc-choice-group legend="Filtrer par statut" name="options-multiples">
            <?php for ($intCpt = 0; $intCpt < count($arrStatuts); $intCpt++) { ?>
                <label for="<?= $arrStatuts[$intCpt]['statut_LEMV'] ?>">
                    <input type="checkbox" value="<?= $arrStatuts[$intCpt]['statut_LEMV'] ?>" name="statuts[]"
                        id="<?= $arrStatuts[$intCpt]['statut_LEMV'] ?>">
                    <span><?= $arrStatuts[$intCpt]['statut_LEMV'] ?></span>
                </label>
            <?php } ?>
        </qc-choice-group>
        <input type="submit" name="filtrer" value="Filtrer" class="qc-button qc-primary">
    </form>
    <ul class="contenu-principal__liste-cartes liste-cartes qc-container">
        <?php for ($cptAnimale = 0; $cptAnimale < count($arrAnimaux); $cptAnimale++) { ?>
            <li class="liste-cartes__item">
                <div class="item__container">
                    <picture class="item__container-image">
                        <img class="container-image__image"
                            src="../assets/images/<?= $arrAnimaux[$cptAnimale]['nom_image'] ?>"
                            alt="<?= $arrAnimaux[$cptAnimale]['bas-de-vignette'] ?>">
                    </picture>
                    <div class="item__infos-espece">
                        <h3 class="infos-espece__nom-francais">
                            <?php
                            echo $arrAnimaux[$cptAnimale]['nom_francais'];
                            if (count(explode(" ", $arrAnimaux[$cptAnimale]['nom_francais'])) >= 5) {
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
            </li>
        <?php } ?>
    </ul>
    <nav class="contenu-principal__pagination pagination" aria-label="Pagination">
        <ul class="pagination__liste">
            <?php if ($intPage > 1) { ?>
                <li class="pagination__item">
                    <a class="pagination__lien" href="?page=<?php echo $intPage - 1; ?>"
                        aria-label="Page précédente">Précédent</a>
                </li>
            <?php } ?>
            <?php for ($i = 1; $i <= $intNbPages; $i++) { ?>
                <li class="pagination__item">
                    <a class="pagination__lien <?php if ($i == $intPage)
                        echo 'pagination__lien--actif'; ?>"
                        href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            <?php if ($intPage < $intNbPages) { ?>
                <li class="pagination__item">
                    <a class="pagination__lien" href="?page=<?php echo $intPage + 1; ?>"
                        aria-label="Page suivante">Suivant</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</main>
<?php include($niveau . "inc/fragments/footer.html") ?>
</body>

</html>