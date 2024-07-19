<?php
/* Template Name: Compariosn */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Carspot
 */
get_header();
global $carspot_theme; ?>
    <div class="main-content-area clearfix">
        <?php
        $id1 = isset($_GET["id1"]) ? $_GET["id1"] : '';
        $id2 = isset($_GET["id2"]) ? $_GET["id2"] : '';
        $top_padding = 'no-top';
        if (isset($carspot_theme['sb_header']) && $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2') {
            $top_padding = '';
        }
        ?>
        <section class="section-padding <?php echo carspot_returnEcho($top_padding); ?> compare-detial gray ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="table-responsives">
                            <table class="selection-list">
                                <tbody>
                                <tr>
                                    <td><?php echo esc_html__("Select Car's You Want To Compare", 'carspot') ?></td>
                                    <td>
                                        <div class="form-group">
                                            <select id="keyword1" class=" form-control make">
                                                <?php echo carspot_fetch_compariosn($id1); ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select id="keyword2" name="keyword2" class="form-control make">
                                                <?php echo carspot_fetch_compariosn($id2); ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">
                                        <button type="button" class="btn btn-block btn-theme"
                                                id="comparison_button"> <?php echo esc_html__("Compare", 'carspot') ?></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div id="populate_data"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php get_footer();