(function ($) {
  $(document).ready(function () {
    let save_button = $("#wrp_save");

    $("#wrp_dashboard_form").on("submit", function (e) {
      e.preventDefault();
      save_button.prop("disabled", true);
      let self = $(this);
      let data = self.serialize();

      $.post(wrpobj.ajax_url, {
        action: "handle_dashboard_form",
        nonce: wrpobj.nonce,
        data: data,
      })
        .done(function (response) {
          save_button.prop("disabled", false);
          location.reload();
        })
        .fail(function (error) {
          console.log(error);
        });
    });
  });
})(jQuery);
