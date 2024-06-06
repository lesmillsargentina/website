$ = jQuery;

$(function () {
  //this is a check for WordPress because wp download the script always.
  if ($("#configInitEnrollmentScript").val() != "true") {
    return;
  }

  if ($("#configActivationId").val() != "" && $("#configToken").val() != "") {
    activateEmail();
  } else {
    showEnrollmentStepInit();
  }

  LoadDatePickers();
  LoadIdNumberTypes("#idNumberType");

  LoadRegionsAutoComplete(
    "#registerRegionSearch",
    "#registerRegionSearchCheck",
    "#registerCountry",
    "#registerState",
    "#registerCity",
    "#registerLocality"
  );

  LoadRegionsAutoComplete(
    "#mailKitAddressSearch",
    "#mailKitAddressSearchCheck",
    "#mailKitAddressCountry",
    "#mailKitAddressState",
    "#mailKitAddressCity",
    "#mailKitAddressLocality"
  );

  $("#stepInit input").keypress(function (event) {
    if (event.which == 13) {
      event.preventDefault();
      submitFormInit();
    }
  });

  $("#continueInit").click(submitFormInit);

  $("#cancelStepConfirmName").click(showEnrollmentStepInit);

  $("#cancelStepRegister").click(showEnrollmentStepInit);

  $("#continueStepConfirmName").click(submitFormConfirm);

  $("#continueStepConfirmPrograms").click(submitConfirmPrograms);

  $("#continueStepRegister").click(submitRegister);

  $("#continueStepConfirmGymName").click(submitConfirmGymName);

  $("#continueStepValidateEmail").click(submitValidateEmail);

  $("#mailKitSelection").removeAttr("checked");
  $("#otherKitWithdrawnSelection").removeAttr("checked");

  $("#mailKitSelection").click(function () {
    if ($(this).is(":checked")) {
      $(".mailKitAddressContainer").css("opacity", 0).show().animate(
        {
          opacity: 1,
        },
        1000
      );
    } else {
      $(".mailKitAddressContainer").hide();
    }
  });

  $("#otherKitWithdrawnSelection").click(function () {
    if ($(this).is(":checked")) {
      $(".otherKitWithdrawnContainer").css("opacity", 0).show().animate(
        {
          opacity: 1,
        },
        1000
      );
    } else {
      $(".otherKitWithdrawnContainer").hide();
    }
  });
});

showEnrollmentStepInit = function () {
  $(".enrollmentStep").hide();
  $("#stepInit").show();
  $("#idNumber").val("");
};

submitFormInit = function () {
  if (!$("#termConditions:checked").length) {
    alert("Debe aceptar lo terminos y condiciones");
    return;
  }

  if ($("#idNumber").val() == "") {
    $("#idNumberError").show();
    $("#idNumberError").html("*Complete su número de documento.");
    return;
  } else {
    $("#idNumberError").hide();
  }

  if ($("#eventId").val() == "") {
    alert("La url accedida es incorrecta.");
    return;
  }

  var idNumberTypeName = $("#idNumberType option:selected").html();

  var parameter = {
    idNumber: parseIdNumber($("#idNumber").val()),
    idNumberType: $("#idNumberType").val(),
    grecaptcharesponse: $("#g-recaptcha-response").val(),
    eventId: $("#eventId").val(),
  };

  $("#captchaError").hide();

  $("#waiting-strategy").show();
  $.ajax({
    url: bodyControlURL + "/webEnrollment/ajaxEnrollWithIdNumber",
    dataType: "jsonp",
    data: parameter,
    success: function (response) {
      if (response.isValid == "-1") {
        if (response.errorCode == "ERROR_CAPTCHA") {
          //captcha is wrong
          Recaptcha.reload();
          $("#captchaError").show();
        } else if (response.errorCode == "ERROR_PARTICIPANT_NOT_FOUND") {
          //captcha is wrong
          $("#idNumberError").show();
          $("#idNumberError").html(
            "*El número de DNI no fue hallado en nuestros registros, y para este evento es necesario ya estar inscripto."
          );
        } else {
          alert("Se generó un error. Intente más tarde.");
        }
      } else if (response.isValid == "0") {
        //captcha is good, next call.
        //we have a personId
        showNextStep(response);
      }
      $("#waiting-strategy").hide();
    },
    error: function (data) {
      $("#waiting-strategy").hide();
      alert("Se produjo un error vuelva a intentar más tarde");
    },
  });
};

