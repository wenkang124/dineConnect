$(document).on('click', '.delete-btn', function (event) {
    var that = this;
    event.preventDefault();

    bootbox.hideAll();

    var url = $(this).attr("href");

    bootbox.confirm($(that).data('confirm'), function(result){
        if(result){
            $.ajax({
                method: "POST",
                url: url,
                // data: { _token: "{{ csrf_token() }}" },
            })
            .done(function( data ) {
                if(data.success){
                    window.location.href = $(that).data('redirect');
                }else{
                    bootbox.alert(data.message);
                }

            });

        }
    });

});