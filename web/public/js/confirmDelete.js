window.onload = function () {
    $('.text-danger').on('click', function (e) {
        if (!confirm('Are you sure you want to delete this question?')) {
            console.log("canceled");
            e.preventDefault();
        }
    });
};

