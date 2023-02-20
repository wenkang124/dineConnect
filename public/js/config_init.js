// Croppie
var croppie_image = $('#image-preview').croppie({
    viewport: {
    width: 150,
    height: 150,
    type: 'circle'
    },
    boundary: {
    width: 200,
    height: 200
    },
    enableExif: true
});

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (event) {
        croppie_image.croppie('bind', {
            url: event.target.result
        });
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        alert('Sorry - you\'re browser doesn\'t support the FileReader API');
    }
}

$(document).on('hidden.bs.modal', '#uploadImage', function (event) {
    $('#file-upload').removeClass('is-invalid');
    $('#no-image').addClass('d-none');
});

$('.create_upload_image_link').on('click', function (ev) {
    croppie_image.croppie('result', {
    type: 'base64',
    format: 'jpeg',
    size: {width: 600, height: 600}
    }).then(function (base64) {
    $('#item-img-output').attr('src', base64);
    $('.create_img').val(base64);
    $('#uploadImage').modal('hide');
    });
});
// End Croppie

// File Upload
$('#file-upload').change(function() {
    if(ValidateSingleInput(this)){
        $('.preview_container').show();
        readFile(this);
        var file = $('#file-upload')[0].files[0].name;
        $(this).next('label').text(file);
    }else{
        Command: toastr["error"]("Invalid Image Type",'Error!')
                toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                }
    }
});

var _validFileExtensions = [".jpg", ".jpeg", ".png"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
        
            if (!blnValid) {
                return false;
            }
        }
    }
    return true;
}
// End File Upload

// IntTelInput
$("#telephone").intlTelInput({
    preferredCountries: ["my","sg"],
    separateDialCode: true,
    utilsScript: "/vendor/build/js/utils.js",
    // preferredCountries: ['my'],
    // separateDialCode: true,
    // allowDropdown: false,
    // onlyCountries:['my'],
});

var countryCode = $(".iti__country[aria-selected='true']").attr('data-country-code');
$('.country_code').val(countryCode);
$('.dial_code').val($('.iti__selected-dial-code').text());


$('#telephone').on('countrychange', function() {
    var countryCode = $(".iti__country[aria-selected='true']").attr('data-country-code');
    // console.log('lo', countryCode);
    // console.log('lo1', $('.iti__selected-dial-code').text());
    $('.country_code').val(countryCode);
    $('.dial_code').val($('.iti__selected-dial-code').text());
    $('#telephone').removeAttr('placeholder');
});

$('#telephone').removeAttr('placeholder');


$("#edit_telephone").intlTelInput({
    // options here
    preferredCountries: ["my","sg"],
    separateDialCode: true,
    utilsScript: "/vendor/build/js/utils.js",
});

$('#edit_telephone').on('countrychange', function() {
    //var countryCode = $(".iti__country[aria-selected='true']").attr('data-country-code');
    var countryCode = $(this).intlTelInput("getSelectedCountryData").iso2;
    // console.log('lo', countryCode);
    // console.log('lo1', $('.iti__selected-dial-code').text());

    //var contact_no = $(this).val();
    // console.log('ess',countryCode );
    // console.log('contact_no',contact_no );
    $('.country_code').val(countryCode);
    $('.dial_code').val($('.iti__selected-dial-code').text());
    $('#edit_telephone').removeAttr('placeholder');
});

$('#edit_telephone').removeAttr('placeholder');

// End IntTelInput

// TimePicker
let time_classes = $(".timepicker");

time_classes.each(function() {
    if($(this).hasClass('start_time')) {
        $(this).datetimepicker({
            format: "LT",
            icons: {
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down"
            }
        });
    }

    if($(this).hasClass('end_time')) {
        $(this).datetimepicker({
            format: "LT",
            icons: {
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down"
            }
        });

    }

    $(this).datetimepicker({
        format: "LT",
        icons: {
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down"
        }
    });
})