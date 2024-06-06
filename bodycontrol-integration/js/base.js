/*GENERAL VARIABLES*/
$ = jQuery;

var dateDDMMYYYRegex = /^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/;
var mailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

/**/

function LoadTabsFunctionality() {

    $('.tabs li a').click(function () {

        if (!$(this).parent().hasClass('active')) {
            var Tab = $(this).attr('aria-tab');
            $('.tabs li').each(function () {
                $('#' + $(this).find('a').attr('aria-tab')).hide();
                $(this).removeClass('active')
            });
            $('#' + Tab).show();
            $(this).parent().addClass('active');
        }

    })

}

function LoadGridFunctionality() {

    $('.grid tr').mousedown(function () {

        var input = $(this).find('td.checkbox').find('input');

        if (input.attr('checked') == 'checked') {
            input.removeAttr('checked');
        } else {
            input.attr('checked', 'checked');
        }

    })

}

function LoadNestedGridFunctionality() {

    $('.nested-grid.grid tr').unbind('mousedown');

    $('.nested-grid td.arrow').mousedown(function () {

        var este = $(this);
        var tr = $(this).parent().next('tr');

        if (este.hasClass('active')) {
            este.removeClass('active');
        } else {
            este.addClass('active');
        }

        if (tr.hasClass('active')) {
            tr.removeClass('active');
        } else {
            tr.addClass('active');
        }

    });

}

function LoadDatePickers() {
    $(".isDatePicker").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        yearRange: "1960:2022"
    });
}

function ValidateDate(date) {
    var pattern = new RegExp(dateDDMMYYYRegex);
    return pattern.test(date);
}

function DateToInt(date) {
    if (ValidateDate(date)) {
        //var d = new Date(year, month, day, hours, minutes, seconds, milliseconds);
        var d = new Date(date.substring(6, 10), date.substring(3, 5), date.substring(0, 2), "00", "00", "00", "00");
        return d.valueOf();
    } else {
        return 0;
    }
}


function ValidateEmail(email) {
    var pattern = new RegExp(mailRegex);
    return pattern.test(email);
}

/**
 *
 * Convert the database date to the  UI date.
 * from YYYY-MM-DD to DD/MM/YYYY
 * @access    public
 * @param    date as YYYY-MM-DD
 * @return    date as DD/MM/YYYY
 */
function ConvertDateYYYMMDDtoDDMMYYY(date) {
    if (date != null && date.trim() != "" && date != "0000-00-00") {
        return date.substring(8, 10) + "/" + date.substring(5, 7) + "/" + date.substring(0, 4) + date.substring(10);
    }
    return "";
}

function FormatCUIT(cuit) {
    if (cuit != null && cuit.trim() != "") {
        return cuit.substring(0, 2) + "-" + cuit.substring(2, 10) + "-" + cuit.substring(10, 11);
    }
    return "";
}

/**
 * initialize the autocompleate for regions
 * TODO
 * @view: is the jquery selector for the user input.
 * @id: is the jquery selector for the id hidden input
 * @check: is the jquery selector for the name hidden input
 * @selectFn: is a callback function when the user select an option.
 * */
function LoadRegionsAutoComplete(view, check, countryId, stateId, cityId, localityId, selectFn) {
    $(view).autocomplete({
        change: function (event, ui) {
            if ($(view).val() == "") {
                $(countryId).val("");
                $(stateId).val("");
                $(cityId).val("");
                $(localityId).val("");
                $(check).val("");
            }
        },
        source: function (request, response) {
            $.ajax({
                url: bodyControlURL + "/webPublics/ajaxGetAllRegions",
                dataType: "jsonp",
                type: 'GET',
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                },
                error: function (data) {
                    alert('Se produjo un error vuela a intentar más tarde');
                }
            });
        },
        minLength: 3,
        select: function (event, ui) {
            //select each one.
            $(countryId).val(ui.item.idCountry);
            $(stateId).val(ui.item.idState);
            $(cityId).val(ui.item.idCity);
            $(localityId).val(ui.item.idLocality);
            $(check).val(ui.item.label);

            if (selectFn != null) {
                selectFn(event, ui);
            }
        }
    });
}

LoadIdNumberTypes = function (idNumberTypeSt) {
    $("#waiting-strategy").show();
    $.ajax({
        url: bodyControlURL + "/webPublics/ajaxGetAllIdNumbersTypes",
        dataType: "jsonp",
        type: 'GET',
        success: function (data) {

            var idNumberTypeHTML = "";
            for (var i = 0; i < data.length; i++) {
                idNumberTypeHTML = idNumberTypeHTML + "<option value=\"" + data[i].Id + "\">" + data[i].Description + "</option>";
            }

            $(idNumberTypeSt).html(idNumberTypeHTML);

            $("#waiting-strategy").hide();
        },
        error: function (data) {
            $("#waiting-strategy").hide();
            alert('Se produjo un error vuela a intentar más tarde');
        }
    });

};