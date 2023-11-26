$(document).ready(function() {
    console.log("1");
    $('#login').submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'php/login.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $('#login')[0].reset();
                if (response.status === 422) {
                    $.notify(response.message, "success");
                    console.log("User ID: " + response.userId);
                    console.log("User Name: " + response.userName);
                    console.log("User Email: " + response.userEmail);
                    $.notify("Profile data updated successfully", "success");
                    window.location.href = 'profile.html';
                } else if (response.status === 404) {
                    window.location.href = 'login.html';
                    $.notify(response.message, "danger");
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
