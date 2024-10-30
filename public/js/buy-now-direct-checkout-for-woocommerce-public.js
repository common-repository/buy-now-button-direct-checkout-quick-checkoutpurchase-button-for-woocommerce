(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
  $(window).load(function () {
    $(document).on("click", ".button-buy-now", function (e) {
      $(this).prop("disabled", true);
      $(this).addClass("button-buy-now-loading");
      var buy_now_cart_form = $(this).closest("form.cart");
      var buy_now_product_id = -1;
      buy_now_product_id = buy_now_cart_form.find("[name='add-to-cart']").val();
      if (buy_now_product_id > 0) {
        var buy_now_variation_id = -1;
        if (buy_now_cart_form.find("input[name=variation_id]")) {
          buy_now_variation_id = buy_now_cart_form
            .find("input[name=variation_id]")
            .val();
        }
        var buy_now_quantity = buy_now_cart_form
          .find("input[name=quantity]")
          .val();
        var buy_now_data = {
          action: "buy_now_direct_checkout_woocommerce_buy_now_click",
          cache: false,
          product_id: buy_now_product_id,
          quantity: buy_now_quantity,
          buy_now_nonce: buyNowJsVars.buy_now_nonce,
        };
        if (buy_now_variation_id > 0) {
          buy_now_data.variation_id = buy_now_variation_id;
        }
        //console.log('buy now form data : ',buy_now_data);

        $.post(buyNowJsVars.ajax_url, buy_now_data, function (response) {
          if (response.success) {
            window.location.href = response.data.checkout_url;
          } else {
            $(e.target).removeClass("button-buy-now-loading");
            $(e.target).prop("disabled", false);
            alert(response.data);
          }
        }).fail(function (response) {
          $(e.target).removeClass("button-buy-now-loading");
          $(e.target).prop("disabled", false);
          alert(
            "An error occurred while submitting the request, Please try again."
          );
        });
      }
    });
    $(".variation_id").change(function (e) {
      if (
        e.target.value == null ||
        e.target.value == undefined ||
        e.target.value == ""
      ) {
        $(this).prop("disabled", true);
        $(this)
          .closest("form.cart")
          .find("button.button-buy-now")
          .addClass("disabled");
      } else {
        $(this).prop("disabled", false);
        $(this)
          .closest("form.cart")
          .find("button.button-buy-now")
          .removeClass("disabled");
      }
    });
    if ($(".variation_id") !== null) {
      var vId = $(".variation_id").val();
      if (vId !== null && vId !== undefined && vId > 0) {
        $(".button.button-buy-now").removeClass("disabled");
      }
    }
    var buy_now_nonce_data = {
      action: "buy_now_direct_checkout_woocommerce_get_buy_now_nonce",
      cache: false,
      buy_now_nonce: buyNowJsVars.buy_now_nonce,
    };
    $.post(buyNowJsVars.ajax_url, buy_now_nonce_data, function (response) {
      if (response.success) {
        buyNowJsVars.buy_now_nonce = response.data.buy_now_nonce;
      } else {
        alert(response.data);
      }
    }).fail(function (response) {
      alert(
        "An error occurred while submitting the request, Please try again."
      );
    });
  });
})(jQuery);
