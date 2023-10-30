$(document).ready(function () {
  $.validator.addMethod(
    "phoneWithCountryCode",
    function (value, element) {
      var regex = /^\+[0-9]{1,3}[-. ]?[0-9]+$/;
      return this.optional(element) || regex.test(value);
    },
    "Please enter a valid phone number with a country code (e.g., +255)."
  );
  
  $.validator.addMethod(
    "lettersOnly",
    function (value, element) {
      var regex = /^[A-Za-z\s]+$/;
      return this.optional(element) || regex.test(value.replace("'", ""));
    },
    "Please enter a valid name containing only letters."
  );
  $.validator.addMethod(
    "letters",
    function (value, element) {
      var regex = /^[A-Za-z0-9\s]+$/;
      return this.optional(element) || regex.test(value.replace("'", ""));
    },
    "Please enter a valid name containing only letters."
  );
  
  $("#steps").validate({
    rules: {
      name: {
        required: true,
        maxlength: 50,
        lettersOnly: true,
      },
  
      phone: {
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true,
      },
      school_name: {
        required: true,
        maxlength: 100,
        letters: true,
      },     
       region: {
        required: true,
        maxlength: 50,
        lettersOnly: true,
      },
      district: {
        required: true,
        maxlength: 50,
        lettersOnly: true,
      },
      ward: {
        required: true,
        maxlength: 50,
        lettersOnly: true,
      },

    },
    messages: {
      name: {
        required: "Full name is required",
        maxlength: "Full name cannot be more than 50 characters",
        lettersOnly: "Please enter a valid name containing only letters.",
      },
      phone: {
        required: "Phone number is required",
        minlength: "Phone number must be of 10 digits",
      },
      school_name: {
        required: "School Name is required",
        maxlength: "School Name cannot be more than 100 characters",
        lettersOnly: "Please enter a valid name containing only letters.",
      },
      region: {
        required: "Region is required",
        maxlength: "Region cannot be more than 100 characters",
        lettersOnly: "Please enter a valid name containing only letters.",
      },
      district: {
        required: "District is required",
        maxlength: "District cannot be more than 100 characters",
        lettersOnly: "Please enter a valid name containing only letters.",
      },
      ward: {
        required: "Ward is required",
        maxlength: "Ward cannot be more than 100 characters",
        lettersOnly: "Please enter a valid name containing only letters.",
      },
    },
    submitHandler: function (form) {
      form.submit();
    },
  });
  });