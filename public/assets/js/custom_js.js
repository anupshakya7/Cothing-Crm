function previewcard(hotel_id) {
    $("#member_modal_poup").modal("show");
    document.getElementById("update_member_modal_poup").innerHTML = "";

    var url = document.location.origin + "/public/hotel/cardpreview";

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
            hotel_id: hotel_id,
        },
        dataType: "json",
        beforeSend: function () {
            $("#AjaxLoader").hide();
        },
        success: function (response) {
            document.getElementById("update_member_modal_poup").innerHTML =
                response.html;
        },
        error: function (error) {
            toastr.error("The Operation cannot performed right now.");
            $("#AjaxLoader").hide();
            //console.log("error", error);
        },
    });
}

function claimcard(member_id) {
    var url = document.location.origin + "/hotel/verify-membercard";

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
            member_id: member_id,
        },
        dataType: "json",
        beforeSend: function () {
            $("#AjaxLoader").hide();
        },
        success: function (response) {
            $('#member_modal_poup').modal('show');
            document.getElementById('update_member_modal_poup').innerHTML = '';

            document.getElementById("update_member_modal_poup").innerHTML =
                response.html;
        },
        error: function (error) {
            toastr.error("The Operation cannot performed right now.");
            $("#AjaxLoader").hide();
            //console.log("error", error);
        },
    });
}

function resendcode(member_id) {
    var url = document.location.origin + "/hotel/resend-code";

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
            member_id: member_id,
        },
        dataType: "json",
        beforeSend: function () {
            $("#AjaxLoader").hide();
        },
        success: function (response) {
            toastr.success("Verification code resend to register member phone number.");

        },
        error: function (error) {
            toastr.error("The Operation cannot performed right now.");
            $("#AjaxLoader").hide();
            //console.log("error", error);
        },
    });
}

function addmembership(hotel_id) {
    $("#membership_modal_poup").modal("show");

    var url = document.location.origin + "/public/hotel/showaddmembership";

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
            hotel_id: hotel_id,
        },
        dataType: "json",
        beforeSend: function () {
            $("#AjaxLoader").hide();
        },
        success: function (response) {
            document.getElementById("update_membership_modal_poup").innerHTML =
                response.html;
        },
        error: function (error) {
            toastr.error("The Operation cannot performed right now.");
            $("#AjaxLoader").hide();
            //console.log("error", error);
        },
    });
}

function printDivContent() {
    $("body").scrollTop(0);
    createPDF();
}

function createPDF() {
    getCanvas().then(function (canvas) {
        var img = canvas.toDataURL("image/png"),
            doc = new jsPDF({
                unit: "px",
                format: "a4",
            });
        doc.addImage(img, "JPEG", 20, 20);
        doc.save("Membership card");
        form.width(cache_width);
    });
}

function getCanvas() {
    var form = $("#divCon"),
        cache_width = form.width(),
        a4 = [600, 480];

    form.width(a4[0] * 1.33333 - 100).css("max-width", "none");

    return html2canvas(form, {
        imageTimeout: 2000,
        removeContainer: true,
    });
}

function addsubscription(hotel_id) {
    var start_date = $("input[name='start_date_" + hotel_id + "']").val();
    var expiry_date = $("input[name='expiry_date_" + hotel_id + "']").val();
    var payment_date = $("input[name='payment_date_" + hotel_id + "']").val();

    document.getElementById("start_date_error_" + hotel_id).innerHTML = "";

    document.getElementById("expiry_date_error_" + hotel_id).innerHTML = "";
    // document.getElementById('payment_date_error'+hotel_id).innerHTML = "";

    var url = document.location.origin + "/public/hotel/addmembership";

    var err = 0;

    if (!start_date) {
        document.getElementById("start_date_error_" + hotel_id).innerHTML =
            "start date cannot be blank.";
        err++;
    }

    if (!expiry_date) {
        document.getElementById("expiry_date_error_" + hotel_id).innerHTML =
            "Expiry date cannot be blank.";
        err++;
    }
    if (err == 0) {
        var ajaxData = {
            start_date: start_date,
            expiry_date: expiry_date,
            payment_date: payment_date,
            hotel_id: hotel_id,
        };

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
                ajaxData: ajaxData,
            },
            dataType: "json",
            beforeSend: function () {
                $("#AjaxLoader").hide();
            },
            success: function (response) {
                location.reload();
                toastr.success("Membership Added Successfully");
            },
            error: function (error) {
                toastr.error("The Operation cannot performed right now.");
                $("#AjaxLoader").hide();
                //console.log("error", error);
            },
        });
    }
}

function addcharge() {
    var date = $("input[name='date']").val();
    var title = $("#title").val();
    var charge = $("#charge").val();

    document.getElementById("title_error").innerHTML = "";

    document.getElementById("date_error").innerHTML = "";
    document.getElementById("charge_error").innerHTML = "";

    var url = document.location.origin + "/public/charge/create";

    var err = 0;

    if (!title) {
        document.getElementById("title_error").innerHTML =
            "Title cannot be blank.";
        err++;
    }

    if (!charge) {
        document.getElementById("charge_error").innerHTML =
            "Charge cannot be blank.";
        err++;
    }

    if (!date) {
        document.getElementById("date_error").innerHTML =
            "Date cannot be blank.";
        err++;
    }
    if (err == 0) {
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
                title: title,
                charge: charge,
                date: date,
            },
            dataType: "json",
            beforeSend: function () {
                $("#AjaxLoader").hide();
            },
            success: function (response) {
                location.reload();
                toastr.success("Membership Added Successfully");
            },
            error: function (error) {
                toastr.error("The Operation cannot performed right now.");
                $("#AjaxLoader").hide();
                //console.log("error", error);
            },
        });
    }
}
