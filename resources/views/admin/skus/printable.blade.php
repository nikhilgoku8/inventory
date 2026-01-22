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
    background: #ddd;
    width: 210mm;
    height: 297mm;
    /*align-items: flex-end;*/
}
.boxes_wrapper .qr_code_wrapper{
    /*display: flex;
    flex-wrap: wrap;*/
    padding: 2mm;
    display: grid;
    grid-template-columns: repeat(10, 1fr); /* Same as 1fr 1fr 1fr */
    grid-gap: 2mm;
}
.boxes_wrapper .qr_code_wrapper .qr_code{
    /*width: 20%;*/
    /*min-height: 25mm;*/
}
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

<div class="boxes_wrapper">

<div class="qr_code_wrapper">
    @for($i=1; $i<=140; $i++)
        <div class="qr_code"><img src="{{ asset('uploads/products/'.$sku->product->slug.'/'.$sku->barcode) }}"></div>
    @endfor
</div>

</div>

</body>
</html>