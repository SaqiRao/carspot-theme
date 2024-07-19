<?php
global $carspot_theme;
if (isset($carspot_theme['search_page_layout']) && $carspot_theme['search_page_layout'] == 'search_layout_one'){
?>
<div class="col-md-3 col-sm-12 col-xs-12">
    <?php }
    ?>

    <div class="sidebar">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php
            if (is_active_sidebar('carspot_search_sidebar')) {
                dynamic_sidebar('carspot_search_sidebar');
            } ?>
        </div>
    </div>
    <?php
    if (isset($carspot_theme['search_page_layout']) && $carspot_theme['search_page_layout'] == 'search_layout_one'){
    ?>
</div>
<?php
}
