  //function to create offers
  $('#createoffer').click(function(){
    var offer_name = $('#offer_name').val();
    var biz_id = $('#selected_offer_biz_id').val();
    var offer_image = $("input[name='eventimage']").val();
    var offer_discount = $('#offer_discount').val();
    var offer_count = $('#offer_count').val();
    var offer_date_from = $("input[name='offer_date_from']").val();
    var offer_date_to = $("input[name='offer_date_to']").val();
    var offer_status = $('#offer_status').val();
    var discount_type = $('#offer_discount_type').val();


    document.getElementById('offer_name_error').innerHTML = "";
    document.getElementById('offer_discount_error').innerHTML = "";
    document.getElementById('offer_discount_type_error').innerHTML = "";
    document.getElementById('offer_count_error').innerHTML = "";
    document.getElementById('selected_offer_biz_id_error').innerHTML = "";
    document.getElementById('offer_date_from_error').innerHTML = "";
    document.getElementById('offer_date_to_error').innerHTML = "";
    document.getElementById('offer_status_error').innerHTML = "";

    var url = document.location.origin + "/offers/createoffer";

    var err=0;

    if (!offer_name) {
    document.getElementById('offer_name_error').innerHTML = 'Offer Name cannot be blank.';
    err++;

    }


    if (!offer_discount) {
        document.getElementById('offer_discount_error').innerHTML = 'Offer Discount cannot be blank.';
        err++;

        }
    if (!discount_type) {
        document.getElementById('offer_discount_type_error').innerHTML = 'Offer Discount type cannot be blank.';
        err++;

        }

    if (!offer_count) {
        document.getElementById('offer_count_error').innerHTML = 'Offer Discount cannot be blank.';
        err++;

        }

        if (!biz_id) {
            document.getElementById('selected_offer_biz_id_error').innerHTML = 'Business cannot be blank.';
            err++;

            }


    if (!offer_date_from) {
        document.getElementById('offer_date_from_error').innerHTML = 'Start Date cannot be blank.';
        err++;

    }


    if (!offer_date_to) {
        document.getElementById('offer_date_to_error').innerHTML = 'End Date cannot be blank.';
        err++;

    }


    if(offer_date_from > offer_date_to){
        document.getElementById('offer_date_to_error').innerHTML = 'End Date must be greater than Start Date.';
        err++;

    }

    if(!offer_status){
        document.getElementById('offer_status_error').innerHTML = 'Status Cannot be blank.';
        err++;

    }


if(err==0){

    var ajaxData = {
        offer_name:offer_name,
        offer_image:offer_image,
        discount:offer_discount,
        offer_count:offer_count,
        biz_id:biz_id,
        start_date:offer_date_from,
        end_date:offer_date_to,
        status:offer_status,
        discount_type:discount_type,
        }


    //  event.preventDefault();
    //  jQuery.noConflict();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
    url: url,
        type: "POST",
        dataType: "json",
        data: {
            ajaxData : ajaxData

        },
        success: function (response) {
            location.reload();
            toastr.success("Offers Created Successfully");



        // setTimeout(function() {
        //     $("#AjaxLoader").hide()
        // }, 1000);
    },
    error: function (error) {

        toastr.error('The Operation cannot performed right now.');
        $("#AjaxLoader").hide()
        console.log("error", error);
    },
    });

}

});

function updatecontent(offer_id){
var url = document.location.origin + "/offers/updateoffercontent";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
$.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: {
        offer_id:offer_id,

    },
    dataType: 'json',
    beforeSend: function () {
        $("#AjaxLoader").hide();
    },
     success: function(response) {

        document.getElementById('update_offer_content').innerHTML = response.html;
        $("#updateofferModal").modal('show');

        },
        error: function (error) {
            toastr.error('The Operation cannot performed right now.');
            $("#AjaxLoader").hide()
             //console.log("error", error);
         },

    });
}