parseIdNumber = function (idNumber) {
  return idNumber
    .trim()
    .replace(/\./g, "")
    .replace(/\,/g, "")
    .replace(/\-/g, "");
};

var EnrolledProgramCodes = null;
var NotEnrolledProgramCodes = null;
var EventValues = null;

submitFormConfirm = function () {
  var parameter = {
    token: $("#confirmNameToken").val().trim(),
    personId: $("#confirmNamePersonId").val().trim(),
    eventId: $("#confirmNameEventId").val().trim(),
  };

  if (parameter.eventId == "") {
    alert("Número de evento icorrecto. Vuelva a acceder.");
    return;
  }

  if (parameter.personId == "") {
    alert("Código de persona icorrecto. Vuelva a acceder.");
    return;
  }

  if (parameter.token == "") {
    alert("Token icorrecto. Vuelva a acceder.");
    return;
  }

  $("#waiting-strategy").show();
  $.ajax({
    url: bodyControlURL + "/webEnrollment/ajaxConfirmPersonId",
    dataType: "jsonp",
    data: parameter,
    success: function (response) {
      if (response.isValid == "-1") {
        if (response.errorCode == "ERROR_INVALID_TOKEN") {
          alert(
            "Ha pasado mucho tiempo y su sesión ha caducado. Porfavor vuelva a ingresar."
          );
        } else {
          alert("Se generó un error. Intente más tarde.");
        }
      } else if (response.isValid == "0") {
        showNextStep(response);
      }
      $("#waiting-strategy").hide();
    },
    error: function (data) {
      $("#waiting-strategy").hide();
      alert("Se produjo un error vuela a intentar más tarde");
    },
  });
};

programSelectionHandler = function () {
  var selections = $(".programSelection:checked");
  var value = 0;
  if (EventValues != null && EventValues.length > 0) {
    if (selections.length >= EventValues.length) {
      //get last one.
      value = parseFloat(EventValues[EventValues.length - 1].Value);
    } else if (selections.length) {
      //get by qty.
      value = parseFloat(
        getItemFromList(selections.length, EventValues, "ProgramsQty").Value
      );
    }
  }

  //check mail kit.
  if ($("#mailKitSelection").attr("checked") == "checked") {
    value = value + parseFloat(MailValue);
  }

  $("#confirmProgramsValue").html(value);
};

getItemFromList = function (value, list, attribute) {
  attribute = typeof attribute !== "undefined" ? attribute : "Id";

  for (var i in list) {
    if (list[i][attribute] == value) {
      //is this one.
      var response = list[i];
      response.index = i;
      return response;
    }
  }

  return null;
};

