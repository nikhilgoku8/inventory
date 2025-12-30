@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Skus</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li><a href="{{ route('admin.products.edit', $result->id) }}">Product - {{$result->title}}</a></li>
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
                <form id="data_form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="dataID" value="{{ $result->id }}">
                    <div class="page-header my_style less_margin">
                        <div class="left_section">
                            <div class="title_text">
                                <div class="title">Edit Sku</div>
                                <div class="sub_title">Please fillup the form </div>
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
                            <div class="col-sm-6">
                                <div class="input_box">
                                    <label>Image</label>
                                    <div class="error form_error form-error-image"></div>
                                    <img src="{{ $result->image }}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Stock</label>
                                    <div class="error form_error form-error-stock"></div>
                                    <input type="number" name="stock" placeholder="Stock" value="{{ $result->stock }}">
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="attributes_wrapper">
                            <div class="attributes-section">
                                <div class="input_boxes attribute-group">
                                    <!----Product ----->
                                    <div class="col-sm-4">
                                        <div class="input_box">
                                            <label>Attribute Type 1</label>
                                            <div class="error form_error form-error-attributes-0-id"></div>
                                            <select name="attributes[0][id]" class="attribute-id">
                                                <option value="">Select Attribute Type</option>
                                                @foreach ($attributes as $attribute)
                                                <option value="{{$attribute->id}}">{{$attribute->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="input_box">
                                            <label>Value</label>
                                            <div class="error form_error form-error-attributes-0-value"></div>
                                            <select name="attributes[0][value]" class="custom_select">
                                                <option value="">Select Attribute Value</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="button" name="button" value="Add Attribute" class="add-attribute blue_filled_btn">
                        </div>
                        <br>
                        <br>

                        <div class="input_boxes">
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Is_Bundle</label>
                                    <div class="error form_error form-error-is_bundle"></div>
                                    <select name="is_bundle">
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="bundles_wrapper">
                            <div class="bundles-section">
                                <div class="input_boxes bundle-group">
                                    <!----Product ----->
                                    <div class="col-sm-4">
                                        <div class="input_box">
                                            <label>Product 1</label>
                                            <div class="error form_error form-error-bundles-0-product_id"></div>
                                            <select name="bundles[0][product_id]" class="bundle-product_id">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{$product->id}}">{{$product->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input_box">
                                            <label>SKU</label>
                                            <div class="error form_error form-error-bundles-0-sku_id"></div>
                                            <select name="bundles[0][sku_id]" class="custom_select">
                                                <option value="">Select Sku</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input_box">
                                            <label>Quantity</label>
                                            <div class="error form_error form-error-bundles-0-quantity"></div>
                                            <input type="number" name="bundles[0][quantity]" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="button" name="button" value="Add Product Sku" class="add-bundle blue_filled_btn">
                        </div>
                        <br>
                        <br>
                        
                        <div class="input_boxes">
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <div class="error form_error form-error-tabs"></div>
                                    <div class="error form_error form-error-filters"></div>
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>

                    </div>
                </form>
            </div>

    </div>
    <!-- /.row -->

@include('admin.products.skus')

<script type="text/javascript">
$(document).ready(function() {

    $("#data_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        var formData = new FormData(this);
        formData.append('_method', 'PUT'); // <-- This is IMPORTANT!

        $.ajax({
            type: "POST",
            url: "{{ route('admin.products.update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('admin.products.index') }}";
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
            }
        });

    }));

    $('select[name="category_id"]').on('change', function () {
        var categoryId = $(this).val();

        if (categoryId) {
            $.ajax({
                url: "{{ route('admin.get_sub_categories_by_category', ':id') }}".replace(':id', categoryId),
                type: 'POST',
                data: {
                    _token: "{{csrf_token()}}"
                },
                success: function (data) {
                    let $subCategoriesSelect = $('select[name="sub_category_id"]');
                    $subCategoriesSelect.empty().append('<option value="" disabled selected>Sub Category</option>');

                    $.each(data, function (key, value) {
                        $subCategoriesSelect.append('<option value="' + value.id + '">' + value.title + '</option>');
                    });
                }
            });
        } else {
            $('select[name="sub_category_id"]').empty().append('<option value="" disabled selected>Sub Category</option>');
        }
    });

});

</script>

</script>
            
@endsection    