function deleteoffer(offer_id)
{
var offer_id = offer_id;
var url = document.location.origin + "/offers/deleteoffer";

event.preventDefault();
swal({
    title: "Are you sure you want to delete this record?",
    text: "If you delete this, it will be gone forever.",
    icon: "warning",
    type: "warning",
    buttons: ["Cancel","Yes!"],
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
}).then((willDelete) => {
    if (willDelete) {
        $.ajaxSetup({
            headers: {
             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
                data: {
                offer_id:offer_id,

                },
            success: function (data) {
              toastr.success('Offer deleted Successfully.');
              location.reload();

            },
            error: function (error) {
                toastr.error('The Operation cannot performed right now.');
                $("#AjaxLoader").hide()
                 //console.log("error", error);
             },
        });
    }
});

}


function updateoffer(offer_id){
var offer_id = offer_id;
var offer_name = $('#offer_name'+offer_id).val();
var biz_id = $('#selected_offer_biz_id'+offer_id).val();
var offer_image = $("input[name='eventimage_"+offer_id+"']").val();
var offer_discount = $('#offer_discount'+offer_id).val();
var offer_count = $('#offer_count'+offer_id).val();
var offer_date_from = $("input[name='offer_date_from"+offer_id+"']").val();
var offer_date_to = $("input[name='offer_date_to"+offer_id+"']").val();
var offer_status = $('#offer_status'+offer_id).val();
var discount_type = $('#offer_discount_type'+offer_id).val();

document.getElementById('offer_name_error'+offer_id).innerHTML = "";
document.getElementById('offer_discount_error'+offer_id).innerHTML = "";
document.getElementById('offer_discount_type_error'+offer_id).innerHTML = "";
document.getElementById('offer_count_error'+offer_id).innerHTML = "";
document.getElementById('selected_offer_biz_id_error'+offer_id).innerHTML = "";
document.getElementById('offer_date_from_error'+offer_id).innerHTML = "";
document.getElementById('offer_date_to_error'+offer_id).innerHTML = "";
document.getElementById('offer_status_error'+offer_id).innerHTML = "";

var url = document.location.origin + "/offers/update_offer";

var err=0;

if (!offer_name) {
document.getElementById('offer_name_error'+offer_id).innerHTML = 'Offer Name cannot be blank.';
err++;

}


if (!offer_discount) {
    document.getElementById('offer_discount_error'+offer_id).innerHTML = 'Offer Discount cannot be blank.';
    err++;

    }
if (!discount_type) {
    document.getElementById('offer_discount_type_error'+offer_id).innerHTML = 'Offer Discount type cannot be blank.';
    err++;

    }

if (!offer_count) {
    document.getElementById('offer_count_error'+offer_id).innerHTML = 'Offer Discount cannot be blank.';
    err++;

    }

    if (!biz_id) {
        document.getElementById('selected_offer_biz_id_error'+offer_id).innerHTML = 'Business cannot be blank.';
        err++;

        }


if (!offer_date_from) {
    document.getElementById('offer_date_from_error'+offer_id).innerHTML = 'Start Date cannot be blank.';
    err++;

}


if (!offer_date_to) {
    document.getElementById('offer_date_to_error'+offer_id).innerHTML = 'End Date cannot be blank.';
    err++;

}


if(offer_date_from > offer_date_to){
    document.getElementById('offer_date_to_error'+offer_id).innerHTML = 'End Date must be greater than Start Date.';
    err++;

}

if(!offer_status){
    document.getElementById('offer_status_error'+offer_id).innerHTML = 'Status Cannot be blank.';
    err++;

}


if(err==0){

var ajaxData = {
    offer_id:offer_id,
    offer_name:offer_name,
    offer_image:offer_image,
    discount:offer_discount,
    offer_count:offer_count,
    biz_id:biz_id,
    start_date:offer_date_from,
    end_date:offer_date_to,
    status:offer_status,
    discount_type:discount_type,
    }

//  event.preventDefault();
//  jQuery.noConflict();
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
$.ajax({
url: url,
    type: "POST",
    dataType: "json",
    data: {
        ajaxData : ajaxData

    },
    success: function (response) {
        location.reload();
        toastr.success("Offers updated Successfully");


    // setTimeout(function() {
    //     $("#AjaxLoader").hide()
    // }, 1000);
},
error: function (error) {

    toastr.error('The Operation cannot performed right now.');
    $("#AjaxLoader").hide()
    console.log("error", error);
},
});

}

}


// function downloadoffer(offer_id){

//     var url = document.location.origin + "/downloadoffer";
//     event.preventDefault();
//     swal({
//         title: "Are you sure you want to collect this offer coupon",
//         text: "You have to use this offer before the end data.",
//         icon: "warning",
//         type: "warning",
//         buttons: ["Cancel","Yes!"],
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'
//     }).then((willDelete) => {
//         if (willDelete) {

//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//     });
//     $.ajax({
//     url: url,
//         type: "POST",
//         dataType: "json",
//         data: {
//             offer_id : offer_id

//         },

//         success: function (response) {

//             var blob = new Blob([response]);
//             var link = document.createElement('a');
//             link.href = window.URL.createObjectURL(blob);
//             link.download = "Sample.pdf";
//             link.click();

//             $("#AjaxLoader").hide()

//         // setTimeout(function() {
//         //     $("#AjaxLoader").hide()
//         // }, 1000);
//     },
//     error: function(blob){
//         console.log(blob);
//         toastr.error('The Operation cannot performed right now.');
//         $("#AjaxLoader").hide()
//   ;
//     },
//     });
// }
// });


// }


function confirmation(location,end_date) {
swal({

    title: "Are you sure you want to collect this offer coupon ? ",
    text: "Coupon should be used before "+end_date+".",
  icon: "warning",
  buttons: ["Cancel","Yes!"],
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
})
.then((willDelete) => {
  if (willDelete) {
    window.location = location;
    $("#AjaxLoader").show();
    setTimeout(function() {
        $("#AjaxLoader").hide('blind', {}, 500)
    }, 5000);
  }
});
}

function redeemcoupon(location) {
    swal({
        title: "Are you sure  want to redeem this offer coupon",
      icon: "warning",
      buttons: ["Cancel","Yes!"],
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    })
    .then((willDelete) => {
      if (willDelete) {
        window.location = location;

      }
    });
    }


function unauthorized() {
    swal({
        title: "!!! Unauthorized !!!",
        text: "You are not authorized business user to redeem this code.",
        icon: "warning",
        buttons: ["Cancel","Yes!"],
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    })

    }



 function offeremail(downloaded_id){

    var url = document.location.origin + "/offer/showcardemail";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: {
        downloaded_id:downloaded_id,
        },
    dataType: 'json',
    beforeSend: function () {
        $("#AjaxLoader").hide();
    },
     success: function(response) {

        document.getElementById('event_update_content').innerHTML = response.html;
        $('#event_update_modal').modal('show');

        },
        error: function (error) {
            toastr.error('The Operation cannot performed right now.');
            $("#AjaxLoader").hide()
             //console.log("error", error);
         },

    });



}

