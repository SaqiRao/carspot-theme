/*
 Theme : Carspot | Car Dealership - Vehicle Marketplace And Car Services
 Author: ScriptsBundle
 Version: 1.0
 Designed and Development by: ScriptsBundle
 */
/*
 ====================================
 [ CSS TABLE CONTENT ]
 ------------------------------------
 1.0 -  Page Preloader
 2.0 -  Counter FunFacts
 3.0 -  List Grid Style Switcher
 4.0 -  Sticky Ads
 5.0 -  Accordion Panelsurl
 6.0 -  Accordion Style 2
 7.0 -  Jquery CheckBoxes
 8.0 -  Jquery Select Dropdowns
 9.0 -  Profile Image Upload
 10.0 - Masonry Grid System
 11.0 - Featured Carousel 1
 12.0 - Featured Carousel 2
 12.0 - Featured Carousel 3
 13.0 - Category Carousel
 14.0 - Background Image Rotator Carousel
 15.0 - Single Ad Slider Carousel
 16.0 - Single Page SLider With Thumb
 17.0 - Price Range Slider
 18.0 - Template MegaMenu
 19.0 - Back To Top
 20.0 - Tooltip
 21.0 - Quick Overview Modal
 -------------------------------------
 [ END JQUERY TABLE CONTENT ]
 =====================================
 */