submitConfirmPrograms = function () {
  var newEnrolledProgramCodesList = [];
  var newNotEnrolledProgramCodesList = [];

  if (!$(".programSelection:checked").length) {
    alert("Seleccione al menos un programa");
    return;
  }

  $(".programSelection").each(function () {
    if (
      $.inArray($(this).val(), EnrolledProgramCodes) >= 0 ||
      $.inArray($(this).val(), NotEnrolledProgramCodes) >= 0
    ) {
      //show it.
      if ($(this).is(":checked")) {
        newEnrolledProgramCodesList.push($(this).val());
      } else if (!$(this).is(":disabled")) {
        newNotEnrolledProgramCodesList.push($(this).val());
      }
    }
  });

  var parameter = {
    participantId: $("#confirmProgramsParticipantId").val(),
    token: $("#confirmProgramsToken").val(),
    enrolledProgramCodes: newEnrolledProgramCodesList.toString(),
    notEnrolledProgramCodes: newNotEnrolledProgramCodesList.toString(),
  };

  var isAnyError = false;

  if ($("#mailKitSelection").is(":checked")) {
    parameter.mailKit = true;
    parameter.mailKitAddress = $("#mailKitAddress").val();
    parameter.mailKitPostalCode = $("#mailKitPostalCode").val();

    if (parameter.mailKitAddress.trim() == "") {
      $("#mailKitAddressError").html(
        "Si selecciona envío por correo, la Dirección es obligatoria."
      );
      $("#mailKitAddressError").show();
    } else {
      $("#mailKitAddressError").hide();
    }

    if (parameter.mailKitPostalCode.trim() == "") {
      $("#mailKitPostalCodeError").html(
        "Si selecciona envío por correo, el Código Postal es obligatorio."
      );
      $("#mailKitPostalCodeError").show();
    } else {
      $("#mailKitPostalCodeError").hide();
    }

    if ($("#mailKitAddressSearch").val() == "") {
      $("#mailKitAddressSearchError").html(
        'Si selecciona envío por correo, el "Pais, Estado, Ciudad, Localidad" es obligatorio.'
      );
      $("#mailKitAddressSearchError").show();
      isAnyError = true;
    } else if (
      $("#mailKitAddressSearch").val() != $("#mailKitAddressSearchCheck").val()
    ) {
      $("#mailKitAddressSearchError").html(
        'El campo "Pais, Estado, Ciudad, Localidad" no es válido. Porfavor revise'
      );
      $("#mailKitAddressSearchError").show();
      isAnyError = true;
    } else {
      $("#mailKitAddressSearchError").hide();

      parameter.mailKitAddressLocation = $("#mailKitAddressSearch").val();
      parameter.mailKitAddressCountry = $("#mailKitAddressCountry").val();
      parameter.mailKitAddressState = $("#mailKitAddressState").val();
      parameter.mailKitAddressCity = $("#mailKitAddressCity").val();
      parameter.mailKitAddressLocality = $("#mailKitAddressLocality").val();
    }
  } else {
    parameter.mailKit = false;
  }

  if ($("#otherKitWithdrawnSelection").is(":checked")) {
    parameter.otherKitWithdrawn = true;
    parameter.otherKitWithdawnName = $("#otherKitWithdawnName").val();
    if (parameter.otherKitWithdawnName.trim() == "") {
      $("#otherKitWithdawnError").html(
        "Si selecciona Retira otra persona, es necesario especificar el nombre de la persona."
      );
      $("#otherKitWithdawnError").show();
      isAnyError = true;
    } else {
      $("#otherKitWithdawnError").hide();
    }
  } else {
    parameter.otherKitWithdrawn = false;
  }

  if (parameter.participantId == "") {
    alert("Código de participante icorrecto. Vuelva a acceder.");
    return;
  }

  if (parameter.token == "") {
    alert("Token icorrecto. Vuelva a acceder.");
    return;
  }

  if (isAnyError) {
    return;
  }

  $("#waiting-strategy").show();
  $.ajax({
    url: bodyControlURL + "/webEnrollment/ajaxConfirmPrograms",
    dataType: "jsonp",
    data: parameter,
    success: function (response) {
      if (response.isValid == "-1") {
        if (response.errorCode == "ERROR_INVALID_TOKEN") {
          alert(
            "Ha pasado mucho tiempo y su sesión ha caducado. Porfavor vuelva a ingresar."
          );
        } else {
          alert("Se generó un error. Intente más tarde.");
        }
      } else if (response.isValid == "0") {
        showNextStep(response);
      }
      $("#waiting-strategy").hide();
    },
    error: function (data) {
      $("#waiting-strategy").hide();
      alert("Se produjo un error vuela a intentar más tarde");
    },
  });
};

