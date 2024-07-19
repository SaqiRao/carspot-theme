/*
 Template: Carspot | Largest Classifieds Portal
 Author: ScriptsBundle
 Version: 1.0
 Designed and Development by: ScriptsBundle
 */
(function ($) {
    "use strict";
    var carspot_ajax_url = $('#carspot_ajax_url').val();
    $(document).ready(function () {
        $('.iCheck-helper, ul.list li label').on('click', function () {
            $('#sb_loading').show();
            $(this).closest("form").submit();
        });
        $('#order_by').on('change', function () {
            $('#sb_loading').show();
            $(this).closest("form").submit();
        });
    });

    /*==========  Price Range Slider  ==========*/
    var min_price = $('#min_price').val();
    var max_price = $('#max_price').val();
    if ($('#min_price').length > 0)
    {
        $('#price-slider').noUiSlider({
            connect: true,
            behaviour: 'tap',
            start: [$('#min_selected').val(), $('#max_selected').val()],
            step: 0,
            range: {
                'min': parseInt(min_price),
                'max': parseInt(max_price)
            }
        });
        $('#price-slider').Link('lower').to($('#price-min'), null, wNumb({
            decimals: 0
        }));
        $('#price-slider').Link('lower').to($('#min_selected'), null, wNumb({
            decimals: 0
        }));
        $('#price-slider').Link('upper').to($('#price-max'), null, wNumb({
            decimals: 0
        }));
        $('#price-slider').Link('upper').to($('#max_selected'), null, wNumb({
            decimals: 0
        }));
    }
    //MAKE MODAL
    $('#make_id').on('change', function ()
    {
        $('#sb_loading').show();
        $('#select_modal').hide();
        $('#select_modals').hide();
        $('#select_forth_div').hide();
        var cat_s_id = $('#make_id').val();
        $('input[name=cat_id]').val(cat_s_id);
        $.post(carspot_ajax_url, {action: 'sb_get_sub_cat_search', cat_id: cat_s_id, }).done(function (response)
        {
            $('#sb_loading').hide();
            $('#select_modal').show();
            $('#select_modal').html(response);
            $(".search-select").select2({
                placeholder: $('#select_place_holder').val(),
                allowClear: false,
                theme: "classic",
                width: '100%',
            });
        });
    });

    $(document).on('change', '#cats_response', function ()
    {
        $('#sb_loading').show();
        $('#select_modals').hide();
        $('#select_forth_div').hide();
        var cat_s_id = $('#cats_response').val();
        $('input[name=cat_id]').val(cat_s_id);
        $.post(carspot_ajax_url, {action: 'sb_get_sub_sub_cat_search', cat_id: cat_s_id, }).done(function (response)
        {
            $('#sb_loading').hide();
            $('#select_modals').show();
            $('#select_modals').html(response);
            $(".search-select").select2({
                placeholder: $('#select_place_holder').val(),
                allowClear: false,
                theme: "classic",
                width: '100%',
            });
        });
    });

    $(document).on('change', '#select_version', function ()
    {
        $('#sb_loading').show();
        $('#select_forth_div').hide();
        var cat_s_id = $('#select_version').val();
        $('input[name=cat_id]').val(cat_s_id);
        $.post(carspot_ajax_url, {action: 'sb_get_sub_sub_sub_cat_search', cat_id: cat_s_id, }).done(function (response)
        {
            $('#sb_loading').hide();
            $('#select_forth_div').show();
            $('#select_forth_div').html(response);
            $(".search-select").select2({
                placeholder: $('#select_place_holder').val(),
                allowClear: false,
                theme: "classic",
                width: '100%',
            });
        });
    });

    $(document).on('change', '#select_forth', function ()
    {
        var cat_s_id = $('#select_forth').val();
        $('input[name=cat_id]').val(cat_s_id);
    });



    // Location
    $('.countries ul li a').on('click', function ()
    {
        $('#sb_loading').show();
        $('#countries_response').html('');
        var cat_s_id = $(this).attr('data-country-id');
        $('#country_id').val(cat_s_id);
        $.post(carspot_ajax_url, {action: 'sb_get_sub_states_search', country_id: cat_s_id, }).done(function (response)
        {
            $('#sb_loading').hide();
            if ($.trim(response) == 'submit')
            {
                $('#search_countries').submit();
            } else
            {
                $('#states_model').modal('show');
                $('#countries_response').html(response);
            }
        });
    });


    $(document).on('click', '#ajax_states', function ()
    {
        $('#sb_loading').show();
        var cat_s_id = $(this).attr('data-country-id');
        $('#country_id').val(cat_s_id);
        $.post(carspot_ajax_url, {action: 'sb_get_sub_states_search', country_id: cat_s_id, }).done(function (response)
        {
            $('#sb_loading').hide();
            if ($.trim(response) == 'submit')
            {
                $('#search_countries').submit();
            } else
            {
                $('#countries_response').html(response);
            }
        });
    });
    $(document).on('click', '#country-btn', function ()
    {
        $('#search_countries').submit();
    });




    $('.categories ul li a').on('click', function ()
    {
        $('#sb_loading').show();
        $('#cats_response').html('');
        var cat_s_id = $(this).attr('data-cat-id');
        $('#cat_id').val(cat_s_id);
        $.post(carspot_ajax_url, {action: 'sb_get_sub_cat_search', cat_id: cat_s_id, }).done(function (response)
        {
            $('#sb_loading').hide();
            if ($.trim(response) == 'submit')
            {
                $('#search_cats_w').submit();
            } else
            {
                $('#cat_modal').modal('show');
                $('#cats_response').html(response);
            }
        });
    });

    $(document).on('click', '#ajax_cat', function ()
    {
        $('#sb_loading').show();
        var cat_s_id = $(this).attr('data-cat-id');
        $('#cat_id').val(cat_s_id);
        $.post(carspot_ajax_url, {action: 'sb_get_sub_cat_search', cat_id: cat_s_id, }).done(function (response)
        {
            $('#sb_loading').hide();
            if ($.trim(response) == 'submit')
            {
                $('#search_cats_w').submit();
            } else
            {
                $('#cats_response').html(response);
            }
        });
    });
    $(document).on('click', '#ad-search-btn', function ()
    {
        $('#search_cats_w').submit();
    });




    /*AUTO SUBMIT FORM FOR RADIUS SEARCH*/

    $(function () {
        $('#radius_number').change(function () {
            this.form.submit();
        });
    });




    /*		//LOCATIONS IN DROPDOWN
     
     $('#ad_country').on('change', function()
     {
     $('#sb_loading').show();
     $('#ad_country_states').hide();
     $('#ad_country_cities').hide();
     $('#ad_country_towns').hide();
     var cat_s_id = $('#ad_country').val();
     var access_token = $('#access_token').val();
     //alert (cat_s_id);
     $('input[name=country_id]').val(cat_s_id);
     $.post(carspot_ajax_url,	{action : 'sb_get_sub_loc_search', cat_id:cat_s_id, }).done( function(response)
     {
     var data = $('#ad_country').select2('data')
     var loc_name = data[0].text;
     $.getJSON('https://api.mapbox.com/geocoding/v5/mapbox.places/'+loc_name+'.json?access_token='+access_token+'').done(function (location) {
     var latitude = location.features[0].center[1];
     var longitude = location.features[0].center[0];
     $('input[name=loc_long]').val(longitude);
     $('input[name=loc_lat]').val(latitude);
     });
     
     
     //console.log($json);
     
     $('#sb_loading').hide();
     $('#ad_country_states').show();
     $('#ad_country_states').html(response);
     $(".search-select").select2({
     placeholder: $('#select_place_holder').val(),
     allowClear: false,
     theme: "classic",
     width: '100%',
     });
     });
     });
     
     $(document).on('change', '#loc_first_response', function()
     {
     $('#sb_loading').show();
     $('#ad_country_cities').hide();
     $('#ad_country_towns').hide();
     var cat_s_id = $('#loc_first_response').val();
     var access_token = $('#access_token').val();
     $('input[name=country_id]').val(cat_s_id);
     $.post(carspot_ajax_url,	{action : 'sb_get_sub_sub_loc_search', cat_id:cat_s_id, }).done( function(response)
     {
     
     var data = $('#loc_first_response').select2('data')
     var loc_name = data[0].text;
     $.getJSON('https://api.mapbox.com/geocoding/v5/mapbox.places/'+loc_name+'.json?access_token='+access_token+'').done(function (location) {
     var latitude = location.features[0].center[1];
     var longitude = location.features[0].center[0];
     $('input[name=loc_long]').val(longitude);
     $('input[name=loc_lat]').val(latitude);
     });
     
     $('#sb_loading').hide();
     $('#ad_country_cities').show();
     $('#ad_country_cities').html(response);
     $(".search-select").select2({
     placeholder: $('#select_place_holder').val(),
     allowClear: false,
     theme: "classic",
     width: '100%',
     });
     });
     });
     
     $(document).on('change', '#loc_second_response', function()
     {
     $('#sb_loading').show();
     $('#ad_country_towns').hide();
     var cat_s_id = $('#loc_second_response').val();
     var access_token = $('#access_token').val();
     $('input[name=country_id]').val(cat_s_id);
     $.post(carspot_ajax_url,	{action : 'sb_get_sub_sub_sub_loc_search', cat_id:cat_s_id, }).done( function(response)
     {
     
     var data = $('#loc_second_response').select2('data')
     var loc_name = data[0].text;
     $.getJSON('https://api.mapbox.com/geocoding/v5/mapbox.places/'+loc_name+'.json?access_token='+access_token+'').done(function (location) {
     var latitude = location.features[0].center[1];
     var longitude = location.features[0].center[0];
     $('input[name=loc_long]').val(longitude);
     $('input[name=loc_lat]').val(latitude);
     });
     $('#sb_loading').hide();
     $('#ad_country_towns').show();
     $('#ad_country_towns').html(response);
     $(".search-select").select2({
     placeholder: $('#select_place_holder').val(),
     allowClear: false,
     theme: "classic",
     width: '100%',
     });
     });
     });
     
     $(document).on('change', '#loc_forth_response', function()
     {
     var cat_s_id = $('#loc_forth_response').val();
     var access_token = $('#access_token').val();
     $('input[name=cat_id]').val(cat_s_id);
     var data = $('#loc_forth_response').select2('data')
     var loc_name = data[0].text;
     $.getJSON('https://api.mapbox.com/geocoding/v5/mapbox.places/'+loc_name+'.json?access_token='+access_token+'').done(function (location) {
     var latitude = location.features[0].center[1];
     var longitude = location.features[0].center[0];
     $('input[name=loc_long]').val(longitude);
     $('input[name=loc_lat]').val(latitude);
     });
     });
     
     */







})(jQuery);

