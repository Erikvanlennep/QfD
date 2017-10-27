window.onload = function () {
    $('#switchForAdmin').on('click', function (e) {
        e.preventDefault();

        console.log("Update user Role");

        $.ajax({
            type: "POST",
            // Routing.generate = install fosjsroutingbundle
            url: Routing.generate('the_route_of_your_contoller'),
            data: DATA,
            cache: false,
            success: function(data){
                alert("database has been updated");

            }
        });
    });


};