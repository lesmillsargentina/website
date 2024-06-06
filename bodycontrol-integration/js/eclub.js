$ = jQuery;

$(function () {

    //this is a check for WordPress because wp download the script always.
    if ($("#configInitEclubScript").val() != "true") {
        return;
    }

    $("#stepInit input").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            submitLogin();
        }
    });

    $(".programs a").click(navigateToProgram);
    $(".eclubimage").click(requestToImageServer);

    showStepInit();
    preventExit();

    $("#continueInit").click(submitLogin);

});

/*
preventExit = function () {
    var message = '¿Está seguro que desa salir de está página?';
    window.onbeforeunload = function salir(e) {
        var evtobj = window.event ? event : e;

        if (evtobj == e) {
            //firefox
            if (!evtobj.clientY) {
                evtobj.returnValue = message;
            }
        } else {

            if (evtobj.clientY < 0) {

                evtobj.returnValue = message;

            }
        }
    }

};
*/
showStepInit = function () {
    $(".eclubStep").hide();
    $("#stepInit").show();
    $("#userName").val("");
    $("#password").val("");
};

submitLogin = function () {

    if ($("#userName").val() == "") {
        $("#userNameError").show();
        $("#userNameError").html("*Complete el usuario.");
        return;
    } else {
        $("#userNameError").hide();
    }


    if ($("#password").val() == "") {
        $("#passwordError").show();
        $("#passwordError").html("*Complete la contraseña.");
        return;
    } else {
        $("#passwordError").hide();
    }

    var parameter = {
        user: $("#userName").val(),
        password: $("#password").val()
    };

    $("#waiting-strategy").show();
    $.ajax({
        url: bodyControlURL + "/webEclub/ajaxGetPermissions",
        dataType: "jsonp",
        data: parameter,
        success: function (response) {
            if (response.isValid == "-1") {
                $("#passwordError").show();
                $("#passwordError").html("El usuario o la contraseña son incorrectos.");

            } else if (response.isValid == "0") {
                //login is good, next call.
                showEclub(response);
            }
            $("#waiting-strategy").hide();

        },
        error: function (data) {
            $("#waiting-strategy").hide();
            alert('Se produjo un error vuela a intentar más tarde');
        }

    });

};


showEclub = function (response) {
    $("#token").val(response.token);
    $("#activePrograms").val(response.programs);
    $("#gymId").val(response.gymId);

    var arPrograms = response.programs.split(",");
    var i = 0;
    $(".programs a").hide();
    $(".programAlbum").hide();

    //show programs links and programAlbum
    $(".ALL").show();
    $(".programs .ALL").addClass("redText");
    //show available links
    for (i = 0; i < arPrograms.length; i++) {
        $(".programs ." + arPrograms[i]).show();
    }

    $(".eclubStep").hide();
    $("#stepEclub").show();

};

navigateToProgram = function () {

    $(".programAlbum").hide();
    $(".programs a").removeClass("redText");
    $("#albums ." + $(this).attr("data-program-code")).show();
    $(this).addClass("redText");
};


requestToImageServer = function () {
    downloadURL(
        eclubFullImageServer +
        "/webGetImage.php?" +
        "program=" + $(this).attr("data-program-code") +
        "&imagename=" + $(this).attr("data-imageserver") +
        "&gymId=" + encodeURIComponent($("#gymId").val()) +
        "&token=" + encodeURIComponent($("#token").val())
    );
};


downloadURL = function (url) {
    var hiddenIFrameID = 'hiddenDownloader',
        iframe = document.getElementById(hiddenIFrameID);
    if (iframe === null) {
        iframe = document.createElement('iframe');
        iframe.id = hiddenIFrameID;
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
    }
    iframe.src = url;
};

