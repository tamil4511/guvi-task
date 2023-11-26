$(document).ready(function() {
    console.log("1");
    $('#register').submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'php/register.php',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                if (response.status == 400) {
                    $('#register')[0].reset();
                    $.notify("Registered Successfully", "success");
                    window.location.href = 'login.html';
                } else {
                    $.notify(response.message, "error");
                    // Handle other statuses or errors as needed
                }
            },
            error: function(error) {
                console.log("Error:", error);
            }
        });
    });
});
