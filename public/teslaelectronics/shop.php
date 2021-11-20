<?php require_once("../../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>


<div class="container">


    <header>
        <h1>Shop</h1>
    </header>

    <hr>


    <div class="row g-3">

        <?php get_products_in_shop_page(); ?>

    </div>




</div>



<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>