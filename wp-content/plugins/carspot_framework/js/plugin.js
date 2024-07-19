(function ($) {
    "use strict";


    $('#ad_catsdiv').hide();
    $('#ad_tagsdiv').hide();
    $('#ad_conditiondiv').hide();
    $('#ad_typediv').hide();
    $('#ad_warrantydiv').hide();

    /* icheck callback */
    $('.skin-minimal .list li input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
        increaseArea: '20%'
    });

    /* select callback */
    $(".select-2").select2({
        allowClear: true,
        width: '100%'
    });

    /* get custom template when we use category base form */
    var is_category_based = $("#is_category_based").val();

    function getCustomTemplate_admin(ajax_url, catId, updateId, is_top) {
        /*For Category Templates*/
        $.post(carspot_ajax_url.ajax_url, {
            action: 'sb_get_sub_template_admin',
            'cat_id': catId,
            'is_update': updateId,
        }).done(function (response) {
            if ($.trim(response) != "") {
                $("#dynamic-fields_admin").html(response);
                $('.skin-minimal .list li input').iCheck({
                    checkboxClass: 'icheckbox_minimal',
                    radioClass: 'iradio_minimal',
                    increaseArea: '20%'
                });
                $('#dynamic-fields select').select2();
               if ($('#input_ad_post_form_type').val() == 1) {
                   sbDropzone_image();
               }

                carspot_inputTags();

                $(document).ready(function () {
                    //$('.dynamic-form-date-fields').datepicker({});
                    $('.dynamic-form-date-fields').datepicker({
                        timepicker: false,
                        dateFormat: 'yyyy-mm-dd',
                        language: {
                            days: [carspot_ajax_url.Sunday, carspot_ajax_url.Monday, carspot_ajax_url.Tuesday, carspot_ajax_url.Wednesday, carspot_ajax_url.Thursday, carspot_ajax_url.Friday, carspot_ajax_url.Saturday],
                            daysShort: [carspot_ajax_url.Sun, carspot_ajax_url.Mon, carspot_ajax_url.Tue, carspot_ajax_url.Wed, carspot_ajax_url.Thu, carspot_ajax_url.Fri, carspot_ajax_url.Sat],
                            daysMin: [carspot_ajax_url.Su, carspot_ajax_url.Mo, carspot_ajax_url.Tu, carspot_ajax_url.We, carspot_ajax_url.Th, carspot_ajax_url.Fr, carspot_ajax_url.Sa],
                            months: [carspot_ajax_url.January, carspot_ajax_url.February, carspot_ajax_url.March, carspot_ajax_url.April, carspot_ajax_url.May, carspot_ajax_url.June, carspot_ajax_url.July, carspot_ajax_url.August, carspot_ajax_url.September, carspot_ajax_url.October, carspot_ajax_url.November, carspot_ajax_url.December],
                            monthsShort: [carspot_ajax_url.Jan, carspot_ajax_url.Feb, carspot_ajax_url.Mar, carspot_ajax_url.Apr, carspot_ajax_url.May, carspot_ajax_url.Jun, carspot_ajax_url.Jul, carspot_ajax_url.Aug, carspot_ajax_url.Sep, carspot_ajax_url.Oct, carspot_ajax_url.Nov, carspot_ajax_url.Dec],
                            today: carspot_ajax_url.Today,
                            clear: carspot_ajax_url.Clear,
                            dateFormat: 'mm/dd/yyyy',
                            firstDay: 0
                        },
                    });
                });
            }
            $('#sb_loading').hide();
            if (is_category_based == 1) {
                if (is_top) {
                    $.post(carspot_ajax_url.ajax_url, {action: 'sb_get_car_total', }).done(function (cartTotal) {
                        $('#sb-quick-cart-price').html(cartTotal);
                    });
                }
            }

        });
        /*For Category Templates*/
    }


    /* ============END============== */

    /* Tags in admin side classified adds */
    function carspot_inputTags() {
        $('#tags').tagsInput({
            'width': '100%',
            'height': '5px;',
            'defaultText': '',
        });
    }


    /* Working on Make, Model, Version etc */
    $('#ad_cat_sub_div').hide();
    $('#ad_cat_sub_sub_div').hide();
    $('#ad_cat_sub_sub_sub_div').hide();
    if ($('#is_update').val() != "") {
        var level = $('#is_level').val();
        if (level >= 2) {
            $('#ad_cat_sub_div').show();
        }
        if (level >= 3) {
            $('#ad_cat_sub_sub_div').show();
        }
        if (level >= 4) {
            $('#ad_cat_sub_sub_sub_div').show();
        }

        var country_level = $('#country_level').val();
        if (country_level >= 2) {
            $('#ad_country_sub_div').show();
        }
        if (country_level >= 3) {
            $('#ad_country_sub_sub_div').show();
        }
        if (country_level >= 4) {
            $('#ad_country_sub_sub_sub_div').show();
        }

    }


    /* Level 1 Select Make */
    $('#ad_cat').on('change', function () {
        $('#sb_loading').show();
        $.post(carspot_ajax_url.ajax_url, {
            action: 'sb_get_sub_cat',
            cat_id: $("#ad_cat").val(),
        }).done(function (response) {
            $('#sb_loading').hide();
            $("#ad_cat_sub").val('');
            $("#ad_cat_sub_sub").val('');
            $("#ad_cat_sub_sub_sub").val('');
            if ($.trim(response) != "" && $.trim(response) != 0) {
                $('#ad_cat_id').val($("#ad_cat").val());
                $('#ad_cat_sub_div').show();
                $('#ad_cat_sub').html(response);
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_cat_sub_sub_sub_div').hide();
            } else {
                $('#ad_cat_sub_div').hide();
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_cat_sub_sub_sub_div').hide();

            }
            /*For Category Templates*/
            getCustomTemplate_admin(carspot_ajax_url.ajax_url, $("#ad_cat").val(), $("#is_update").val(), true);


            /*For Category Templates*/

        });
    });

    /* Level 2 Select Model */
    $('#ad_cat_sub').on('change', function () {
        $('#sb_loading').show();
        $.post(carspot_ajax_url.ajax_url, {
            action: 'sb_get_sub_cat',
            cat_id: $("#ad_cat_sub").val(),
        }).done(function (response) {
            $('#sb_loading').hide();
            $("#ad_cat_sub_sub").val('');
            $("#ad_cat_sub_sub_sub").val('');
            if ($.trim(response) != "" && $.trim(response) != 0) {
                $('#ad_cat_id').val($("#ad_cat_sub").val());
                $('#ad_cat_sub_sub_div').show();
                $('#ad_cat_sub_sub').html(response);
                $('#ad_cat_sub_sub_sub_div').hide();
            } else {
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_cat_sub_sub_sub_div').hide();
            }
            /*For Category Templates*/
            getCustomTemplate_admin(carspot_ajax_url.ajax_url, $("#ad_cat_sub").val(), $("#is_update").val(), false);
            /*For Category Templates*/
        });
    });

    /* Level 3 Select Version */
    $('#ad_cat_sub_sub').on('change', function () {
        $('#sb_loading').show();
        $.post(carspot_ajax_url.ajax_url, {
            action: 'sb_get_sub_cat',
            cat_id: $("#ad_cat_sub_sub").val(),
        }).done(function (response) {
            $('#sb_loading').hide();
            $("#ad_cat_sub_sub_sub").val('');
            if ($.trim(response) != "" && $.trim(response) != 0) {
                $('#ad_cat_id').val($("#ad_cat_sub_sub").val());
                $('#ad_cat_sub_sub_sub_div').show();
                $('#ad_cat_sub_sub_sub').html(response);
            } else {
                $('#ad_cat_sub_sub_sub_div').hide();
            }
            /*For Category Templates*/
            getCustomTemplate_admin(carspot_ajax_url.ajax_url, $("#ad_cat_sub_sub").val(), $("#is_update").val(), false);
            /*For Category Templates*/

        });
    });

    /* Level 4 */
    $('#ad_cat_sub_sub_sub').on('change', function () {
        $('#ad_cat_id').val($("#ad_cat_sub_sub_sub").val());
        /*For Category Templates*/
        getCustomTemplate_admin(carspot_ajax_url.ajax_url, $("#ad_cat_sub_sub_sub").val(), $("#is_update").val(), false);
        /*For Category Templates*/

    });

    /*============END=============*/
    /*Country Selection*/
    $('#ad_country_sub_div').hide();
    $('#ad_country_sub_sub_div').hide();
    $('#ad_country_sub_sub_sub_div').hide();
    $('#ad_country_sub_sub_sub_div').hide();
    if ($('#is_update').val() != "") {
        var country_level = $('#country_level').val();
        if (country_level >= 2) {
            $('#ad_country_sub_div').show();
        }
        if (country_level >= 3) {
            $('#ad_country_sub_sub_div').show();
        }
        if (country_level >= 4) {
            $('#ad_country_sub_sub_sub_div').show();
        }
    }
    /* Level 1 */
    $('#ad_country').on('change', function () {
        $('#sb_loading').show();
        $.post(carspot_ajax_url.ajax_url, {
            action: 'sb_get_sub_states',
            cat_id: $("#ad_country").val(),
        }).done(function (response) {
            $('#sb_loading').hide();
            $("#ad_country_states").val('');
            $("#ad_country_cities").val('');
            $("#ad_country_towns").val('');
            if ($.trim(response) != "") {
                $('#ad_country_id').val($("#ad_cat").val());
                $('#ad_country_sub_div').show();
                $('#ad_country_states').html(response);
                $('#ad_country_sub_sub_div').hide();
                $('#ad_country_sub_sub_sub_div').hide();
            } else {
                $('#ad_country_sub_div').hide();
                $('#ad_country_sub_sub_div').hide();
                $('#ad_country_sub_sub_sub_div').hide();

            }

        });
    });

    /* Level 2 */
    $('#ad_country_states').on('change', function () {
        $('#sb_loading').show();
        $.post(carspot_ajax_url.ajax_url, {
            action: 'sb_get_sub_states',
            cat_id: $("#ad_country_states").val(),
        }).done(function (response) {
            $('#sb_loading').hide();
            $("#ad_country_cities").val('');
            $("#ad_country_towns").val('');
            if ($.trim(response) != "" && $.trim(response) != 0) {
                $('#ad_country_id').val($("#ad_country_states").val());
                $('#ad_country_sub_sub_div').show();
                $('#ad_country_cities').html(response);
                $('#ad_country_sub_sub_sub_div').hide();
            } else {
                $('#ad_country_sub_sub_div').hide();
                $('#ad_country_sub_sub_sub_div').hide();
            }
        });
    });

    /* Level 3 */
    $('#ad_country_cities').on('change', function () {
        $('#sb_loading').show();
        $.post(carspot_ajax_url.ajax_url, {
            action: 'sb_get_sub_states',
            cat_id: $("#ad_country_cities").val(),
        }).done(function (response) {
            $('#sb_loading').hide();
            $("#ad_country_towns").val('');
            if ($.trim(response) != "" && $.trim(response) != 0) {
                $('#ad_country_id').val($("#ad_country_cities").val());
                $('#ad_country_sub_sub_sub_div').show();
                $('#ad_country_towns').html(response);
            } else {
                $('#ad_country_sub_sub_sub_div').hide();
            }
        });
    });
    /*==============END===============*/

    /*====== Price Type ======*/

    /*working when change the price type from dropdown*/
    var price = $('#hiden_pric').val();
    if (price == '') {
        $('#ad_pricees').hide();
    }
    $(document).on('change', '#ad_price_type', function () {

        if (this.value == "on_call" || this.value == "free" || this.value == "no_price" || this.value == "") {
            $('#ad_price').attr("data-parsley-required", "false")
            $('#ad_price').val('');
            $('#ad_pricees').hide();
        } else {
            $('#ad_price').attr("data-parsley-required", "true")
            $('#ad_pricees').show();
        }
    });
    /* ==============END================ */

    /* gallery images on admin side.  */
    var meta_gallery_frame;
    $('#carspot_ad_gallery_button').on('click', function (e) {
        // sonu code here.
        if (meta_gallery_frame) {
            meta_gallery_frame.open();
            return;
        }
        // Sets up the media library frame
        meta_gallery_frame = wp.media.frames.meta_gallery_frame = wp.media({
            title: carspot_ajax_url.ads_img_title,
            button: {text: carspot_ajax_url.ads_img_upload_btn},
            library: {type: 'image'},
            multiple: true
        });
        // Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
        meta_gallery_frame.states.add([
            new wp.media.controller.Library({
                priority: 20,
                toolbar: 'main-gallery',
                filterable: 'uploaded',
                library: wp.media.query(meta_gallery_frame.options.library),
                multiple: meta_gallery_frame.options.multiple ? 'reset' : false,
                editable: true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);
        var idsArray;
        var attachment;
        meta_gallery_frame.on('open', function () {
            var selection = meta_gallery_frame.state().get('selection');
            var library = meta_gallery_frame.state('gallery-edit').get('library');
            var ids = $('#carspot_photo_arrangement_').val();
            if (ids) {
                idsArray = ids.split(',');
                idsArray.forEach(function (id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
            }
        });
        meta_gallery_frame.on('ready', function () {
            $('.media-modal').addClass('no-sidebar');
        });
        var images;
        // When an image is selected, run a callback.
        //meta_gallery_frame.on('update', function() {          
        var count = 0;
        meta_gallery_frame.on('select', function () {
            var imageIDArray = [];
            var imageHTML = '';
            var metadataString = '';
            images = meta_gallery_frame.state().get('selection');
            imageHTML += '<ul class="carspot_gallery">';
            images.each(function (attachment) {
                // get image object
                console.debug(attachment.attributes);
                //push/add the ids in array
                imageIDArray.push(attachment.attributes.id);
                imageHTML += '<li><div class="carspot_gallery_container"><span class="carspot_delete_icon"><img id="' + attachment.attributes.id + '" src="' + attachment.attributes.url + '" style="max-width:100%;"></span></div></li>';
            });
            imageHTML += '</ul>';
            metadataString = imageIDArray.join(",");
            if (metadataString) {
                $("#carspot_photo_arrangement_").val(metadataString);
                $("#carspot_admin_gall_render").html(imageHTML);
            }
        });
        // Finally, open the modal
        meta_gallery_frame.open();
    });

    $(document.body).on('click', '.carspot_delete_icon', function (event) {
        event.preventDefault();
        if (confirm(carspot_ajax_url.ads_img_upload_btn)) {
            var removedImage = $(this).children('img').attr('id');
            var oldGallery = $("#carspot_photo_arrangement_").val();
            var newGallery = oldGallery.replace(',' + removedImage, '').replace(removedImage + ',', '').replace(removedImage, '');
            $(this).parents().eq(1).remove();
            $("#carspot_photo_arrangement_").val(newGallery);
        }
    });


    /*======= pdf brochure upload =======*/
    var meta_pdf_brochure_frame;
    $('#carspot_ad_pdf_brochure_button').on('click', function (e) {
        // sonu code here.
        if (meta_pdf_brochure_frame) {
            meta_pdf_brochure_frame.open();
            return;
        }
        var pdf_logo = $('#pdf_brochure_logo').val();
        // Sets up the media library frame
        meta_pdf_brochure_frame = wp.media.frames.meta_pdf_brochure_frame = wp.media({
            title: carspot_ajax_url.ad_pdf_brochure_title,
            button: {text: carspot_ajax_url.ad_pdf_brochure_upload_btn},
            library: {type: ''},
            multiple: true
        });
        // Create pdf upload state. This is essentially the pdf state, but selection behavior is altered.
        meta_pdf_brochure_frame.states.add([
            new wp.media.controller.Library({
                priority: 20,
                toolbar: 'main-gallery',
                filterable: 'uploaded',
                library: wp.media.query(meta_pdf_brochure_frame.options.library),
                multiple: meta_pdf_brochure_frame.options.multiple ? 'reset' : false,
                editable: true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);
        var idsArray;
        var attachment;
        meta_pdf_brochure_frame.on('open', function () {
            var selection = meta_pdf_brochure_frame.state().get('selection');
            var library = meta_pdf_brochure_frame.state('gallery-edit').get('library');
            var ids = $('#carspot_pdf_brochure_arrangement_').val();
            if (ids) {
                idsArray = ids.split(',');
                idsArray.forEach(function (id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
            }
        });
        meta_pdf_brochure_frame.on('ready', function () {
            $('.media-modal').addClass('no-sidebar');
        });
        var pdf_brochure;
        var count = 0;
        meta_pdf_brochure_frame.on('select', function () {
            var pdfIDArray = [];
            var pdfHTML = '';
            var pdf_logo = $('#pdf_brochure_logo').val();
            var metadataString = '';
            pdf_brochure = meta_pdf_brochure_frame.state().get('selection');
            pdfHTML += '<ul class="carspot_gallery">';
            pdf_brochure.each(function (attachment) {
                var attachment_name = attachment.attributes.filename;
                // get image object
                //console.debug(attachment.attributes);
                //push/add the ids in array
                pdfIDArray.push(attachment.attributes.id);
                pdfHTML += '<li><div class="carspot_gallery_container"><span class="carspot_delete_pdf_icon"><img id="' + attachment.attributes.id + '" src="' + '' + '" alt="'+ attachment_name +'" style="max-width:100%;"></span></div></li>';
            });
            pdfHTML += '</ul>';
            metadataString = pdfIDArray.join(",");
            if (metadataString) {
                $("#carspot_pdf_brochure_arrangement_").val(metadataString);
                $("#carspot_pdf_brochure_render").html(pdfHTML);
            }
        });
        // Finally, open the modal
        meta_pdf_brochure_frame.open();
    });

    $(document.body).on('click', '.carspot_delete_pdf_icon', function (event) {
        event.preventDefault();
        if (confirm(carspot_ajax_url.ad_pdf_brochure_delete_btn)) {
            var removedImage_pdf = $(this).children('img').attr('id');
            var oldBrochure = $("#carspot_pdf_brochure_arrangement_").val();
            var newBrochure = oldBrochure.replace(',' + removedImage_pdf, '').replace(removedImage_pdf + ',', '').replace(removedImage_pdf, '');
            $(this).parents().eq(1).remove();
            $("#carspot_pdf_brochure_arrangement_").val(newBrochure);
        }
    });

    /**
     * media upload in
     * term meta
     * review stamp logo
     */
    $("#show_review_logo").on("click", function () {
        let image = wp
                .media({
                    // Accepts [ 'select', 'post', 'image', 'audio', 'video' ]
                    // Determines what kind of library should be rendered.
                    frame: "select", //select
                    // Modal title.
                    title: "'Select Image'",
                    // Enable/disable multiple select
                    multiple: false,
                    // Library wordpress query arguments.
                    library: {
                        order: "DESC",
                        // [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo', 'id', 'post__in', 'menuOrder' ]
                        orderby: "date",
                        // mime type. e.g. 'image', 'image/jpeg'
                        type: "image",
                        // Searches the attachment title.
                        search: null,
                        // Includes media only uploaded to the specified post (ID)
                        uploadedTo: null, // wp.media.view.settings.post.id (for current post ID)
                    },

                    button: {
                        text: "Done",
                    },
                })
                .open()
                .on("select", function (e) {
                    let uploaded_image = image.state().get("selection");
                    let image_data = uploaded_image.first().toJSON();
                    $("<img />")
                            .attr("src", "" + image_data.url + "")
                            .width("150px")
                            .height("150px")
                            .appendTo($("#show_images"));
                    $("#review_logo_url").val(image_data.url);
                });
    });
    /*
     //  * Remove image event
     //  */
    $("#review_logo_remove").on("click", function () {
        $("#review_logo_url").val("");
        $("#show_images").remove();
    });

    /*======= single video upload =======*/
    /* single video upload on admin side.  */
    var meta_video_frame;
    $('#carspot_ad_video_button').on('click', function (e) {
        // sonu code here.
        if (meta_video_frame) {
            meta_video_frame.open();
            return;
        }
        // Sets up the media library frame
        meta_video_frame = wp.media.frames.meta_video_frame = wp.media({
            title: carspot_ajax_url.ad_video_title,
            button: {text: carspot_ajax_url.ad_video_upload_btn},
            library: {type: 'video'},
            multiple: true
        });
        // Create Video upload state. This is essentially the Video state, but selection behavior is altered.
        meta_video_frame.states.add([
            new wp.media.controller.Library({
                priority: 20,
                toolbar: 'main-gallery',
                filterable: 'uploaded',
                library: wp.media.query(meta_video_frame.options.library),
                multiple: meta_video_frame.options.multiple ? 'reset' : false,
                editable: true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);
        var idsArray;
        var attachment;
        meta_video_frame.on('open', function () {
            var selection = meta_video_frame.state().get('selection');
            var library = meta_video_frame.state('gallery-edit').get('library');
            var ids = $('#carspot_video_uploaded_attachment_').val();
            if (ids) {
                idsArray = ids.split(',');
                idsArray.forEach(function (id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
            }
        });
        meta_video_frame.on('ready', function () {
            $('.media-modal').addClass('no-sidebar');
        });
        var video;
        // When an image is selected, run a callback.
        //meta_video_frame.on('update', function() {
        var count = 0;
        meta_video_frame.on('select', function () {
            var imageIDArray = [];
            var imageHTML = '';
            var metadataString = '';
            var video_logo_ = $('#video_logo_').val();
            video = meta_video_frame.state().get('selection');
            imageHTML += '<ul class="carspot_gallery">';
            video.each(function (attachment) {
                var attach_vid_name = attachment.attributes.filename;
                // get image object
                //console.debug(attachment.attributes);
                //push/add the ids in array
                imageIDArray.push(attachment.attributes.id);
                imageHTML += '<li><div class="carspot_gallery_container"><span class="carspot_delete_vid_icon"><img id="' + attachment.attributes.id + '" src="' + '' + '" alt="'+ attach_vid_name +'"  style="width:100px; height:70px;"></span></div></li>';
            });
            imageHTML += '</ul>';
            metadataString = imageIDArray.join(",");
            if (metadataString) {
                $("#carspot_video_uploaded_attachment_").val(metadataString);
                $("#carspot_admin_video_render").html(imageHTML);
            }
        });
        // Finally, open the modal
        meta_video_frame.open();
    });

    $(document.body).on('click', '.carspot_delete_vid_icon', function (event) {
        event.preventDefault();
        if (confirm(carspot_ajax_url.ad_video_delete_btn)) {
            var removedImage_video = $(this).children('img').attr('id');
            var videoID = $("#carspot_video_uploaded_attachment_").val();
            var newVideo = videoID.replace(',' + removedImage_video, '').replace(removedImage_video + ',', '').replace(removedImage_video, '');
            $(this).parents().eq(1).remove();
            $("#carspot_video_uploaded_attachment_").val(newVideo);
        }


    });

})(jQuery);