submitRegister = function () {
  var parameter = {
    eventId: $("#registerEventId").val(),
    token: $("#registerToken").val(),
    name: $("#registerLastName").val() + " " + $("#registerName").val(),
    gender: $("#registerGenderFemale").is(":checked") ? "F" : "M",
    cuit: $("#registerCUIT").val(),
    idNumber: $("#registerIdNumber").val(),
    idNumberType: $("#registerIdNumberTypeId").val(),
    birthDate: $("#registerBirthDate").val(),
    nationality: $("#registerNationality").val(),
    address: $("#registerAddress").val(),
    postalCode: $("#registerPostalCode").val(),
    countryId: $("#registerCountry").val(),
    stateId: $("#registerState").val(),
    cityId: $("#registerCity").val(),
    localityId: $("#registerLocality").val(),
    mobile: $("#registerMobile").val(),
    phoneNumber1: $("#registerPhoneNumber1").val(),
    phoneNumber2: $("#registerPhoneNumber2").val(),
    nextel: $("#registerNextel").val(),
    skype: $("#registerSkype").val(),
    faxNumber: $("#registerFaxNumber").val(),
    email1: $("#registerEmail1").val(),
    email2: $("#registerEmail2").val(),
    web: $("#registerWeb").val(),
    facebook: $("#registerFacebook").val(),
    twitter: $("#registerTwitter").val(),
  };

  var isAnyError = false;
  $("#stepRegister .error").hide();

  if ($("#registerName").val().trim() == "") {
    $("#registerNameError").html("El nombre es obligatorio.");
    $("#registerNameError").show();
    isAnyError = true;
  }

  if ($("#registerLastName").val().trim() == "") {
    $("#registerLastNameError").html("El apellido es obligatorio");
    $("#registerLastNameError").show();
    isAnyError = true;
  }

  if (parameter.mobile.trim() == "") {
    $("#registerMobileError").html("El celular es obligatorio");
    $("#registerMobileError").show();
    isAnyError = true;
  }
  /*
    if (parameter.birthDate.trim() == "") {
        $("#registerBirthDateError").html('La fecha de nacimiento es obligatoria');
        $("#registerBirthDateError").show();
        isAnyError = true;
    }

    if (parameter.birthDate.trim() != "" && !ValidateDate(parameter.birthDate)) {
        $("#registerBirthDateError").html('La fecha de nacimiento no es válida debe tener format DD/MM/AAAA');
        $("#registerBirthDateError").show();
        isAnyError = true;
    }


    if (parameter.nationality.trim() == "") {
        $("#registerNationalityError").html('La nacionalidad es obligatoria');
        $("#registerNationalityError").show();
        isAnyError = true;
    }
*/
  if (parameter.address.trim() == "") {
    $("#registerAddressError").html("La dirección es obligatoria");
    $("#registerAddressError").show();
    isAnyError = true;
  }
  /*
    if (parameter.postalCode.trim() == "") {
        $("#registerPostalCodeError").html('El código postal es obligatorio');
        $("#registerPostalCodeError").show();
        isAnyError = true;
    }
*/
  if (!ValidateEmail(parameter.email1)) {
    $("#registerEmail1Error").html("El email principal no es válido");
    $("#registerEmail1Error").show();
    isAnyError = true;
  }
  /*
    if (parameter.email2.trim() != "" && !ValidateEmail(parameter.email2)) {
        $("#registerEmail2Error").html('El email secundario no es válido');
        $("#registerEmail2Error").show();
        isAnyError = true;
    }
*/
  if ($("#registerRegionSearch").val() == "") {
    $("#registerRegionError").html(
      'El "Pais, Estado, Ciudad, Localidad" es obligatorio.'
    );
    $("#registerRegionError").show();
    isAnyError = true;
  }

  if (
    $("#registerRegionSearch").val() != $("#registerRegionSearchCheck").val()
  ) {
    $("#registerRegionError").html(
      'El campo "Pais, Estado, Ciudad, Localidad" no es válido. Porfavor revise'
    );
    $("#registerRegionError").show();
    isAnyError = true;
  }

  if (parameter.localityId == null) {
    parameter.localityId = "";
  }

  if (parameter.cityId == null) {
    parameter.cityId = "";
  }

  if (parameter.stateId == null) {
    parameter.stateId = "";
  }

  if (parameter.countryId == null) {
    parameter.countryId = "";
  }

  /*if (parameter.cuit.trim() != "") {
        parameter.cuit = parseIdNumber(parameter.cuit);

        if (parameter.cuit.length != 11) {
            $("#registerCUITError").html('El CUIT debe tener 11 números.');
            $("#registerCUITError").show();
            isAnyError = true;
            return false;
        }

    }*/
  if (isAnyError) {
    window.scrollTo(0, 0);
    return false;
  }

  $("#waiting-strategy").show();
  $.ajax({
    url: bodyControlURL + "/webEnrollment/ajaxRegister",
    dataType: "jsonp",
    data: parameter,
    success: function (response) {
      if (response.isValid == "-1") {
        if (response.errorCode == "ERROR_INVALID_TOKEN") {
          alert(
            "Ha pasado mucho tiempo y su sesión ha caducado. Porfavor vuelva a ingresar."
          );
        } else {
          alert("Se generó un error. Intente más tarde.");
        }
      } else if (response.isValid == "0") {
        showNextStep(response);
      }
      $("#waiting-strategy").hide();
    },
    error: function (data) {
      $("#waiting-strategy").hide();
      alert("Se produjo un error vuela a intentar más tarde");
    },
  });
};

