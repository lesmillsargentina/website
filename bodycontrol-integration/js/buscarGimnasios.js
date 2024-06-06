$ = jQuery;

$(function () {
    $(document).ready(function () {
        $('#gymsGrid').fixheadertable({
            colratio: [16, 240, 410, 240],
            height: 300,
            width: 928,
            zebra: true,
            sortable: true,
            resizeCol: false,
            pager: false,
            rowsPerPage: 10,
            sortType: ['string', 'string', 'string', 'integer'],
        });
    });

    //this is a check for WordPress because wp download the script always.
    if ($("#configInitSearchGymsScript").val() != "true") {
        return;
    }

    $("#operationalAddressSearch").val("");

    $("#token").val("");
    $("#activePrograms").val("");
    $("#gymId").val("");

    $(".programSelection").removeAttr("checked");
    $("#selectAllCheckbox").removeAttr("checked");
    $(".criteriaInput:checked").removeAttr("checked");
    $("#searchCriteriaGyms").attr("checked", "checked");

    LoadNestedGridFunctionality();
    LoadRegionsAutoComplete("#operationalAddressSearch", "#operationalAddressSearchCheck", "#operationalAddressCountry",
        "#operationalAddressState", "#operationalAddressCity", "#operationalAddressLocality");

    $(".tablesorter").tablesorter();

    $("form input").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            submitForm();
        }
    });

    $("#search").click(function () {
        submitForm();
    });

    $("#eclubShowAccess").click(function () {
        if (( $("#eclubFields").css("display") == "none")) {
            $("#eclubFields").show({
                duration: 500
            });
        } else {
            $("#eclubFields").hide({
                duration: 500
            });
        }
    });

    $("#eclubFields input").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            submitSearchLogin();
        }
    });

    $("#eclubLogin").click(submitSearchLogin);


});

selectAllPrograms = function () {

    if ($("#selectAllCheckbox").attr("checked") == "checked") {
        $(".programSelection").attr("checked", "checked");
    } else {
        $(".programSelection").removeAttr("checked");
    }
};

var showingItems = [];

var programImageNames = [];
programImageNames["BP"] = "prog-pump.jpg";
programImageNames["BA"] = "prog-attack.jpg";
programImageNames["BC"] = "prog-combat.jpg";
//programImageNames["BV"] = "prog-vive.jpg";
programImageNames["BB"] = "prog-balance.jpg";
programImageNames["RPM"] = "prog-rpm.jpg";
programImageNames["BJ"] = "prog-jam.jpg";
programImageNames["SH"] = "prog-shbam.jpg";
programImageNames["BS"] = "prog-step.jpg";
programImageNames["CX"] = "prog-cxworx.jpg";
programImageNames["PJ"] = "PJ_white_98x36.png";