function sendoffer(downloaded_id){

    var url = document.location.origin + "/offer/sendofferemail";

    var recipient_name = $('#recipient_name_'+downloaded_id).val();
    var recipient_email = $('#recipient_email_'+downloaded_id).val();
    var message = $('#message_'+downloaded_id).val();



    document.getElementById('recipient_name_error_'+downloaded_id).innerHTML = "";
    document.getElementById('recipient_email_error_'+downloaded_id).innerHTML = "";
    document.getElementById('message_error_'+downloaded_id).innerHTML = "";
    var err=0;

    if (!recipient_name) {
    document.getElementById('recipient_name_error_'+downloaded_id).innerHTML = 'Receipient Name cannot be blank.';
    err++;

    }

    if (!recipient_email) {
    document.getElementById('recipient_email_error_'+downloaded_id).innerHTML = 'Receipient Email cannot be blank.';
    err++;

    }
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;



     if(recipient_email && (!(recipient_email.match(mailformat)))){
        document.getElementById('recipient_email_error_'+downloaded_id).innerHTML = 'Please, enter valid email address.';
        err++;
     }




        if(err==0){


        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            downloaded_id:downloaded_id,
            recipient_name:recipient_name,
            recipient_email:recipient_email,
            message:message,

            },
        dataType: 'json',

            success: function(response) {

                toastr.success('Coupon Send Successfully to receipient email.');
                location.reload();

            },
            error: function (error) {
                toastr.error('The Operation cannot performed right now.');
                $("#AjaxLoader").hide()
                    //console.log("error", error);
                },

        });
    }



    }