stepConfirmation = function (response) {
  $(".enrollmentStep").hide();
  $("#paypalSection").hide();
  if (response.value != null) {
    $("#showConfirmationValue").html(response.value);
    $("#stepShowConfirmation .value").show();
    $("#stepShowConfirmation .paymentMethodsTitle").show();
    $("#stepShowConfirmation .paymentMethods").show();
    $("#stepShowConfirmation .paymentMethodsFirstStep").show();
    if (response.value.includes("$ ")) {
      $("#mercadoPagoPoint").attr("href", response.mercadoPagoId);
      $("#paypalSection").hide();
    } else {
      $("#paypalSection").show();
      $("#paypalPoint").attr("href", response.mercadoPagoId);
      $("#mercadoPagoSection").hide();
    }
  } else {
    $("#stepShowConfirmation .value").hide();
    $("#stepShowConfirmation .paymentMethodsTitle").hide();
    $("#stepShowConfirmation .paymentMethods").hide();
    $("#stepShowConfirmation .paymentMethodsFirstStep").hide();
  }

  if (response.webEventType == "LESMILLS_WORKSHOP") {
    $("#stepShowConfirmation .juanAccount").show();
    $("#stepShowConfirmation .bodytrainingAccount").hide();
  } else {
    $("#stepShowConfirmation .juanAccount").hide();
    $("#stepShowConfirmation .bodytrainingAccount").show();
  }

  $("#stepShowConfirmation .confirmEmail").html(response.sentEmail);

  $("#stepShowConfirmation .eventTitle").html(response.title);
  $("#stepShowConfirmation").show();
  $("#mercadoPagoPoint").attr("href", response.mercadoPagoId);
};

var EventType = null;

stepConfirmGymName = function (response) {
  $(".enrollmentStep").hide();
  //we received the participantId.
  $("#stepConfirmGymName input").val("");
  $("#stepConfirmGymName .error").hide();
  $("#confirmGymNameToken").val(response.token);
  $("#confirmGymNameParticipantId").val(response.participantId);

  $("#stepConfirmGymName").show();
  EventType = response.webEventType;
};

submitConfirmGymName = function () {
  var parameter = {
    participantId: $("#confirmGymNameParticipantId").val(),
    token: $("#confirmGymNameToken").val(),
    gymName: $("#confirmGymNameName").val(),
    responsibleName: $("#confirmGymNameResponsible").val(),
    phone: $("#confirmGymNamePhone").val(),
  };

  var isAnyError = false;
  $("#stepConfirmGymName .error").hide();

  if (EventType != "LESMILLS_FANS" && parameter.gymName.trim() == "") {
    $("#confirmGymNameNameError").html("El nombre del gimnasio es obligatorio");
    $("#confirmGymNameNameError").show();
    isAnyError = true;
  }

  if (
    EventType != "LESMILLS_GFM_GERENTE" &&
    EventType != "LESMILLS_FANS" &&
    parameter.responsibleName.trim() == ""
  ) {
    $("#confirmGymNameResponsibleError").html(
      "El nombre del responsable es obligatorio"
    );
    $("#confirmGymNameResponsibleError").show();
    isAnyError = true;
  }

  if (
    EventType != "LESMILLS_GFM_GERENTE" &&
    EventType != "LESMILLS_FANS" &&
    parameter.phone.trim() == ""
  ) {
    $("#confirmGymNamePhoneError").html("El teléfono es obligatorio");
    $("#confirmGymNamePhoneError").show();
    isAnyError = true;
  }

  if (isAnyError) {
    window.scrollTo(0, 0);
    return false;
  }

  $("#waiting-strategy").show();
  $.ajax({
    url: bodyControlURL + "/webEnrollment/ajaxConfirmGymName",
    dataType: "jsonp",
    data: parameter,
    success: function (response) {
      if (response.isValid == "-1") {
        if (response.errorCode == "ERROR_INVALID_TOKEN") {
          alert(
            "Ha pasado mucho tiempo y su sesión ha caducado. Porfavor vuelva a ingresar."
          );
        } else {
          alert("Se generó un error. Intente más tarde.");
        }
      } else if (response.isValid == "0") {
        showNextStep(response);
      }
      $("#waiting-strategy").hide();
    },
    error: function (data) {
      $("#waiting-strategy").hide();
      alert("Se produjo un error vuela a intentar más tarde");
    },
  });
};

