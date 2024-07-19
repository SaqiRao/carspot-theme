<?php
/* Template Name: Compare Ads */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package carspot
 */
global $carspot_theme;
get_header();
?>
    <style>
        .w-15 {
            width: 15% !important;
        }

        .w-20 {
            width: 20% !important;
        }

        .w-30 {
            width: 30% !important;
        }

        .w-35 {
            width: 35% !important;
        }

        .w-40 {
            width: 40% !important;
        }

        .w-60 {
            width: 60% !important;
        }

        .w-65 {
            width: 65% !important;
        }

        .w-80 {
            width: 80% !important;
        }

        .w-85 {
            width: 85% !important;
        }

        .w-90 {
            width: 90% !important;
        }

        .compare-table table th {
            font-weight: 400;
            font-size: 14px;
            text-transform: capitalize;
        }

        .compare-table .table-striped > tbody > tr:nth-of-type(2n+1) {
            background-color: #f8fafd;
        }

        .border-left {
            border-left: 1px solid #e7eaf3 !important;
        }

        .border-right {
            border-right: 1px solid #e7eaf3 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #e7eaf3 !important;
        }

        .compare-table .table > thead > tr > th, .compare-table .table > tbody > tr > th, .compare-table .table > thead > tr > td, .compare-table .table > tbody > tr > td {
            border: none;
            padding: 15px;
            font-family: "Poppins", sans-serif;
        }

        .compare-table .table > thead > tr > th, .compare-table .table > tbody > tr > th {
            color: #777;
            vertical-align: top;
            position: relative;
        }

        .compare-table .table > thead > tr > td, .compare-table .table > tbody > tr > td {
            font-size: 14px;
            font-weight: 400;
            color: #242424;
            vertical-align: top;
        }

        .compare-table th .text-secondary {
            padding-top: 20px;
            display: inline-block;
        }

        .compare-table th .text-secondary a {
            font-size: 20px;
            color: #242424;
            font-weight: 500;
        }

        .compare-table ul.ad_features li {
            line-height: 30px;
        }

        .compare-table ul.ad_features i {
            margin-right: 5px;
            color: green;
            padding: 5px;
            border-radius: 50%;
        }

        .compare-table .remove_compare_page {
            position: absolute;
            top: 0;
            right: 0;
            padding: 5px;
            border-radius: 50%;
            background-color: red;
            color: #FFF;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.5s linear;
        }

        .compare-table .remove_compare_page i {
            display: block;
        }

        .compare-table th .text-secondary.ad-title a {
            text-transform: uppercase;
            font-size: 14px;
            color: #777;
        }

        .compare-table .table thead tr th:hover .remove_compare_page {
            visibility: visible;
            opacity: 1;
        }

        .compare-table thead h3 {
            font-size: 30px;
            font-weight: 500;
            color: #242424;
            margin-bottom: 10px;
        }

        .null-value {
            color: #E52D27;
        }

        .compare-table ul.ad_features i.null-value {
            color: #E52D27;
            padding: 0;
        }


    </style>

<?php
$pid_1 = "";
$pid_2 = "";
$img_html_1 = '';
$img_html_2 = '';

/*COOKIE 1*/
if (isset($_COOKIE["cookie_1"]) != null) {
    $pid_1 = $_COOKIE["cookie_1"];
}
$media = carspot_fetch_listing_gallery($pid_1);

if (count((array)$media) > 0) {
    $counting = 1;
    foreach ($media as $m) {
        if ($counting > 1)
            break;

        $mid = '';
        if (isset($m->ID)) {
            $mid = $m->ID;
        } else {
            $mid = $m;
        }
        $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
        if (wp_attachment_is_image($mid)) {
            $img_html_1 = '<a href="' . get_the_permalink($pid_1) . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title($pid_1) . '" class="img-responsive"></a> ';
        } else {
            $img_html_1 = '<a class="sasas" href="' . get_the_permalink($pid_1) . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title($pid_1) . '" class="img-responsive"></a> ';
        }
        $counting++;
    }
}

/*COOKIE 2*/
if (isset($_COOKIE["cookie_2"]) != null) {
    $pid_2 = $_COOKIE["cookie_2"];
}

$media = carspot_fetch_listing_gallery($pid_2);

