function refresh(){
    $.ajax({
        type: "GET",
        url: "php/profile.php",
        success: function (response) {
          console.log(response);
          response = JSON.parse(response);
          $("#firstname").text(response.firstname);
          $("#lastname").text(response.lastname);
          $('#mobileno').text(response.mobileno);
          $('#dob').text(response.dob);
          $('#address').text(response.address);
          $('#district').text(response.district);
          $('#pincode').text(response.pincode);
          $('#username').text(response.firstname);
        },
        error: function (xhr, status, error) {
          console.error("AJAX request failed: " + status + ", " + error);
        },
      });
}



$(document).ready(function () {
  $("#socialmedia").submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "php/profile1.php",
      data: $(this).serialize() + "&action=socialmedia", // Include action parameter
      success: function (response) {
        $("#profile")[0].reset();
        $.notify("Social media data updated successfully", "success");
      },
      error: function (error) {
        console.error(error);
      },
    });
  });
});


$(document).ready(function () {
  $("#profile").submit(function (event) {
    event.preventDefault();
    console.log("hu");
    $.ajax({
      type: "POST",
      url: "php/profile1.php",
      data: $(this).serialize() + "&action=profile", 
      success: function (response) {
        refresh();
        $("#target2").modal("hide");  
        $("#profile")[0].reset();
        $.notify("Profile data updated successfully", "success");
      },
      error: function (error) {
        console.error(error);
      },
    });
  });
});

// $(document).ready(function () {
//     $("#login").submit(function (e) {
//       e.preventDefault();
//       var formData = $(this).serialize();
//       $.ajax({
//         type: "POST",
//         url: "php/profile.php",
//         data: formData,
//         dataType: "json",
//         success: function (response) {
//           console.log(response);
//           if (response && typeof response === "object") {
//             console.log("User ID: " + response.id);
//             console.log("User Name: " + response.name);
//             console.log("User Email: " + response.email);
//             $("#name").text(response.name);
//             window.location.href = "profile.html";
//           } else {
//             console.error("Login failed: " + response.error);
//           }
//         },
//
//       });
//     });
//   });



$(document).ready(function () {
    

    
  $("#logoutbutton").click(function (e) {
      e.preventDefault();

     
      $.ajax({
          type: "POST",
          url: "php/profile.php",
          data: { logout: true }, 
          dataType: "json",
          success: function (response) {
              console.log("Logout Success:", response);
              if (response.success) {
                  window.location.replace("login.html");
              } else {
                  console.error("Logout failed:", response.error);
              }
          },
          error: function (xhr, status, error) {
              console.error("AJAX Error:", xhr.responseText);
          }
      });
  });






$(document).ready(function () {
refresh();
})
});


$(document).ready(function () {
  $.ajax({
      type: "GET",
      url: "php/profile.php",
      success: function (response) {
          $("#username").text(response.firstname + ' ' + response.lastname);
      },
      error: function (xhr, status, error) {
          console.error("AJAX request failed: " + status + ", " + error);
      }
  });
});