(function ($) {
  "use strict";
  $("#ad_inpection").on("submit", function (e) {
    e.preventDefault();
    $.post(carspot_ajax_url, {
      type: "post",
      action: "sb_ad_inspection",
      data: $("#ad_inpection").serialize(),
      success: function () {
        toastr.success($("#inpection_posted").val(), "", {
          timeOut: 2500,
          closeButton: true,
          positionClass: "toast-top-right",
        });
        setTimeout(function () {
          location.reload();
        }, 100);
      },
    });
  });

  $(".add_compare").on({
    click: function () {
      //alert ($(this).attr('data-post_id'));
      var pid = $(this).attr("data-post_id");
      var first = Cookies.get("cookie_1");
      var second = Cookies.get("cookie_2");
      $("#sb_loading").show();
      setTimeout(function () {
        $("#sb_loading").hide();
      }, 500);
      if (first == null) {
        Cookies.set("cookie_1", pid, {
          expires: 7,
        });
        $(".add_compare").hide();
        $(".remove_compare").show();
        $(".compare-floating-btn").show();
        $(".compare-floating-btn .badge").hide();

        var first = Cookies.get("cookie_1");
        var second = Cookies.get("cookie_2");
        if (first == null || second == null) {
          $(".compare-floating-btn").append("<span class='badge'>1</span>");
        } else {
          $(".compare-floating-btn").append("<span class='badge'>2</span>");
        }

        toastr.success(get_strings.addToCompare, "", {
          timeOut: 3500,
          closeButton: true,
          positionClass: "toast-bottom-left",
        });
      } else if (second == null) {
        Cookies.set("cookie_2", pid, {
          expires: 7,
        });
        $(".add_compare").hide();
        $(".remove_compare").show();
        $(".compare-floating-btn").show();
        $(".compare-floating-btn .badge").hide();

        var first = Cookies.get("cookie_1");
        var second = Cookies.get("cookie_2");
        if (first == null || second == null) {
          $(".compare-floating-btn").append("<span class='badge'>1</span>");
        } else {
          $(".compare-floating-btn").append("<span class='badge'>2</span>");
        }
        //$(".compare-floating-btn").append("<span class='badge'>2</span>");
        toastr.success(get_strings.addToCompare, "", {
          timeOut: 3500,
          closeButton: true,
          positionClass: "toast-bottom-left",
        });
      } else {
        toastr.error(get_strings.alreadyToCompare, "", {
          timeOut: 3500,
          closeButton: true,
          positionClass: "toast-bottom-left",
        });
      }
    },
  });

  /* load first child category in new hero form */
  $(".categ_data").on("click", function () {
    //alert($(this).attr("data-categ_id"));
    let category_id = $(this).attr("data-categ_id");
    //let years_arr = $(this).attr("data-years_arr");
    if (category_id != "") {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "carspot_load_child_categories",
        categ_id: category_id,
        //years_arr: years_arr,
      }).done(function (response) {
        /**/

        /* */

        $("#sb_loading").hide();
        if ($.trim(response) != "") {
          $(".category_change").html(response);
        }
      });
    }
  });

  /* redirect to search On Country Change */
  // $("#topbar-country-select").on("change", function(){
  //     let country_id = $('#topbar-country-select').find(":selected").attr("value");
  //     $('#sb_loading').show();
  //     $.post(carspot_ajax_url, {
  //         action: 'carspot_redirect_to_country_search',
  //         country_id: country_id,
  //     }).done(function (response) {
  //         $('#sb_loading').hide();
  //         if ($.trim(response) != "") {
  //             window.location.replace(response);
  //         }
  //     });
  // });

  $(".remove_compare").on({
    click: function () {
      var first = Cookies.get("cookie_1");
      var second = Cookies.get("cookie_2");
      var pid = $(this).attr("data-post_id");
      $("#sb_loading").show();
      setTimeout(function () {
        $("#sb_loading").hide();
      }, 500);

      if (first == pid) {
        $(".remove_compare").hide();
        $(".add_compare").show();
        Cookies.remove("cookie_1");
        toastr.success(get_strings.removeToCompare, "", {
          timeOut: 3500,
          closeButton: true,
          positionClass: "toast-bottom-left",
        });
      } else if (second == pid) {
        $(".remove_compare").hide();
        $(".add_compare").show();
        Cookies.remove("cookie_2");
        toastr.success(get_strings.removeToCompare, "", {
          timeOut: 3500,
          closeButton: true,
          positionClass: "toast-bottom-left",
        });
      }

      /*COUNT REPLCE AFTER REMOVING*/
      var first = Cookies.get("cookie_1");
      var second = Cookies.get("cookie_2");
      if (first == null && second == null) {
        $(".badge").hide();
        $(".compare-floating-btn").append("<span class='badge'>0</span>");
      } else if (first == null || second == null) {
        $(".badge").hide();
        $(".compare-floating-btn").append("<span class='badge'>1</span>");
      }
    },
  });

  /*FOR COMPARE PAGE ONLY*/

  $(".remove_compare_page").on({
    click: function () {
      var first = Cookies.get("cookie_1");
      var second = Cookies.get("cookie_2");
      var pid = $(this).attr("data-post_id");
      $("#sb_loading").show();
      setTimeout(function () {
        $("#sb_loading").hide();
      }, 500);

      if (first == pid) {
        $(".remove_compare_page").hide();
        $(".add_compare").show();
        Cookies.remove("cookie_1");
        toastr.success(get_strings.removeToCompare, "", {
          timeOut: 3500,
          closeButton: true,
          positionClass: "toast-bottom-left",
        });
        setTimeout(function () {
          location.reload();
        }, 1000);
      } else if (second == pid) {
        $(".remove_compare_page").hide();
        $(".add_compare").show();
        Cookies.remove("cookie_2");
        toastr.success(get_strings.removeToCompare, "", {
          timeOut: 3500,
          closeButton: true,
          positionClass: "toast-bottom-left",
        });
        setTimeout(function () {
          location.reload();
        }, 1000);
      }
      /*COUNT REPLCE AFTER REMOVING*/
      var first = Cookies.get("cookie_1");
      var second = Cookies.get("cookie_2");
      if (first == null && second == null) {
        $(".badge").hide();
        $(".compare-floating-btn").append("<span class='badge'>0</span>");
      } else if (first == null || second == null) {
        $(".badge").hide();
        $(".compare-floating-btn").append("<span class='badge'>1</span>");
      }
    },
  });

  if ($(window).width() < 767) {
    $(".navbar-btn .btn-toggle-fullwidth i")
      .removeClass("la-arrow-circle-left")
      .addClass("la-bars");
  }

  var phonenumbers = [];
  $(".phonenumber").each(function (i) {
    phonenumbers.push($(this).text());
    var text_string = get_strings.showNumber;
    var hashes = "***** ";
    var newcontent =
      $(this)
        .text()
        .substr(0, $(this).text().length - 5) +
      hashes +
      text_string;
    $(this).text(newcontent);
    $(this).bind("click", function () {
      if ($(this).text() == phonenumbers[i]) {
        //$(this).text(phonenumbers[i].substr(0, phonenumbers[i].length - 4));
      } else {
        $(".phonenumber").each(function (x) {
          if ($(this).text() == phonenumbers[x]) {
            $(this).text(phonenumbers[x].substr(0, phonenumbers[x].length - 5));
          }
        });
        $(this).text(phonenumbers[i]);
      }
    });
  });

  /*RADIO IN REVIW FORM*/
  $(".review-form input.icheck").iCheck({
    checkboxClass: "icheckbox_minimal",
    radioClass: "iradio_minimal",
    increaseArea: "20%", // optional
  });

  /*PROTIP TOOL TIP*/
  $.protip();

  $(".btn-toggle-fullwidth").on("click", function () {
    if (!$("body").hasClass("layout-fullwidth")) {
      $("body").addClass("layout-fullwidth");
    } else {
      $("body").removeClass("layout-fullwidth");
      $("body").removeClass("layout-default"); // also remove default behaviour if set
    }

    $(this)
      .find(".la")
      .toggleClass("la-arrow-circle-left  la-arrow-circle-right");

    if ($(window).innerWidth() < 1025) {
      if (!$("body").hasClass("offcanvas-active")) {
        $("body").addClass("offcanvas-active");
      } else {
        $("body").removeClass("offcanvas-active");
      }
    }
  });

  $(window).on("load", function () {
    if ($(window).innerWidth() < 1025) {
      $(".btn-toggle-fullwidth")
        .find(".icon-arrows")
        .removeClass("icon-arrows-move-left")
        .addClass("icon-arrows-move-right");
    }

    // adjust right sidebar top position
    $(".right-sidebar").css("top", $(".navbar").innerHeight());

    // if page has content-menu, set top padding of main-content
    if ($(".has-content-menu").length > 0) {
      $(".navbar + .main-content").css(
        "padding-top",
        $(".navbar").innerHeight()
      );
    }

    // for shorter main content
    if ($(".main").height() < $("#sidebar-nav").height()) {
      $(".main").css("min-height", $("#sidebar-nav").height());
    }
  });

  /*-----------------------------------/
     /*	SIDEBAR NAVIGATION
     /*----------------------------------*/

  $('.sidebar a[data-toggle="collapse"]').on("click", function () {
    if ($(this).hasClass("collapsed")) {
      $(this).addClass("active");
    } else {
      $(this).removeClass("active");
    }
  });

  if ($(".sidebar-scroll").length > 0) {
    $(".sidebar-scroll").slimScroll({
      height: "95%",
      wheelStep: 2,
    });
  }

  /*Full Screen*/
  $(document).on("click", "#full-screen", function toggleFullScreen() {
    if (
      (document.fullScreenElement !== undefined &&
        document.fullScreenElement === null) ||
      (document.msFullscreenElement !== undefined &&
        document.msFullscreenElement === null) ||
      (document.mozFullScreen !== undefined && !document.mozFullScreen) ||
      (document.webkitIsFullScreen !== undefined &&
        !document.webkitIsFullScreen)
    ) {
      if (document.documentElement.requestFullScreen) {
        document.documentElement.requestFullScreen();
      } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
      } else if (document.documentElement.webkitRequestFullScreen) {
        document.documentElement.webkitRequestFullScreen(
          Element.ALLOW_KEYBOARD_INPUT
        );
      } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen();
      }
    } else {
      if (document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }
  });

  /*SCROLL TO SPASIFIC BLOCK*/
  $(function () {
    $('a[href*="#"].scroller:not([href="#"])').click(function () {
      var target = $(this.hash);
      target = target.length ? target : $("[name=" + this.hash.substr(1) + "]");
      if (target.length) {
        $("html,body").animate(
          {
            scrollTop: target.offset().top,
          },
          1000
        );
        return false;
      }
    });
  });

  $(".date-pop").datepicker({
    timepicker: true,
    minDate: 0,
    dateFormat: "yyyy-mm-dd",
    language: {
      days: [
        get_strings.Sunday,
        get_strings.Monday,
        get_strings.Tuesday,
        get_strings.Wednesday,
        get_strings.Thursday,
        get_strings.Friday,
        get_strings.Saturday,
      ],
      daysShort: [
        get_strings.Sun,
        get_strings.Mon,
        get_strings.Tue,
        get_strings.Wed,
        get_strings.Thu,
        get_strings.Fri,
        get_strings.Sat,
      ],
      daysMin: [
        get_strings.Su,
        get_strings.Mo,
        get_strings.Tu,
        get_strings.We,
        get_strings.Th,
        get_strings.Fr,
        get_strings.Sa,
      ],
      months: [
        get_strings.January,
        get_strings.February,
        get_strings.March,
        get_strings.April,
        get_strings.May,
        get_strings.June,
        get_strings.July,
        get_strings.August,
        get_strings.September,
        get_strings.October,
        get_strings.November,
        get_strings.December,
      ],
      monthsShort: [
        get_strings.Jan,
        get_strings.Feb,
        get_strings.Mar,
        get_strings.Apr,
        get_strings.May,
        get_strings.Jun,
        get_strings.Jul,
        get_strings.Aug,
        get_strings.Sep,
        get_strings.Oct,
        get_strings.Nov,
        get_strings.Dec,
      ],
      today: get_strings.Today,
      clear: get_strings.Clear,
      dateFormat: "dd/mm/yyyy",
      firstDay: 0,
    },
  });

  if ($("#test_drive_pop-form").length > 0) {
    $("#test_drive_pop-form")
      .parsley()
      .on("field:validated", function () {})
      .on("form:submit", function () {
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "test_drive",
          test_drive_data: $("form#test_drive_pop-form").serialize(),
          security: $("#make_offer_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            var get_r = response.split("|");
            if ($.trim(get_r[0]) == "1") {
              toastr.success(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              $("#test_drive_pop-form")[0].reset();
              $("#test-drive-modal").modal("hide");
            } else {
              toastr.error(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });
  }

  /*MAKE AND OFFER*/

  if ($("#make_offer_pop_form").length > 0) {
    $("#make_offer_pop_form")
      .parsley()
      .on("field:validated", function () {})
      .on("form:submit", function () {
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "make_offer",
          make_offer_data: $("form#make_offer_pop_form").serialize(),
          security: $("#make_offer_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            var get_r = response.split("|");
            if ($.trim(get_r[0]) == "1") {
              toastr.success(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              $("#make_offer_pop_form")[0].reset();
              $("#make-offer-modal").modal("hide");
            } else {
              toastr.error(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });
  }

  /*CAR FINANCING JS*/

  if ($("#finance_form").length > 0) {
    $("#finance_form")
      .parsley()
      .on("field:validated", function () {
        var ok = $(".parsley-error").length === 0;
      })
      .on("form:submit", function () {
        var vehicle_price;
        var interest_rate;
        var down_payment;
        var period_month;

        var CurrentCurrency = $("#current_currency").val();
        var stmPriceDel = " ";
        var stmCurrencyPos = "left";

        vehicle_price = parseFloat(document.getElementById("tot_price").value);
        interest_rate = parseFloat(
          document.getElementById("interest_rate").value
        );
        interest_rate = interest_rate / 1200;

        period_month = parseFloat(document.getElementById("periods").value);
        down_payment = parseFloat(
          document.getElementById("down_payment").value
        );

        var monthly_payment = 0;
        var total_interest_payment = 0;
        var total_amount_to_pay = 0;

        var validation_errors = false;
        if (!validation_errors) {
          var interest_rate_unused = interest_rate;

          if (interest_rate == 0) {
            interest_rate_unused = 1;
          }
          monthly_payment =
            (vehicle_price - down_payment) *
            interest_rate_unused *
            Math.pow(1 + interest_rate, period_month);
          var monthly_payment_div =
            Math.pow(1 + interest_rate, period_month) - 1;
          if (monthly_payment_div == 0) {
            monthly_payment_div = 1;
          }

          monthly_payment = monthly_payment / monthly_payment_div;
          monthly_payment = monthly_payment.toFixed(2);

          total_amount_to_pay = down_payment + monthly_payment * period_month;
          total_amount_to_pay = total_amount_to_pay.toFixed(2);

          total_interest_payment = total_amount_to_pay - vehicle_price;
          total_interest_payment = total_interest_payment.toFixed(2);

          $(".finance-form-result").show();
          document.getElementById("monthly_pay").innerHTML =
            CurrentCurrency + " " + monthly_payment;
          document.getElementById("interest_pay").innerHTML =
            CurrentCurrency + " " + total_interest_payment;
          document.getElementById("total_pay").innerHTML =
            CurrentCurrency + " " + total_amount_to_pay;
        } else {
          /*Something went wrong...*/
        }

        return false;
      });

    $("#rest-finace-form").click(function () {
      /* Single line Reset function executes on click of Reset Button */
      $("#finance_form")[0].reset();
      $(".finance-form-result").hide();
    });
  }

  $(window).on("load", function () {
    $("#ask_for_user_type").modal({
      backdrop: "static",
      keyboard: false,
    });
  });

  if ($("#save_user_type_old_users").length > 0) {
    $("#save_user_type_old_users")
      .parsley()
      .on("field:validated", function () {})
      .on("form:submit", function () {
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "save_user_type_old_users",
          dealer_contact_data: $("form#save_user_type_old_users").serialize(),
          security: $("#user_type_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            var get_r = response.split("|");
            if ($.trim(get_r[0]) == "1") {
              toastr.success(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              window.location = $("#previous_url").val();
              //   window.location = $("#profile_page").val();
            } else {
              toastr.error(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });
  }

  /*DEALER CONTACT FORM*/
  if ($("#dealer-contact-form").length > 0) {
    $("#dealer-contact-form")
      .parsley()
      .on("field:validated", function () {})
      .on("form:submit", function () {
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "dealer_contact",
          dealer_contact_data: $("form#dealer-contact-form").serialize(),
          security: $("#user_contact_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            var get_r = response.split("|");
            if ($.trim(get_r[0]) == "1") {
              toastr.success(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              $("#dealer-contact-form")[0].reset();
              $("#dealer-contact-form").modal("hide");
            } else {
              toastr.error(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });
  }

  /* on click active tab */
  $(".review_active").click(function () {
    $('.nav-tabs a[href="#Section2"]').tab("show");
    $("html, body").animate(
      {
        scrollTop: $("#reviews").offset().top,
      },
      1000
    );
  });

  /* ===== 29-1-2021 ===== */
  // $('[data-toggle="confirmation"]').confirmation();
  $('[data-toggle="confirmation"]').confirmation({
    rootSelector: "[data-toggle=confirmation]",
    // other options
  });
  $(".btn-confirm").on("click", function () {
    $("#sb_loading").show();
    $.post(carspot_ajax_url, {
      action: "carspot_make_featured",
      ad_id: $(this).attr("data-id"),
    }).done(function (response) {
      $("#sb_loading").hide();
      var get_r = response.split("|");
      if ($.trim(get_r[0]) == "1") {
        $("[data-toggle=confirmation]").confirmation({
          rootSelector: "[data-toggle=confirmation]",
          // other options
        });
        toastr.success(get_r[1], "", {
          timeOut: 2500,
          closeButton: true,
          positionClass: "toast-top-right",
        });
        location.reload();
      } else {
        toastr.error(get_r[1], "", {
          timeOut: 2500,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      }
    });
  });
  /* ============ */

  // $('[data-toggle="confirmation"]').confirmation();
  // $('.btn-confirm').on('click', function () {
  //     $('#sb_loading').show();
  //     $.post(carspot_ajax_url, {
  //         action: 'carspot_make_featured',
  //         ad_id: $(this).attr('data-id'),
  //     }).done(function (response) {
  //         $('#sb_loading').hide();
  //         var get_r = response.split('|');
  //         if ($.trim(get_r[0]) == '1') {
  //             $('[data-toggle=confirmation]').confirmation({
  //                 rootSelector: '[data-toggle=confirmation]',
  //                 // other options
  //             });
  //             toastr.success(get_r[1], '', {
  //                 timeOut: 2500,
  //                 "closeButton": true,
  //                 "positionClass": "toast-top-right"
  //             });
  //             location.reload();
  //         } else {
  //             toastr.error(get_r[1], '', {
  //                 timeOut: 2500,
  //                 "closeButton": true,
  //                 "positionClass": "toast-top-right"
  //             });
  //         }
  //     });
  // });

  // Add to Cart
  $("body").on("click", ".added_to_cart", function () {
    $("#sb_loading").show();
    $.post(carspot_ajax_url, {
      action: "carspot_package_add_cart",
      product_id: $(this).attr("data-product-id"),
      qty: $(this).attr("data-product-qty"),
    }).done(function (response) {
      $("#sb_loading").hide();
      var get_r = response.split("|");
      if ($.trim(get_r[0]) == "1") {
        toastr.success(get_r[1], "", {
          timeOut: 2500,
          closeButton: true,
          positionClass: "toast-top-right",
        });
        window.location = get_r[2];
      } else {
        toastr.error(get_r[1], "", {
          timeOut: 2500,
          closeButton: true,
          positionClass: "toast-top-right",
        });
        window.location = get_r[2];
      }
    });
  });

  /*Lisitng Images Sorting*/
  $("#sortable").sortable({
    stop: function (event, ui) {
      $("#ad_imgz_ids").val("");
      var current_img = "";
      $(".ui-state-default img").each(function (index) {
        current_img = current_img + $(this).attr("data-img-id") + ",";
      });
      $("#ad_imgz_ids").val(current_img.replace(/,\s*$/, ""));
    },
  });
  /*Lisitng Images Sorting*/
  $("#listing_sort_images").on("click", function () {
    $("#sb_loading").show();

    $.post(carspot_ajax_url, {
      action: "carspot_sort_listing_images",
      ids: $("#ad_imgz_ids").val(),
      ad_id: $("#current_ad_id").val(),
      security: $("#sort_images_nonce").val(),
    })
      .done(function (response) {
        $("#sb_loading").hide();
        $(".sortable-images").modal("hide");
        location.reload();
      })
      .fail(function () {
        $("#sb_loading").hide();
        toastr.error($("#nonce_error").val(), "", {
          timeOut: 4000,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      });
  });

  $("#parent_make").on("change", function () {
    $("#sb_loading").show();
    var cat_s_id = $("#parent_make").val();
    $("input[name=cat_id]").val(cat_s_id);
    $.post(carspot_ajax_url, {
      action: "select_parent_make",
      cat_id: cat_s_id,
    }).done(function (response) {
      $("#sb_loading").hide();
      $("#make_select").html(response);
    });
  });

  $("#make_select").on("change", function () {
    var cat_s_id = $("#make_select").val();
    $("input[name=cat_id]").val(cat_s_id);
  });

  /*Video Popup*/
  var get_active_val = $("#is_video_active").val();
  if (get_active_val != "" && get_active_val == 1) {
    $("a.play-video").YouTubePopUp();
  }
  //Car Comparison
  $("#comparison_button").on("click", function () {
    var id1 = $("#keyword1").val();
    var id2 = $("#keyword2").val();
    if (id1 && id2) {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "comparison_data_fetch",
        keyword1: id1,
        keyword2: id2,
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#populate_data").html(response);
        $("#first_accor").first().addClass("open");
        $("#first_accor .accordion-content")
          .first()
          .css("display", "block")
          .slideDown(400);
      });
    } else {
      var msg = "Select Cars You Want To Compare";
      toastr.error(msg, "", {
        timeOut: 2500,
        closeButton: true,
        positionClass: "toast-top-right",
      });
      return false;
    }
  });

  $("#submit_loader").on("click", function () {
    $("#sb_loading").show();
    $(this).closest("form").submit();
  });
  $("#submit_loader2").on("click", function () {
    $("#sb_loading").show();
    $(this).closest("form").submit();
  });

  var ajax_url = $("input#carspot_ajax_url").val();
  var searchType = $("select#autocomplete-select")
    .find("option:selected")
    .val();
  var extraParams = {
    action: "carspot_data_fetch_live",
    searchType: searchType,
  };

  $("#autocomplete-dynamic").autocomplete({
    serviceUrl: ajax_url,
    id: "test",
    type: "POST",
    params: {
      action: "data_fetch",
      searh_type: function () {
        return $("select#autocomplete-select").find("option:selected").val();
      },
    },
    autoSelectFirst: true,
    clear: true,
    onSearchStart: function () {
      $("#autocomplete-dynamic").addClass("banner-icon-loader");
    },
    onSearchComplete: function () {
      $("#autocomplete-dynamic").removeClass("banner-icon-loader");
    },
    onSelect: function (suggestion) {},
  });

  var carspot_ajax_url = $("#carspot_ajax_url").val();

  var ua = navigator.userAgent.toLowerCase();
  if (
    ua.indexOf("safari/") !== -1 && // It says it's Safari
    ua.indexOf("windows") !== -1 && // It says it's on Windows
    ua.indexOf("chrom") === -1 // It DOESN'T say it's Chrome/Chromium
  ) {
    $(".sb-top-bar_notification").show();
  }

  /* ======= Preloader ======= */
  $(window).load(function () {
    $("#cssload-wrapper").fadeOut("slow", function () {
      $(this).remove();
    });
    $(".preloader").delay(2000).fadeOut(1000);
  });
  $(".fancybox").fancybox();
  if ($(".wow").length) {
    var wow = new WOW({
      boxClass: "wow",
      animateClass: "animated",
      offset: 0,
      mobile: false,
      live: true,
    });
    wow.init();
  }

  /* ======= Counter FunFacts ======= */
  var timer = $(".timer");
  if (timer.length) {
    timer.appear(function () {
      timer.countTo();
    });
  }

  /* ======= Progress bars ======= */
  $(".progress-bar > span").each(function () {
    var $this = $(this);
    var width = $(this).data("percent");
    $this.css({
      transition: "width 3s",
    });
    setTimeout(function () {
      $this.appear(function () {
        $this.css("width", width + "%");
      });
    }, 500);
  });

  /* ======= Accordion Panels ======= */
  $(".accordion li").first().addClass("open");
  $(".accordion li .accordion-content")
    .first()
    .css("display", "block")
    .slideDown(400);
  $(document).on("click", ".accordion-title a", function (event) {
    event.preventDefault();
    if ($(this).parents("li").hasClass("open")) {
      $(this)
        .parents("li")
        .removeClass("open")
        .find(".accordion-content")
        .slideUp(400);
    } else {
      $(this)
        .parents(".accordion")
        .find(".accordion-content")
        .not($(this).parents("li").find(".accordion-content"))
        .slideUp(400);
      $(this)
        .parents(".accordion")
        .find("> li")
        .not($(this).parents("li"))
        .removeClass("open");
      $(this)
        .parents("li")
        .addClass("open")
        .find(".accordion-content")
        .slideDown(400);
    }
  });

  /* ======= Accordion Style 2 ======= */
  $("#accordion").on("shown.bs.collapse", function () {
    var offset = $(".panel.panel-default > .panel-collapse.in").offset();
    if (offset) {
      $("html,body").animate(
        {
          scrollTop: $(".panel-title a").offset().top - 20,
        },
        500
      );
    }
  });

  /* ======= Jquery CheckBoxes ======= */
  $(".skin-minimal .list li input").iCheck({
    checkboxClass: "icheckbox_minimal",
    radioClass: "iradio_minimal",
    increaseArea: "20%", // optional
  });
  var get_sticky = $("#is_sticky_header").val();
  var is_sticky = false;
  if (get_sticky != "" && get_sticky == "1") {
    var is_sticky = true;
  }
  $(document).scroll(function () {
    if (
      $(this).scrollTop() >= 100 &&
      $("#header_style").val() == "transparent2" &&
      is_sticky
    ) {
      $("#sb_site_logo").attr("src", $("#sticky_sb_logo_url").val());
    }
    if (
      $(this).scrollTop() <= 100 &&
      $("#header_style").val() == "transparent2" &&
      is_sticky
    ) {
      $("#sb_site_logo").attr("src", $("#static_sb_logo_url").val());
    }

    if (
      $(this).scrollTop() >= 100 &&
      $("#header_style").val() == "transparent" &&
      is_sticky
    ) {
      $("#sb_site_logo").attr("src", $("#sticky_sb_logo_url").val());
    }
    if (
      $(this).scrollTop() <= 100 &&
      $("#header_style").val() == "transparent" &&
      is_sticky
    ) {
      $("#sb_site_logo").attr("src", $("#static_sb_logo_url").val());
    }
  });

  if ($("#is_rtl").val() != "" && $("#is_rtl").val() == "1") {
    /* ======= Jquery Select Dropdowns ======= */
    $("select").select2({
      dir: "rtl",
      placeholder: $("#select_place_holder").val(),
      allowClear: true,
      width: "100%",
    });

    $(".sb_variation").select2({
      dir: "rtl",
      placeholder: $("#select_place_holder").val(),
      allowClear: false,
      theme: "classic",
      width: "100%",
    });

    $(".search-select").select2({
      dir: "rtl",
      placeholder: $("#select_place_holder").val(),
      allowClear: false,
      theme: "classic",
      width: "100%",
    });

    $(".product-thumb").owlCarousel({
      rtl: true,
      dots: $(".product-thumb .item").length > 1 ? false : false,
      loop: $(".product-thumb .item").length > 1 ? true : false,
      autoWidth: true,
      nav: true,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 4,
        },
      },
    });

    $(".featured-slider-shop").owlCarousel({
      rtl: true,
      items: 4,
      dots: $(".featured-slider-shop .item").length > 1 ? false : false,
      loop: $(".featured-slider-shop .item").length > 1 ? true : false,
      nav: true,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 4,
        },
      },
    });

    $(".owl-testimonial-2").owlCarousel({
      rtl: true,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      responsiveClass: true,
      dots: $(".owl-testimonial-2 .item").length > 1 ? false : false,
      loop: $(".owl-testimonial-2 .item").length > 1 ? true : false,
      items: 3,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 3,
        },
      },
      stopOnHover: true,
    });

    $(".owl-testimonial-1").owlCarousel({
      rtl: true,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      dots: $(".owl-testimonial-2 .item").length > 1 ? false : false,
      loop: $(".owl-testimonial-2 .item").length > 1 ? true : false,
      responsiveClass: true,
      items: 2,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
      },
      stopOnHover: true,
    });

    $(".featured-slider").owlCarousel({
      items: 3,
      rtl: true,
      dots: $(".featured-slider .item").length > 1 ? false : false,
      loop: $(".featured-slider .item").length > 1 ? true : false,
      nav: true,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 3,
        },
      },
    });

    $(".clients-list").owlCarousel({
      rtl: true,
      dots: $(".clients-list .item").length > 1 ? false : false,
      loop: $(".clients-list .item").length > 1 ? true : false,
      nav: false,
      items: 5,
      autoplay: true,
      autoplayTimeout: 2000,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 2,
        },
        600: {
          items: 4,
        },
        1000: {
          items: 5,
        },
      },
    });

    /* ======= Featured Carousel 2 ======= */
    $(".featured-slider-1").owlCarousel({
      rtl: true,
      dots: $(".featured-slider-1 .item").length > 1 ? false : false,
      loop: $(".featured-slider-1 .item").length > 1 ? true : false,
      margin: -10,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
          nav: true,
        },
        600: {
          items: 2,
          nav: true,
        },
        1000: {
          items: 3,
          nav: true,
          loop: false,
        },
      },
    });

    /* ======= Featured  Carousel 3 ======= */
    $(".featured-slider-3").owlCarousel({
      rtl: true,
      dots: $(".featured-slider-3 .item").length > 1 ? false : false,
      loop: $(".featured-slider-3 .item").length > 1 ? true : false,
      margin: 0,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
          nav: true,
        },
        600: {
          items: 1,
          nav: true,
        },
        1000: {
          items: 1,
          nav: true,
          loop: false,
        },
      },
    });

    /* ======= Category Carousel ======= */
    $(".category-slider").owlCarousel({
      loop: true,
      rtl: true,
      dots: false,
      margin: 0,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
          nav: true,
        },
        600: {
          items: 2,
          nav: true,
        },
        1000: {
          items: 4,
          nav: true,
          loop: false,
        },
      },
    });

    /* ======= Background Image Rotator Carousel ======= */
    $(".background-rotator-slider").owlCarousel({
      loop: false,
      rtl: true,
      dots: false,
      margin: 0,
      autoplay: true,
      mouseDrag: true,
      touchDrag: true,
      autoplayTimeout: 5000,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      nav: false,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        1000: {
          items: 1,
        },
      },
    });

    /* ======= إعلان واحد Slider Carousel  ======= */
    $(".single-details").owlCarousel({
      dots: $(".single-details .item").length > 1 ? false : false,
      loop: $(".single-details .item").length > 1 ? true : false,
      rtl: true,
      margin: 0,
      autoplay: false,
      mouseDrag: true,
      touchDrag: true,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      nav: true,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        1000: {
          items: 1,
        },
      },
    });

    /*==========  Single Page SLider With Thumb ==========*/
    $("#carousel").flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      itemWidth: 160,
      itemMargin: 5,
      asNavFor: "#single-slider",
      rtl: true,
    });

    $("#single-slider").flexslider({
      rtl: true,
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      sync: "#carousel",
    });

    $(".posts-masonry").imagesLoaded(function () {
      $(".posts-masonry").isotope({
        layoutMode: "masonry",
        transitionDuration: "0.3s",
        isOriginLeft: false,
      });
    });
    /*SINGLE PAGE STYLE TWO MAIN SLIDER*/
    $(".listing-page-slider").owlCarousel({
      loop: true,
      animateOut: "fadeOut",
      animateIn: "fadeIn",
      nav: true,
      dots: false,
      margin: 0,
      center: true,
      rtl: true,
      smartSpeed: 1000,
      navText: [
        "<i class='la la-angle-left'></i>",
        "<i class='la la-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
      },
    });

    $("#menu-1").megaMenu({
      // DESKTOP MODE SETTINGS
      logo_align: "left", // align the logo left or right. options (left) or (right)
      links_align: "left", // align the links left or right. options (left) or (right)
      socialBar_align: "right", // align the socialBar left or right. options (left) or (right)
      searchBar_align: "left", // align the search bar left or right. options (left) or (right)
      trigger: "hover", // show drop down using click or hover. options (hover) or (click)
      effect: "expand-top", // drop down effects. options (fade), (scale), (expand-top), (expand-bottom), (expand-left), (expand-right)
      effect_speed: 400, // drop down show speed in milliseconds
      sibling: true, // hide the others showing drop downs if this option true. this option works on if the trigger option is "click". options (true) or (false)
      outside_click_close: true, // hide the showing drop downs when user click outside the menu. this option works if the trigger option is "click". options (true) or (false)
      top_fixed: false, // fixed the menu top of the screen. options (true) or (false)
      sticky_header: false, // menu fixed on top when scroll down down. options (true) or (false)
      sticky_header_height: 200, // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
      menu_position: "horizontal", // change the menu position. options (horizontal), (vertical-left) or (vertical-right)
      full_width: false, // make menu full width. options (true) or (false)
      // MOBILE MODE SETTINGS
      mobile_settings: {
        collapse: true, // collapse the menu on click. options (true) or (false)
        sibling: true, // hide the others showing drop downs when click on current drop down. options (true) or (false)
        scrollBar: true, // enable the scroll bar. options (true) or (false)
        scrollBar_height: 400, // scroll bar height in px value. this option works if the scrollBar option true.
        top_fixed: false, // fixed menu top of the screen. options (true) or (false)
        sticky_header: false, // menu fixed on top when scroll down down. options (true) or (false)
        sticky_header_height: 200, // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
      },
    });
  } else {
    /* ======= Template MegaMenu  ======= */
    $("#menu-1").megaMenu({
      // DESKTOP MODE SETTINGS
      logo_align: "left", // align the logo left or right. options (left) or (right)
      links_align: "left", // align the links left or right. options (left) or (right)
      socialBar_align: "left", // align the socialBar left or right. options (left) or (right)
      searchBar_align: "right", // align the search bar left or right. options (left) or (right)
      trigger: "hover", // show drop down using click or hover. options (hover) or (click)
      effect: "expand-top", // drop down effects. options (fade), (scale), (expand-top), (expand-bottom), (expand-left), (expand-right)
      effect_speed: 400, // drop down show speed in milliseconds
      sibling: true, // hide the others showing drop downs if this option true. this option works on if the trigger option is "click". options (true) or (false)
      outside_click_close: true, // hide the showing drop downs when user click outside the menu. this option works if the trigger option is "click". options (true) or (false)
      top_fixed: false, // fixed the menu top of the screen. options (true) or (false)
      sticky_header: false, // menu fixed on top when scroll down down. options (true) or (false)
      sticky_header_height: 200, // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
      menu_position: "horizontal", // change the menu position. options (horizontal), (vertical-left) or (vertical-right)
      full_width: false, // make menu full width. options (true) or (false)
      // MOBILE MODE SETTINGS
      mobile_settings: {
        collapse: true, // collapse the menu on click. options (true) or (false)
        sibling: true, // hide the others showing drop downs when click on current drop down. options (true) or (false)
        scrollBar: true, // enable the scroll bar. options (true) or (false)
        scrollBar_height: 400, // scroll bar height in px value. this option works if the scrollBar option true.
        top_fixed: false, // fixed menu top of the screen. options (true) or (false)
        sticky_header: false, // menu fixed on top when scroll down down. options (true) or (false)
        sticky_header_height: 200, // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
      },
    });

    /* ======= Jquery Select Dropdowns ======= */

    $("select").select2({
      placeholder: $("#select_place_holder").val(),
      allowClear: true,
      width: "100%",
    });

    $(".sb_variation").select2({
      placeholder: $("#select_place_holder").val(),
      allowClear: false,
      theme: "classic",
      width: "100%",
    });

    $(".search-select").select2({
      placeholder: $("#select_place_holder").val(),
      allowClear: false,
      theme: "classic",
      width: "100%",
    });

    /* ======= Featured Carousel 1 ======= */

    $(".featured-slider").owlCarousel({
      items: 3,
      dots: $(".featured-slider .item").length > 1 ? false : false,
      loop: $(".featured-slider .item").length > 1 ? true : false,
      nav: true,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 3,
        },
      },
    });

    $(".product-thumb").owlCarousel({
      dots: $(".product-thumb .item").length > 1 ? false : false,
      loop: $(".product-thumb .item").length > 1 ? true : false,
      autoWidth: true,
      nav: true,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 4,
        },
      },
    });

    $(".featured-slider-shop").owlCarousel({
      items: 4,
      dots: $(".featured-slider-shop .item").length > 1 ? false : false,
      loop: $(".featured-slider-shop .item").length > 1 ? true : false,
      nav: true,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 4,
        },
      },
    });

    /* ======= Featured Carousel 2 ======= */
    $(".featured-slider-1").owlCarousel({
      dots: $(".featured-slider-1 .item").length > 1 ? false : false,
      loop: $(".featured-slider-1 .item").length > 1 ? true : false,
      margin: -10,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
          nav: true,
        },
        600: {
          items: 2,
          nav: true,
        },
        1000: {
          items: 3,
          nav: true,
          loop: false,
        },
      },
    });

    /* ======= Featured  Carousel 3 ======= */
    $(".featured-slider-3").owlCarousel({
      dots: $(".featured-slider-3 .item").length > 1 ? false : false,
      loop: $(".featured-slider-3 .item").length > 1 ? true : false,
      margin: 0,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
          nav: true,
        },
        600: {
          items: 1,
          nav: true,
        },
        1000: {
          items: 1,
          nav: true,
          loop: false,
        },
      },
    });

    /* ======= Category Carousel ======= */
    $(".category-slider").owlCarousel({
      loop: true,
      dots: false,
      margin: 0,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
          nav: true,
        },
        600: {
          items: 2,
          nav: true,
        },
        1000: {
          items: 4,
          nav: true,
          loop: false,
        },
      },
    });

    /* ======= Background Image Rotator Carousel ======= */
    $(".background-rotator-slider").owlCarousel({
      loop: false,
      dots: false,
      margin: 0,
      autoplay: true,
      mouseDrag: true,
      touchDrag: true,
      autoplayTimeout: 5000,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      nav: false,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        1000: {
          items: 1,
        },
      },
    });

    $(".owl-testimonial-2").owlCarousel({
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      responsiveClass: true,
      dots: $(".owl-testimonial-2 .item").length > 1 ? false : false,
      loop: $(".owl-testimonial-2 .item").length > 1 ? true : false,
      items: 3,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 3,
        },
      },
      stopOnHover: true,
    });

    $(".owl-testimonial-1").owlCarousel({
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      dots: false,
      responsiveClass: true,
      loop: true,
      items: 2,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
      },
      stopOnHover: true,
    });

    $(".clients-list").owlCarousel({
      dots: $(".clients-list .item").length > 1 ? false : false,
      loop: $(".clients-list .item").length > 1 ? true : false,
      nav: false,
      items: 5,
      autoplay: true,
      autoplayTimeout: 2000,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 2,
        },
        600: {
          items: 4,
        },
        1000: {
          items: 5,
        },
      },
    });

    /* ======= Single Ad Slider Carousel  ======= */
    $(".single-details").owlCarousel({
      dots: $(".single-details .item").length > 1 ? false : false,
      loop: $(".single-details .item").length > 1 ? true : false,
      margin: 0,
      autoplay: false,
      mouseDrag: true,
      touchDrag: true,
      responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
      nav: true,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        1000: {
          items: 1,
        },
      },
    });

    /*==========  Single Page SLider With Thumb ==========*/
    $("#carousel").flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      itemWidth: 160,
      itemMargin: 5,
      asNavFor: "#single-slider",
    });

    $("#single-slider").flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      sync: "#carousel",
    });
  }
  /*SINGLE PAGE STYLE TWO MAIN SLIDER*/
  $(".listing-page-slider").owlCarousel({
    loop: true,
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    nav: true,
    dots: false,
    margin: 0,
    center: true,
    smartSpeed: 1000,
    navText: [
      "<i class='la la-angle-left'></i>",
      "<i class='la la-angle-right'></i>",
    ],
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 2,
      },
    },
  });

  /* ======= Profile Image Upload ======= */
  $(document).on("change", ".btn-file :file", function () {
    var input = $(this),
      label = input.val().replace(/\\/g, "/").replace(/.*\//, "");
    input.trigger("fileselect", [label]);
  });
  $(document).on("fileselect", ".btn-file :file", function (event, label) {
    var input = $(this).parents(".input-group").find(":text"),
      log = label;
    if (input.length) {
      input.val(log);
    }
  });

  /* ======= Masonry Grid System ======= */
  $(".posts-masonry").imagesLoaded(function () {
    $(".posts-masonry").isotope({
      layoutMode: "masonry",
      transitionDuration: "0.3s",
    });
  });

  $(".bid-info .small-box").click(function () {
    $("html, body").animate(
      {
        scrollTop: $("#tab1default").offset().top,
      },
      2000
    );
  });

  /*==========  Back To Top  ==========*/
  var offset = 300,
    offset_opacity = 1200,
    //duration of the top scrolling animation (in ms)
    scroll_top_duration = 700,
    //grab the "back to top" link
    $back_to_top = $(".cd-top");
  //hide or show the "back to top" link
  $(window).scroll(function () {
    $(this).scrollTop() > offset
      ? $back_to_top.addClass("cd-is-visible")
      : $back_to_top.removeClass("cd-is-visible cd-fade-out");
    if ($(this).scrollTop() > offset_opacity) {
      $back_to_top.addClass("cd-fade-out");
    }
  });
  //smooth scroll to top
  $back_to_top.on("click", function (event) {
    event.preventDefault();
    $("body,html").animate(
      {
        scrollTop: 0,
      },
      scroll_top_duration
    );
  });

  /*==========  Tooltip  ==========*/
  $("body").on("hover", '[data-toggle="tooltip"]', function () {
    $('[data-toggle="tooltip"]').tooltip();
    $(this).trigger("hover");
  });

  /*==========  Quick Overview Modal  ==========*/
  // Validating Registration process
  if ($("#sb-sign-form").length > 0) {
    $("#sb_register_msg").hide();
    $("#sb_register_redirect").hide();
    $("#sb-sign-form")
      .parsley()
      .on("field:validated", function () {
        var ok = $(".parsley-error").length === 0;
      })
      .on("form:submit", function () {
        $("#sb_loading").show();
        // Ajax for Registration
        $("#sb_register_submit").hide();
        $("#sb_register_msg").show();
        $.post(carspot_ajax_url, {
          action: "sb_register_user",
          sb_data: $("form#sb-sign-form").serialize(),
          security: $("#register_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            $("#sb_register_msg").hide();

            if ($.trim(response) == "1") {
              $("#sb_register_redirect").show();
              window.location = $("#previous_url").val();
              //   window.location = $("#profile_page").val();
            } else if ($.trim(response) == "2") {
              $(".resend_email").show();
              $("html, body").animate({
                scrollTop: $("#resend_email").position().top,
              });
              toastr.success($("#verify_account_msg").val(), "", {
                timeOut: 3500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            } else {
              $("#sb_register_submit").show();
              toastr.error(response, "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });
  }
  /*Resend Email*/
  $("#resend_email").on("click", function () {
    $("#sb_loading").show();
    var usr_email = $("#sb_reg_email").val();
    $.post(carspot_ajax_url, {
      action: "sb_resend_email",
      usr_email: usr_email,
    }).done(function (response) {
      toastr.success($("#verify_account_msg").val(), "", {
        timeOut: 3500,
        closeButton: true,
        positionClass: "toast-top-right",
      });
      $(".resend_email").hide();
      $(".contact_admin").show();
      $("#sb_loading").hide();
      $("html, body").animate({
        scrollTop: $("#resend_email").position().top,
      });
    });
  });

  if ($("#sb-login-form").length > 0) {
    // Login Process
    $("#sb_login_msg").hide();
    $("#sb_login_redirect").hide();

    $("#sb-login-form")
      .parsley()
      .on("field:validated", function () {
        var ok = $(".parsley-error").length === 0;
      })
      .on("form:submit", function () {
        $("#sb_loading").show();
        // Ajax for Registration
        $("#sb_login_submit").hide();
        $("#sb_login_msg").show();
        $.post(carspot_ajax_url, {
          action: "sb_login_user",
          sb_data: $("form#sb-login-form").serialize(),
          security: $("#login_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            $("#sb_login_msg").hide();

            if ($.trim(response) == "1") {
              $("#sb_login_redirect").show();
              window.location = $("#previous_url").val();
              //   window.location = $("#profile_page").val();
            } else {
              $("#sb_login_submit").show();
              toastr.error(response, "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });

        return false;
      });
  }

  /*// Forgot Password*/
  if ($("#sb-forgot-form").length > 0) {
    $("#sb_forgot_msg").hide();

    $("#sb-forgot-form")
      .parsley()
      .on("field:validated", function () {
        var ok = $(".parsley-error").length === 0;
      })
      .on("form:submit", function () {
        // Ajax for Registration
        $("#sb_forgot_submit").hide();
        $("#sb_forgot_msg").show();
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "sb_forgot_password",
          sb_data: $("form#sb-forgot-form").serialize(),
          security: $("#forget_psw_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            $("#sb_forgot_msg").hide();

            if ($.trim(response) == "1") {
              $("#sb_forgot_submit").show();
              $("#sb_forgot_email").val("");
              toastr.success($("#carspot_forgot_msg").val(), "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              $("#myModal").modal("hide");
            } else {
              $("#sb_forgot_submit").show();
              toastr.error(response, "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });

        return false;
      });
  }

  /*// Reset Password*/
  if ($("#sb-reset-password-form").length > 0) {
    $(window).on("load", function () {
      $("#sb_reset_password_modal").modal("show");
    });
    $("#sb_reset_password_msg").hide();

    $("#sb-reset-password-form")
      .parsley()
      .on("field:validated", function () {
        var ok = $(".parsley-error").length === 0;
      })
      .on("form:submit", function () {
        if (
          $("#sb_new_password").val() != $("#sb_confirm_new_password").val()
        ) {
          toastr.error($("#adforest_password_mismatch_msg").val(), "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
          return false;
        }
        // Ajax for Registration
        $("#sb_reset_password_submit").hide();
        $("#sb_reset_password_msg").show();
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "sb_reset_password",
          sb_data: $("form#sb-reset-password-form").serialize(),
        }).done(function (response) {
          $("#sb_loading").hide();
          $("#sb_reset_password_msg").hide();

          var get_r = response.split("|");
          if ($.trim(get_r[0]) == "1") {
            toastr.success(get_r[1], "", {
              timeOut: 2500,
              closeButton: true,
              positionClass: "toast-top-right",
            });
            $("#sb_reset_password_modal").modal("hide");
            $("#sb_reset_password_submit").show();
            window.location = $("#login_page").val();
          } else {
            $("#sb_reset_password_submit").show();
            toastr.error(get_r[1], "", {
              timeOut: 2500,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          }
        });

        return false;
      });
  }

  /* Change Password*/
  $(document).on("click", "#change_pwd", function () {
    $("#sb_loading").show();
    $.post(carspot_ajax_url, {
      action: "sb_change_password",
      sb_data: $("form#sb-change-password").serialize(),
      security: $("#reset_psw_nonce").val(),
    })
      .done(function (response) {
        $("#sb_loading").hide();
        var get_r = response.split("|");
        if ($.trim(get_r[0]) == "1") {
          toastr.success(get_r[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
          $("#myModal").modal("hide");
          window.location = $("#login_page").val();
        } else {
          toastr.error(get_r[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
        }
      })
      .fail(function () {
        $("#sb_loading").hide();
        toastr.error($("#nonce_error").val(), "", {
          timeOut: 4000,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      });
  });

  var is_load_required = 0;

  /*// Add Post*/
  if ($("#ad_post_form").length > 0) {
    $("#ad_cat_sub_div").hide();
    $("#ad_cat_sub_sub_div").hide();
    $("#ad_cat_sub_sub_sub_div").hide();

    //ad_cat_sub_sub_sub_div
    $("#ad_country_sub_div").hide();
    $("#ad_country_sub_sub_div").hide();
    $("#ad_country_sub_sub_sub_div").hide();

    if ($("#is_update").val() != "") {
      var level = $("#is_level").val();
      if (level >= 2) {
        $("#ad_cat_sub_div").show();
      }
      if (level >= 3) {
        $("#ad_cat_sub_sub_div").show();
      }
      if (level >= 4) {
        $("#ad_cat_sub_sub_sub_div").show();
      }

      var country_level = $("#country_level").val();
      if (country_level >= 2) {
        $("#ad_country_sub_div").show();
      }
      if (country_level >= 3) {
        $("#ad_country_sub_sub_div").show();
      }
      if (country_level >= 4) {
        $("#ad_country_sub_sub_sub_div").show();
      }
    }

    //   $('#sb_user_profile_update').on('click', function() {

    //    $('#sb_update_profile').parsley().on('field:validated', function() {}).on('form:submit', function() {

    $("#ad_post_form")
      .parsley()
      .on("field:validated", function () {})
      .on("form:submit", function () {
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "sb_ad_posting",
          sb_data: $("form#ad_post_form").serialize(),
          is_update: $("#is_update").val(),
          security: $("#ad_post_nonce").val(),
          video_req: $("#required_vidoes_value").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            //return false;
            if ($.trim(response) == "0") {
              toastr.error($("#not_logged_in").val(), "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            } else if ($.trim(response) == "img_req") {
              toastr.error($("#required_images").val(), "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            } else if ($.trim(response) == "vid_req") {
              toastr.error($("#required_vidoes_").val(), "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            } else {
              toastr.success($("#ad_posted").val(), "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              window.location = response;
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });

    // if ($('#ad_post_form').length > 0) {
    //     $('#ad_post_form').parsley().on('field:validated', function() {})
    //         .on('form:submit', function() {
    //             $('#sb_loading').show();
    //             $.post(carspot_ajax_url, {
    //                 action: 'sb_ad_posting',
    //                 sb_data: $("form#").serialize(),
    //                 is_update: $('#is_update').val(),
    //                 security: $('#ad_post_nonce').val(),
    //                 video_req: $('#required_vidoes_value').val()
    //             }).done(function(response) {
    //                 $('#sb_loading').hide();
    //                 //return false;
    //                 if ($.trim(response) == "0") {
    //                     toastr.error($('#not_logged_in').val(), '', {
    //                         timeOut: 2500,
    //                         "closeButton": true,
    //                         "positionClass": "toast-top-right"
    //                     });
    //                 } else if ($.trim(response) == "img_req") {
    //                     toastr.error($('#required_images').val(), '', {
    //                         timeOut: 2500,
    //                         "closeButton": true,
    //                         "positionClass": "toast-top-right"
    //                     });
    //                 } else if ($.trim(response) == "vid_req") {
    //                     toastr.error($('#required_vidoes_').val(), '', {
    //                         timeOut: 2500,
    //                         "closeButton": true,
    //                         "positionClass": "toast-top-right"
    //                     });
    //                 } else {
    //                     toastr.success($('#ad_posted').val(), '', {
    //                         timeOut: 2500,
    //                         "closeButton": true,
    //                         "positionClass": "toast-top-right"
    //                     });
    //                     window.location = response;
    //                 }
    //             }).fail(function() {
    //                 $('#sb_loading').hide();
    //                 toastr.error($('#nonce_error').val(), '', {
    //                     timeOut: 4000,
    //                     "closeButton": true,
    //                     "positionClass": "toast-top-right"
    //                 });
    //             });
    //             return false;
    //         });
    // }

    /* Level 1 */
    $("#ad_cat").on("change", function () {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "sb_get_sub_cat",
        cat_id: $("#ad_cat").val(),
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#ad_cat_sub").val("");
        $("#ad_cat_sub_sub").val("");
        $("#ad_cat_sub_sub_sub").val("");
        if ($.trim(response) != "" && $.trim(response) != 0) {
          $("#ad_cat_id").val($("#ad_cat").val());
          $("#ad_cat_sub_div").show();
          $("#ad_cat_sub").html(response);
          $("#ad_cat_sub_sub_div").hide();
          $("#ad_cat_sub_sub_sub_div").hide();
        } else {
          $("#ad_cat_sub_div").hide();
          $("#ad_cat_sub_sub_div").hide();
          $("#ad_cat_sub_sub_sub_div").hide();
        }
        /*For Category Templates*/
        getCustomTemplate(
          carspot_ajax_url,
          $("#ad_cat").val(),
          $("#is_update").val(),
          true
        );
        /*For Category Templates*/
      });
    });

    /* Level 2 */
    $("#ad_cat_sub").on("change", function () {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "sb_get_sub_cat",
        cat_id: $("#ad_cat_sub").val(),
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#ad_cat_sub_sub").val("");
        $("#ad_cat_sub_sub_sub").val("");
        if ($.trim(response) != "" && $.trim(response) != 0) {
          $("#ad_cat_id").val($("#ad_cat_sub").val());
          $("#ad_cat_sub_sub_div").show();
          $("#ad_cat_sub_sub").html(response);
          $("#ad_cat_sub_sub_sub_div").hide();
        } else {
          $("#ad_cat_sub_sub_div").hide();
          $("#ad_cat_sub_sub_sub_div").hide();
        }
        /*For Category Templates*/
        getCustomTemplate(
          carspot_ajax_url,
          $("#ad_cat_sub").val(),
          $("#is_update").val(),
          false
        );
        /*For Category Templates*/
      });
    });

    /* Level 3 */
    $("#ad_cat_sub_sub").on("change", function () {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "sb_get_sub_cat",
        cat_id: $("#ad_cat_sub_sub").val(),
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#ad_cat_sub_sub_sub").val("");
        if ($.trim(response) != "" && $.trim(response) != 0) {
          $("#ad_cat_id").val($("#ad_cat_sub_sub").val());
          $("#ad_cat_sub_sub_sub_div").show();
          $("#ad_cat_sub_sub_sub").html(response);
        } else {
          $("#ad_cat_sub_sub_sub_div").hide();
        }
        /*For Category Templates*/
        getCustomTemplate(
          carspot_ajax_url,
          $("#ad_cat_sub_sub").val(),
          $("#is_update").val(),
          false
        );
        /*For Category Templates*/
      });
    });

    /* Level 4 */
    $("#ad_cat_sub_sub_sub").on("change", function () {
      $("#ad_cat_id").val($("#ad_cat_sub_sub_sub").val());
      /*For Category Templates*/
      getCustomTemplate(
        carspot_ajax_url,
        $("#ad_cat_sub_sub_sub").val(),
        $("#is_update").val(),
        false
      );
      /*For Category Templates*/
    });

    /*========  Countries  =======*/
    /* Level 1 */
    $("#ad_country").on("change", function () {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "sb_get_sub_states",
        cat_id: $("#ad_country").val(),
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#ad_country_states").val("");
        $("#ad_country_cities").val("");
        $("#ad_country_towns").val("");
        if ($.trim(response) != "" && $.trim(response) != 0) {
          $("#ad_country_id").val($("#ad_cat").val());
          $("#ad_country_sub_div").show();
          $("#ad_country_states").html(response);
          $("#ad_country_sub_sub_div").hide();
          $("#ad_country_sub_sub_sub_div").hide();
        } else {
          $("#ad_country_sub_div").hide();
          $("#ad_country_sub_sub_div").hide();
          $("#ad_country_sub_sub_sub_div").hide();
        }
      });
    });

    /* Level 2 */
    $("#ad_country_states").on("change", function () {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "sb_get_sub_states",
        cat_id: $("#ad_country_states").val(),
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#ad_country_cities").val("");
        $("#ad_country_towns").val("");
        if ($.trim(response) != "" && $.trim(response) != 0) {
          $("#ad_country_id").val($("#ad_country_states").val());
          $("#ad_country_sub_sub_div").show();
          $("#ad_country_cities").html(response);
          $("#ad_country_sub_sub_sub_div").hide();
        } else {
          $("#ad_country_sub_sub_div").hide();
          $("#ad_country_sub_sub_sub_div").hide();
        }
      });
    });

    /* Level 3 */
    $("#ad_country_cities").on("change", function () {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "sb_get_sub_states",
        cat_id: $("#ad_country_cities").val(),
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#ad_country_towns").val("");
        if ($.trim(response) != "" && $.trim(response) != 0) {
          $("#ad_country_id").val($("#ad_country_cities").val());
          $("#ad_country_sub_sub_sub_div").show();
          $("#ad_country_towns").html(response);
        } else {
          $("#ad_country_sub_sub_sub_div").hide();
        }
      });
    });
  }

  // select profile tabs
  $(document).on("click", ".messages_actions", function () {
    var sb_action = $(this).attr("sb_action");
    if (sb_action != "") {
      //$('.dashboard-menu-container ul li').removeClass('active');
      //$(this).closest("li").addClass('active');
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: sb_action,
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#carspot_res").html(response);
        $('[data-toggle="tooltip"]').tooltip();
        $("[data-toggle=confirmation]").confirmation({
          rootSelector: "[data-toggle=confirmation]",
          // other options
        });
      });
    }
  });
  $(".menu-name, .profile_tabs").on("click", function () {
    var sb_action = $(this).attr("sb_action");
    if (sb_action != "") {
      $(".dashboard-menu-container ul li").removeClass("active");
      $(this).closest("li").addClass("active");
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: sb_action,
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#carspot_res").html(response);
        if (sb_action != "my_msgs") {
          $(".posts-masonry").imagesLoaded(function () {
            $(".posts-masonry").isotope({
              layoutMode: "masonry",
              transitionDuration: "0.3s",
            });
          });
        }
        $('[data-toggle="tooltip"]').tooltip();
        $("[data-toggle=confirmation]").confirmation({
          rootSelector: "[data-toggle=confirmation]",
          // other options
        });
      });
    }
  });
  $(function () {
    $(".get_msgs_auto").click();
  });
  $(".get_msgs_auto").on("click", function () {
    var sb_action = $(this).attr("sb_action");
    if (sb_action != "") {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: sb_action,
      }).done(function (response) {
        $("#sb_loading").hide();
        $("#carspot_res").html(response);

        if ($("#current_action").val() == "sb_load_messages") {
          $(document).find(".messages_actions").removeClass("active");
          $(document).find("#receive_messages").addClass("active");
          $(document).find("#receive_messages").click();

          var second_user = $("#second_user").val();
          var cid = $("#current_ad").val();
          $.post(carspot_ajax_url, {
            action: "sb_load_messages",
            ad_id: cid,
          }).done(function (response) {
            $("#sb_loading").hide();
            $("#carspot_res").html(response);
            $(".message-details .list-wraps")
              .scrollTop(20000)
              .perfectScrollbar("update");
            $("#sb_loading").show();
            $.post(carspot_ajax_url, {
              action: "sb_get_messages",
              ad_id: cid,
              user_id: second_user,
              receiver: second_user,
              inbox: "no",
            }).done(function (response) {
              $("#usr_id").val(second_user);
              $("#rece_id").val(second_user);
              $("#msg_receiver_id").val(second_user);
              $("#ad_post_id").val(cid);
              $("#sb_loading").hide();
              $("#messages").html(response);
              $(".message-details .list-wraps")
                .scrollTop(20000)
                .perfectScrollbar("update");
            });
          });
        }
        $(".message-details .list-wraps")
          .scrollTop(20000)
          .perfectScrollbar("update");
      });
    }
  });

  // Update Profile //

  $("#sb_user_profile_update").on("click", function () {
    $("#sb_update_profile")
      .parsley()
      .on("field:validated", function () {})
      .on("form:submit", function () {
        // Ajax for Update profile
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "sb_update_profile",
          sb_data: $("form#sb_update_profile").serialize(),
          security: $("#save_profile_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            if ($.trim(response) == "1") {
              toastr.success($("#carspot_profile_msg").val(), "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              location.reload();
            } else {
              $("#sb_forgot_submit").show();
              toastr.error(response, "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });
  });

  // Upload user profile picture
  $("body").on("change", ".sb_files-data", function (e) {
    var fd = new FormData();
    var files_data = $(".sb_files-data");

    $.each($(files_data), function (i, obj) {
      $.each(obj.files, function (j, file) {
        fd.append("my_file_upload[" + j + "]", file);
      });
    });

    fd.append("action", "upload_user_pic");
    fd.append("security", $("#profile_pic_nonce").val());
    $("#sb_loading").show();
    $.ajax({
      type: "POST",
      url: carspot_ajax_url,
      data: fd,
      contentType: false,
      processData: false,
      success: function (res) {
        $("#sb_loading").hide();
        var res_arr = res.split("|");
        if ($.trim(res_arr[0]) == "1") {
          $("#profile-image").attr("src", res_arr[1]);
          $("#img-upload").attr("src", res_arr[1]);
        } else {
          toastr.error(res_arr[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
        }
      },
      error: function () {
        $("#sb_loading").hide();
        toastr.error($("#nonce_error").val(), "", {
          timeOut: 4000,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      },
    });
  });
  // Upload user profile picture
  $("body").on("change", ".sb_store_img", function (e) {
    var fd = new FormData();
    var files_data = $(".sb_store_img");

    $.each($(files_data), function (i, obj) {
      $.each(obj.files, function (j, file) {
        fd.append("my_store_file[" + j + "]", file);
      });
    });

    fd.append("action", "upload_store_pic");
    fd.append("security", $("#cover_pic_nonce").val());
    $("#sb_loading").show();
    $.ajax({
      type: "POST",
      url: carspot_ajax_url,
      data: fd,
      contentType: false,
      processData: false,
      success: function (res) {
        $("#sb_loading").hide();
        var res_arr = res.split("|");
        if ($.trim(res_arr[0]) == "1") {
          $("#store-image").css("background-image", "url(" + res_arr[1] + ")");
        } else {
          toastr.error(res_arr[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
        }
      },
      error: function () {
        $("#sb_loading").hide();
        toastr.error($("#nonce_error").val(), "", {
          timeOut: 4000,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      },
    });
  });

  if ($("#is_sub_active").val() == "1") {
    /*images uplaod*/
    sbDropzone_image();
  }

  /*
   * upload images for gallery
   * during submit selling form
   * */
  function sbDropzone_image() {
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
    var fileList = new Array();
    var i = 0;
    /* working for post gallery images */
    if ($("#dropzone").length) {
      $("#dropzone").dropzone({
        timeout: 5000000000,
        maxFilesize: $("#sb_upload_size").val(),
        addRemoveLinks: true,
        paramName: "my_file_upload",
        maxFiles: $("#sb_upload_limit").val(), //change limit as per your requirements
        acceptedFiles: ".jpeg,.jpg,.png",
        /*acceptedFiles: acceptedFileTypes,*/
        url:
          carspot_ajax_url +
          "?action=upload_ad_images&is_update=" +
          $("#is_update").val(),
        parallelUploads: 1,
        dictMaxFilesExceeded: $("#dictMaxFilesExceeded").val(),
        dictDefaultMessage: $("#dictDefaultMessage").val(),
        dictFallbackMessage: $("#dictFallbackMessage").val(),
        dictFallbackText: $("#dictFallbackText").val(),
        dictFileTooBig: $("#dictFileTooBig").val(),
        dictInvalidFileType: $("#dictInvalidFileType").val(),
        dictResponseError: $("#dictResponseError").val(),
        dictCancelUpload: $("#dictCancelUpload").val(),
        dictCancelUploadConfirmation: $("#dictCancelUploadConfirmation").val(),
        dictRemoveFile: $("#dictRemoveFile").val(),
        dictRemoveFileConfirmation: null,
        init: function () {
          var thisDropzone = this;
          $.post(carspot_ajax_url, {
            action: "get_uploaded_ad_images",
            is_update: $("#is_update").val(),
          }).done(function (data) {
            $.each(data, function (key, value) {
              var mockFile = {
                name: value.name,
                size: value.size,
              };
              thisDropzone.options.addedfile.call(thisDropzone, mockFile);
              thisDropzone.options.thumbnail.call(
                thisDropzone,
                mockFile,
                value.name
              );
              $("#dropzone a.dz-remove:eq(" + i + ")").attr(
                "data-dz-remove",
                value.id
              );
              i++;
            });
            if (i > 0) $(".dz-message").hide();
            else $(".dz-message").show();
          });
          /*rejected because the number of files exceeds the maxFiles limit.*/
          thisDropzone.on("maxfilesexceeded", function (file) {
            this.removeFile(file);
          });
          this.on("addedfile", function (file) {
            $(".dz-message").hide();
          });
          this.on("success", function (file, responseText) {
            var res_arr = responseText.split("|");
            if ($.trim(res_arr[0]) != "0") {
              $("a.dz-remove:eq(" + i + ")").attr(
                "data-dz-remove",
                responseText
              );
              i++;
              $(".dz-message").hide();
            } else {
              if (i == 0) $(".dz-message").show();
              this.removeFile(file);
              toastr.error(res_arr[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          });
          this.on("removedfile", function (file) {
            var img_id = file._removeLink.attributes[2].value;
            if (img_id != "") {
              i--;
              if (i == 0) $(".dz-message").show();
              $.post(carspot_ajax_url, {
                action: "delete_ad_image",
                img: img_id,
                is_update: $("#is_update").val(),
              }).done(function (response) {
                if ($.trim(response) == "1") {
                  /*this.removeFile(file);*/
                }
              });
            }
          });
        },
      });
    }
  }

  /*
   * Pdf Brochure File
   * */
  /*pdf brochure upload*/
  cs_upload_brochure_file();

  function cs_upload_brochure_file() {
    Dropzone.autoDiscover = false;
    var j = 0;
    if ($("div#pdf_brochure_dropzone").length) {
      $("div#pdf_brochure_dropzone").dropzone({
        timeout: 5000000000,
        maxFilesize: $("#pdf_brochure_size").val(),
        addRemoveLinks: true,
        paramName: "my_pdf_brochure_file_upload",
        maxFiles: $("#pdf_brochure_upload_limit").val(), //change limit as per your requirements
        acceptedFiles: ".pdf",
        /*acceptedFiles: acceptedFileTypes,*/
        url:
          carspot_ajax_url +
          "?action=upload_pdf_brochure_file&is_update=" +
          $("#is_update").val(),
        parallelUploads: 1,
        dictMaxFilesExceeded: $("#dictMaxFilesExceeded").val(),
        dictDefaultMessage: $("#dictDefaultMessage").val(),
        dictFallbackMessage: $("#dictFallbackMessage").val(),
        dictFallbackText: $("#dictFallbackText").val(),
        dictFileTooBig: $("#dictFileTooBig").val(),
        dictInvalidFileType: $("#dictInvalidFileType").val(),
        dictResponseError: $("#dictResponseError").val(),
        dictCancelUpload: $("#dictCancelUpload").val(),
        dictCancelUploadConfirmation: $("#dictCancelUploadConfirmation").val(),
        dictRemoveFile: $("#dictRemoveFile").val(),
        dictRemoveFileConfirmation: null,
        init: function () {
          var thisDropzone = this;
          let imageUrl = $("#pdf_brochure_logo_url").val();
          /*get already uploaded pdf from server*/
          $.post(carspot_ajax_url, {
            action: "get_uploaded_pdf_brochure_file",
            is_update: $("#is_update").val(),
          }).done(function (data) {
            $.each(data, function (key, value) {
              var mockFile = {
                name: value.pdf_display_name,
                size: value.pdf_size,
              };
              thisDropzone.options.addedfile.call(thisDropzone, mockFile);
              thisDropzone.options.thumbnail.call(
                thisDropzone,
                mockFile,
                imageUrl
              );
              $("#pdf_brochure_dropzone a.dz-remove:eq(" + j + ")").attr(
                "data-dz-remove",
                value.pdf_id
              );
              j++;
            });
            if (j > 0) $(".dz-message").hide();
            else $(".dz-message").show();
          });
          /*rejected because the number of files exceeds the maxFiles limit.*/
          thisDropzone.on("maxfilesexceeded", function (file) {
            this.removeFile(file);
          });
          /*file has been uploaded successfully*/
          this.on("success", function (file, responseText) {
            var res_arr = responseText.split("|");
            // If the image is already a thumbnail:
            this.emit("thumbnail", file, imageUrl);
            if ($.trim(res_arr[0]) != "0") {
              $("#pdf_brochure_dropzone a.dz-remove:eq(" + j + ")").attr(
                "data-dz-remove",
                responseText
              );
              j++;
              $(".dz-message").hide();
            } else {
              if (j == 0) $(".dz-message").show();
              this.removeFile(file);
              toastr.error(res_arr[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          });
          /*remove file*/
          this.on("removedfile", function (file) {
            var pdf_id = file._removeLink.attributes[2].value;
            if (pdf_id != "") {
              j--;
              if (j == 0) $(".dz-message").show();
              $.post(carspot_ajax_url, {
                action: "delete_pdf_brochure_file",
                pdf: pdf_id,
                is_update: $("#is_update").val(),
              }).done(function (response) {
                if ($.trim(response) == "1") {
                  //thisDropzone.removeFile(file);
                }
              });
            }
          });
        },
      });
    }
  }

  // function cs_upload_brochure_file() {
  //     Dropzone.autoDiscover = false;
  //     var acceptedFileTypes = "application/pdf"; //dropzone requires this param be a comma separated list
  //     var fileList = new Array;
  //     var j = 0;
  //     /* working for post gallery images */
  //     if ($('div#pdf_brochure_dropzone').length) {
  //         $("div#pdf_brochure_dropzone").dropzone({
  //             timeout: 5000000000,
  //             maxFilesize: $('#pdf_brochure_size').val(),
  //             addRemoveLinks: true,
  //             paramName: "my_pdf_brochure_file_upload",
  //             maxFiles: $('#pdf_brochure_upload_limit').val(), //change limit as per your requirements
  //             acceptedFiles: '.pdf',
  //             /*acceptedFiles: acceptedFileTypes,*/
  //             url: carspot_ajax_url + "?action=upload_pdf_brochure_file&is_update=" + $('#is_update').val(),
  //             parallelUploads: 1,
  //             dictMaxFilesExceeded: $('#dictMaxFilesExceeded').val(),
  //             dictDefaultMessage: $('#dictDefaultMessage').val(),
  //             dictFallbackMessage: $('#dictFallbackMessage').val(),
  //             dictFallbackText: $('#dictFallbackText').val(),
  //             dictFileTooBig: $('#dictFileTooBig').val(),
  //             dictInvalidFileType: $('#dictInvalidFileType').val(),
  //             dictResponseError: $('#dictResponseError').val(),
  //             dictCancelUpload: $('#dictCancelUpload').val(),
  //             dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
  //             dictRemoveFile: $('#dictRemoveFile').val(),
  //             dictRemoveFileConfirmation: null,
  //             init: function () {
  //                 var thisDropzone = this;
  //                 $.post(carspot_ajax_url, {
  //                     action: 'get_uploaded_pdf_brochure_file',
  //                     is_update: $('#is_update').val()
  //                 }).done(function (data) {
  //                     $.each(data, function (key, value) {
  //                         var mockFile = {
  //                             name: value.pdf_display_name,
  //                             size: value.pdf_size,
  //                             id: value.pdf_id
  //                         };
  //                         thisDropzone.options.addedfile.call(thisDropzone, mockFile);
  //                         thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.pdf_name);
  //                         $('#pdf_brochure_dropzone a.dz-remove:eq(' + j + ')').attr("data-dz-remove", value.pdf_id);
  //                         j++;
  //                     });
  //                     if (j > 0)
  //                         $('.dz-message').hide();
  //                     else
  //                         $('.dz-message').show();
  //                 });
  //                 this.on("addedfile", function (file) {
  //                     $('.dz-message').hide();
  //                 });
  //                 this.on("success", function (file, responseText) {
  //                     var res_arr = responseText.split("|");
  //                     if ($.trim(res_arr[0]) != "0") {
  //                         $('#pdf_brochure_dropzone a.dz-remove:eq(' + j + ')').attr("data-dz-remove", responseText);
  //                         j++;
  //                         $('.dz-message').hide();
  //                     } else {
  //                         if (j == 0)
  //                             $('.dz-message').show();
  //                         this.removeFile(file);
  //                         toastr.error(res_arr[1], '', {
  //                             timeOut: 2500,
  //                             "closeButton": true,
  //                             "positionClass": "toast-top-right"
  //                         });
  //                     }
  //                 });
  //                 this.on("removedfile", function (file) {
  //                     var pdf_id = file._removeLink.attributes[2].value;
  //                     if (pdf_id != "") {
  //                         j--;
  //                         if (j == 0)
  //                             $('.dz-message').show();
  //                         $.post(carspot_ajax_url, {
  //                             action: 'delete_pdf_brochure_file',
  //                             pdf: pdf_id,
  //                             is_update: $('#is_update').val(),
  //                         }).done(function (response) {
  //                             if ($.trim(response) == "1") {
  //                                 //this.removeFile(file);
  //                             }
  //                         });
  //                     }
  //                 });
  //             },
  //         });
  //     }
  // }

  /*
   * upload single video
   * */
  /*single video upload*/
  csDropzone_video();

  function csDropzone_video() {
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = "video/mp4,video/ogg,video/webm";
    var fileList = new Array();
    var k = 0;
    if ($("#ad_vidoe_dropzone").length) {
      $("#ad_vidoe_dropzone").dropzone({
        timeout: 5000000000,
        maxFilesize: $("#max_upload_video_size").val(),
        addRemoveLinks: true,
        paramName: "my_single_video_upload",
        maxFiles: $("#sb_upload_video_limit").val(), //change limit as per your requirements
        MaxFilesExceeded: $("#sb_upload_video_limit").val(),
        acceptedFiles: acceptedFileTypes,
        url:
          carspot_ajax_url +
          "?action=upload_cs_single_video&is_update=" +
          $("#is_update").val(),
        parallelUploads: 1,
        uploadMultiple: false,
        dictMaxFilesExceeded: $("#dictMaxFilesExceeded").val(),
        dictDefaultMessage: $("#dictDefaultMessage").val(),
        dictFallbackMessage: $("#dictFallbackMessage").val(),
        dictFallbackText: $("#dictFallbackText").val(),
        dictFileTooBig: $("#dictFileTooBig").val(),
        dictInvalidFileType: $("#dictInvalidFileType").val(),
        dictResponseError: $("#dictResponseError").val(),
        dictCancelUpload: $("#dictCancelUpload").val(),
        dictCancelUploadConfirmation: $("#dictCancelUploadConfirmation").val(),
        dictRemoveFile: $("#dictRemoveFile").val(),
        dictRemoveFileConfirmation: null,
        init: function () {
          var thisDropzone = this;
          let videoLogoUrl = $("#video_logo_url").val();
          /*get uploaded videos*/
          $.post(carspot_ajax_url, {
            action: "get_uploaded_video",
            is_update: $("#is_update").val(),
          }).done(function (data) {
            $.each(data, function (key, value) {
              var mockFile = {
                name: value.video_name,
                size: value.video_size,
              };
              thisDropzone.options.addedfile.call(thisDropzone, mockFile);
              thisDropzone.options.thumbnail.call(
                thisDropzone,
                mockFile,
                videoLogoUrl
              );
              $("#ad_vidoe_dropzone a.dz-remove:eq(" + k + ")").attr(
                "data-dz-remove",
                value.video_id
              );
              k++;
            });
            if (k > 0) $(".dz-message").hide();
            else $(".dz-message").show();
          });

          /*rejected because the number of files exceeds the maxFiles limit.*/
          thisDropzone.on("maxfilesexceeded", function (file) {
            this.removeFile(file);
          });

          /*file has been uploaded successfully*/
          thisDropzone.on("success", function (file, responseText) {
            var res_arr = responseText.split("|");
            // If the image is already a thumbnail:
            this.emit("thumbnail", file, videoLogoUrl);
            if ($.trim(res_arr[0]) != "0") {
              $("#ad_vidoe_dropzone a.dz-remove:eq(" + k + ")").attr(
                "data-dz-remove",
                responseText
              );
              k++;
              $(".dz-message").hide();
            } else {
              if (k == 0) $(".dz-message").show();
              this.removeFile(file);
              toastr.error(res_arr[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          });
          /*remove/delete the file*/
          thisDropzone.on("removedfile", function (file) {
            var video_id = file._removeLink.attributes[2].value;
            if (video_id != "") {
              k--;
              if (k == 0) {
                $(".dz-message").show();
              }
              $.post(carspot_ajax_url, {
                action: "delete_upload_video",
                video: video_id,
                is_update: $("#is_update").val(),
              }).done(function (response) {
                if ($.trim(response) == "1") {
                  //thisDropzone.removeFile(file);
                }
              });
            }
          });
        },
      });
    }
  }

  /*Make Post on blur of title field*/
  $("#ad_title").on("blur", function () {
    if ($("#is_update").val() == "") {
      $.post(carspot_ajax_url, {
        action: "post_ad",
        title: $("#ad_title").val(),
        is_update: $("#is_update").val(),
      }).done(function (response) {});
    }
  });

  /*ajax call for 3rd party api data fetch */
  /*Make Post on blur of title field*/
  $("#ad_api_regis_num").on("blur", function () {
    if ($("#is_update").val() == "") {
      $("#sb_loading").show();
      $.post(carspot_ajax_url, {
        action: "get_data_for_liveapi",
        title: $("#ad_api_regis_num").val(),
        login_name: $("#api_login_user_name").val(),
        dataType: "json",
      }).done(function (response) {
        $("#sb_loading").hide();
        var obj = $.parseJSON(response);
        if (!$.isEmptyObject(obj)) {
          $.each(obj, function (key, value) {
            //alert($("#ad_engine_capacities").val());
            if (key == "ad_cats") {
              $("#ad_cat").val(value).trigger("change.select2");
            }
            if (key == "ad_cats2") {
              $.post(carspot_ajax_url, {
                action: "sb_get_sub_cat",
                cat_id: $("#ad_cat").val(),
              }).done(function (response) {
                $("#ad_cat_sub").html(response);
                $("#ad_cat_sub_div").show();
                $("#ad_cat_sub").val(value).trigger("change.select2");
              });
            }
            if (key == "ad_cats3") {
              $.post(carspot_ajax_url, {
                action: "sb_get_sub_sub_cat_search",
                cat_id: $("#ad_cat_sub").val(),
              }).done(function (response) {
                $("#ad_cat_sub_sub").html(response);
                $("#ad_cat_sub_sub_div").show();
                $("#ad_cat_sub_sub").val(value).trigger("change.select2");
              });
            }
            if (key == "ad_years") {
              $("#ad_years").val(value).trigger("change.select2");
            }
            if (key == "ad_engine_capacities") {
              $("#ad_engine_capacities").val(value).trigger("change.select2");
            }
            if (key == "ad_engine_types") {
              $("#ad_engine_types").val(value).trigger("change.select2");
            }
            if (key == "ad_body_types") {
              $("#ad_body_types").val(value).trigger("change.select2");
            }
            if (key == "ad_transmissions") {
              $("#ad_transmissions").val(value).trigger("change.select2");
            }
          });
        } else {
          $("#ad_cat").val("").trigger("change.select2");
          $("#ad_cat_sub_div").hide();
          $("#ad_cat_sub_sub_div").hide();
          $("#ad_cat_sub").val("").trigger("change.select2");
          $("#ad_years").val("").trigger("change.select2");
          $("#ad_engine_capacities").val("").trigger("change.select2");
          $("#ad_engine_types").val("").trigger("change.select2");
          $("#ad_body_types").val("").trigger("change.select2");
          $("#ad_transmissions").val("").trigger("change.select2");
        }
      });
    }
  });

  if ($("#facebook_key").val() != "" && $("#google_key").val() != "") {
    // Hello JS
    hello.init(
      {
        facebook: $("#facebook_key").val(),
        google: $("#google_key").val(),
      },
      {
        redirect_uri: $("#redirect_uri").val(),
      }
    );
  } else if ($("#facebook_key").val() != "" && $("#google_key").val() == "") {
    // Hello JS
    hello.init(
      {
        facebook: $("#facebook_key").val(),
      },
      {
        redirect_uri: $("#redirect_uri").val(),
      }
    );
  } else if ($("#google_key").val() != "" && $("#facebook_key").val() == "") {
    // Hello JS
    hello.init(
      {
        google: $("#google_key").val(),
      },
      {
        redirect_uri: $("#redirect_uri").val(),
      }
    );
  }

  // Hello JS Hander
  $(".form-grid a.btn-social").on("click", function () {
    hello.on("auth.login", function (auth) {
      console.log(auth);
      $("#sb_loading").show();
      // Call user information, for the given network
      hello(auth.network)
        .api("me")
        .then(function (r) {
          if (
            $("#get_action").val() == "login" ||
            $("#get_action").val() == "register"
          ) {
            var access_token = hello(auth.network).getAuthResponse()
              .access_token;
            var sb_network = hello(auth.network).getAuthResponse().network;
            $.post(carspot_ajax_url, {
              action: "sb_social_login",
              access_token: access_token,
              sb_network: sb_network,
              email: r.email,
              //key_code mean time in string.
              key_code: $("#nonce").val(),
            }).done(function (response) {
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $("#nonce").val(get_r[1]);
                if ($.trim(get_r[2]) == "1") {
                  toastr.success(get_r[3], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                  window.location = $("#previous_url").val();
                  //   window.location = $("#profile_page").val();
                } else {
                  toastr.error(get_r[3], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                }
              }
            });
          } else {
            $("#sb_reg_name").val(r.name);
            $("#sb_reg_email").val(r.email);
          }
          $("#sb_loading").hide();
        });
    });
  });

  if ($("#is_sub_active").val() == "1") {
    /* Tags*/
    carspot_inputTags();
  }

  // Single Ad JS
  /* ======= Show Number ======= */
  $(".number").click(function () {
    $(this).find("span").text($(this).data("last"));
  });

  /* ======= Ad Location ======= */
  if ($("#lat").length > 0) {
    var map_type = get_strings.carspot_map_type;
    var lat = $("#lat").val();
    var lon = $("#lon").val();
    if (map_type == "leafletjs_map") {
      /*For leafletjs map*/
      var map = L.map("itemMap").setView([lat, lon], 7);
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "",
      }).addTo(map);
      L.marker([lat, lon]).addTo(map);
    } else if (map_type == "google_map") {
      var map = "";
      var latlng = new google.maps.LatLng(lat, lon);
      var myOptions = {
        zoom: 13,
        center: latlng,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        size: new google.maps.Size(480, 240),
      };
      map = new google.maps.Map(document.getElementById("itemMap"), myOptions);
      var marker = new google.maps.Marker({
        map: map,
        position: latlng,
      });
    }
  }

  // Report Ad
  $("#sb_mark_it").on("click", function () {
    $("#sb_loading").show();
    $.post(carspot_ajax_url, {
      action: "sb_report_ad",
      option: $("#report_option").val(),
      comments: $("#report_comments").val(),
      ad_id: $("#ad_id").val(),
      security: $("#report_ad_nonce").val(),
    })
      .done(function (response) {
        $("#sb_loading").hide();
        var get_r = response.split("|");
        if ($.trim(get_r[0]) == "1") {
          toastr.success(get_r[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
          $(".report-quote").modal("hide");
        } else {
          toastr.error(get_r[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
        }
      })
      .fail(function () {
        $("#sb_loading").hide();
        toastr.error($("#nonce_error").val(), "", {
          timeOut: 4000,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      });
  });

  // Add to favourites
  $("#ad_to_fav,.save-ad").on("click", function () {
    $("#sb_loading").show();
    $.post(carspot_ajax_url, {
      action: "sb_fav_ad",
      ad_id: $(this).attr("data-adid"),
      security: $("#fav_ad_nonce").val(),
    })
      .done(function (response) {
        $("#sb_loading").hide();
        var get_p = response.split("|");
        if ($.trim(get_p[0]) == "1") {
          toastr.success(get_p[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
        } else {
          toastr.error(get_p[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
        }
      })
      .fail(function () {
        $("#sb_loading").hide();
        toastr.error($("#nonce_error").val(), "", {
          timeOut: 4000,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      });
  });

  $("#carspot_delete_account").on("click", function () {
    var use_id = $(this).attr("data-userid");
    $.confirm({
      title: get_strings.alt,
      content: get_strings.acDelMsg,
      buttons: {
        confirm: {
          text: get_strings.alertConfirm,
          action: function () {
            $("#sb_loading").show();
            $.post(carspot_ajax_url, {
              action: "carspot_delete_account",
              user_id: use_id,
              security: $("#del_profile_nonce").val(),
            })
              .done(function (response) {
                var account_delete = $("#account_deleted").val();
                $("#sb_loading").hide();
                var get_p = response.split("|");
                if ($.trim(get_p[0]) == "1") {
                  toastr.success(get_p[1], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                  window.setTimeout(function () {
                    window.location = get_p[2];
                  }, 1000);
                } else {
                  toastr.error(get_p[1], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                }
              })
              .fail(function () {
                $("#sb_loading").hide();
                toastr.error($("#nonce_error").val(), "", {
                  timeOut: 4000,
                  closeButton: true,
                  positionClass: "toast-top-right",
                });
              });
          },
        },
        cancel: {
          text: get_strings.alertCancle,
          action: function () {},
        },
      },
    });
  });

  /*REMOVE FROM FAVORIT AD*/

  $(".remove_fav_ad").on("click", function () {
    var id = $(this).attr("data-adid");
    $.confirm({
      title: get_strings.alt,
      content: get_strings.altMsg,
      buttons: {
        confirm: {
          text: get_strings.alertConfirm,
          action: function () {
            $("#sb_loading").show();
            $.post(carspot_ajax_url, {
              action: "sb_fav_remove_ad",
              ad_id: id,
              security: $("#edit_post_nonce").val(),
            })
              .done(function (response) {
                $("#sb_loading").hide();
                var get_r = response.split("|");
                if ($.trim(get_r[0]) == "1") {
                  $("body")
                    .find("#holder-" + id)
                    .remove();
                  toastr.success(get_r[1], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                  location.reload();
                } else {
                  toastr.error(get_r[1], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                }
              })
              .fail(function () {
                $("#sb_loading").hide();
                toastr.error($("#nonce_error").val(), "", {
                  timeOut: 4000,
                  closeButton: true,
                  positionClass: "toast-top-right",
                });
              });
          },
        },
        cancel: {
          text: get_strings.alertCancle,
          action: function () {},
        },
      },
    });
  });

  // Send message to ad owner
  if ($("#send_message_pop").length > 0) {
    $("#send_message_pop")
      .parsley()
      .on("field:validated", function () {})
      .on("form:submit", function () {
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "sb_send_message",
          sb_data: $("form#send_message_pop").serialize(),
          security: $("#message_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();
            var get_r = response.split("|");
            if ($.trim(get_r[0]) == "1") {
              toastr.success(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              $("#sb_forest_message").val("");
              $(".close").trigger("click");
            } else {
              toastr.error(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });
  }

  $("body").on("click", ".user_list", function () {
    $("#sb_loading").show();
    $(".message-history-active").removeClass("message-history-active");
    $(this).addClass("message-history-active");
    var second_user = $(this).attr("second_user");
    var inbox = $(this).attr("inbox");
    var prnt = "no";
    if (inbox == "yes") {
      prnt = "yes";
    }
    var cid = $(this).attr("cid");
    $("#" + second_user + "_" + cid).html("");
    $.post(carspot_ajax_url, {
      action: "sb_get_messages",
      ad_id: cid,
      user_id: second_user,
      receiver: second_user,
      inbox: prnt,
    }).done(function (response) {
      $("#usr_id").val(second_user);
      $("#rece_id").val(second_user);
      $("#msg_receiver_id").val(second_user);
      $("#ad_post_id").val(cid);
      $("#sb_loading").hide();
      $("#messages").html(response);
      $(".message-details .list-wraps")
        .scrollTop(20000)
        .perfectScrollbar("update");
    });
  });

  $("body").on("click", "#send_msg", function () {
    $("#send_message")
      .parsley()
      .on("field:validated", function () {})
      .on("form:submit", function () {
        var inbox = $("#send_msg").attr("inbox");
        var prnt = "no";
        if (inbox == "yes") {
          prnt = "yes";
        }

        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "sb_send_message",
          sb_data: $("form#send_message").serialize(),
          security: $("#message_nonce").val(),
        })
          .done(function (response) {
            var get_r = response.split("|");
            if ($.trim(get_r[0]) == "1") {
              toastr.success(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              $("#sb_forest_message").val("");
              $.post(carspot_ajax_url, {
                action: "sb_get_messages",
                ad_id: $("#ad_post_id").val(),
                user_id: $("#usr_id").val(),
                inbox: prnt,
              }).done(function (response) {
                $("#sb_loading").hide();
                $("#messages").html(response);
                $(".message-details .list-wraps")
                  .scrollTop(20000)
                  .perfectScrollbar("update");
              });
            } else {
              toastr.error(get_r[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });
        return false;
      });
  });

  // Delete  Ad
  /*$('body').on('hover', '.remove_ad', function(e)
     {
     $(this).confirmation({
     rootSelector: '[data-toggle=confirmation]',
     });
     });*/
  // Delete  Ad
  $(".delete_ad").on("click", function () {
    var id = $(this).attr("data-adid");
    $.confirm({
      title: get_strings.alt,
      content: get_strings.altMsg,
      buttons: {
        confirm: {
          text: get_strings.alertConfirm,
          action: function () {
            $("#sb_loading").show();
            $.post(carspot_ajax_url, {
              action: "sb_remove_ad",
              ad_id: id,
              security: $("#edit_post_nonce").val(),
            })
              .done(function (response) {
                $("#sb_loading").hide();
                var get_r = response.split("|");
                if ($.trim(get_r[0]) == "1") {
                  $("body")
                    .find("#holder-" + id)
                    .remove();
                  toastr.success(get_r[1], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                  location.reload();
                } else {
                  toastr.error(get_r[1], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                }
              })
              .fail(function () {
                $("#sb_loading").hide();
                toastr.error($("#nonce_error").val(), "", {
                  timeOut: 4000,
                  closeButton: true,
                  positionClass: "toast-top-right",
                });
              });
          },
        },
        Cancle: {
          text: get_strings.alertCancle,
          action: function () {},
        },
      },
    });
  });

  // My ads pagination
  $("body").on("click", ".sb_page", function () {
    $("#sb_loading").show();
    var this_action = "my_ads";
    if ($(this).attr("ad_type") == "yes") {
      this_action = "my_fav_ads";
    }
    $.post(carspot_ajax_url, {
      action: this_action,
      paged: $(this).attr("page_no"),
    }).done(function (response) {
      $("#sb_loading").hide();
      $("#carspot_res").html(response);
      $("body,html").animate(
        {
          scrollTop: 200,
        },
        scroll_top_duration
      );

      $(".posts-masonry").imagesLoaded(function () {
        $(".posts-masonry").isotope({
          layoutMode: "masonry",
          transitionDuration: "0.3s",
        });
      });
    });
  });
  // Load Messages
  $("body").on("click", ".get_msgs", function () {
    $("#sb_loading").show();
    $.post(carspot_ajax_url, {
      action: "sb_load_messages",
      ad_id: $(this).attr("ad_msg"),
    }).done(function (response) {
      $("#sb_loading").hide();
      $("#carspot_res").html(response);
      $(".message-details .list-wraps")
        .scrollTop(20000)
        .perfectScrollbar("update");
    });
  });

  var previous;

  // My ads pagination
  /*$('body').on('focus','.ad_status', function()
     {
     previous = this.value;
     }).on('change','.ad_status', function()
     {
     if( $(this).val() != "" )
     {
     if( confirm( $('#confirm_update').val() ) )
     {
     $('#sb_loading').show();
     $.post(carspot_ajax_url,	{action : 'sb_update_ad_status', ad_id:$(this).attr('adid'), status:$(this).val(),  }).done( function(response) 
     {
     $('#sb_loading').hide();
     var get_r	=	response.split( '|');
     if( $.trim(get_r[0]) == '1' )
     {
     toastr.success(get_r[1], '', {timeOut: 2500,"closeButton": true, "positionClass": "toast-top-right"});
     previous = this.value;
     $('.menu-name[sb_action="my_ads"]').get(0).click();
     }
     else
     {
     toastr.error(get_r[1], '', {timeOut: 2500,"closeButton": true, "positionClass": "toast-top-right"});
     }
     });
     }
     else
     {
     $(this).val(previous)
     }
     }
     
     });*/

  $(document).ready(function () {
    let phoneNumberVisible = false;

    $(".number").click(function (event) {
      event.preventDefault();
      const linkElement = $(this);
      const numberElement = linkElement.find(".phone-num");

      if (phoneNumberVisible) {
        // Dial the number (replace 'tel:' with 'callto:' if it's for desktop applications)
        window.location.href = "tel:" + linkElement.data("last");
      } else {
        // Show the phone number for reading
        numberElement.text(linkElement.data("last"));
        phoneNumberVisible = true;
      }
    });
  });

  $(".ad_status_new li").on("click", function () {
    var id = $(this).attr("data-adid");
    var ad_status = $(this).data("val");
    $.confirm({
      title: get_strings.alt,
      content: get_strings.altMsg,
      buttons: {
        confirm: {
          text: get_strings.alertConfirm,
          action: function () {
            $("#sb_loading").show();
            $.post(carspot_ajax_url, {
              action: "sb_update_ad_status",
              ad_id: id,
              status: ad_status,
              security: $("#edit_post_nonce").val(),
            })
              .done(function (response) {
                $("#sb_loading").hide();
                var get_r = response.split("|");
                if ($.trim(get_r[0]) == "1") {
                  toastr.success(get_r[1], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                  location.reload();
                } else {
                  toastr.error(get_r[1], "", {
                    timeOut: 2500,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                }
              })
              .fail(function () {
                $("#sb_loading").hide();
                toastr.error($("#nonce_error").val(), "", {
                  timeOut: 4000,
                  closeButton: true,
                  positionClass: "toast-top-right",
                });
              });
          },
        },
        cancel: {
          text: get_strings.alertCancle,
          action: function () {},
        },
      },
    });
  });

  // Add to Cart
  $("body").on("click", ".sb_add_cart", function () {
    $("#sb_loading").show();
    $.post(carspot_ajax_url, {
      action: "sb_add_cart",
      product_id: $(this).attr("data-product-id"),
      qty: $(this).attr("data-product-qty"),
      security: $("#package_nonce").val(),
    })
      .done(function (response) {
        $("#sb_loading").hide();
        var get_r = response.split("|");
        if ($.trim(get_r[0]) == "1") {
          toastr.success(get_r[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
          window.location = get_r[2];
        } else {
          toastr.error(get_r[1], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
          window.location = get_r[2];
        }
      })
      .fail(function () {
        $("#sb_loading").hide();
        toastr.error($("#nonce_error").val(), "", {
          timeOut: 4000,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      });
  });
  if ($("#is_sub_active").val() == "1") {
    $("[data-toggle=confirmation]").confirmation({
      rootSelector: "[data-toggle=confirmation]",
    });
  }

  if ($("#ad_description").length > 0) {
    $("#ad_description").jqte({
      link: false,
      unlink: false,
      formats: false,
      format: false,
      funit: false,
      fsize: false,
      fsizes: false,
      color: false,
      strike: false,
      source: false,
      sub: false,
      sup: false,
      indent: false,
      outdent: false,
      right: false,
      left: false,
      center: false,
      remove: false,
      rule: false,
      title: false,
    });
  }

  $("#sb_feature_ad").on("click", function () {
    $("#sb_loading").show();
    $.post(carspot_ajax_url, {
      action: "sb_make_featured",
      ad_id: $(this).attr("aaa_id"),
    }).done(function (response) {
      $("#sb_loading").hide();
      var get_r = response.split("|");
      if ($.trim(get_r[0]) == "1") {
        toastr.success(get_r[1], "", {
          timeOut: 2500,
          closeButton: true,
          positionClass: "toast-top-right",
        });
        location.reload();
      } else {
        toastr.error(get_r[1], "", {
          timeOut: 2500,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      }
    });
  });

  $(document).on("click", ".ad_title_show", function () {
    var cur_ad_id = $(this).attr("cid");
    $(".sb_ad_title").hide();
    $("#title_for_" + cur_ad_id).show();
  });

  if (
    $("#msg_notification_on").val() != "" &&
    $("#msg_notification_on").val() != 0 &&
    $("#msg_notification_time").val() != ""
  ) {
    setInterval(function () {
      $.post(carspot_ajax_url, {
        action: "sb_check_messages",
        new_msgs: $("#is_unread_msgs").val(),
      }).done(function (response) {
        var get_r = response.split("|");
        if ($.trim(get_r[0]) == "1") {
          toastr.success(get_r[1], "", {
            timeOut: 5000,
            closeButton: true,
            positionClass: "toast-bottom-left",
          });
          $("#is_unread_msgs").val(get_r[2]);
          $(".msgs_count").html(get_r[2]);
          $(".notify").html(
            '<span class="heartbit"></span><span class="point"></span>'
          );

          $.post(carspot_ajax_url, {
            action: "sb_get_notifications",
          }).done(function (notifications) {
            $(".message-center").html(notifications);
          });
        }
      });
    }, $("#msg_notification_time").val());
  }

  $(".dynamic-form-date-fields11").datepicker({
    timepicker: false,
    dateFormat: "yyyy-mm-dd",
    language: {
      days: [
        get_strings.Sunday,
        get_strings.Monday,
        get_strings.Tuesday,
        get_strings.Wednesday,
        get_strings.Thursday,
        get_strings.Friday,
        get_strings.Saturday,
      ],
      daysShort: [
        get_strings.Sun,
        get_strings.Mon,
        get_strings.Tue,
        get_strings.Wed,
        get_strings.Thu,
        get_strings.Fri,
        get_strings.Sat,
      ],
      daysMin: [
        get_strings.Su,
        get_strings.Mo,
        get_strings.Tu,
        get_strings.We,
        get_strings.Th,
        get_strings.Fr,
        get_strings.Sa,
      ],
      months: [
        get_strings.January,
        get_strings.February,
        get_strings.March,
        get_strings.April,
        get_strings.May,
        get_strings.June,
        get_strings.July,
        get_strings.August,
        get_strings.September,
        get_strings.October,
        get_strings.November,
        get_strings.December,
      ],
      monthsShort: [
        get_strings.Jan,
        get_strings.Feb,
        get_strings.Mar,
        get_strings.Apr,
        get_strings.May,
        get_strings.Jun,
        get_strings.Jul,
        get_strings.Aug,
        get_strings.Sep,
        get_strings.Oct,
        get_strings.Nov,
        get_strings.Dec,
      ],
      today: get_strings.Today,
      clear: get_strings.Clear,
      dateFormat: "mm/dd/yyyy",
      firstDay: 0,
    },
  });

  $(".date_time").datepicker({
    timepicker: true,
    dateFormat: "yyyy-mm-dd",
    language: {
      days: [
        get_strings.Sunday,
        get_strings.Monday,
        get_strings.Tuesday,
        get_strings.Wednesday,
        get_strings.Thursday,
        get_strings.Friday,
        get_strings.Saturday,
      ],
      daysShort: [
        get_strings.Sun,
        get_strings.Mon,
        get_strings.Tue,
        get_strings.Wed,
        get_strings.Thu,
        get_strings.Fri,
        get_strings.Sat,
      ],
      daysMin: [
        get_strings.Su,
        get_strings.Mo,
        get_strings.Tu,
        get_strings.We,
        get_strings.Th,
        get_strings.Fr,
        get_strings.Sa,
      ],
      months: [
        get_strings.January,
        get_strings.February,
        get_strings.March,
        get_strings.April,
        get_strings.May,
        get_strings.June,
        get_strings.July,
        get_strings.August,
        get_strings.September,
        get_strings.October,
        get_strings.November,
        get_strings.December,
      ],
      monthsShort: [
        get_strings.Jan,
        get_strings.Feb,
        get_strings.Mar,
        get_strings.Apr,
        get_strings.May,
        get_strings.Jun,
        get_strings.Jul,
        get_strings.Aug,
        get_strings.Sep,
        get_strings.Oct,
        get_strings.Nov,
        get_strings.Dec,
      ],
      today: get_strings.Today,
      clear: get_strings.Clear,
      dateFormat: "mm/dd/yyyy",
      firstDay: 0,
    },
  });

  function carspot_inputTags() {
    $("#tags").tagsInput({
      width: "100%",
      height: "5px;",
      defaultText: "",
    });

    $(".dynamic-form-date-fields").datepicker({
      timepicker: false,
      dateFormat: "yyyy-mm-dd",
      language: {
        days: [
          get_strings.Sunday,
          get_strings.Monday,
          get_strings.Tuesday,
          get_strings.Wednesday,
          get_strings.Thursday,
          get_strings.Friday,
          get_strings.Saturday,
        ],
        daysShort: [
          get_strings.Sun,
          get_strings.Mon,
          get_strings.Tue,
          get_strings.Wed,
          get_strings.Thu,
          get_strings.Fri,
          get_strings.Sat,
        ],
        daysMin: [
          get_strings.Su,
          get_strings.Mo,
          get_strings.Tu,
          get_strings.We,
          get_strings.Th,
          get_strings.Fr,
          get_strings.Sa,
        ],
        months: [
          get_strings.January,
          get_strings.February,
          get_strings.March,
          get_strings.April,
          get_strings.May,
          get_strings.June,
          get_strings.July,
          get_strings.August,
          get_strings.September,
          get_strings.October,
          get_strings.November,
          get_strings.December,
        ],
        monthsShort: [
          get_strings.Jan,
          get_strings.Feb,
          get_strings.Mar,
          get_strings.Apr,
          get_strings.May,
          get_strings.Jun,
          get_strings.Jul,
          get_strings.Aug,
          get_strings.Sep,
          get_strings.Oct,
          get_strings.Nov,
          get_strings.Dec,
        ],
        today: get_strings.Today,
        clear: get_strings.Clear,
        dateFormat: "mm/dd/yyyy",
        firstDay: 0,
      },
    });
  }

  //Mileage
  if ($("#get_mileage").length > 0) {
    $("#get_mileage")
      .parsley()
      .on("field:validated", function () {
        var ok = $(".parsley-error").length === 0;
      })
      .on("form:submit", function () {
        $("#sb_loading").show();
        return true;
      });
  }

  /*// Rate User */
  if ($("#user_ratting_form").length > 0) {
    $("#user_ratting_form")
      .parsley()
      .on("field:validated", function () {
        var ok = $(".parsley-error").length === 0;
      })
      .on("form:submit", function () {
        // Ajax for Registration
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "sb_post_user_ratting",
          sb_data: $("form#user_ratting_form").serialize(),
          security: $("#rating_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();

            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) != "0") {
              toastr.success(res_arr[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              window.location.reload(true);
            } else {
              toastr.error(res_arr[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });

        return false;
      });
  }

  /*// Replay to Rator */
  if ($(".sb-reply-rating-form").length > 0) {
    $(".sb-reply-rating-form").on("click", function () {
      var comment_id = $(this).attr("data-commentid");
      var comment_reply_text = $(".review-reply-" + comment_id).val();
      $(this)
        .parsley()
        .on("field:validated", function () {
          var ok = $(".parsley-error").length === 0;
        })
        .on("form:submit", function () {
          /*Ajax for Rating Reply*/
          $("#sb_loading").show();
          $.post(carspot_ajax_url, {
            action: "sb_reply_user_rating",
            cid: comment_id,
            reply_text: comment_reply_text,
            security: $("#rating_reply_nonce").val(),
          })
            .done(function (response) {
              $("#sb_loading").hide();

              var res_arr = response.split("|");
              if ($.trim(res_arr[0]) != "0") {
                toastr.success(res_arr[1], "", {
                  timeOut: 2500,
                  closeButton: true,
                  positionClass: "toast-top-right",
                });
                window.setTimeout(function () {
                  window.location.reload(true);
                }, 1000);
              } else {
                toastr.error(res_arr[1], "", {
                  timeOut: 2500,
                  closeButton: true,
                  positionClass: "toast-top-right",
                });
              }
            })
            .fail(function () {
              $("#sb_loading").hide();
              toastr.error($("#nonce_error").val(), "", {
                timeOut: 4000,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            });
          return false;
        });
    });
  }

  $(".clikc_reply").on("click", function () {
    $("#rator_name").html($(this).attr("data-rator-name"));
    $("#rator_reply").val($(this).attr("data-rator-id"));
  });

  /* Bidding System  */
  /*// Replay to Rator */
  if ($("#sb_bid_ad").length > 0) {
    $("#sb_bid_ad")
      .parsley()
      .on("field:validated", function () {
        var ok = $(".parsley-error").length === 0;
      })
      .on("form:submit", function () {
        // Ajax for Registration
        $("#sb_loading").show();
        $.post(carspot_ajax_url, {
          action: "sb_submit_bid",
          sb_data: $("form#sb_bid_ad").serialize(),
          security: $("#bidding_nonce").val(),
        })
          .done(function (response) {
            $("#sb_loading").hide();

            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) != "0") {
              toastr.success(res_arr[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
              location.reload();
            } else {
              toastr.error(res_arr[1], "", {
                timeOut: 2500,
                closeButton: true,
                positionClass: "toast-top-right",
              });
            }
          })
          .fail(function () {
            $("#sb_loading").hide();
            toastr.error($("#nonce_error").val(), "", {
              timeOut: 4000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          });

        return false;
      });
  }

  var $scrollbar = $(".bidding");
  $scrollbar.perfectScrollbar({
    maxScrollbarLength: 150,
  });
  $scrollbar.perfectScrollbar("update");

  $("form.custom-search-form select").on("select2:select", function (e) {
    $("#sb_loading").show();
    $(this).closest("form").submit();
    $("#sb_loading").hide();
  });

  /* For Cart Buttons */
  $("div.select-package a").on("click", function (e) {
    $("#sb_loading").show();
    var adonId = $(this).attr("data-adon-id");
    var ajax_url = $("input#carspot_ajax_url").val();
    $.post(carspot_ajax_url, {
      action: "carspot_add_ad_adons",
      adon_id: adonId,
      security: $("#pay_per_post_nonce").val(),
    })
      .done(function (response) {
        $("#sb_loading").hide();
        var res_arr = response.split("|");
        if ($.trim(res_arr[0]) == 1) {
          toastr.success(res_arr[2], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
          $("#sb-quick-cart-price").html(res_arr[4]);
        } else {
          toastr.error(res_arr[2], "", {
            timeOut: 2500,
            closeButton: true,
            positionClass: "toast-top-right",
          });
          $("#sb-quick-cart-price").html(res_arr[4]);
        }

        $("div.select-package a[data-adon-id=" + res_arr[1] + "]").html(
          res_arr[3]
        );
      })
      .fail(function () {
        $("#sb_loading").hide();
        toastr.error($("#nonce_error").val(), "", {
          timeOut: 4000,
          closeButton: true,
          positionClass: "toast-top-right",
        });
      });
  });

  var is_category_based = $("#is_category_based").val();

  function getCustomTemplate(ajax_url, catId, updateId, is_top) {
    /*For Category Templates*/
    $.post(ajax_url, {
      action: "sb_get_sub_template",
      cat_id: catId,
      is_update: updateId,
    }).done(function (response) {
      if ($.trim(response) != "") {
        $("#dynamic-fields").html(response);
        $(".skin-minimal .list li input").iCheck({
          checkboxClass: "icheckbox_minimal",
          radioClass: "iradio_minimal",
          increaseArea: "20%",
        });
        $("#dynamic-fields select").select2();
        if ($("#input__type").val() == 1) {
          // sbDropzone_image();
        }
        sbDropzone_image();
        carspot_inputTags();
      }
      $("#sb_loading").hide();
      if (is_category_based == 1) {
        if (is_top) {
          $.post(carspot_ajax_url, {
            action: "sb_get_car_total",
          }).done(function (cartTotal) {
            $("#sb-quick-cart-price").html(cartTotal);
          });
        }
      }
    });

    /*For Category Templates*/
  }

  $(document).on("change", "#ad_price_type", function () {
    if (
      this.value == "on_call" ||
      this.value == "free" ||
      this.value == "no_price"
    ) {
      $("#ad_price").attr("data-parsley-required", "false");
      $("#ad_price").val("");
      $("#ad_price").parent("div").hide();
    } else {
      $("#ad_price").attr("data-parsley-required", "true");
      $("#ad_price").parent("div").show();
    }
  });

  /*
   *
   * validate int on Average in Highway
   */
  $("#ad_avg_hwy").on("keypress keyup blur", function (event) {
    $(this).val(
      $(this)
        .val()
        .replace(/[^\d].+/, "")
    );
    if (event.which < 48 || event.which > 57) {
      event.preventDefault();
    }
  });
  /*
   *
   * validate int on Average in City
   */
  $("#ad_avg_city").on("keypress keyup blur", function (event) {
    $(this).val(
      $(this)
        .val()
        .replace(/[^\d].+/, "")
    );
    if (event.which < 48 || event.which > 57) {
      event.preventDefault();
    }
  });
  /*
   *
   * validate int on Average in Milage
   */
  $("#ad_mileage").on("keypress keyup blur", function (event) {
    $(this).val(
      $(this)
        .val()
        .replace(/[^\d].+/, "")
    );
    if (event.which < 48 || event.which > 57) {
      event.preventDefault();
    }
  });

  //=================
  /*
   * category filter on search-form-2 shortcode
   */
  $("#make_id_2").on("change", function () {
    $("#sb_loading").show();
    $("#select_modal_2").hide();
    $("#select_modals_2").hide();
    $("#select_forth_div_2").hide();
    var cat_ss_id = $("#make_id_2").val();
    var filter_select_class = "no-class";
    $("input[name=cat_id]").val(cat_ss_id);
    $.post(carspot_ajax_url, {
      action: "sb_get_sub_cat_search",
      cat_id: cat_ss_id,
      filter_class: filter_select_class,
    }).done(function (response) {
      $("#sb_loading").hide();
      $("#select_modal_2").show();
      $("#select_modal_2").html(response);
      $("select").select2({
        placeholder: $("#select_place_holder").val(),
        allowClear: false,
        width: "100%",
      });
    });
  });
  //for first child category
  $(document).on("change", "#cats_response", function () {
    $("#sb_loading").show();
    $("#select_modals_2").hide();
    $("#select_forth_div_2").hide();
    var cat_s_id = $("#cats_response").val();
    var filter_select_class = "no-class";
    $("input[name=cat_id]").val(cat_s_id);
    $.post(carspot_ajax_url, {
      action: "sb_get_sub_sub_cat_search",
      cat_id: cat_s_id,
      filter_class: filter_select_class,
    }).done(function (response) {
      $("#sb_loading").hide();
      $("#select_modals_2").show();
      $("#select_modals_2").html(response);
      $("select").select2({
        placeholder: $("#select_place_holder").val(),
        allowClear: false,
        width: "100%",
      });
    });
  });
  //for second child category
  $(document).on("change", "#select_version", function () {
    $("#sb_loading").show();
    $("#select_forth_div_2").hide();
    var cat_s_id = $("#select_version").val();
    var filter_select_class = "no-class";
    $("input[name=cat_id]").val(cat_s_id);
    $.post(carspot_ajax_url, {
      action: "sb_get_sub_sub_sub_cat_search",
      cat_id: cat_s_id,
      filter_class: filter_select_class,
    }).done(function (response) {
      $("#sb_loading").hide();
      $("#select_forth_div_2").show();
      $("#select_forth_div_2").html(response);
      $("select").select2({
        placeholder: $("#select_place_holder").val(),
        allowClear: false,
        width: "100%",
      });
    });
  });
  //for 3rd child category
  $(document).on("change", "#select_forth", function () {
    var cat_s_id = $("#select_forth").val();
    $("input[name=cat_id]").val(cat_s_id);
  });

  //==================
})(jQuery);

jQuery(document).ready(function ($) {
  $("#comparison_button").trigger("click");
  $("#ad_price_type").trigger("change");
});

function carspot_validateEmail(sEmail) {
  var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
  if (filter.test(sEmail)) {
    return true;
  } else {
    return false;
  }
}

function carspot_select_msg(cid, second_user, prnt) {
  alert("here");
  jQuery(document).find(".messages_actions").removeClass("active");
  jQuery(document).find("#receive_messages").addClass("active");
  jQuery(".message-history-active").removeClass("message-history-active");
  jQuery(document)
    .find("#" + second_user + "_" + cid)
    .html("");
  jQuery(document)
    .find("#sb_" + second_user + "_" + cid)
    .addClass("message-history-active");
  jQuery("#sb_loading").show();

  jQuery
    .post(jQuery("#carspot_ajax_url").val(), {
      action: "sb_get_messages",
      ad_id: cid,
      user_id: second_user,
      receiver: second_user,
      inbox: prnt,
    })
    .done(function (response) {
      jQuery("#usr_id").val(second_user);
      jQuery("#rece_id").val(second_user);
      jQuery("#msg_receiver_id").val(second_user);
      jQuery("#ad_post_id").val(cid);
      jQuery("#sb_loading").hide();
      jQuery("#messages").html(response);
    });
}

/* Sticky Menu Option */
var is_stick = jQuery("#is_sticky_header").val();
if (is_stick == 1) {
  jQuery(window).scroll(function () {
    var limit = 200;
    if (jQuery(this).scrollTop() >= limit) {
      jQuery(".mega-menu").addClass("desktopTopFixed");
    } else {
      jQuery(".mega-menu").removeClass("desktopTopFixed");
    }
  });
}
carspot_timerCounter_function();

function profile_badge_function() {
  jQuery(document).ready(function ($) {
    $("#profile-badge-btn").click(function () {
      var ajax_url = $("#carspot_ajax_url").val();
      $.confirm({
        title: "Are You sure",
        icon: "fa fa-question-circle",
        theme: "supervan",
        animation: "scale",
        closeIcon: false,
        content: get_strings.content,
        closeAnimation: "scale",
        type: "green",
        buttons: {
          confirm: {
            text: get_strings.ok,
            action: function () {
              $.post(ajax_url, {
                action: "user_form_submission",
              }).done(function (response) {
                if (response.data.success) {
                  var message = response.data.message;
                  toastify(message, "#235b1c");
                  var cartUrl = response.data.cartUrl;
                  window.location.href = `${cartUrl}`;
                } else {
                  var message = response.data.message;
                  toastify(message, "#E52D27");
                  // alert(response.data.message);
                }
                //www.yourwebsite.com/checkout/?add-to-cart=ID
                https: $(".delete-button-" + key).button("reset");
                $(el).closest("tr").css("background", "tomato");
                $(el)
                  .closest("tr")
                  .fadeOut(800, function () {
                    $(this).remove();
                  });
              });
            },
          },
          cancle: {
            text: get_strings.cancle,
            // action: function () {
            //   $(".delete-button-" + key).button("reset");
            // },
          },
        },
      });
      return false;
    });
  });
}

profile_badge_function();

function toastify(message, bgColor) {
  var toast = jQuery('<div class="toast">' + message + "</div>");

  // Add styling to the toast
  toast.css({
    position: "fixed",
    // upper: "10px",
    right: "20px",
    background: bgColor,
    color: "#fff",
    padding: "10px",
    borderRadius: "5px",
  });

  // Append the toast to the body
  jQuery(".toast-container").append(toast);

  // Set a timeout to remove the toast after the specified duration
  setTimeout(function () {
    toast.fadeOut("slow", function () {
      toast.remove();
    });
  }, 3000);
}
