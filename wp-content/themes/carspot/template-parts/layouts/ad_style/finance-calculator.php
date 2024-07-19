<?php global $carspot_theme; 
$pid	=	get_the_ID();
?>

<div class="finance-calculator">
  <form id="finance_form"  data-parsley-validate="">
    <div class="form-group">
      <label><?php echo esc_html__('Vehicle price ', 'carspot' ); 
      echo '('; echo esc_html($carspot_theme['sb_currency']);  ?>) </label>
      <input type="text" name="tot_price" id="tot_price"  class="form-control" value="<?php echo esc_attr(get_post_meta($pid, '_carspot_ad_price', true )); ?>" required="" data-parsley-error-message="<?php echo esc_attr__('Vehicle price is must', 'carspot' ); ?>">
    </div>
    <div class="form-group">
      <label><?php echo esc_html__('Interest rate (%)', 'carspot' ); ?></label>
      <input type="text" name="interest_rate" id="interest_rate"  class="form-control" value=""  required="" data-parsley-error-message="<?php echo esc_attr__('Please set interest rate', 'carspot' ); ?>">
    </div>
    <div class="form-group">
      <label><?php echo esc_html__('Period (month)', 'carspot' ); ?></label>
      <input type="text" name="periods" id="periods" class="form-control" value=""  required="" data-parsley-error-message="<?php echo esc_attr__('Provide return period in months', 'carspot' ); ?>">
    </div>
    <div class="form-group">
      <label><?php echo esc_html__('Down Payment ', 'carspot' ); echo '('; echo esc_html($carspot_theme['sb_currency']);  ?>) </label>
      <input type="text" name="down_payment" id="down_payment" class="form-control" value=""  required="" data-parsley-error-message="<?php echo esc_attr__('Provide down payment', 'carspot' ); ?>">
    </div>
    <div class="finance-form-result">
      <div><?php echo esc_html__('Monthly Installment: ', 'carspot' ); ?> <span id="monthly_pay"> </span></div>
      <div><?php echo esc_html__('Total Interest: ', 'carspot' ); ?> <span id="interest_pay"> </span></div>
      <div><?php echo esc_html__('Total Amount to Pay: ', 'carspot' ); ?> <span id="total_pay"> </span></div>
    </div>
    <div class="form-group">
      <button class="btn btn-theme btn-sm" type="submit"><?php echo esc_html__('Calculate', 'carspot' ); ?></button>
      <button class="btn btn-theme btn-sm" type="reset" id="rest-finace-form"><?php echo esc_html__('Clear', 'carspot' ); ?></button>
    </div>
  </form>
</div>
