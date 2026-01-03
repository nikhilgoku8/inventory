@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Skus</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li><a href="{{ route('admin.products.edit', $result->product->id) }}">Product - {{$result->product->title}}</a></li>
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

                <form>
                    <div class="page-header my_style less_margin">
                        <div class="left_section">
                            <div class="title_text">
                                <div class="title">View Sku</div>
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
                            <div class="col-sm-3">
                                <div class="input_box">
                                    <label>Image</label>
                                    <a href="{{ asset('uploads/products/'.$result->product->slug.'/'.$result->image) }}" target="_blank">
                                        <img src="{{ asset('uploads/products/'.$result->product->slug.'/'.$result->image) }}" width="100px">
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input_box">
                                    <label>QR Code</label>
                                    <a href="{{ asset('uploads/products/'.$result->product->slug.'/'.$result->barcode) }}" target="_blank">
                                        <img src="{{ asset('uploads/products/'.$result->product->slug.'/'.$result->barcode) }}" width="100px">
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input_box">
                                    <label>Sku Code</label>
                                    <div>{{ $result->sku_code }}</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input_box">
                                    <label>Stock</label>
                                    <div>
                                        <big>
                                            @if($result->is_bundle)
                                                @php
                                                    $bundleStock = $result->bundleItems
                                                    ->map(function ($item) {
                                                        return intdiv($item->childSku->stock, $item->quantity);
                                                    })
                                                    ->min();
                                                @endphp
                                                {{$bundleStock}}
                                            @else
                                                {{ $result->stock }}
                                            @endif
                                        </big>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input_box">
                                    <label>Attributes</label>
                                    <div>
                                        @if(!empty($result->attributeValues) && count($result->attributeValues) > 0)
                                            <ul>
                                                @foreach($result->attributeValues as $attributeValue)
                                                    <li>{{ $attributeValue->attribute->title }} :- {{ $attributeValue->value }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="input_boxes">
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Is_Bundle</label>
                                    <div>{{ $result->is_bundle ? 'Yes' : 'No' }}</div>
                                    <!-- <select>
                                        <option value="1" @selected($result->is_bundle == 1)>Yes</option>
                                        <option value="0" @selected($result->is_bundle == 0)>No</option>
                                    </select> -->
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>

                        @if($result->is_bundle && !empty($result->bundleItems) && count($result->bundleItems) > 0)
                        <div class="bundles_wrapper">
                            <div class="bundles-section">
                                @foreach($result->bundleItems as $item)
                                    <div class="input_boxes bundle-group">
                                        <!----Product ----->
                                        <div class="col-sm-3">
                                            <div class="input_box">
                                                <label>Product {{$loop->iteration}}</label>
                                                <div>{{ $item->childSku->product->title }}</div>
                                                <!-- <input type="text" value="{{ $item->childSku->product->title }}"> -->
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="input_box">
                                                <label>SKU</label>
                                                <div>{{ $item->childSku->sku_code }}</div>
                                                <!-- <input type="text" value="{{ $item->childSku->sku_code }}"> -->
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input_box">
                                                <label>Attributes</label>
                                                <div>
                                                    @if(!empty($item->childSku->attributeValues) && count($item->childSku->attributeValues) > 0)
                                                        <ul>
                                                            @foreach($item->childSku->attributeValues as $attributeValue)
                                                                <li>{{ $attributeValue->attribute->title }} :- {{ $attributeValue->value }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input_box">
                                                <label>Quantity</label>
                                                <div>{{ $item->quantity }}</div>
                                                <!-- <input type="text" value="{{ $item->quantity }}"> -->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <br>
                        @endif
                        
                    </div>
                </form>
            </div>

    </div>
    <!-- /.row -->

    @if(!$result->is_bundle)

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
                    <input type="hidden" name="dataID" value="{{ $result->id }}">
                    <div class="page-header my_style less_margin">
                        <div class="left_section">
                            <div class="title_text">
                                <div class="title">Update Sku</div>
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
                                    <label>Image</label>
                                    <div class="error form_error form-error-image"></div>
                                    @if(!empty($result->image))
                                        <div class="existing_file_wrapper">
                                            To replace <a href="{{ asset('uploads/products/'.$result->product->slug.'/'.$result->image) }}" target="_blank"><img src="{{ asset('uploads/products/'.$result->product->slug.'/'.$result->image) }}" width="50px"></a> select below
                                        </div>
                                        <input type="hidden" name="existing_image" value="{{ $result->image }}">
                                    @endif
                                    <input type="file" name="image" placeholder="Replace Image">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Stock*</label>
                                    <div class="error form_error form-error-stock"></div>
                                    <input type="number" name="stock" placeholder="Stock" min="1">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Movement Type*</label>
                                    <div class="error form_error form-error-movement_type"></div>
                                    <select name="movement_type">
                                        <option value="increment">Increment</option>
                                        <option value="decrement">Decrement</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Remarks</label>
                                    <div class="error form_error form-error-remarks"></div>
                                    <textarea name="remarks"></textarea>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>

                        <div class="input_boxes">
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <div class="error form_error form-error-all_errors"></div>
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
    @endif

    <div class="row">
        <div class="fourth_row">
            
            <div class="my_panel">
                
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif

                <div class="upper_sec">
                    <div class="left_section">
                        <div class="title">Inventory Movements</div>
                    </div>
                    <div class="right_section">
                    </div>
                </div>
                <div class="details_table">
                    <table>
                        <tbody>
                            <tr>
                                <th class="col-sm-3">Quantity</th>
                                <th class="col-sm-3">Movement Type</th>
                                <th class="col-sm-3">Remarks</th>
                                <th class="col-sm-3">Created By / Updated By</th>
                            </tr>
                            @if(!empty($inventoryMovements) && count($inventoryMovements) > 0)
                                @foreach ($inventoryMovements as $row)
                                    <tr>
                                        <td>{{ $row->quantity }}</td>
                                        <td>{{ $row->movement_type }}</td>
                                        <td>{!! $row->remarks !!}</td>
                                        <td>
                                            {{ $row->created_by }} <br> {{ $row->created_at }}
                                            <br> / <br>
                                            {{ $row->updated_by }} <br> {{ $row->updated_at }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No Records</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if(method_exists($inventoryMovements, 'links'))
                    <div class="table_pagination">
                        {{ $inventoryMovements->links() }}
                        <div class="clr"></div>
                    </div>
                @endif

            </div>

        </div>
        <!-- fourth_row end -->
    </div>
    <!-- /.row -->



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
            url: "{{ route('admin.skus.update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('admin.skus.edit', $result->id) }}";
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

});

</script>
            
@endsection    