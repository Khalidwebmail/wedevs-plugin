;(function($) {

    $('.rating').betterRating();

    $(document).on('click', '.fa-star', function(){
        
        var self = $(this);
        var rating = self.data('rate');
        var nonce = $("#_wpnonce").val();
        var id = $("#post-id").val();

        $.ajax({
            type: "POST",
            url: ratingJs.url,
            data: {id: id, rating: rating, action: 'book_review', nonce: nonce },
            success: function(response){
                if (response.success) {
                    self.siblings('.message').text(response.data.message);
                }else{
                    self.siblings('.message').text(response.data.message);                   
                }
            },
            error: function(){
                self.siblings('.message').text(ratingJs.error);
            }
        });

    });
    
})(jQuery);
