<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Marjy I. Galingan">

    <title><?= $title?></title>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/darkly_bootstraps.css')?>">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/my_styles.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/side_navs.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/fontawesome.css')?>">
    <!-- JQUERY DEPENDENCIES -->
    <script src="<?= base_url('assets/dependencies/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/dependencies/bootstrap.js') ?>"></script>
    <!-- JQUERY -->
<?php   if(uri_string() == 'catalog'){
?>          <script src="<?= base_url('assets/jquery/catalogs.js') ?>"></script>
<?php   }
        if(uri_string() == 'orders'){
?>          <script src="<?= base_url('assets/jquery/orders.js') ?>"></script>
<?php   }
        if(uri_string() == 'products'){
?>          <script src="<?= base_url('assets/jquery/products.js') ?>"></script>
<?php   }
        if(uri_string() == 'profile'){
?>          <script src="<?= base_url('assets/jquery/profiles.js') ?>"></script>
<?php   }
        if(uri_string() == 'cart'){
?>          <script src="<?= base_url('assets/jquery/carts.js') ?>"></script>
<?php   }
        if(uri_string() != 'login' || uri_string() != 'registration'){ 
?>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
<?php   }
?>
    

    <!-- CONSTANTS -->
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
</head>
<body>