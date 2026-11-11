<?php
     $niveau = "";
    include($niveau . "inc/config.inc.php");
    $strRequete = "SELECT `especes`.id, `nom_francais`, `nom_scientifique`, `statut_LEMV`, `nom_groupe`, `nom_image`
    FROM `especes`
    JOIN `groupes` ON `especes`.groupe_id = `groupes`.id
    INNER JOIN images ON `especes`.id = `images`.espece_id
    WHERE `est_aire-repartition` = 0 AND (`statut_LEMV` = 'Vulnérable' OR `statut_LEMV` = 'Menacée') ORDER BY RAND() LIMIT 3";

    $objResultat = $pdoConnexion->query($strRequete);
    foreach ($objResultat as $objEspece) {
        $arrEspeces[] = $objEspece;
    }
    $strRequete = "SELECT `actualites`.id, `titre`, `auteur`, `date`, `texte` FROM `actualites` ORDER BY `date` DESC LIMIT 3";
    $objResultat = $pdoConnexion->query($strRequete);
    foreach ($objResultat as $objActualites) {
        $arrActualites[] = $objActualites;
    }
?>

        <?php include($niveau . "inc/fragments/header.html") ?>
        <main id="contenu" class="contenu qc-container" role="main">
            
        <h1 class="visuallyhidden">Accueil</h1>
        <section class="hero" aria-label="Introduction">
            <img class="hero__image" src="<?php echo $niveau ?>assets/images/IMG_Rorqual-commun_fredklus-melccfp.jpg" alt="Rorqual commun" />
            <div class="hero__texte">
            <p class="hero__slogan">Découvrir. Comprendre. Protéger.</p>
            <a href="<?php echo $niveau ?>especes/index.php" class="hero__lien">Consulter la liste des espèces</a>
            </div>
        </section>
        <section class="protection-statuts" aria-label="Statut de protection des espèces">
        <h2>Statuts de protection</h2>
        <div class="statuts">
            <div class="statuts__item">
                <h3 class="status__item-titre">Menacé</h3>
            <p>espèce, sous-espèce ou population dont la disparition est redoutée. <a href="<?php echo $niveau ?>especes/index.php">Voir les espèces menacées</a></p>
            </div>
            <div class="statuts__item">
                <h3 class="status__item-titre">Vulnérable</h3>
            <p>espèce, sous-espèce ou population dont la survie est jugée précaire. <a href="<?php echo $niveau ?>especes/index.php">Voir les espèces vulnérables</a></p>
            </div>
        </div>
        </section>
        <section class="actualites" aria-label="Actualités">
        <h2>Actualités</h2>
        <?php foreach ($arrActualites as $objActualites) { ?>
            <article class="actualite">
                <h3 class="actualite__titre"><?php echo htmlspecialchars($objActualites['titre']); ?></h3>
                <img class="actualite__image" src="<?php echo $niveau ?>assets/images/<?php echo htmlspecialchars($objActualites['id']);?>.jpeg" alt="<?php echo htmlspecialchars($objActualites['titre']); ?>" />
                <?php $dateSeparee = explode("-", $objActualites['date']);
                    $arrMois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
                ?>
                <time datetime="<?php echo htmlspecialchars($objActualites['date']); ?>" class="actualite__date"><?php 
                echo (int)$dateSeparee[2];
                echo " "; 
                echo $arrMois[$dateSeparee[1] - 1];
                echo " ";
                echo $dateSeparee[0]?>
                </time>
                <?php $texteSepare = explode(" ", strip_tags($objActualites['texte'])); ?>
                <p class="actualite__resume"><?php echo htmlspecialchars(implode(" ", array_slice($texteSepare, 0, 45))); ?>(...) <a href="#"> Lire l'article</a></p>
            </article>
        <?php } ?>
        </section>
        <section class="especes" aria-label="Espèces à découvrir">
        <h2>Espèces à découvrir</h2>
        <?php foreach ($arrEspeces as $objEspece) { ?>
            <article class="espece">
                <img class="espece__image" src="<?php echo $niveau; ?>assets/images/<?php echo htmlspecialchars($objEspece['nom_image']); ?>" alt="<?php echo htmlspecialchars($objEspece['nom_francais']); ?>" />
                <h3 class="espece__titre"><?php echo htmlspecialchars($objEspece['nom_francais']); ?></h3>
                <i class="espece__nom-scientifique"><?php echo htmlspecialchars($objEspece['nom_scientifique']); ?></i>
                <span class="espece__groupe"><?php echo htmlspecialchars($objEspece['nom_groupe']); ?></span>
                <span class="<?php if ($objEspece['statut_LEMV'] === 'Menacée') {
                     echo 'espece__statut-menace';
                      } else {
                         echo 'espece__statut-vulnerable'; 
                         } ?>">
                    <?php echo htmlspecialchars($objEspece['statut_LEMV']); ?>
                </span>
                <a href="<?php echo $niveau; ?>especes/fiche/index.php?id=<?php echo htmlspecialchars($objEspece['id']); ?>" class="espece__button-lien">Consulter la fiche</a>

            </article>
        <?php } ?>
        </section>
        <section class="mise-action" aria-label="Mise à l'action">
        <h2 class="mise-action__titre">Pourquoi protéger ces espèces?</h2>
        <img class="mise-action__image" src="assets/images/IMG_Carcajou_ZooSt-Felicien.jpg">
        <div class="mise-action__text-container">
        <p>Les espèces menacées et vulnérables sont des indicateurs précieux de la santé de nos écosystèmes. Leur déclin signale souvent des déséquilibres environnementaux plus larges qui nous affectent tous : qualité de l'eau, qualité de l'air, résilience des forêts et des milieux humides. En protégeant ces espèces, nous préservons les services écologiques essentiels dont dépend notre propre bien-être.</p>
        <ul>
            <li>Des écosystèmes en santé</li>
            <li>Une nature plus résiliente</li>
            <li>Un patrimoine naturel unique</li>
        </ul>
        <a class="hero__cta" href="<?php echo $niveau; ?>especes/index.php">Consulter la liste des espèces</a>
        </div>    
    </section>
</main>

<?php include($niveau . "inc/fragments/footer.html") ?>
<script src="<?php echo $niveau ?>assets/sdg/dist/js/qc-sdg.min.js"></script>

</body>

</html>