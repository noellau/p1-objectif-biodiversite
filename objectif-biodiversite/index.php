<?php
$niveau = "";
?>

<!DOCTYPE html>
<html lang="fr-ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objectif biodiversite accueil</title>

    <!-- Liens css -->
    <link rel="stylesheet" href="assets/sdg/dist/css/qc-sdg-design-tokens-rfz100.min.css">
    <link rel="stylesheet" href="assets/sdg/dist/css/qc-sdg-design-tokens.min.css">
    <link rel="stylesheet" href="assets/sdg/dist/css/qc-sdg-no-grid-rfz100.min.css">
    <link rel="stylesheet" href="assets/sdg/dist/css/qc-sdg-no-grid.min.css">
    <link rel="stylesheet" href="assets/sdg/dist/css/qc-sdg-rfz100.min.css">
    <link rel="stylesheet" href="assets/sdg/dist/css/qc-sdg.min.css">

    <!-- Liens js -->
    <script defer src="assets/sdg/dist/js/qc-sdg-no-grid.js"></script>
    <script defer src="assets/sdg/dist/js/qc-sdg.js"></script>
    <script defer src="assets/sdg/dist/js/qc-sdg.min.js"></script>
</head>

<body>
    <?php include($niveau . "inc/fragments/navigation.html") ?>
    <h1>Accueil</h1>
    <footer>
        <qc-piv-footer logo-src="assets/sdg/dist/img/QUEBEC_couleur.svg">
            <nav aria-label="Navigation du pied de page">
                <ul>
                    <li><a href="/">Accessibilité</a></li>
                    <li><a href="/">Politique de confidentialité</a></li>
                    <li><a href="/">Conditions d’utilisation</a></li>
                </ul>
            </nav>
            <img src="assets/sdg/dist/img/QUEBEC_couleur.svg" alt="Logo du gouvernement du Québec">
            <qc-external-link slot="copyright">
                <a target="_blank" rel="noopener" href="https://www.quebec.ca/droit-auteur">
                    © Gouvernement du Québec, 2023
                </a>
            </qc-external-link>
        </qc-piv-footer>
    </footer>
</body>

</html>