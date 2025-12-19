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
                    <input type="hidden" name="dataID" value="{{ $result->id }}">
                    <div class="page-header my_style less_margin">
                        <div class="left_section">
                            <div class="title_text">
                                <div class="title">View Product</div>
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
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Category</label>
                                    <div class="error form_error" id="form-error-category_id"></div>
                                    <select name="category_id">
                                        <option value="">Select Category</option>
                                        @if(!empty($categories) && count($categories) > 0)
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($result->subCategory->category->id == $category->id) selected @endif>{{ $category->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Sub Category</label>
                                    <div class="error form_error" id="form-error-sub_category_id"></div>
                                    <select name="sub_category_id">
                                        <option value="" selected disabled>Sub Category</option>
                                        @if(!empty($subCategories) && count($subCategories) > 0)
                                            @foreach($subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}" @if($result->subCategory->id == $subCategory->id) selected @endif>{{ $subCategory->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Title</label>
                                    <div class="error form_error" id="form-error-title"></div>
                                    <input type="text" name="title" placeholder="Title" value="{{ $result->title }}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Description</label>
                                    <div class="error form_error" id="form-error-description"></div>
                                    <textarea name="description" placeholder="Description">{{ $result->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Features</label>
                                    <div class="error form_error" id="form-error-features"></div>
                                    <textarea name="features" placeholder="Features" class="toolbar">{!! $result->features !!}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Sales Drawing</label>
                                    <div class="error form_error form-error-sales_drawing"></div>
                                    <input type="text" name="sales_drawing" placeholder="Sales Drawing" value="{{ $result->sales_drawing }}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Catalogue</label>
                                    <div class="error form_error form-error-catalogue"></div>
                                    <input type="text" name="catalogue" placeholder="Catalogue" value="{{ $result->catalogue }}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Featured</label>
                                    <div class="error form_error form-error-featured"></div>
                                    <select name="featured">
                                        <option value="1" @selected(($result->featured ?? '') == "1")>Yes</option>
                                        <option value="0" @selected(($result->featured ?? '') == "0")>No</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="input_box">
                                    <label>Images</label>
                                    <div class="error form_error" id="form-error-img_file"></div>
                                    <input type="file" name="img_file">
                                </div>
                            </div> -->
                            <div class="clr"></div>
                        </div>

                        <div class="images_wrapper">
                            <div class="images-section">
                                @if(!empty($result->productImages))
                                    @foreach($result->productImages as $productImage)
                                        <div class="input_boxes image-group">
                                            <input type="hidden" name="images[{{ $loop->iteration - 1 }}][id]" value="{{ $productImage->id }}">
                                            <!----Product ----->
                                            <div class="col-sm-6">
                                                <div class="input_box">
                                                    <label>Image Link {{ $loop->iteration }}</label>
                                                    <div class="error form_error form-error-images-{{ $loop->iteration - 1 }}-link"></div>
                                                    <input type="text" name="images[{{ $loop->iteration - 1 }}][link]" placeholder="Image Link" value="{{ $productImage->image_file }}">
                                                    <!-- <a href="{{ $productImage->image_file }}" target="_blank">
                                                        <img src="{{ $productImage->image_file }}" width="100px">
                                                    </a> -->
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="input_box">
                                                    <!-- <label>Image Link {{ $loop->iteration }}</label>
                                                    <div class="error form_error form-error-images-{{ $loop->iteration - 1 }}-link"></div>
                                                    <input type="text" name="images[{{ $loop->iteration - 1 }}][link]" placeholder="Image Link" value="{{ $productImage->image_file }}"> -->
                                                    <a href="{{ $productImage->image_file }}" target="_blank">
                                                        <img src="{{ $productImage->image_file }}">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="input_box">
                                                    <label>Sort Order</label>
                                                    <div class="error form_error form-error-images-{{ $loop->iteration - 1 }}-sort_order"></div>
                                                    <input type="number" name="images[{{ $loop->iteration - 1 }}][sort_order]" placeholder="Sort Order" value="{{ $productImage->sort_order }}">
                                                </div>
                                            </div>
                                            @if($loop->iteration != 1)
                                            <div class="col-sm-2">
                                                <div class="input_box orange_filled_btn">
                                                    <button type="button" class="remove-image">Remove Image</button>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <input type="button" name="button" value="Add Image" class="add-image blue_filled_btn">
                        </div>
                        <br>
                        <br>

                        <div class="filters_wrapper">
                            <div class="filters-section">
                                @if(!empty($result->filterValues))
                                    @foreach($result->filterValues as $filterRow)
                                        <div class="input_boxes filter-group">
                                            <!----Product ----->
                                            <div class="col-sm-6">
                                                <div class="input_box">
                                                    <label>Filter 1</label>
                                                    <div class="error form_error form-error-filters-0-id"></div>
                                                    <select name="filters[0][id]">
                                                        <option value="" selected disabled>Select Filter Type</option>
                                                        @foreach ($filterTypes as $filterType)
                                                        <option value="{{$filterType->id}}" @if($filterRow->filterType->id == $filterType->id) selected @endif>{{$filterType->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="input_box">
                                                    <label>Value</label>
                                                    <div class="error form_error form-error-filters-0-value"></div>
                                                    <textarea name="filters[0][value]">{{ $filterRow->value }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <input type="button" name="button" value="Add Filter" class="add-filter blue_filled_btn">
                        </div>

                        <div class="tabs_wrapper">
                            <div class="tabs-section">
                                @if(!empty($result->productTabContents))
                                    @foreach($result->productTabContents as $tabRow)
                                    <div class="input_boxes tab-group">
                                        <!----Product ----->
                                        <div class="col-sm-6">
                                            <div class="input_box">
                                                <label>Tab 1</label>
                                                <div class="error form_error form-error-tabs-{{$loop->iteration - 1}}-id"></div>
                                                <select name="tabs[{{$loop->iteration - 1}}][id]">
                                                    <option value="" selected disabled>Select Tab Label</option>
                                                    @foreach ($productTabLabels as $productTabLabel)
                                                    <option value="{{$productTabLabel->id}}" @if($tabRow->productTabLabel->id == $productTabLabel->id) selected @endif>{{$productTabLabel->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="input_box">
                                                <label>Content</label>
                                                <div class="error form_error form-error-tabs-{{$loop->iteration - 1}}-content"></div>
                                                <textarea name="tabs[{{$loop->iteration - 1}}][content]">{{$tabRow->content}}</textarea>
                                            </div>
                                        </div>
                                        @if($loop->iteration != 1)
                                        <div class="col-sm-3">
                                            <div class="input_box orange_filled_btn">
                                                <button type="button" class="remove-medicine">Remove Medicine</button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <input type="button" name="button" value="Add Tab" class="add-tab blue_filled_btn">
                        </div>

                        <div class="competitors_wrapper">
                            <div class="competitors-section">
                                @if(!empty($result->competitors))
                                    @foreach($result->competitors as $competitorRow)
                                        <div class="input_boxes competitor-group">
                                            <input type="hidden" name="competitors[{{ $loop->iteration - 1 }}][id]" value="{{ $competitorRow->id }}">
                                            <div class="col-sm-10">
                                                <div class="input_box">
                                                    <label>Competitor Name</label>
                                                    <div class="error form_error form-error-competitors-{{$loop->iteration - 1}}-title"></div>
                                                    <input type="text" name="competitors[{{$loop->iteration - 1}}][title]" placeholder="Competitor Name" value="{{ $competitorRow->title }}">
                                                </div>
                                            </div>
                                            <!-- @@if($loop->iteration != 1) -->
                                            <div class="col-sm-2">
                                                <div class="input_box orange_filled_btn">
                                                    <button type="button" class="remove-competitor">Remove Competitor</button>
                                                </div>
                                            </div>
                                            <!-- @@endif -->
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <input type="button" name="button" value="Add Competitor" class="add-competitor blue_filled_btn">
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
    $("input").prop('disabled', true);
    $("select").prop('disabled', true);
    $("textarea").prop('disabled', true);
    $(".delete_icon").css({'display':'none'});
    $(".edit_details").css({'display':'none'});
});
</script>
@endsection    