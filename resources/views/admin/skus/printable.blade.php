<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Printable</title>
<style>
*{
    margin: 0;
    padding: 0;
}
img{
    max-width: 100%;
}
.boxes_wrapper{
    background: #ddd;
    width: 210mm;
    /*height: 297mm;*/
    display: flex;
    flex-wrap: wrap;
    /*align-items: flex-end;*/
}
.boxes_wrapper .box_wrapper{
    width: 33.33%;
    page-break-inside: avoid;
    break-inside: avoid;
}
.boxes_wrapper .box_wrapper .box{
    padding: 0 5% 10% 5%;
    display: flex;
    flex-wrap: wrap;
}
.boxes_wrapper .box_wrapper .box .product_name{
    font-size: 12px;
}
.boxes_wrapper .box_wrapper .box .left_pane{
    width: 50%;
}
.boxes_wrapper .box_wrapper .box .right_pane{
    width: 50%;
}
@media print {
  .boxes_wrapper .box_wrapper{
    page-break-inside: avoid;
    break-inside: avoid;
  }
}
</style>
</head>
<body>

<div class="boxes_wrapper">

@if(!empty($result))
    @foreach ($result as $row)
        @if(!empty($row->skus))
            @foreach ($row->skus as $sku)
                <div class="box_wrapper">
                    <div class="box">
                        <div class="left_pane">
                            <div class="image"><img src="{{ asset('uploads/products/'.$row->slug.'/'.$sku->image) }}"></div>
                        </div>
                        <div class="right_pane">
                            <div class="qr_code"><img src="{{ asset('uploads/products/'.$row->slug.'/'.$sku->barcode) }}"></div>
                        </div>
                        <div class="product_name">
                            {{ $row->title }}
                            @foreach($sku->attributeValues as $attribute)
                                 , {{$attribute->value}}
                            @endforeach
                        </div>
                        <!-- <div class="sku">{{$sku->sku_code}}</div> -->
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
@endif

</div>

</body>
</html>