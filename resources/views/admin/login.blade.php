<!DOCTYPE html>
<html lang="en">
<head>    
<base href="{{ URL::to('/') }}/">
<script type="text/javascript">
var BaseUrl = {};
BaseUrl.siteRoot = "{{ URL::to('/') }}/";
</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>{{ env('APP_NAME') }} - Admin Login</title>

<link rel="icon" type="image/png" href="{{ asset('admin/assets/images/favicon.png') }}">

<!-- Bootstrap Core CSS -->
<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="{{ asset('admin/assets/css/metisMenu.min.css') }}" rel="stylesheet">

<!-- Custom CSS -->
<link href="{{ asset('admin/assets/css/sb-admin-2.css') }}" rel="stylesheet">
<link href="{{ asset('admin/assets/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('admin/assets/css/form_elements.css') }}" rel="stylesheet">

<!-- Custom Fonts -->
<link href="{{ asset('admin/assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

<!--Datepicker-->
<link href="{{ asset('admin/assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
</head>

<body class="login_page">

    <div id="wrapper">        

    	<div class="container">
		    <div class="row">
		        <div class="col-md-4 col-md-offset-4">
		            <div class="login-panel panel panel-default">
		            	<div class="panel-logo">
		            		<div class="image"><img src="{{ asset('admin/assets/images/logo.png') }}"></div>
		            	</div>
		                <div class="panel-heading">
		                    <h3 class="panel-title">Welcome Admin</h3>
							<p>Login to dashboard</p>
		                </div>
		                <div class="panel-body">
		                    <div class="form-horizontal">
		                    	<form action="" method="POST" id="login_form" enctype="multipart/form-data">
		                    	@csrf
		                        <fieldset>
		                            <div class="form-group">
		                                <div class="col-md-12">
		                                	<div class="error form_error" id="form-error-email"></div>
		                                    <input id="email" type="text" placeholder="Email" class="form-control" name="email" value="" autofocus>
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <div class="col-md-12">
		                                	<div class="error form_error" id="form-error-password"></div>
		                                    <input id="password" type="password" placeholder="Password" class="form-control" name="password">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <div class="col-md-12">
		                                    <input type="submit" class="btn btn-block btn-primary login_btn" id="submit" value="Login">
		                                </div>
		                            </div>
		                        </fieldset>
		                        </form>
		                    </div>
		                </div>
		            </div>
		            <div id="form_login_notification"></div>
		        </div>
		    </div>
		</div>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>

	<script type="text/javascript">
	$(document).ready(function() {	
		$("#login_form").on('submit',(function(e){
	    	e.preventDefault();
	    	$(".form_error").html("");
        	$(".form_error").removeClass("alert alert-danger");
	    	$(".form_login_notification").html("");
		    $("#form_login_notification").removeClass('form_login_error');
		    $("#form_login_notification").removeClass('form_login_success');

		    $.ajax({
		        type: "POST",
		        url: "{{ route('admin.authenticate') }}",
		        data:  new FormData(this),
		        dataType: 'json',
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(result) {            
		            $("#form_login_notification").addClass('form_login_success');
		            $("#form_login_notification").html("Login successful");
		            window.location.href = "{{ route('admin.dashboard') }}";
		        },
		        error: function(data){
		            var responseData = data.responseJSON;        
		            if(responseData.error_type=='login'){
		            	$("#form_login_notification").addClass('form_login_error');
		            	$("#form_login_notification").html(responseData.message);
		            }else if(responseData.error_type=='form'){
		            	jQuery.each( responseData.errors, function( i, val ) {
					    	$("#form-error-"+i).html(val);
					    	$("#form-error-"+i).addClass('alert alert-danger');
						});
		            }else if(responseData.error_type=='database'){
		            	$("#form_login_notification").addClass('form_login_error');
		            	$("#form_login_notification").html(responseData.message);
		            }
		        }
		    });

		}));
	});
	</script>


</body>

</html>
