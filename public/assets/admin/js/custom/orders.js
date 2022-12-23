$(document).ready(function(){

/**************** Datatable Script Start *************/

if($('table').hasClass('my-datatable')){
   jQuery('.my-datatable').dataTable({
   	dom: 'Bfrtip',
       buttons: [
           'colvis'
       ],
       aoColumnDefs: [{
          bSortable: false,
          aTargets: [0,10]
       },
    	]
     });
}

/**************** Datatable Script End *************/

/**************** Re-process Payment Script Start *************/ 

$('body').on('click','a.reprocess-btn',function(){
    showProgressBar();
    $('form.reprocess-order-form')[0].reset();
    setTimeout(function(){
        $('#noAnimation').modal({show:true});
    },200);
    hideProgressBar();
})

/**************** Re-process Payment Script End ***************/

/**************** Re-process Payment Submit Script Start *************/

var form_object = jQuery(".reprocess-order-form");
form_object.validate({
    ignore: ":hidden:not(select.chosen-select)",
    rules:{
        amount:{
            required: true
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
        $.ajax({
            url: api_url + 'reprocess/payment',
            type:"POST",
            data: $('.reprocess-order-form').serialize(),
            success: function(resp){
                if(resp.status == 200){
                    showToaster('success','Success !',resp.message);  
                    setTimeout(function(){
                        window.location.href = `${base_url}admin/orders/details/${resp.data.order_guid}`;
                    },2000);
                }else{
                    showToaster('error','Error !',resp.message);  
                }
                hideProgressBar();
            }
        });
    }
});

/**************** Re-process Payment Submit Script End ***************/

});