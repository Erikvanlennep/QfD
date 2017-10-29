window.onload = function () {
    $('.text-danger').on('click', function (e) {
        if (!confirm('Are you sure you want to delete this question?')) {
            console.log("canceled");
            e.preventDefault();
        }
    });

    $('.switchForAdmin').on('click', function (e) {
        // e.preventDefault();

        console.log("Update user Role");

        var URL = $(this).attr('href');
        var $developerId = $(this).attr("#data-id");

        $.post(URL, {
            // Your post data here, if any
        }).done(function(response){

            alert("Updated userprofile: " + response);
        }).error(function(){
            alert("Couldn't update the userprofile. Something went wrong");
        });
    });



    $('#searchForQuestion2').on('click', function (e) {
        e.preventDefault();

        var value = $('#searchForQuestions').val();
        var URL = '/search/' + value;


        if( !value ) {
            console.log(URL);
            $('#searchForQuestions').parents('div').addClass('has-warning');
            return;
        }

        $.post(URL, {
            // Your post data here, if any
        }).done(function(response){
            template = response;
            $('#main_info').html(response);
            // alert("Updated userprofile: " + response);
        }).error(function(){
            // alert("Couldn't update the userprofile. Something went wrong");
        });
    });
};