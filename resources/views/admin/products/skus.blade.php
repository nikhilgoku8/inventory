

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
                        <div class="purple_hollow_btn">
                            <a href="{{ route('admin.skus.create', $result->id) }}">Add New</a>
                        </div>
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
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Attributes</th>
                                <th>Is_Bundle</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th class="action">ACTION</th>
                            </tr>
                            @if(!empty($result->skus))
                                @foreach ($result->skus as $row)
                                    <tr>
                                        <td>{{ $row->sku_code }}</td>
                                        <td>
                                            <a href="{{ asset('uploads/products/'.$result->slug.'/'.$row->barcode) }}" target="_blank">
                                                <img src="{{ asset('uploads/products/'.$result->slug.'/'.$row->barcode) }}" width="50px">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('uploads/products/'.$result->slug.'/'.$row->image) }}" target="_blank">
                                                <img src="{{ asset('uploads/products/'.$result->slug.'/'.$row->image) }}" width="50px">
                                            </a>
                                        </td>
                                        <td>{{ $row->price }}</td>
                                        <td>{{ $row->stock }}</td>
                                        <td>{{ $row->is_bundle ? 'Yes' : 'No' }}</td>
                                        <td>{{ $row->created_by }} <br> {{ $row->created_at }}</td>
                                        <td>{{ $row->updated_by }} <br> {{ $row->updated_at }}</td>
                                        <td class="action">
                                            <a href="{{ route('admin.products.edit', $row->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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

<script type="text/javascript">
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
                url: "{{ route('admin.products.bulk-delete') }}",
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
</script>