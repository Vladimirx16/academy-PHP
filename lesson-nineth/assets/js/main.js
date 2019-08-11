// document.onmousemove = function (event) {
//     let x = event.x - 810;
//     let y = event.y - 200;
//     console.log(x + ' ' + y);
//     document.querySelector('.eye.-first').style.transform = 'rotate(45deg)';
// }

jQuery(document).ready(function($) {
    $('#delete_checkbox').on('change', function() {
       if ($(this).prop('checked') == true) {
           $('#delete_account').prop('disabled', false);
       } else {
           $('#delete_account').prop('disabled', true);
       }
    });
});

jQuery(document).ready(function($) {

    $('#login_input').on('click', function() {
        $('.kgb-region').fadeIn(1000);
        $('.kgb-region').css('display', 'flex');
        $('.kgb-region .eye').css('display', 'block ');
    });

   $('#login_input').on('keyup', function() {
        if ($(this).val() !== '') {
            $('.eye.-first').css('margin-top', '2px');
            $('.eye.-second').css('margin-top', '2px');
            $('.eye.-third').css('margin-top', '2px');
            $('.eye.-fourth').css('margin-top', '2px');
            if ($(this).val().length < 6) {
                $('.eye.-first').css('margin-left', $(this).val().length);
                $('.eye.-second').css('margin-left', $(this).val().length);
                $('.eye.-third').css('margin-right', 0);
                $('.eye.-fourth').css('margin-right', 0);
            }
            if ($(this).val().length > 13 && $(this).val().length < 21) {
                $('.eye.-third').css('margin-right', -($(this).val().length)+13);
            }
            if ($(this).val().length > 17 && $(this).val().length < 25) {
                $('.eye.-fourth').css('margin-right', -($(this).val().length)+17);
            }
        } else {
            $('.eye.-first').css('margin-top', '0');
            $('.eye.-first').css('margin-left', '0');
            $('.eye.-second').css('margin-top', '0');
            $('.eye.-second').css('margin-left', '0');
            $('.eye.-third').css('margin-top', '0');
            $('.eye.-third').css('margin-right', '-6px');
            $('.eye.-fourth').css('margin-top', '0');
            $('.eye.-fourth').css('margin-right', '-4px');
        }
   });

   $('#password_input').on('keyup', function() {
       if ($(this).val() !== '') {
           $('.eye.-first').css('margin-top', '2px');
           $('.eye.-second').css('margin-top', '2px');
           $('.eye.-third').css('margin-top', '2px');
           $('.eye.-fourth').css('margin-top', '2px');
           if ($(this).val().length < 6) {
               $('.eye.-first').css('margin-left', $(this).val().length);
               $('.eye.-second').css('margin-left', $(this).val().length);
               $('.eye.-third').css('margin-right', 0);
               $('.eye.-fourth').css('margin-right', 0);
           }
           if ($(this).val().length > 40 && $(this).val().length < 50) {
               $('.eye.-third').css('margin-right', -($(this).val().length)+40);
               $('.eye.-fourth').css('margin-right', 0);
           }
           if ($(this).val().length > 44 && $(this).val().length < 54) {
               $('.eye.-fourth').css('margin-right', -($(this).val().length)+44);
           }
       } else {
           $('.eye.-first').css('margin-top', '0');
           $('.eye.-first').css('margin-left', '0');
           $('.eye.-second').css('margin-top', '0');
           $('.eye.-second').css('margin-left', '0');
           $('.eye.-third').css('margin-top', '0');
           $('.eye.-third').css('margin-right', '-6px');
           $('.eye.-fourth').css('margin-top', '0');
           $('.eye.-fourth').css('margin-right', '-4px');
       }
   });

    $('body').on('click', function(e) {
        if (!$('#login_input').is(e.target) && !$('#password_input').is(e.target)) {
            $('.eye.-first').css('margin-top', '0');
            $('.eye.-first').css('margin-left', '0');
            $('.eye.-second').css('margin-top', '0');
            $('.eye.-second').css('margin-left', '0');
            $('.eye.-third').css('margin-top', '0');
            $('.eye.-third').css('margin-right', '-6px');
            $('.eye.-fourth').css('margin-top', '0');
            $('.eye.-fourth').css('margin-right', '-4px');
        }
    })
});

jQuery(document).ready(function($) {


    /*======= Skillset *=======*/
    
    
    $('.level-bar-inner').css('width', '0');
    
    $(window).on('load', function() {

        $('.level-bar-inner').each(function() {
        
            var itemWidth = $(this).data('level');
            
            $(this).animate({
                width: itemWidth
            }, 800);
            
        });

    });
   
    

});