confirmGymNameIsAutonomoChange = function () {
  if ($("#confirmGymNameIsAutonomo").is(":checked")) {
    $("#confirmGymNameName").val("SOY AUTONOMO");
    $("#confirmGymNameResponsible").val("SOY AUTONOMO");
    $("#confirmGymNamePhone").val("SOY AUTONOMO");
    $("#confirmGymNameName").attr("disabled", "disabled");
    $("#confirmGymNameResponsible").attr("disabled", "disabled");
    $("#confirmGymNamePhone").attr("disabled", "disabled");
  } else {
    $("#confirmGymNameName").val("");
    $("#confirmGymNameResponsible").val("");
    $("#confirmGymNamePhone").val("");
    $("#confirmGymNameName").removeAttr("disabled");
    $("#confirmGymNameResponsible").removeAttr("disabled");
    $("#confirmGymNamePhone").removeAttr("disabled");
  }
};

showNextStep = function (response) {
  $(".enrollmentStep").hide();

  switch (response.nextStep) {
    case "STEP_CONFIRM_NAME":
      $("#confirmNameName").html(response.personName);
      $("#confirmPersonMail").html(response.personMail);
      $("#confirmNamePersonId").val(response.personId);
      $("#confirmNameToken").val(response.token);
      $("#confirmNameEventId").val(response.eventId);
      if (response.custom) {
        $("#refPaypal").attr("value", response.custom);
      }
      $("#stepConfirmName").show();
      break;

    case "STEP_REGISTER":
      $("#stepRegister input").val("");
      $("#stepRegister select").val("");
      $("#registerToken").val(response.token);
      $("#registerEventId").val(response.eventId);
      $("#registerIdNumber").val(response.idNumber);
      $("#registerIdNumberTypeId").val(response.idNumberType);
      $("#registerIdNumberText").val(
        response.idNumberTypeName + ": " + response.idNumber
      );
      $("#stepRegister").show();
      break;

    case "STEP_SHOW_ALREADY_ENROLLED":
      $("#stepAlreadyEnrolled").show();
      break;
    case "STEP_SHOW_NO_VALID_PARTICIPANT":
      $("#stepNoValidParticipant").show();
      break;
    case "STEP_CONFIRM_PROGRAMS":
      $("#confirmProgramsToken").val(response.token);
      $("#confirmProgramsParticipantId").val(response.participantId);

      EnrolledProgramCodes = response.enrolledProgramCodes.split(",");
      NotEnrolledProgramCodes = response.notEnrolledProgramCodes.split(",");

      EventValues = response.values;
      MailValue = response.mailValue;
      $(".programSelection").each(function () {
        if ($.inArray($(this).val(), EnrolledProgramCodes) >= 0) {
          //disable to prevent paying the same.
          $(this).parent().show();
          $(this).removeAttr("checked");
          $(this).attr("disabled", true);
        } else if ($.inArray($(this).val(), NotEnrolledProgramCodes) >= 0) {
          $(this).parent().show();
          $(this).removeAttr("checked");
          if (typeof response.nzcode[$(this).val()] !== "undefined") {
            if (response.nzcode[$(this).val()] === false) {
              $(this).hide(); // no tiene la correlativa pagada, deshabilitamos
              $("#code_correlativa_" + $(this).val()).show();
            } else {
              $("#code_" + $(this).val()).html(response.nzcode[$(this).val()]);
            }
          }
        } else {
          //hide it.
          $(this).parent().hide();
        }
      });

      $(".programSelection").change(programSelectionHandler);
      $("#mailKitSelection").change(programSelectionHandler);
      programSelectionHandler();

      $("#stepConfirmPrograms").show();
      break;
    case "STEP_SHOW_CONFIRMATION":
      if (response.custom) {
        $("#refPaypal").attr("value", response.custom);
      }
      stepConfirmation(response);
      break;
    case "STEP_SHOW_CONFIRM_GYM_NAME":
      stepConfirmGymName(response);
      break;
    case "STEP_VALIDATE_EMAIL":
      $("#validateEmailEmail").val(response.currentEmail);
      $("#validateEmailEventId").val(response.eventId);
      $("#validateEmailPersonId").val(response.personId);
      $("#validateEmailToken").val(response.token);
      $("#stepValidateEmail .error").hide();
      $("#stepValidateEmail").show();
      break;
    case "STEP_SHOW_CHECK_MAIL_BOX":
      $("#checkMailBoxMail").html(response.email);
      $("#stepShowCheckMailBox").show();
      break;
    case "STEP_SHOW_ACTIVATION_CODE_USED":
      $("#stepShowActivationCodeUsed").show();
      break;

    default:
      alert("Se generó un error. Respuesta inesperada.");

      break;
  }
};

