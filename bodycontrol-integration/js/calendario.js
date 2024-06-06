$ = jQuery;

$(function () {
    //this is a check for WordPress because wp download the script always.
    if ($("#configInitEventsScript").val() != "true") {
        return;
    }

    prepareCalendar();

});

var Events = null;

prepareCalendar = function () {
    var parameter = {
        lesmillsModules: ( $("#configShowLesMillsModules").val() == "true" ? true : false ),
        lesmillsWorkshops: ( $("#configShowLesMillsWorkshops").val() == "true" ? true : false ),
        lesmillsCourse: ( $("#configShowLesMillsCourse").val() == "true" ? true : false ),
        everlast: ( $("#configShowEverlast").val() == "true" ? true : false ),
        core360: ( $("#configShowCore360").val() == "true" ? true : false ),
        onlineModules: ( $("#configShowOnline").val() == "true" ? true : false )
    };

    $("#waiting-strategy").show();

    /***
     * ask to bodyControl for the evenlists
     * we will receive a list of
     * {
	 * 		eventType: string "LESMILLS_MODULE"; "LESMILLS_WORKSHOP"; "EVERLAST"; "CORE360"
	 * 		eventTitle: string with the event Title
	 * 		gymName: gym name as string
	 * 		gymAddress: string with the event Title
	 * 		gymCountry: gym location.
	 * 		gymState: gym location.
	 * 		gymCity: gym location.
	 * 		gymLocality: gym location.
	 * 		startTime: start tiem
	 * 		endTime: end time
	 * 		eventId: encoded event Id.
	 * 		startDate: start date of the event.
	 * 		endDate: end date of the event.
	 * 		workshopGroupCode: 3 leters code for workshop.
	 * 		programCode: 3 leters program code.
	 * }
     */
    $.ajax({
        url: bodyControlURL + "/webEventsList/ajaxGetEventsList",
        dataType: "jsonp",
        type: 'GET',
        data: parameter,
        success: function (items) {
            Events = items;

            $(".content").empty();

            for (var iItem = 0; iItem < items.length; iItem++) {


                $("#templates .eventTitle").html(items[iItem].eventTitle);
                if (items[iItem].gymName != null) {
                    $("#templates .gymName").html(items[iItem].gymName);
                } else {
                    $("#templates .gymName").html("(A definir)");
                }

                $("#templates .gymAddress").html(items[iItem].gymAddress);

                var location = items[iItem].gymState;
                if (items[iItem].gymLocality != null && items[iItem].gymLocality != "") {
                    location = location + ", " + items[iItem].gymLocality;
                }

                $("#templates .gymLocation").html(location);
                if (items[iItem].startTime == null || items[iItem].startTime == ""
                    || items[iItem].endTime == null || items[iItem].endTime == "") {

                    $("#templates .eventTime").hide();
                } else {
                    $("#templates .eventTime").show();
                }

                $("#templates .startTime").html(items[iItem].startTime);
                $("#templates .endTime").html(items[iItem].endTime);

                var eventIdURI = encodeURIComponent(items[iItem].eventId);
                var eventTitleURI = encodeURIComponent(items[iItem].eventTitle);

                var currentEnrollmentLink = enrollmentLink
                    .replace("@@EVENT-ID@@", eventIdURI)
                    .replace("@@EVENT-TITLE@@", eventTitleURI);
                $("#templates .enrollmentLink").attr("href", currentEnrollmentLink);
                $("#templates .scheduleLink").attr("href", schedulesPath + "schedule-" + items[iItem].workshopGroupCode + "-" + items[iItem].startDate + ".png");

                if (items[iItem].webInscription == "1") {
                    $("#templates .enrollmentLink").show();
                    $("#templates .closedEnrollmentInfoBox").hide();

                } else {
                    $("#templates .enrollmentLink").hide();
                    $("#templates .closedEnrollmentInfoBox").show();
                }

                if (items[iItem].webNote != "") {
                    $("#templates .note").show();
                    $("#templates .brNote").show();
                    var note = items[iItem].webNote;
                    note = note.replace(/\n/g, "<br/>");
                    $("#templates .note").html(note);
                } else {
                    $("#templates .note").hide();
                    $("#templates .brNote").hide();
                }

                switch (items[iItem].eventType) {
                    case "LESMILLS_MODULE":
                        isOnline = items[iItem].isOnline === "1"? "O":"";
                        $('#templates .eventImage').attr("src", imagesPath + "events-module-" + items[iItem].programCode + isOnline + ".png");
                        $('#templates .lesMillsModule').clone().appendTo('.content');
                        break;

                    case "LESMILLS_WORKSHOP":
                        isOnline = items[iItem].isOnline === "1"? "O":"";
                        $('#templates .eventImage').attr("src", imagesPath + "events-ws-" + items[iItem].workshopGroupCode + isOnline + ".png");
                        $('#templates .lesMillsWorkshop').clone().appendTo('.content');
                        break;

                    case "LESMILLS_COURSE":
                        //$('#templates .eventImage').attr("src", imagesPath + "events-ws-" + items[iItem].workshopGroupCode + ".png");
                        $('#templates .lesMillsCourse').clone().appendTo('.content');
                        break;

                    case "LESMILLS_GFM_GERENTE":
                        $('#templates .eventImage').attr("src", imagesPath + "events-course-gfmgerente.png");
                        $('#templates .lesMillsCourse').clone().appendTo('.content');
                        break;
                    case "LESMILLS_GFM_INSTRUCTOR":
                        $('#templates .eventImage').attr("src", imagesPath + "events-course-gfminstructor.png");
                        $('#templates .lesMillsCourse').clone().appendTo('.content');
                        break;
                    case "LESMILLS_FIT":
                        $('#templates .eventImage').attr("src", imagesPath + "events-course-fit.png");
                        $('#templates .lesMillsModule').clone().appendTo('.content');
                        break;
                    case "LESMILLS_FIT_OL":
                        $('#templates .eventImage').attr("src", imagesPath + "events-module-FIT-online.png");
                        $('#templates .lesMillsModule').clone().appendTo('.content');
                        break;
                    case "LESMILLS_CLINIC":
                        $('#templates .eventImage').attr("src", imagesPath + "events-course-clinic.png");
                        $('#templates .lesMillsCourse').clone().appendTo('.content');
                        break;
                    case "LESMILLS_IMPLEMENTATION":
                        $('#templates .eventImage').attr("src", imagesPath + "events-course-implemetation.png");
                        $('#templates .lesMillsCourse').clone().appendTo('.content');
                        break;

                    case "EVERLAST":
                        $('#templates .eventImage').attr("src", imagesPath + "events-ringside.png");
                        $('#templates .lesMillsModule').clone().appendTo('.content');
                        break;

                    case "CORE360_ADVANCE":
                        $('#templates .eventImage').attr("src", imagesPath + "events-core-advance.png");
                        $('#templates .core360').clone().appendTo('.content');
                        break;

                    case "CORE360_FUNDAMENTALS":
                        $('#templates .eventImage').attr("src", imagesPath + "events-core-fundamentals.png");
                        $('#templates .core360').clone().appendTo('.content');
                        break;

                    case "LESMILLS_FANS":
                        $('#templates .eventImage').attr("src", imagesPath + "events-ws-CAP-fans.png");
                        $('#templates .lesMillsWorkshop').clone().appendTo('.content');
                        break;

                }
            }
            $("#waiting-strategy").hide();
        },
        error: function (data) {
            $("#waiting-strategy").hide();
            alert('Se produjo un error vuela a intentar más tarde');
        }
    });

};
