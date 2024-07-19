<!doctype html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php global $carspot_theme; ?>
<?php
if ( isset( $carspot_theme['sb_pre_loader'] ) && $carspot_theme['sb_pre_loader'] ) {
	if ( isset( $carspot_theme['theme_loader_type'] ) && $carspot_theme['theme_loader_type'] == 'classic' ) {
		?>
        <!-- =-=-=-=-=-=-= Preloader =-=-=-=-=-=-= -->
        <div id="cssload-wrapper">
            <div class="cssload-loader">
                <div class="cssload-line"></div>
                <div class="cssload-line"></div>
                <div class="cssload-line"></div>
                <div class="cssload-line"></div>
                <div class="cssload-line"></div>
                <div class="cssload-line"></div>
                <div class="cssload-subline"></div>
                <div class="cssload-subline"></div>
                <div class="cssload-subline"></div>
                <div class="cssload-subline"></div>
                <div class="cssload-subline"></div>
                <div class="cssload-loader-circle-1">
                    <div class="cssload-loader-circle-2"></div>
                </div>
                <div class="cssload-needle"></div>
                <div class="cssload-loading"><?php echo esc_html__( 'Loading', 'carspot' ) ?></div>
            </div>
        </div>
		<?php
	} else {
		$style = '';
		if ( isset( $carspot_theme['theme_loader_type_modern']['url'] ) && $carspot_theme['theme_loader_type_modern']['url'] != "" ) {
			$url   = esc_url( $carspot_theme['theme_loader_type_modern']['url'] );
			$style = 'style="background: rgba(0, 0, 0, 0) url(' . $url . ') no-repeat scroll 0 0;"';
		}

		echo '<div class="preloader"><span class="preloader-gif" ' . $style . '></span></div>';
	}
}
?>
<?php
if ( ! is_page_template( 'page-profile.php' ) ) {
	if ( isset( $carspot_theme['sb_color_plate'] ) && $carspot_theme['sb_color_plate'] ) {
		?>
        <div class="color-switcher" id="choose_color">
            <a href="#" class="picker_close"><i class="fa fa-gear"></i></a>
            <h5><?php echo esc_html__( 'STYLE SWITCHER', 'carspot' ); ?></h5>
            <div class="theme-colours">
                <p> <?php echo esc_html__( 'Choose Colour style', 'carspot' ); ?> </p>
                <ul>
                    <li>
                        <a href="#." class="defualt" id="defualt"></a>
                    </li>
                    <li>
                        <a href="#." class="green" id="green"></a>
                    </li>
                    <li>
                        <a href="#." class="purple" id="purple"></a>
                    </li>
                    <li>
                        <a href="#." class="blue" id="blue"></a>
                    </li>
                    <li>
                        <a href="#." class="gold" id="gold"></a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}
}


if ( isset( $carspot_theme['sb_comming_soon_mode'] ) && $carspot_theme['sb_comming_soon_mode'] ) {
	if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
		get_template_part( 'template-parts/layouts/coming', 'soon' );
		exit;
	}
}
/* loader use for form etc  */
if ( isset( $carspot_theme['sb_pre_loader'] ) && $carspot_theme['sb_pre_loader'] ) {
if ( isset( $carspot_theme['theme_loader_type'] ) && $carspot_theme['theme_loader_type'] == 'classic' ) {

?>
<div class="loading" id="sb_loading"><?php esc_html__( 'Loading', 'carspot' ); ?>&#8230;</div>

<?php
} else {
	$style_1 = '';
	if ( isset( $carspot_theme['theme_loader_type_modern']['url'] ) && $carspot_theme['theme_loader_type_modern']['url'] != "" ) {
		$url1    = esc_url( $carspot_theme['theme_loader_type_modern']['url'] );
		$style_1 = 'style="background: rgba(0, 0, 0, 0) url(' . $url1 . ') no-repeat scroll 0 0; background-position: center center; background-color: transparent;"';
	}
	echo '<div class="loading" id="sb_loading" ' . $style_1 . '></div>';
}
}
else {
	echo '<div class="loading" id="sb_loading">' . esc_html__( 'Loading', 'carspot' ) . '&#8230;</div>';
}