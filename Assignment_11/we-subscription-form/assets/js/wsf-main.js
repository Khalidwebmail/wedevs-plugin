(function ($) {
  $(document).ready(function () {
    $("#wsf_widget_form").on("submit", function (e) {
      e.preventDefault();
      let self = $(this);
      let id = $("#wsf_subscribe").data("id");
      let formValue = $("#wsf_subscribe").val();

      if ("" === formValue) {
        alert("Sorry, please provide a valid email address");
        $("#wsf_subscribe").css("border", "2px solid #f00").focus();
        $("#wsf_subscribe").keypress(function (e) {
          $(this).css("border", "3px solid #000");
        });
        return;
      }

      let formData = self.serialize();

      let data = {
        action: "submit_subscriber",
        audience_id: id,
        data: formData,
        nonce: wsfobj.nonce,
      };

      $.post(wsfobj.ajax_url, data)
        .done(function (response) {
          self.trigger("reset");
          alert(response.data.message);
        })
        .fail(function (error) {
          console.log(error);
        });
    });

    //Validate email
    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }
  });
})(jQuery);
