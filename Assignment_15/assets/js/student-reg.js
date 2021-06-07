(function ($) {
  $(document).ready(function () {
    //material contact form animation
    $(".we-contact-form")
      .find(".we-form-control")
      .each(function () {
        var targetItem = $(this).parent();
        if ($(this).val()) {
          $(targetItem).find("label").css({
            top: "10px",
            fontSize: "14px",
          });
        }
      });
    $(".we-contact-form")
      .find(".we-form-control")
      .focus(function () {
        $(this).parent(".input-block").addClass("focus");
        $(this).parent().find("label").animate(
          {
            top: "10px",
            fontSize: "14px",
          },
          300
        );
      });
    $(".we-contact-form")
      .find(".we-form-control")
      .blur(function () {
        if ($(this).val().length == 0) {
          $(this).parent(".input-block").removeClass("focus");
          $(this).parent().find("label").animate(
            {
              top: "25px",
              fontSize: "18px",
            },
            300
          );
        }
      });
  });
})(jQuery);
