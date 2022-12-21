$(document).ready(function(){

/**************** Update Configurations Script Start ***************/

var form_object = jQuery(".update-configuration-form");
form_object.validate({
    ignore: ":hidden:not(select.chosen-select)",
    rules:{
        stripe_mode:{
            required: true
        },
        stripe_currency:{
            required: true
        },
        stripe_publishable_key:{
            required: true,
        },
        stripe_secret_key:{
            required: true,
        },
        statement_descriptor:{
            required: true,
        },
        description:{
            required: true,
        },
        website_name:{
            required: true,
        }
    },
    highlight: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      jQuery(element[0]).remove();
    },
    submitHandler: function() {
        var formData = new FormData($(".update-configuration-form")[0]);
        $.ajax({
            url: api_url + 'dashboard/update_configurations',
            type:"POST",
            data: formData,
            dataType : "JSON",   
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp){
                if(resp.status == 200){
                    showToaster('success','Success !',resp.message);  
                    setTimeout(function(){
                        window.location.reload();
                    },1000)
                }else{
                    showToaster('error','Error !',resp.message);  
                }
                hideProgressBar();
            }
        });
    }
});

/**************** Update Configurations Script End *****************/


});

