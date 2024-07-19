<?php
global $carspot_theme;
$style = '';
if (isset($carspot_theme['trans_bread_img']['url'])) {
    $bg_img = $carspot_theme['trans_bread_img']['url'];
    $style = 'style="background: url(' . $bg_img . '); background-repeat: no-repeat ; background-size: cover ;  background-position: center center ;  background-attachment: scroll; "';
}
?>
<section class="transparent-breadcrumb-listing" <?php echo carspot_returnEcho($style); ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="list-heading">
                    <?php
                    if (is_author()) {
                        
                    } else {
                        ?>
                        <h2><?php echo carspot_bread_crumb_heading(); ?></h2>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>