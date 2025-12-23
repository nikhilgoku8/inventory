<div class="filter_box {{ (request()->has('q') || request('attribute_id')) ? 'show' : '' }}" id="filter_box">
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
                        <form id="filter_form" action="{{ route('admin.attribute-values.index') }}" method="GET">
                        <!-- @@csrf -->
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Attribute Value Name</label>
                                <div class="error form_error" id="form-error-q"></div>
                                <input type="text" name="q" placeholder="Attribute Value Name" value="{{ request('q') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Attribute</label>
                                <div class="error form_error form-error-attribute_id"></div>
                                <select name="attribute_id">
                                    <option value="">Select Attribute</option>
                                    @if(!empty($attributes) && count($attributes) > 0)
                                        @foreach($attributes as $attribute)
                                            <option value="{{ $attribute->id }}" @if(request('attribute_id') == $attribute->id) selected @endif>{{ $attribute->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input_box">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input_box blue_filled_btn">
                                <a href="{{ route('admin.attribute-values.index').'?q=' }}" class="">Clear Filters</a>
                            </div>
                        </div>
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