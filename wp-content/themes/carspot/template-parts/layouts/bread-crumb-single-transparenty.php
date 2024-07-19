<?php global $carspot_theme;
$style = ''; 
if (isset($carspot_theme['trans_bread_img']['url']))
{
	$bg_img = $carspot_theme['trans_bread_img']['url'];
	$style = 'style="background: url('.$bg_img.'); background-repeat: no-repeat ; background-size: cover ;  background-position: center center ;  background-attachment: scroll; "';
}
?>
<section class="transparent-breadcrumb-listing single-trans-bread" <?php echo carspot_returnEcho($style); ?>>
    <div class="container">
        <div class="row">
			<?php get_template_part( 'template-parts/layouts/ad_style/short-summary', 'title' ); ?>	
        </div>
    </div>
</section>