if (count((array)$media) > 0) {
    $counting = 1;
    foreach ($media as $m) {
        if ($counting > 1)
            break;
        $mid = '';
        if (isset($m->ID)) {
            $mid = $m->ID;
        } else {
            $mid = $m;
        }
        $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
        if (wp_attachment_is_image($mid)) {
            $img_html_2 = '<a href="' . get_the_permalink($pid_2) . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title($pid_2) . '" class="img-responsive"></a> ';
        } else {
            $img_html_2 = '<a href="' . get_the_permalink($pid_2) . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title($pid_2) . '" class="img-responsive"></a> ';
        }
        $counting++;
    }
}
?>

    <section class="section-padding">
        <!-- Main Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <!-- Middle Content Area -->
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    <div class="compare-table table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead class="">
                            <tr>
                                <th class="w-40">
                                    <?php
                                    if ($carspot_theme['compare_ad_front_title']) { ?>
                                        <h3>
                                            <?php
                                            echo esc_html($carspot_theme['compare_ad_front_title']);
                                            ?>
                                        </h3>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($carspot_theme['compare_ad_front_desc']) { ?>
                                        <p>
                                            <?php
                                            echo($carspot_theme['compare_ad_front_desc']);
                                            ?>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </th>
                                <th class="w-20  border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        echo($img_html_1);
                                        ?>
                                        <small class="text-secondary"> <a
                                                    href="<?php echo esc_url(get_the_permalink($pid_1)); ?>"> <?php echo esc_html(get_the_title($pid_1)); ?> </a></small>
                                        <p class="ad-price"><?php echo carspot_adPrice($pid_1); ?> </p>
                                        <a href="javascript:void(0)" class="remove_compare_page"
                                           data-post_id="<?php echo($pid_1); ?>"><i class="la la-close"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>"><img
                                                    src="<?php echo esc_url(get_template_directory_uri()); ?>/images/compare.png"
                                                    alt="<?php echo esc_attr(get_the_title($pid_1)); ?>"
                                                    class="img-responsive"></a>
                                        <small class="text-secondary ad-title"> <a
                                                    href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>"> <?php echo esc_html__('Add to compare', 'carspot'); ?> </a></small>
                                        <?php
                                    }
                                    ?>
                                </th>
                                <th class="w-20">
                                    <?php
                                    if ($pid_2 != null) {
                                        echo($img_html_2);
                                        ?>
                                        <small class="text-secondary"> <a
                                                    href="<?php echo esc_url(get_the_permalink($pid_2)); ?>"> <?php echo esc_html(get_the_title($pid_2)); ?> </a></small>
                                        <p class="ad-price"><?php echo carspot_adPrice($pid_2); ?></p>
                                        <a href="javascript:void(0)" class="remove_compare_page"
                                           data-post_id="<?php echo esc_attr($pid_2); ?>"><i
                                                    class="la la-close"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>"><img
                                                    src="<?php echo esc_url(get_template_directory_uri()); ?>/images/compare.png"
                                                    alt="<?php echo esc_attr(get_the_title($pid_2)); ?>"
                                                    class="img-responsive"></a>

                                        <small class="text-secondary ad-title"> <a
                                                    href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>"> <?php echo esc_html__('Add to compare', 'carspot'); ?> </a></small>
                                        <?php
                                    }
                                    ?>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="">
                                <th class=""><?php echo esc_html__('Body Type', 'carspot'); ?></th>
                                <td class="border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_body_types', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_body_types', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class="">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_body_types', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_body_types', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Mileage ', 'carspot'); ?></th>
                                <td class=" border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_mileage', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_mileage', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class="">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_mileage', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_mileage', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Warranty ', 'carspot'); ?></th>
                                <td class="text-secondary border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_warranty', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_warranty', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_warranty', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_warranty', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }

                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Model Year ', 'carspot'); ?></th>
                                <td class="text-secondary border-left border-right ">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_years', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_years', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_years', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_years', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class=""><?php echo esc_html__('Transmission', 'carspot'); ?></th>
                                <td class="border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_transmissions', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_transmissions', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class="">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_transmissions', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_transmissions', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Engine Size', 'carspot'); ?></th>
                                <td class="text-secondary border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_engine_capacities', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_engine_capacities', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_engine_capacities', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_engine_capacities', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Engine Type', 'carspot'); ?></th>
                                <td class=" border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_engine_types', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_engine_types', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_engine_types', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_engine_types', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Assembly', 'carspot'); ?></th>
                                <td class="text-secondary border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_assembles', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_assembles', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_assembles', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_assembles', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Fuel Economy in City', 'carspot'); ?></th>
                                <td class="text-secondary border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_avg_city', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_avg_city', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_avg_city', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_avg_city', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Fuel Economy on Highway', 'carspot'); ?></th>
                                <td class="text-secondary border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_avg_hwy', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_avg_hwy', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_avg_hwy', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_avg_hwy', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Color', 'carspot'); ?></th>
                                <td class="text-secondary border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        if (get_post_meta($pid_1, '_carspot_ad_colors', true) != null) {
                                            echo esc_html(get_post_meta($pid_1, '_carspot_ad_colors', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        if (get_post_meta($pid_2, '_carspot_ad_colors', true) != null) {
                                            echo esc_html(get_post_meta($pid_2, '_carspot_ad_colors', true));
                                        } else {
                                            echo '<i class="la la-close null-value"></i>';
                                        }
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Features', 'carspot'); ?></th>
                                <td class="text-secondary border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        ?>
                                        <ul class="ad_features">
                                            <?php
                                            $features = get_post_meta($pid_1, '_carspot_ad_features', true);
                                            $sep_features = explode("|", $features);

                                            foreach ($sep_features as $sep_feature) {
                                                ?>
                                                <li><i class="fa fa-check"></i> <?php echo esc_html($sep_feature); ?>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                        <?php
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td class=" ">
                                    <?php
                                    if ($pid_2 != null) {
                                        ?>
                                        <ul class="ad_features">
                                            <?php
                                            $features = get_post_meta($pid_2, '_carspot_ad_features', true);
                                            if ($features != null) {
                                                $sep_features = explode("|", $features);
                                                foreach ($sep_features as $sep_feature) {
                                                    ?>
                                                    <li>
                                                        <i class="fa fa-check"></i> <?php echo esc_html($sep_feature); ?>
                                                    </li>
                                                    <?php
                                                }
                                            } else {
                                                echo '<i class="la la-close null-value"></i>';
                                            }
                                            ?>
                                        </ul>
                                        <?php
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td class="border-left border-right">
                                    <?php
                                    if ($pid_1 != null) {
                                        ?>
                                        <a href="<?php echo esc_url(get_the_permalink($pid_1)); ?>"
                                           class="btn btn-theme btn-xs"> <?php echo esc_html__('View Details', 'carspot'); ?></a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td class="">
                                    <?php
                                    if ($pid_2 != null) {
                                        ?>
                                        <a href="<?php echo esc_url(get_the_permalink($pid_2)); ?>"
                                           class="btn btn-theme btn-xs"> <?php echo esc_html__('View Details', 'carspot'); ?></a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();