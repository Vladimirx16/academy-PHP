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

jQuery(document).ready(function($)
{
    const FORM_NAME = $('#form_name');

    $(FORM_NAME).hover(
        function()
        {
        $(this).css('max-width', '100px');
        },
        function()
        {
            if ($(this).val() !== '')
            {
                $(this).css('max-width', '100px');
            }
            else
                {
                $(this).css('max-width', '25px');
                }
        }
    );
    $(FORM_NAME).on('keyup', function()
    {
        if ($(this).val() !== '')
        {
            $(this).css('max-width', '100px');
        }
        else
            {
            $(this).css('max-width', '25px');
            }
    })
});