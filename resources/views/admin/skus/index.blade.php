@extends('admin.layout.master')

@section('content')   
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Skus</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li><a href="{{ route('admin.skus.index') }}">Skus</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <!-- <div class="orange_hollow_btn">
                        <a id="filter_option">Filter</a>
                    </div> -->
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- @@include('admin.skus.filter') -->

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
                        <div class="title">Skus Data</div>
                        <div class="sub_title"> </div>
                    </div>
                    <div class="right_section">
                        <div class="orange_filled_btn">
                            <a id="delete_records">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="details_table">
                    <table>
                        <tbody>
                            <tr>
                                <th>Sku Code</th>
                                <th>Barcode</th>
                                <th>Image</th>
                                <th>Stock</th>
                                <th>Attributes</th>
                                <th>Is_Bundle</th>
                                <th>Created By / Updated By</th>
                                <th class="action">ACTION</th>
                            </tr>
                            @if(!empty($result))
                                @foreach ($result as $row)
                                    <tr>
                                        <td>{{ $row->sku_code }}</td>
                                        <td>
                                            <a href="{{ asset('uploads/products/'.$row->product->slug.'/'.$row->barcode) }}" target="_blank">
                                                <img src="{{ asset('uploads/products/'.$row->product->slug.'/'.$row->barcode) }}" width="50px">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('uploads/products/'.$row->product->slug.'/'.$row->image) }}" target="_blank">
                                                <img src="{{ asset('uploads/products/'.$row->product->slug.'/'.$row->image) }}" width="50px">
                                            </a>
                                        </td>
                                        <td>
                                            @if($row->is_bundle)
                                                @php
                                                    $bundleStock = $row->bundleItems
                                                    ->map(function ($item) {
                                                        return intdiv($item->childSku->stock, $item->quantity);
                                                    })
                                                    ->min();
                                                @endphp
                                                {{$bundleStock}}
                                            @else
                                                {{ $row->stock }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($row->attributeValues) && count($row->attributeValues) > 0)
                                                <ul>
                                                    @foreach($row->attributeValues as $attributeValue)
                                                        <li>{{ $attributeValue->attribute->title }} :- {{ $attributeValue->value }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->is_bundle && !empty($row->bundleItems) && count($row->bundleItems) > 0)
                                                @foreach($row->bundleItems as $item)
                                                    Sku Code - {{$item->childSku->sku_code}}<br>
                                                    {{$item->childSku->product->title}}<br>
                                                    Quantity - {{$item->quantity}}
                                                    <br>
                                                    Attributes - 
                                                    @if(!empty($item->childSku->attributeValues) && count($item->childSku->attributeValues) > 0)
                                                        <ul>
                                                            @foreach($item->childSku->attributeValues as $attributeValue)
                                                                <li>{{ $attributeValue->attribute->title }} :- {{ $attributeValue->value }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    <br>
                                                    <br>
                                                @endforeach
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td>{{ $row->created_by }} <br> {{ $row->created_at }}
                                            <br>/<br>
                                            {{ $row->updated_by }} <br> {{ $row->updated_at }}</td>
                                        <td class="action">
                                            <a href="{{ route('admin.skus.edit', $row->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <span class="checkbox">
                                                <input name="dataID" class="styled" type="checkbox" value="{{ $row->id }}">
                                                <label for="checkbox1"></label>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @if(method_exists($result, 'links'))
                    <div class="table_pagination">
                        {{ $result->links() }}
                        <div class="clr"></div>
                    </div>
                @endif
            </div>

        </div>
        <!-- fourth_row end -->
    </div>
    <!-- /.row -->

<!-- <script type="text/javascript">
$(document).ready(function() {

  $("#delete_records").on('click',(function(e){
    e.preventDefault();

    var dataID = [];
    $.each($("input[name='dataID']:checked"), function(){
        dataID.push($(this).val());
    });

    if(dataID.length == 0){
        alert('No records are selected');
    }else{
        if (confirm('Are you sure you want to delete these records?')) {
            $.ajax({
                type: "POST",
                url: "@{{ route('admin.skus.bulk-delete') }}",
                data: {"_token":"{{ csrf_token() }}", "dataID":dataID},
                dataType: 'json',
                success: function(response) {
                    window.location.reload(true);
                },
                error: function(data){
                    console.log(data.message);
                    console.log(data.responseJSON.message);
                }
            });
        }
    }  

  }));

});
</script> -->

@endsection