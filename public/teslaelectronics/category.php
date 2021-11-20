<?php require_once("../../resources/config.php") ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<!-- Page Content -->
<div class="container">
    <div class="row">

        <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

            <?php

            get_products_in_cat_page();


            ?>




        </div>
        <!-- /.row -->

    </div>
</div>

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>