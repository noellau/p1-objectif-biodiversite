<?php
    $niveau = "../";

    include($niveau . "inc/config.inc.php");
?>

<!DOCTYPE html>
<html lang="fr-ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objectif biodiversite liste des especes</title>

    <!-- Liens css -->
    <link rel="stylesheet" href="<?php echo $niveau ?>/assets/sdg/dist/css/qc-sdg-design-tokens-rfz100.min.css">
    <link rel="stylesheet" href="<?php echo $niveau ?>/assets/sdg/dist/css/qc-sdg-design-tokens.min.css">
    <link rel="stylesheet" href="<?php echo $niveau ?>/assets/sdg/dist/css/qc-sdg-no-grid-rfz100.min.css">
    <link rel="stylesheet" href="<?php echo $niveau ?>/assets/sdg/dist/css/qc-sdg-no-grid.min.css">
    <link rel="stylesheet" href="<?php echo $niveau ?>/assets/sdg/dist/css/qc-sdg-rfz100.min.css">
    <link rel="stylesheet" href="<?php echo $niveau ?>/assets/sdg/dist/css/qc-sdg.min.css">

    <!-- Liens js -->
    <script defer src="<?php echo $niveau ?>/assets/sdg/dist/js/qc-sdg-no-grid.js"></script>
    <script defer src="<?php echo $niveau ?>/assets/sdg/dist/js/qc-sdg.js"></script>
    <script defer src="<?php echo $niveau ?>/assets/sdg/dist/js/qc-sdg.min.js"></script>
</head>
<body>
    <?php include($niveau . "inc/fragments/navigation.html") ?>

    <h1>Liste des especes</h1>
</body>

</html>