(function ($) {
  $(document).ready(function () {
    let error_container = $("#wcfn_error_messagebox");

    $("#wcf_form").on("submit", function (e) {
      e.preventDefault();
      let self = $(this);
      let data = "";

      let wcfn_name = $("#wcfn_name");
      let wcfn_email = $("#wcfn_email");
      let wcfn_message = $("#wcfn_message");

      let validName = validateInput(wcfn_name.val());
      let validMessage = validateInput(wcfn_message.val());
      let validEmail = validateEmail(wcfn_email.val());

      showError();

      if (validName && validMessage && validEmail) {
        data = self.serialize();

        $.post(wcfnobj.ajax_url, {
          action: "wcfn_handle_form_request",
          nonce: wcfnobj.nonce,
          data: data,
        })
          .done(function (response) {
            self.trigger("reset");
            error_container.text(response.data.message).css({
              border: "1px solid #000",
              padding: "5px",
              textAlign: "center",
            });
          })
          .fail(function (error) {
            console.log(error);
          });
      }

      function showError() {
        if (false === validName) {
          wcfn_name
            .css("border", "3px solid red")
            .attr("placeholder", "Please provide a valid name");
        } else {
          wcfn_name.css("border", "3px solid #000");
        }
        if (false === validMessage) {
          wcfn_message
            .css("border", "3px solid red")
            .attr("placeholder", "Please provide a message");
        } else {
          wcfn_message.css("border", "3px solid #111");
        }
        if (false === validEmail) {
          wcfn_email
            .css("border", "3px solid red")
            .attr("placeholder", "Please provide a valid email");
        } else {
          wcfn_email.css("border", "3px solid #000");
        }
      }
    });

    function validateInput(value) {
      if ("" === value || value.length < 3) {
        return false;
      }
      return $.trim(value);
    }

    function validateEmail(email) {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }
  });
})(jQuery);