submitValidateEmail = function () {
  var parameter = {
    personId: $("#validateEmailPersonId").val(),
    token: $("#validateEmailToken").val(),
    eventId: $("#validateEmailEventId").val(),
    email: $("#validateEmailEmail").val(),
    webLink: encodeURIComponent($("#configWebLink").val()),
  };

  var isAnyError = false;
  $("#stepValidateEmail .error").hide();

  if (!ValidateEmail(parameter.email)) {
    $("#validateEmailEmailError").html("El email no es válido");
    $("#validateEmailEmailError").show();
    isAnyError = true;
  }

  if (isAnyError) {
    window.scrollTo(0, 0);
    return false;
  }

  $("#waiting-strategy").show();
  $.ajax({
    url: bodyControlURL + "/webEnrollment/ajaxValidateEmail",
    dataType: "jsonp",
    data: parameter,
    success: function (response) {
      if (response.isValid == "-1") {
        if (response.errorCode == "ERROR_INVALID_TOKEN") {
          alert(
            "Ha pasado mucho tiempo y su sesión ha caducado. Porfavor vuelva a ingresar."
          );
        } else {
          alert("Se generó un error. Intente más tarde.");
        }
      } else if (response.isValid == "0") {
        showNextStep(response);
      }
      $("#waiting-strategy").hide();
    },
    error: function (data) {
      $("#waiting-strategy").hide();
      alert("Se produjo un error vuela a intentar más tarde");
    },
  });
};

/***/
activateEmail = function () {
  $("#waiting-strategy").show();

  var parameter = {
    activationId: $("#configActivationId").val(),
    token: $("#configToken").val(),
  };
  $.ajax({
    url: bodyControlURL + "/webEnrollment/ajaxActivateEmail",
    dataType: "jsonp",
    data: parameter,
    success: function (response) {
      if (response.isValid == "-1") {
        if (response.errorCode == "ERROR_INVALID_TOKEN") {
          alert(
            "Ha pasado mucho tiempo y su sesión ha caducado. Porfavor vuelva a ingresar."
          );
        }
        if (response.errorCode == "ERROR_ALREADY_ACTIVATED") {
          alert("");
        } else {
          alert("Se generó un error. Intente más tarde.");
        }
      } else if (response.isValid == "0") {
        showNextStep(response);
      }
      $("#waiting-strategy").hide();
    },
    error: function (data) {
      $("#waiting-strategy").hide();
      alert("Se produjo un error vuela a intentar más tarde");
    },
  });
};
