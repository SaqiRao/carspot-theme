<?php
/* ------------------------------------------------ */
/* Inspection  Ad  */
/* ------------------------------------------------ */
 
if (!function_exists('ad_inspect_short')) {

    function ad_inspect_short()
    {
        vc_map(array(
            "name" => esc_html__("Ad Inspection", 'carspot'),
            "base" => "ad_inspect_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Ad Post Form Type", 'carspot'),
                    "param_name" => "ad_inscpect_form_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Post Form', 'carspot') => '',
                        esc_html__('Default Form', 'carspot') => 'no',
                        esc_html__('Categories Based Form', 'carspot') => 'yes',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                    "description" => esc_html__("Select the ad post form type default or with dynamic categories based. Extra fields will only works with default form.", 'carspot'),
                ),
                carspot_generate_type(esc_html__('Extra Fields Section Title', 'carspot'), 'textfield', 'extra_section_title'),
                carspot_generate_type(esc_html__('Tip Section Title', 'carspot'), 'textfield', 'tip_section_title'),
                carspot_generate_type(esc_html__('Tips Description', 'carspot'), 'textarea', 'tips_description'),
                // Making add more loop for fields
                array
                (
                    'group' => esc_html__('Extra Fileds', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Add field', 'carspot'),
                    'param_name' => 'fields',
                    'value' => '',
                    'params' => array
                    (
                        carspot_generate_type(esc_html__('Title', 'carspot'), 'textfield', 'title'),
                        carspot_generate_type(esc_html__('Slug', 'carspot'), 'textfield', 'slug', esc_html__('This should be unique and if you change it the pervious data of this field will be lost', 'carspot')),
                        carspot_generate_type(esc_html__('Type', 'carspot'), 'dropdown', 'type', '', "", array(
                            "Please select" => "",
                            "Textfield" => "text",
                            "Select/List" => "select"
                        )),
                        carspot_generate_type(esc_html__('Values for Select/List', 'carspot'), 'textarea', 'option_values', esc_html__('Like: value1,value2,value3', 'carspot'), '', '', '', 'vc_col-sm-12 vc_column', array(
                            'element' => 'type',
                            'value' => 'select'
                        )),
                    )
                ),
                // Making add more loop for tips
                array
                (
                    'group' => esc_html__('Saftey Tips', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Add Tip', 'carspot'),
                    'param_name' => 'tips',
                    'value' => '',
                    'params' => array
                    (
                        carspot_generate_type(esc_html__('Tip', 'carspot'), 'textarea', 'description'),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ad_inspect_short');


if (!function_exists('ad_inspect_short_base_func')) {

    function ad_inspect_short_base_func($atts, $content = '')
    {
        global $carspot_theme;
          
return '<section class="section-padding  gray">
        <div class="container">
         <div class="row">
         <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
          <div class="postdetails">
          <form id="ad_inpection" name="ad_inpectiontt" >

          <div class="row">
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                 <label class="control-label">' . esc_html__('Your Name', 'carspot') . '</label>
                  <input class="form-control" type="text" id="inspection_title" name="inspection_title" value="" required>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                  <label class="control-label">' . esc_html__('Mobile Number', 'carspot') . '</label>
                    <input class="form-control" name="contact_number" value="" type="text" required>
                </div>
           </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                 <label class="control-label"> ' . esc_html__('Location', 'carspot') . '</label>
                  <select class="category form-control" id="location" name="location" >
                    '.carspot_framework_terms_options('ad_location' , $make ).'
                   
                 </select>
                
              </div>
           </div>
           <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                 <label class="control-label">' . esc_html__('Address', 'carspot') . '</label>
                   <input class="form-control" type="text" name="address" value="" required>
                </div>
           </div>
             <div class="row">
              <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                 <label class="control-label">' . esc_html__('Make/Model', 'carspot') . '</label>
                 <select class="category form-control" id="make" name="make" >
                    '.carspot_framework_terms_options('ad_make' , $make ).'
                   
                 </select>
               
              </div>
           </div>
            <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <label class="control-label">' . esc_html__('Time Slot', 'carspot') . '</label>
           <input type="datetime" class="form-control date_time" value="" id="ad_time" name="ad_time" placeholder="Select Date $ Time">
               </div>
           </div>
           
           <button class="btn btn-theme pull-right" id="inspection" class="inspection" type="submit">' . esc_html__('submitt', 'carspot') . '</button>
      </form>
     </div>
   </div>  
 </div>
</div>

</section>';

        
     }
  }

 if (function_exists('carspot_add_code')) {
      carspot_add_code('ad_inspect_short_base', 'ad_inspect_short_base_func');
  }    