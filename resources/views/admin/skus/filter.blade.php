<div class="filter_box {{ (request()->has('q') || request('category_id') || request('sub_category_id')) ? 'show' : '' }}" id="filter_box">
        <div class="row">
            <div class="my_panel">
                <div class="inner_box ">
                    <div class="upper_sec">
                        <div class="left_section">
                            <div class="title">
                                Filter Data
                                <div class="error form_error" id="form-error-custom_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_form">
                        <form id="filter_form" action="{{ route('admin.products.index') }}" method="GET">
                        <!-- @@csrf -->
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Product Name</label>
                                <div class="error form_error" id="form-error-q"></div>
                                <input type="text" name="q" placeholder="Product Name" value="{{ request('q') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Category</label>
                                <div class="error form_error form-error-category_id"></div>
                                <select name="category_id">
                                    <option value="">Select Category</option>
                                    @if(!empty($categories) && count($categories) > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(request('category_id') == $category->id) selected @endif>{{ $category->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Sub Category</label>
                                <div class="error form_error form-error-sub_category_id"></div>
                                <select name="sub_category_id" class="custom_select">
                                    <option value="">Sub Category</option>
                                    @if(!empty($sub_categories) && count($sub_categories) > 0)
                                        @foreach($sub_categories as $sub_category)
                                            <option value="{{ $sub_category->id }}" @if(request('sub_category_id') == $sub_category->id) selected @endif>{{ $sub_category->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <span class="input_box purple_filled_btn">
                                <button type="submit">Search</button>
                            </span>
                            <!-- <span class="input_box orange_hollow_btn">
                                <button type="submit" formaction="@{{ route('admin.products.export') }}">Export</button>
                            </span> -->
                            <span class="input_box blue_filled_btn">
                                <a href="{{ route('admin.products.index').'?q=' }}" class="">Clear Filters</a>
                            </span>
                        </div>
                        <!-- <div class="col-sm-4">
                            <div class="input_box blue_filled_btn">
                                <a href="{{ route('admin.products.index').'?q=' }}" class="">Clear Filters</a>
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-2">
                            <div class="countAjaxResult">
                                Result : <span id="countAjaxResult">0</span>
                            </div>
                        </div> -->
                        </form>
                    </div>
                    <div class="clr"></div>
                </div>
                <!-- patients_filter_box end -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- patients_filter end -->


<!-- <script type="text/javascript">
$(document).ready(function() {
    
    $("#filter_form").on('submit',(function(e){
        e.preventDefault();

        $(".form_error").html('');
        $(".form_error").removeClass('alert alert-danger');
        $('button[type="submit"]').prop('disabled', true);

        $.ajax({
            type: "GET",
            url: "{{ url('ewm/patients/filter') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                // console.log(result.html);
                $("#filter_result").html(result.html);
                // var rowCount = $(".details_table tbody").html(result.html).find('tr.ajaxRow').length;
                // $("#countAjaxResult").html(rowCount);
            },
            complete: function(){
                $('button[type="submit"]').prop('disabled', false);
            },
            error: function(data){
                var responseData = data.responseJSON;        
                if(responseData.error_type=='form'){
                    jQuery.each( responseData.errors, function( i, val ) {
                        $("#form-error-"+i).html(val);
                        $("#form-error-"+i).addClass('alert alert-danger');
                    });
                }
            }
        });

    }));

    // $("#export_btn").on('click',(function(){
    //     var name = $("#filter_fname").val();
    //     var mobile = $("#filter_mobile").val();

    //     window.location.href = "<?php echo URL::to('/'); ?>/ewm/doctors/export?name="+name+"&mobile="+mobile;
    // }));

});
</script> -->