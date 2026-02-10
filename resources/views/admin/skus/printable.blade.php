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
    display: block;
}
.boxes_wrapper{
    {{-- background: #ddd; --}}
    width: 210mm;
    height: 297mm;
    /*align-items: flex-end;*/
    overflow: hidden;
}
.boxes_wrapper .qr_code_wrapper{
    /*display: flex;
    flex-wrap: wrap;*/
    padding: 6mm 4mm 4mm 4mm;
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Same as 1fr 1fr 1fr */
    grid-gap: 2mm;
}
.boxes_wrapper .qr_code_wrapper .qr_code{
    /*width: 20%;*/
    /*min-height: 25mm;*/
}
{{-- custom added code --}}
.boxes_wrapper .qr_code_wrapper .qr_code{
    display: flex;
    --qr-size: 20mm;
}
.boxes_wrapper .qr_code_wrapper .qr_code .img{
    width: var(--qr-size);
}
.boxes_wrapper .qr_code_wrapper .qr_code .txt{
    width: calc(100% - var(--qr-size));
    padding: 0 0 0 2mm;
}
.boxes_wrapper .qr_code_wrapper .qr_code .txt .product_title{
    font-size: 12px;
}
.boxes_wrapper .qr_code_wrapper .qr_code .txt .attributes{
    font-size: 12px;
}
.boxes_wrapper .qr_code_wrapper .qr_code .txt .attributes li{
    list-style: none;
    display: flex;
}
{{-- custom added code end --}}
@page { margin: 2mm; }
@media print {
  .boxes_wrapper .qr_code_wrapper{
    page-break-inside: avoid;
    break-inside: avoid;
  }
}
</style>
</head>
<body onload="window.print(); window.onafterprint = () => window.close();">
{{-- <body> --}}

<div class="boxes_wrapper">

<div class="qr_code_wrapper">
    @for($i=1; $i<=52; $i++)
        <div class="qr_code">
            <span class="img">
                <img src="{{ asset('uploads/products/'.$sku->product->slug.'/'.$sku->barcode) }}">
            </span>
            <span class="txt">
                <span class="product_title">{{ $sku->product->title }}</span>
                <span class="attributes">
                    @if(!empty($sku->attributeValues) && count($sku->attributeValues) > 0)
                        <ul>
                            @foreach($sku->attributeValues as $attributeValue)
                                {{-- <li>{{ $attributeValue->attribute->title }} :- {{ $attributeValue->value }}</li> --}}
                                <li>
                                    @if($attributeValue->attribute->title == 'Color')

                                        @php
                                            $value = strtolower(trim($attributeValue->value));

                                            if ($value === 'tricolor') {
                                                // Indian flag: saffron, white, green
                                                $background = 'linear-gradient(
                                                    to bottom,
                                                    #ff9933 0%,
                                                    #ff9933 33%,
                                                    #ffffff 33%,
                                                    #ffffff 66%,
                                                    #138808 66%,
                                                    #138808 100%
                                                )';
                                            } elseif (str_contains($value, ' and ')) {
                                                // Example: black and gold
                                                [$color1, $color2] = array_map('trim', explode(' and ', $value));
                                                $background = "linear-gradient(45deg, {$color1}, {$color2})";
                                            } elseif (str_contains($value, '/')) {
                                                // Example: grey/gray
                                                $background = strtok($value, '/');
                                            } else {
                                                // Single color
                                                $background = $value;
                                            }
                                        @endphp

                                        {{ $attributeValue->value }} : 
                                        <span
                                            class="color_circle"
                                            style="
                                                display:inline-block;
                                                background: {{ $background }};
                                                width:14px;
                                                height:12px;
                                                border:1px solid #ddd;
                                            ">
                                        </span>
                                    @else
                                        {{ $attributeValue->value }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </span>
            </span>
        </div>
    @endfor
</div>

</div>

</body>
</html>