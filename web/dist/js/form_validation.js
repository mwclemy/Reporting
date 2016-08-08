$(document).ready(function (e) {


    $("#loginForm").submit(function (e) {
        var fullnameLen = $("#fname").val().length < 1;
        var contactLen = $("#contact").val().length < 1;
        var locationLen = $("#location").val().length < 1;
        var packageLen = $("#package").val().length < 1;
       // var NewpackageLen = $("#npack").val().length < 1;
        if (fullnameLen || contactLen || locationLen || packageLen  ) {
            $("#fn").html(fullnameLen ? "Full Name required" : "").css("color", "red");
            $("#cc").html(contactLen ? "Contact required" : "").css("color", "red");
            $("#loc").html(locationLen ? "Location required" : "").css("color", "red");
            $("#pack").html(packageLen ? "Package required" : "").css("color", "red");
           
            // $("#np").html(packageLen ? "New Package required" : "").css("color", "red");
            e.preventDefault();
        }
    });

    $.ajax({
        type: "POST",
        url: "test.php",
        data: {"id": "tech"},
        success: function (data) {
            var opts = $.parseJSON(data);
            $.each(opts.technology, function (i, d) {

                $('#tech').append('<option value="' + opts.technology[i].name + '">' + opts.technology[i].name + '</option>');

            });

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " " + thrownError);
        }
    });

    $.ajax({
        type: "POST",
        url: "test.php",
        data: {"id": "service"},
        success: function (data) {
            var opts = $.parseJSON(data);
            $.each(opts.services, function (i, d) {

                $('#service').append('<option value="' + opts.services[i].name + '">' + opts.services[i].name + '</option>');

            });

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " " + thrownError);
        }
    });

    function check()
    {

        var pass1 = document.getElementById('contact');


        var message = document.getElementById('cc');

        var goodColor = "white";
        var badColor = "red";

        if (pass1.value.length !== 10) {

            pass1.style.backgroundColor = goodColor;
            message.style.color = badColor;
            message.innerHTML = "required 10 digits";
        }
        else {
            message.innerHTML = "";
            pass1.style.backgroundColor = goodColor;
            message.style.color = goodColor;
        }
    }

    $(document).on("keyup blur input", "#contact", function (e) {

        check();
    });
});