submitForm = function () {

    if (($('#operationalAddressSearch').val().trim() != "") && ( $('#operationalAddressSearch').val() != $('#operationalAddressSearchCheck').val() )) {
        $("#operationalAddressSearchError").show();
        return false;
    } else {
        $("#operationalAddressSearchError").hide();
    }


    var parameter = {
        name: $("#searchName").val(),
        criteria: $(".criteriaInput:checked").val(),
        token: $("#token").val(),
        gymId: $("#gymId").val()
    };


    $(".programSelection:checked").each(function (index) {
        if (parameter.programSelection == null) {
            parameter.programSelection = [];
        }
        parameter.programSelection.push($(this).val());
    });

    if ($('#operationalAddressSearch').val().trim() != "") {
        parameter.operationalAddressCountry = $("#operationalAddressCountry").val();
        parameter.operationalAddressState = $("#operationalAddressState").val();
        parameter.operationalAddressCity = $("#operationalAddressCity").val();
        parameter.operationalAddressLocality = $("#operationalAddressLocality").val();
    }

    $("#waiting-strategy").show();

    $.ajax({
        url: bodyControlURL + "/webSearchGyms/ajaxGetWebGyms",
        dataType: "jsonp",
        type: 'GET',
        data: parameter,
        success: function (items) {
            //if items is array is ok, else is an error.
            if (!Array.isArray(items)) {
                alert("Se produjo un error de conexión, porfavor intente más tarde");
                return;
            }

            showingItems = items;

            $("#count").html(items.length);

            $("#gymsGrid tbody").empty();
            for (var iItem = 0; iItem < items.length; iItem++) {

                $("#templates .arrow").attr("data-gym-index", iItem);
                $("#templates .gymName").html(items[iItem].name);
                $("#templates .gymLocation").html(
                    ( (items[iItem].country != null) ? items[iItem].country : ""  )
                    + ( (items[iItem].state != null) ? ", " + items[iItem].state : ""  )
                    + ( (items[iItem].city != null) ? ", " + items[iItem].city : ""  )
                    + ( (items[iItem].locality != null) ? ", " + items[iItem].locality : ""  )
                );
                $("#templates .gymPhone").html(( items[iItem].telephone != null) ? items[iItem].telephone : "");

                $('#templates .gymTr').clone().appendTo('#gymsGrid tbody');

                $('#templates .gymDetailTr').clone().appendTo('#gymsGrid tbody');

            }

            if (parameter.criteria == "gyms") {
                $(".phoneColumn").show();
                $(".emailContainer").show();
                $(".webContainer").show();
                $(".leyend").hide();
                $("#totalLabel").html("gimnasios");
            } else {
                if ($("#token").val() != "") {
                    //is a logued gym, show email and phone.
                    $(".phoneColumn").show();
                    $(".emailContainer").show();
                } else {
                    //is not a logued gym, hide email and phone.
                    $(".phoneColumn").hide();
                    $(".emailContainer").hide();

                }
                //is instructor
                $(".leyend").show();
                $(".webContainer").hide();
                $("#totalLabel").html("instructores");

            }


            LoadNestedGridFunctionality();
            $("#gymsGrid").trigger("updateAll");
            $(".arrow").click(arrowHandler);

            $(".gridContainer").show();

            $("#waiting-strategy").hide();

        },
        error: function (data) {
            $("#waiting-strategy").hide();
            alert('Se produjo un error vuela a intentar más tarde');
        }
    });


};

arrowHandler = function () {

    var that = $(this);
    var iItem = that.attr("data-gym-index");
    var items = showingItems;
    var selection = $(this).parent().find('.selection');
    var detailTr = $(this).parent().next('tr');

    if (items[iItem].detailIsShown == null) {
        detailTr.find(".gymEMail").html(( items[iItem].email != null) ? items[iItem].email : "");
        detailTr.find(".gymWeb").html(( items[iItem].site != null) ? items[iItem].site : "");

        $("#templates .itemPrograms").empty();

        for (var iProgram = 0; iProgram < items[iItem].programs.length; iProgram++) {
            var program = items[iItem].programs[iProgram];
            var imageName = programImageNames[program.programCode];

            if (imageName != null) {
                if (program.isCertified == true) {
                    $("#imageTemplate .programCertified").show();
                } else {
                    $("#imageTemplate .programCertified").hide();
                }
                if (program.isAimA == true) {
                    $("#imageTemplate .programAIMa").show();
                } else {
                    $("#imageTemplate .programAIMa").hide();
                }
                if (program.isAimB == true) {
                    $("#imageTemplate .programAIMb").show();
                } else {
                    $("#imageTemplate .programAIMb").hide();
                }
                if (program.isAimBPlus == true) {
                    $("#imageTemplate .programAIMbplus").show();
                } else {
                    $("#imageTemplate .programAIMbplus").hide();
                }

                $("#imageTemplate .programImage").attr("src", imagesPath + imageName);

                detailTr.find(".itemPrograms").append($("#imageTemplate .programItem").clone());
            }
        }

        items[iItem].detailIsShown = true;

    }

};


submitSearchLogin = function () {

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
                showLogguedUser(response);
            }
            $("#waiting-strategy").hide();

        },
        error: function (data) {
            $("#waiting-strategy").hide();
            alert('Se produjo un error vuela a intentar más tarde');
        }

    });
};

showLogguedUser = function (response) {
    $("#eclubFields").hide({
        duration: 500
    });
    $("#eclubShowAccessContainer").hide();
    $("#eclubLogguedIn").show();

    $("#token").val(response.token);
    $("#activePrograms").val(response.programs);
    $("#gymId").val(response.gymId);
};