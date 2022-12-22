var is_first_order = 0;
var old_no_of_practices = 0;

$(document).ready(function(){

$( "input.form-check-input" ).change(function(){
   let self  = $(this);
   var value = self.val();
   if(self.is(":checked")) {
      self.parent().addClass('selected');
   } else {
      self.parent().removeClass('selected');
   }
});

$('.dropdown-menu li').on('click', function() {
   var getValue = $(this).text();
   $('.dropdown-select').text(getValue);
});

/*****************************************************************************
***********************Validate only numbers end *****************************
******************************************************************************/

$('body').on('keypress','.validate-no',function(event){
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode == 46){
       return false;
    }
    if (event.keyCode == 9 || event.keyCode == 8 || event.keyCode == 46) {
       return true;
    }
    else if ( key < 48 || key > 57 ) {
       return false;
    }
    else {
       return true;   
    }
});

/*****************************************************************************
***********************Validate only numbers end *****************************
******************************************************************************/
ajaxindicatorstart();

/* Create Stripe Elements */
const stripe = Stripe(atob($('input.pk').val()));
const elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
var style = {
  base: {
    // Add your base input styles here. For example:
    fontSize: '16px',
    color: '#32325d',
    lineHeight : '3.5',
  },
};

// Create an instance of the card Element.
const card = elements.create('card', {style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

ajaxindicatorstop();

/* Submit Form */
$("#payment-form").submit(async function(event) {
    event.preventDefault();

    /* Create Stripe Token */
    const {token, error} = await stripe.createToken(card);
    if (error) {
        swal({
          type : "error",
          title: "Error !!",
          text: error.message
        });
        return false;
    }

    var form_data = new FormData($('#payment-form')[0]);
    form_data.append('stripe_token', token.id);
    form_data.append('client_ip', token.client_ip);
    $.ajax({
            url  : "api/user/payment",
            type : "POST",
            data : form_data,   
            dataType : "JSON",   
            cache: false,
            contentType: false,
            processData: false,   
            beforeSend:function(){
              ajaxindicatorstart();
            },       
            success: function(resp){
               if(resp.status == 200){
                    swal({
                      type : "success",
                      title: "Success !!",
                      text: resp.message
                    });
                    setTimeout(function(){
                        window.location.reload();
                    },4000);
                }else{
                    swal({
                      type : "error",
                      title: "Error !!",
                      text: resp.message
                    });
                }
                ajaxindicatorstop();
            },
            error:function(jqXHR, exception){
                ajaxindicatorstop();
            }
        });
});

});

/*****************************************************************************
**********************Ajax loader start ***************************************
******************************************************************************/

function ajaxindicatorstart()
{
    if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
    jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="assets/img/ajax-loader.gif"><div>Loading...</div></div><div class="bg"></div></div>');
    }
    
    jQuery('#resultLoading').css({
        'width':'100%',
        'height':'100%',
        'position':'fixed',
        'z-index':'10000000',
        'top':'0',
        'left':'0',
        'right':'0',
        'bottom':'0',
        'margin':'auto'
    }); 
    
    jQuery('#resultLoading .bg').css({
        'background':'#000000',
        'opacity':'0.7',
        'width':'100%',
        'height':'100%',
        'position':'absolute',
        'top':'0'
    });
    
    jQuery('#resultLoading>div:first').css({
        'width': '250px',
        'height':'75px',
        'text-align': 'center',
        'position': 'fixed',
        'top':'0',
        'left':'0',
        'right':'0',
        'bottom':'0',
        'margin':'auto',
        'font-size':'16px',
        'z-index':'10',
        'color':'#ffffff'
        
    });

    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}

function ajaxindicatorstop()
{
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}

/*****************************************************************************
**********************Ajax loader end ****************************************
******************************************************************************/
