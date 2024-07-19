<?php
global $carspot_theme;
$pid	=	get_the_ID();
function carspot_html_bidding_system($pid)
{
	global $carspot_theme;
	
	$dif_bid = get_post_meta($pid, 'ad_dif_bid_key', true);
	$min_bid = get_post_meta($pid, 'ad_min_bid_key', true);
	 /*  max Bidding Code starts     */
	$bids_res = carspot_get_all_biddings_array($pid);
	$total_bids = count((array)$bids_res);
	$max = 0;
	if ($total_bids > 0) {
			$max = max($bids_res);
	 
	}
	$thousands_sep = ",";
	if (isset($carspot_theme['sb_price_separator'])) {
			$thousands_sep = $carspot_theme['sb_price_separator'];
	}
	$decimals = 0;
	if (isset($carspot_theme['sb_price_decimals'])) {
			$decimals = $carspot_theme['sb_price_decimals'];
	}
	$decimals_separator = ".";
	if (isset($carspot_theme['sb_price_decimals_separator'])) {
			$decimals_separator = $carspot_theme['sb_price_decimals_separator'];
	}
	// Price format
	$max = number_format((int)$max, $decimals, $decimals_separator, $thousands_sep);
	$var = intval(preg_replace('/[^\d.]/', '', $max));
		 /*  max Bidding Code Ends    */
	if($var == ""){
		$last_ofer = ((int)$min_bid + (int)$dif_bid);
	}else{
	$last_ofer = ((int)$var + (int)$dif_bid);
	}
?>
	<div class="bidding">
		<?php echo carspot_bidding_html($pid); ?>
	</div>
	<div class="chat-form">
		<form id="sb_bid_ad">
			<?php
			$col	=	8;
			?>
			<div class="col-md-2 col-sm-12 col-xs-12 no-padding">
				<input name="bid_amount" value="<?php echo $last_ofer ; ?>" placeholder="<?php echo esc_html__('Bids', 'carspot'); ?>" class="form-control" type="text" data-parsley-required="true" data-parsley-type="integer" data-parsley-error-message="<?php echo esc_html__('Only integers.', 'carspot'); ?>" autocomplete="off" />
				<span>*Minimum Bids</span>
			</div>
			<div class="col-md-<?php echo esc_attr($col); ?> col-sm-12 col-xs-12 no-padding">
				<input name="bid_comment" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('This field is required.', 'carspot'); ?>" placeholder="<?php echo esc_html__('Comments...', 'carspot'); ?>" class="form-control" type="text" autocomplete="off">
				<small><em><?php echo esc_html($carspot_theme['sb_comments_section_note']); ?></em></small>
			</div>
			<div class="col-md-2 col-sm-12 col-xs-12 no-padding">
				<button class="btn btn-theme btn-block " type="submit"><?php echo esc_html__('Send', 'carspot'); ?></button>
				<input type="hidden" name="ad_id" value="<?php echo esc_attr($pid) ?>" />
				<input type="hidden" id="bidding_nonce" value="<?php echo wp_create_nonce('carspot_bidding_secure'); ?>" />
			</div>
		</form>
	</div>
<?php
}
?>
<?php

function carspot_get_bidding_active($class = 'bid')
{
	global $carspot_theme;
	$arr = array();
	if (isset($carspot_theme['sb_enable_comments_offer']) && $carspot_theme['sb_enable_comments_offer']) {

		$arr = array("bid" => "in active", "video" => "");
	} else {
		$arr = array("bid" => "", "video" => "in active");
	}

	return $arr["$class"];
}


function carspot_bid_li()
{
	$class = carspot_get_bidding_active('bid');
	global $carspot_theme;
	$bids_title = esc_html($carspot_theme['sb_comments_section_title']);
	if ($bids_title != "") {
		return '<li class="' . $class . '"><a href="#tab1default" data-toggle="tab">' . esc_html($carspot_theme['sb_comments_section_title']) . '</a></li>';
	}
}
?>
<?php
if (($carspot_theme['sb_enable_comments_offer'] == 1) || get_post_meta($pid, '_carspot_ad_yvideo', true)) {
?>
	<div class="list-style-1 margin-top-20">
		<div class="panel with-nav-tabs panel-default">
			<div class="panel-heading">
				<ul class="nav nav-tabs">
					<?php
					if (isset($carspot_theme['sb_enable_comments_offer']) && $carspot_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_carspot_ad_status_', true) != 'sold' && get_post_meta($pid, '_carspot_ad_status_', true) != 'expired' && get_post_meta($pid, '_carspot_ad_price', true) != "0") {
						if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_carspot_ad_bidding', true) == 1) {
							echo carspot_bid_li();
						} else if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_carspot_ad_bidding', true) == 0) {
						} else {

							echo carspot_bid_li();
						}
					}
					?>
					<?php if (get_post_meta($pid, '_carspot_ad_yvideo', true) != "") {
						$class = carspot_get_bidding_active('video');
					?>
						<li class="<?php echo esc_attr($class); ?>"><a href="#tab3default" data-toggle="tab"> <?php echo esc_html__('Ad Video', 'carspot'); ?></a></li>
					<?php
					}
					?>
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<?php $class = carspot_get_bidding_active('bid'); ?>
					<div class="tab-pane  <?php echo esc_attr($class); ?>  fade" id="tab1default">

						<?php
						if (isset($carspot_theme['sb_enable_comments_offer']) && $carspot_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_carspot_ad_status_', true) != 'sold' && get_post_meta($pid, '_carspot_ad_status_', true) != 'expired' && get_post_meta($pid, '_carspot_ad_price', true) != "0") {

							if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_carspot_ad_bidding', true) == 1) {
								echo carspot_html_bidding_system($pid);
							} else if (isset($carspot_theme['sb_enable_comments_offer_user']) && $carspot_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_carspot_ad_bidding', true) == 0) {
							} else {
								echo carspot_html_bidding_system($pid);
							}
						}
						?>
					</div>
					<?php if (get_post_meta($pid, '_carspot_ad_yvideo', true) != "") {
						$class = carspot_get_bidding_active('video');
						preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', esc_url(get_post_meta($pid, '_carspot_ad_yvideo', true)), $match);
						if (isset($match[1]) && $match[1] != "") {
							$video_id = $match[1];
					?>
							<div class="tab-pane fade <?php echo ($class); ?>" id="tab3default">
								<?php
								$iframe = 'iframe';
								echo '<' . $iframe . ' width="700" height="370" src="https://www.youtube.com/embed/' . esc_attr($video_id) . '" frameborder="0" allowfullscreen></' . $iframe . '>';
								?>
							</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>