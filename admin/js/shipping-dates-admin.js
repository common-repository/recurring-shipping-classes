jQuery(document).ready(function ($) { 
    
    // Datepicker for woocommerce shipping dates
    $(".datepicker_shipping_class").datepicker( { 
         changeYear: false, 
         dateFormat: 'mm-dd'
     } ).focus(function () {
         $(".ui-datepicker-year").hide();
     });
    
    // Add button
    $(".add-shipping-block").on( 'click', function(e){
        e.preventDefault();
        var shippingBlocks = $( "#shipping_form .options_group" ).length;
        shippingBlocks = shippingBlocks-1;
        var removeButton   = '<input class="remove-shipping-block button" type="button" value="Remove"/>'

        // Clone the shipping block and change some class
        $( "#shipping_form .options_group.group_0" ).clone().appendTo( "#shipping_form" ).removeClass( 'group_0' ).addClass( 'added_class' ).append( removeButton );
        
        // Add the datepicker
        $(".added_class:last-child .datepicker_shipping_class").removeClass( 'hasDatepicker' ).attr( 'id', '_datepicker_shipping_class_'+shippingBlocks ).val('').datepicker( { 
            changeYear: false, 
            dateFormat: 'mm-dd'
        } ).focus(function () {
            $(".ui-datepicker-year").hide();
        });
    });
    
    // Remove button
    $( document ).on( 'click', '.remove-shipping-block', function(e){
        e.preventDefault();
        $(this).parent().remove();
    });
    
});