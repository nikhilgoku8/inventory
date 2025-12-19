@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Sub Categories</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li><a href="{{ route('admin.sub-categories.index') }}">Sub Categories</a></li>
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
                            <div class="title">View Sub Category</div>
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
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Category</label>
                                <div class="error form_error" id="form-error-category_id"></div>
                                <select>
                                    <option value="">Select Category</option>
                                    @if(!empty($categories) && count($categories) > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if($result->category->id == $category->id) selected @endif>{{ $category->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Title</label>
                                <div class="error form_error" id="form-error-title"></div>
                                <input type="text" name="title" placeholder="Title" value="{{ $result->title }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Thumbnail</label>
                                <div class="error form_error form-error-thumbnail"></div>
                                <div class="existing_file_wrapper">
                                    To replace <a href="{{ asset('uploads/sub-categories/'.$result->thumbnail) }}" target="_blank"><img src="{{ asset('uploads/sub-categories/'.$result->thumbnail) }}" width="50px">Existing Thumbnail</a> select below
                                </div>
                                <input type="hidden" name="existing_thumbnail" value="{{ $result->thumbnail }}">
                                <input type="file" name="thumbnail">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Image</label>
                                <div class="error form_error form-error-image"></div>
                                <div class="existing_file_wrapper">
                                    To replace <a href="{{ asset('uploads/sub-categories/'.$result->image) }}" target="_blank"><img src="{{ asset('uploads/sub-categories/'.$result->image) }}" width="50px">Existing Image</a> select below
                                </div>
                                <input type="hidden" name="existing_image" value="{{ $result->image }}">
                                <input type="file" name="image">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>PDF</label>
                                <div class="error form_error form-error-pdf"></div>
                                <div class="existing_file_wrapper">
                                    To replace <a href="{{ asset('uploads/products/pdf/'.$result->pdf) }}" target="_blank"> Existing PDF</a> select below
                                </div>
                                <input type="hidden" name="existing_pdf" value="{{ $result->pdf }}">
                                <input type="file" name="pdf">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Description</label>
                                <div class="error form_error" id="form-error-description"></div>
                                <textarea name="description" class="toolbar">{!! $result->description !!}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Sort Order</label>
                                <div class="error form_error" id="form-error-sort_order"></div>
                                <input type="number" name="sort_order" placeholder="Sort Order" value="{{ $result->sort_order }}">
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
    $("input").prop('disabled', true);
    $("select").prop('disabled', true);
    $(".delete_icon").css({'display':'none'});
    $(".edit_details").css({'display':'none'});
});
</script>
@endsection    