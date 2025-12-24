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
                    <div class="page-header my_style less_margin">
                        <div class="left_section">
                            <div class="title_text">
                                <div class="title">Add New Sku</div>
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
                                    <input type="file" name="image">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Price</label>
                                    <div class="error form_error form-error-price"></div>
                                    <input type="number" name="price" placeholder="Price" step="0.01">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Stock</label>
                                    <div class="error form_error form-error-stock"></div>
                                    <input type="number" name="stock" placeholder="Stock">
                                </div>
                            </div>
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
                            <div class="col-sm-4">
                                <div class="input_box">
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


<script type="text/javascript">
$(document).ready(function() {

    $("#data_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "@{{ route('admin.skus.store') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="@{{ route('admin.skus.index') }}";
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




$(document).on('change', '.attribute-id', function () {
    let $idSelect = $(this);
    let attributeId = $idSelect.val();

    var token = $('meta[name="csrf-token"]').attr('content');

    // Extract index from name, e.g., "attributes[0][id]"
    let nameAttr = $idSelect.attr('name');
    let match = nameAttr.match(/^attributes\[(\d+)]\[id]$/);
    if (match) {
        let index = match[1];
        let $valueSelect = $(`select[name="attributes[${index}][value]"]`);
    // console.log($valueSelect);

        if (!attributeId) {
            $valueSelect.html('<option value="">Select Value</option>');
            return;
        }

        // Fetch attribute values from server
        $.ajax({
            url: "{{ route('admin.get_values_by_attribute', ':id') }}".replace(':id', attributeId),
            method: 'POST',
            data: { _token: token },
            // success: function (response) {
            //     let options = '<option value="">Select Value</option>';
            //     response.forEach(function (item) {
            //         options += `<option value="${item.id}">${item.label}</option>`;
            //     });
            //     $valueSelect.html(options);
            // },
            // error: function () {
            //     alert('Failed to load attribute values');
            //     $valueSelect.html('<option value="">Select Value</option>');
            // }
            success: function (data) {
                // console.log(data);
                $valueSelect.empty().append('<option value="" disabled selected>Select Value</option>');

                $.each(data, function (key, value) {
                    $valueSelect.append('<option value="' + value.id + '">' + value.value + '</option>');
                });

                setTimeout(function() {
                    $(".custom_select").select2({
                        tags:true
                    });
                }, 100);
            }
        });
    }
});


$(document).on('click', '.add-attribute', function() {

    let $attributeWrapper = $(this).closest('.attributes_wrapper');
    let $attributesSection = $attributeWrapper.find('.attributes-section');
    
    let attributeCount = $attributesSection.find('.attribute-group').length;

    let newAttributeGroup = `
        <div class="input_boxes attribute-group">
            <div class="col-sm-4">
                <div class="input_box">
                    <label>Attribute ${attributeCount + 1}</label>
                    <div class="error form_error form-error-attributes-${attributeCount}-id"></div>
                    <select name="attributes[${attributeCount}][id]" class="attribute-id">
                        <option value="" selected disabled>Select Attribute Type</option>
                        @foreach ($attributes as $attribute)
                        <option value="{{$attribute->id}}">{{$attribute->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="input_box">
                    <label>Value</label>
                    <div class="error form_error form-error-attributes-${attributeCount}-value"></div>    
                    <select name="attributes[${attributeCount}][value]" class="custom_select">
                        <option value="" selected disabled>Select Attribute Value</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input_box orange_filled_btn">
                    <button type="button" class="remove-attribute">Remove Attribute</button>
                </div>
            </div>
        </div>
    `;

    $attributesSection.append(newAttributeGroup);

    setTimeout(function() {
        $("select").select2();

        $(".custom_select").select2({
            tags:true
        });
    }, 100);
});

$(document).on('click', '.remove-attribute', function() {
    let $attributeWrapper = $(this).closest('.attributes_wrapper');
    let $attributesSection = $attributeWrapper.find('.attributes-section');

    $(this).closest('.attribute-group').remove();

    // Update labels (optional)
    $attributesSection.find('.attribute-group').each(function(index) {
        $(this).find('label:first').text(`Attribute ${index + 1}`);

        // let $productAttributeTypeSelect = $(this).find('select');
        let $productAttributeTypeSelect = $(this).find('[name*=id]');
        $productAttributeTypeSelect.attr('name', `attributes[${index}][id]`);
        $productAttributeTypeSelect.prev('.form_error').attr('class', `error form_error form-error-attributes-${index}-id`);

        // let $productAttributeValueContent = $(this).find('select');
        let $productAttributeValueContent = $(this).find('[name*=value]');
        $productAttributeValueContent.attr('name', `attributes[${index}][value]`);
        $productAttributeValueContent.prev('.form_error').attr('class', `error form_error form-error-attributes-${index}-value`);
    });
});

</script>

@endsection