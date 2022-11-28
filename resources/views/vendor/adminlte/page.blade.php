@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation --}}
        @if($layoutHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    
    <script>
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
    </script>
@stop
