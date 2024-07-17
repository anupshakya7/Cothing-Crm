@extends('sms::layouts.main')

@section('content')
    <style>
        .sms-contacts {
            max-height: 630px;
            overflow: auto;
        }

        form label {
            padding: 8px 0px;
        }

        #chars {
            padding: 10px 10px;
            position: relative;
            top: -35px;
            font-size: 12px;
            font-style: italic;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ 'SMS' }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">{{ 'SMS' }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row  mt-5">
                <div class="col-5">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a class="btn btn-success add-contacts" href="#">
                                            <i class="ri-add-circle-line align-middle me-1"></i>
                                            {{ "
                                                                                                                                                                                    Add contacts to send SMS" }}
                                            <span class="total"></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <div class="form-check checkbox">
                                            <input type="checkbox" class="form-check-input block_check_all" />
                                            <label class="form-check-label" for="formCheck6">Check All</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body sms-contacts">

                            <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box accordion-success"
                                id="accordionBordered">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="accordionborderedMember">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#accor_member" aria-expanded="true"
                                            aria-controls="accor_borderedExamplecollapse1">
                                            Customer
                                        </button>
                                    </h2>
                                    <div id="accor_member" class="accordion-collapse collapse"
                                        aria-labelledby="accordionborderedMember" data-bs-parent="#accordionBordered">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="to">Select Letter</label>

                                                    <select name="filter_letter" class="form-select select2 me-2"
                                                        id="filter_name">
                                                        <option value="">Select Letter</option>
                                                        @foreach (range('A', 'Z') as $letter)
                                                            <option value="{{ $letter }}"
                                                                {{ request('filter_letter') == $letter ? 'selected' : '' }}>
                                                                {{ $letter }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="to">Customer:</label>
                                                    <input type="text" id="customer_name" name="customer_name"
                                                        class="form-control" placeholder="Search customer"
                                                        value="{{ request('customer_name') }}">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="to">Customer Phone Number</label>
                                                    <input type="text" id="phone_number" name="phone_number"
                                                        class="form-control" placeholder="Search phone_number"
                                                        value="{{ request('phone_number') }}">
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-success w-50 my-3" id="searchBtn">Search</button>
                                                </div>

                                            </div>

                                            <div class="checkbox"><label><input type="checkbox"
                                                        class="form-check-input member_check_all">Check All</label></div>
                                            <div id="customer_list">
                                                @foreach ($customers as $customer)
                                                    <div class="row g-4 align-items-center box">
                                                        <div class="col-sm">
                                                            <div class="form-check form-check-success mb-12">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="formCheck6"
                                                                    number="{{ $customer->customer_contact_number }}">
                                                                <label class="form-check-label" for="formCheck6">
                                                                    {{ $customer->customer_name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="d-flex flex-wrap align-items-start gap-2">
                                                                <span>{{ $customer->customer_contact_number }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--form to send sms-->
                <div class="col-7">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0"><i class="ri-mail-send-line"></i> Compose SMS</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div>
                                        <blockquote
                                            class="blockquote custom-blockquote blockquote-outline blockquote-success rounded mb-0">
                                            <h5 class="card-title mb-0" style="font-size:11px;">
                                                <span><?php echo 'Total Credit: रु. ' . $balance . ''; ?></span>
                                            </h5>
                                        </blockquote>
                                        {{-- <h5 class="card-title mb-0" style="font-size:12px;text-decoration:underline"><span>Total Balance: {{"रु. ".$balance}}</span></h5> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!--SMS Form-->
                            <form id="send_msg" method="post" action="{{ route('send.sms') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Sender Number:</label>
                                        <select name="sender_number" class="form-control form-select">
                                            <option value="Tukutuku Nepal">Tukutuku Nepal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>To:<small>(Enter Numbers with comma separated only!!!)</small></label>
                                        <textarea id="destination_content" name="des_number" class="form-control" minlength="10" style="height:100px"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Message Templates:</label>
                                        <?php
                                        $messagess = Modules\SMS\Entities\Message::all();
                                        
                                        ?>
                                        <select id="msg_tpl_select" name="msg_template" class="form-control form-select">
                                            <option value="">Select Message Template</option>
                                            @foreach ($messagess as $message)
                                                <option value="{{ $message->body }}">{{ $message->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Message Type:</label>
                                        <input type="radio" name="text_type" value='text'
                                            class="iradio_minimal-red checked"
                                            checked=checked><label>Text</label><!--<input type="radio" name="text_type" value="unicode" class="iradio_minimal-red"><label>Unicode(Nepali Language)</label></div>-->
                                        <div class="form-group">
                                            <textarea class="form-control message_content required" rows="8" maxlength="250" name="message"
                                                placeholder="Type Your Message Here ..."></textarea>
                                            <p class="clearfix" id="chars"></p>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="form-group">
                                            <button class="btn btn-success" name="send_msg" type="submit">
                                                <i class="ri-mail-send-line"></i> Send Message
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(".block_check_all").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });


        $('.accordion-body').on('click', '.member_check_all', function() {

            if ($(this).is(":checked")) {
                $(this).parents('.accordion-body').find('input[type="checkbox"]').prop('checked', true);
                //console.log('hello');
            } else {
                $(this).parents('.accordion-body').find('input[type="checkbox"]').prop('checked', false);

            }
        });


        $('.accordion-body').on('click', '.senior_check_all', function() {

            if ($(this).is(":checked")) {
                $(this).parents('.accordion-body').find('input[type="checkbox"]').prop('checked', true);
                //console.log('hello');
            } else {
                $(this).parents('.accordion-body').find('input[type="checkbox"]').prop('checked', false);

            }
        });

        $('.accordion-body').on('click', '.owner_check_all', function() {

            if ($(this).is(":checked")) {
                $(this).parents('.accordion-body').find('input[type="checkbox"]').prop('checked', true);
                //console.log('hello');
            } else {
                $(this).parents('.accordion-body').find('input[type="checkbox"]').prop('checked', false);

            }
        });

        $('.accordion-body').on('click', '.business_check_all', function() {
            console.log('business checked');
            if ($(this).is(":checked")) {
                $(this).parents('.accordion-body').find('input[type="checkbox"]').prop('checked', true);
                //console.log('hello');
            } else {
                $(this).parents('.accordion-body').find('input[type="checkbox"]').prop('checked', false);

            }
        });

        $('.add-contacts').on('click', function() {
            //console.log('add contact btn clicked');
            var addnos = "";

            $('.box input[type="checkbox"]:checked').each(function() {
                var number = $(this).attr('number');
                if (typeof number != "") {
                    addnos += number + ', ';
                }
            });

            if (addnos != '') {
                $('#destination_content').val(addnos);
                var no = addnos.split(",");
                var total = no.length - 1;
                console.log(total);
                $('.total').html('(' + total + ')');
            } else {
                alert('Please Select Numbers');
            }
        });

        /*setting messages in textarea depending on message template selected*/
        $('#msg_tpl_select').on('change', function() {
            var msg_tmp = $(this).val();
            //console.log(msg_tmp);
            $('.message_content').val(msg_tmp);
        });

        /*counting character in textarea*/
        $(document).ready(function() {
            var $txtArea = $('.message_content');
            var $chars = $('#chars');
            var textMax = $txtArea.attr('maxlength');
            //console.log(textMax);
            $chars.html(textMax + ' characters remaining');

            $txtArea.on('keyup', countChar);

            function countChar() {
                var textLength = $txtArea.val().length;
                var textRemaining = textMax - textLength;
                $chars.html(textRemaining + ' characters remaining');
            };
        });
    </script>
    @parent
    <script>
        $(document).ready(function() {
            $('#searchBtn').click(function() {
                var filter_letter = $('#filter_name').val();
                var customer_name = $('#customer_name').val();
                var phone_number = $("#phone_number").val();
                if (filter_letter || customer_name || phone_number) {
                    $.ajax({
                        url: "{{ route('data.CustomerFilter') }}", // Example URL for demonstration
                        type: 'GET',
                        data: {
                            filter_letter: filter_letter,
                            customer_name: customer_name,
                            phone_number: phone_number,
                        },
                        success: function(response) {
                            // console.log(response);
                            // Handle successful response
                            $('#customer_list').html('');
                            $.each(response.customers, function(key, value) {
                                //   console.log(value);
                                $('#customer_list').append('<div class="row g-4 align-items-center box">\
            												<div class="col-sm">\
            													<div class="form-check form-check-success mb-12">\
            														<input class="form-check-input" type="checkbox" id="formCheck6" number="' + value
                                    .customer_contact_number + '">\
            														<label class="form-check-label" for="formCheck6">\
            															' + value.customer_name + '\
            														</label>\
            													</div>\
            												</div>\
            												<div class="col-sm-auto">\
            													<div class="d-flex flex-wrap align-items-start gap-2">\
            														<span>' + value.customer_contact_number + '</span>\
            													</div>\
            												</div>\
            											</div>');
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    console.log('empty');
                }
            })
        });
    </script>
@endsection
