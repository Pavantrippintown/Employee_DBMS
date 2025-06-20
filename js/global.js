(function ($) {
    'use strict';
    
    /*==================================================================
        [ Futuristic Loader ]*/
    $(window).on('load', function() {
        $('.futuristic-loader').fadeOut(500, function() {
            $('body').addClass('loaded');
            // Initialize particles if needed
            if(typeof particlesJS !== 'undefined') {
                particlesJS.load('particles-js', 'assets/particles.json', function() {
                    console.log('Particles.js loaded');
                });
            }
        });
    });
    
    /*==================================================================
        [ Daterangepicker ]*/
    try {
        $('.js-datepicker').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoUpdateInput": false,
            "opens": "center",
            "drops": "up",
            locale: {
                format: 'YYYY/MM/DD',
                applyLabel: 'Confirm',
                cancelLabel: 'Clear',
                daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
        });
    
        var myCalendar = $('.js-datepicker');
        var isClick = 0;
    
        $(window).on('click',function(){
            isClick = 0;
        });
    
        $(myCalendar).on('apply.daterangepicker',function(ev, picker){
            isClick = 0;
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
            $(this).addClass('has-value');
        });
    
        $('.js-btn-calendar').on('click',function(e){
            e.stopPropagation();
    
            if(isClick === 1) isClick = 0;
            else if(isClick === 0) isClick = 1;
    
            if (isClick === 1) {
                myCalendar.focus();
            }
        });
    
        $(myCalendar).on('click',function(e){
            e.stopPropagation();
            isClick = 1;
        });
    
        $('.daterangepicker').on('click',function(e){
            e.stopPropagation();
        });
    
    } catch(er) {console.log(er);}
    
    /*==================================================================
        [ Select 2 Config ]*/
    try {
        var selectSimple = $('.js-select-simple');
    
        selectSimple.each(function () {
            var that = $(this);
            var selectBox = that.find('select');
            var selectDropdown = that.find('.select-dropdown');
            selectBox.select2({
                dropdownParent: selectDropdown,
                minimumResultsForSearch: Infinity,
                width: '100%'
            });
            
            // Add custom styling
            selectBox.on('select2:open', function() {
                $('.select2-dropdown').addClass('futuristic-dropdown');
            });
        });
    
    } catch (err) {
        console.log(err);
    }
    
    /*==================================================================
        [ Futuristic Form Validation ]*/
    $('form').on('submit', function(e) {
        var form = $(this);
        var inputs = form.find('input[required], select[required], textarea[required]');
        var valid = true;
        
        inputs.each(function() {
            if(!$(this).val()) {
                $(this).addClass('error');
                valid = false;
            } else {
                $(this).removeClass('error');
            }
        });
        
        if(!valid) {
            e.preventDefault();
            form.find('.error').first().focus();
            
            // Add error animation
            form.addClass('shake');
            setTimeout(function() {
                form.removeClass('shake');
            }, 500);
        }
    });
    
    /*==================================================================
        [ Hover Effects ]*/
    $('.card, .btn, nav ul li a').on('mouseenter', function() {
        $(this).addClass('hover');
    }).on('mouseleave', function() {
        $(this).removeClass('hover');
    });
    
    /*==================================================================
        [ Futuristic Alerts ]*/
    window.futuristicAlert = function(message, type = 'success') {
        var alert = $('<div class="futuristic-alert futuristic-alert-' + type + '">' + message + '</div>');
        $('body').append(alert);
        alert.fadeIn(300).delay(3000).fadeOut(400, function() {
            $(this).remove();
        });
    };
    
    // Check for alert messages in URL
    if(window.location.href.indexOf('?alert=') > -1) {
        var alertMessage = decodeURIComponent(window.location.href.split('?alert=')[1].split('&')[0]);
        var alertType = window.location.href.indexOf('&type=') > -1 ? 
            window.location.href.split('&type=')[1] : 'success';
        futuristicAlert(alertMessage, alertType);
    }

})(jQuery);