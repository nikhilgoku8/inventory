@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">QR Scan</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <!-- <li><a href="{{ route('admin.categories.index') }}">Categories</a></li> -->
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="blue_filled_btn">
                        <a href="{{ url()->previous() }}">Back</a>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">

        <div class="my_panel form_box">
            
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif

            <form id="data_form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="page-header my_style less_margin">
                    <div class="left_section">
                        <div class="title_text">
                            <div class="title">Scan QR</div>
                            <!-- <div class="sub_title">Please fillup the form </div> -->
                        </div>
                    </div>
                    <div class="right_section">
                        <!-- <div class="purple_filled_btn">
                            <a href="#">Save</a>
                        </div> -->
                    </div>
                </div>

                <div class="inner_boxes">

                    <div class="input_boxes">
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>SKU Code (Scan QR)</label>
                                <div class="error form_error form-error-sku_code"></div>
                                <input type="text" name="sku_code" placeholder="ABC" autofocus autocomplete="off" oninput="this.value = this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="input_boxes">
                        <div class="col-sm-4">
                            <div class="input_box">
                                <div class="error form_error form-error-all_errors"></div>
                                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <div id="scan_error" class="error form_error form-error-scan_error"></div>
                                <div id="reader" style="width:300px; display:none;"></div>
                                <button type="button" id="startScan" class="btn btn-success">Scan Barcode / QR</button>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>

                </div>

            </form>
        </div>

    </div>
    <!-- /.row -->

<div id="sku_results"></div>


<script src="https://unpkg.com/html5-qrcode"></script>

<script type="text/javascript">
$(document).ready(function() {

let html5QrCode;

$("#startScan").on("click", function () {

    $(".form_error").html("");
    $(".form_error").removeClass("alert alert-danger");
    $("#reader").show();

    if (!html5QrCode) {
        html5QrCode = new Html5Qrcode("reader");
    }

    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: 250
        },
        function (decodedText) {
            // ✅ success scan
            $("[name=sku_code]").val(decodedText);

            html5QrCode.stop();
            $("#reader").hide();

            $("#data_form").submit();
        }
    ).catch(function (err) {
        // ❌ camera failed to start
        console.error("Camera error:", err);

        $("#reader").hide();

        let message = "Unable to access camera.";

        if (err.name === "NotAllowedError") {
            message = "Camera permission was denied. Please allow camera access.";
        } else if (err.name === "NotFoundError") {
            message = "No camera found on this device.";
        } else if (location.protocol !== "https:") {
            message = "Camera works only on HTTPS.";
        }

        $(".form-error-scan_error").text(message).addClass('alert alert-danger');
    });

});

$("#data_form").on('submit',(function(e){

    $this = $(this);
    
    e.preventDefault();
    $(".form_error").html("");
    $(".form_error").removeClass("alert alert-danger");

    $.ajax({
        type: "POST",
        url: "{{ route('admin.skus.validate') }}",
        data:  new FormData(this),
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(result) {
            // location.href="{{ route('admin.categories.index') }}";
            // if (result.redirect_url) {
            //     window.location.href = result.redirect_url;
            // }

            $('#sku_results').html(result.html);
            // $('[name=stock]').focus();
            setTimeout(() => {
                $('[name=stock]').focus().select();
            }, 100);
            
            $('html, body').animate({
                scrollTop: $('#sku_results').offset().top
            }, 400);
        },
        error: function(data){
            if (data.status === 422) {
                let errors = data.responseJSON.errors;
                $.each(errors, function (key, message) {

                    var fieldName = key.replace(/\./g, '-');
                    $this.find(".form-error-"+fieldName).html(message);
                    $this.find(".form-error-"+fieldName).addClass('alert alert-danger');

                    // $('#form-error-' + key).html(message).addClass('alert alert-danger');
                });
            } else if (data.status === 401) {
                alert("Please log in.");
                // window.location.href = "/login";
            } else if (data.status === 403) {
                alert("You don’t have permission.");
            } else if (data.status === 404) {
                alert("The resource was not found.");
            } else if (data.status === 500) {
                alert("Something went wrong on the server.");
                console.log(data.console_message);
            } else {
                alert("Unexpected error: " + data.status);
                console.log(data);
            }

            $('#sku_results').html('');
        }
    });

}));

});
</script>
            
@endsection