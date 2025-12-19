@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Products</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li><a href="{{ route('admin.products.index') }}">Products</a></li>
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
                                <div class="title">Add New Product</div>
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
                                    <label>Category</label>
                                    <div class="error form_error form-error-category_id"></div>
                                    <select name="category_id">
                                        <option value="">Select Category</option>
                                        @if(!empty($categories) && count($categories) > 0)
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input_box">
                                    <label>Sub Category</label>
                                    <div class="error form_error form-error-sub_category_id"></div>
                                    <select name="sub_category_id" class="custom_select">
                                        <option value="" selected disabled>Sub Category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Title</label>
                                    <div class="error form_error form-error-title"></div>
                                    <input type="text" name="title" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Description</label>
                                    <div class="error form_error form-error-description"></div>
                                    <textarea name="description" placeholder="Description" class="toolbar"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input_box">
                                    <label>Image</label>
                                    <div class="error form_error form-error-image"></div>
                                    <input type="file" name="image">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input_box">
                                    <label>PDF</label>
                                    <div class="error form_error form-error-pdf"></div>
                                    <input type="file" name="pdf">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Specifications Table</label>
                                    <div class="small_note">To add or delete a column click the cell and then click on the table icon <i class="fa fa-table" aria-hidden="true"></i><br><br></div>
                                    <div class="error form_error form-error-specifications_table"></div>
                                    <textarea name="specifications_table" placeholder="Description" class="toolbar">
                                        <table width="100%">
                                            <tr>
                                                <th>1</th>
                                                <td>a</td>
                                            </tr>
                                            <tr>
                                                <th>2</th>
                                                <td>b</td>
                                            </tr>
                                        </table>
                                    </textarea>
                                    <br>
                                    <div class="orange_hollow_btn">
                                        <button type="button" onclick="clearTextArea();">Clear Specifications Table</button>
                                    </div>
                                    <script>
                                        function clearTextArea(){
                                            tinymce.get('specifications_table').setContent('');
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input_box">
                                    <label>Sort Order</label>
                                    <div class="error form_error form-error-sort_order"></div>
                                    <input type="number" name="sort_order" placeholder="Sort Order">
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>

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
            url: "{{ route('admin.products.store') }}",
            data:  new FormData(this),
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

        var token = $('meta[name="csrf-token"]').attr('content');

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

@endsection