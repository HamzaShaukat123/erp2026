@include('../layouts.header')
<body>
<section class="body">
@include('../layouts.pageheader')

<div class="inner-wrapper cust-pad">
<section role="main" class="content-body" style="margin:0px">

<form method="post" action="{{ route('update-tquotation') }}" enctype="multipart/form-data" id="addForm">
@csrf

<div class="card">
<header class="card-header d-flex justify-content-between">
    <h2 class="card-title">Edit Quotation Pipes/Girders</h2>
    <button type="button" class="btn btn-primary" onclick="addNewRow_btn()">
        <i class="fas fa-plus"></i> Add New Row
    </button>
</header>

<div class="card-body">

<input type="hidden" id="itemCount" name="items" value="{{ count($pur2_item) }}">

<div class="row">

<div class="col-md-2">
<label>Quotation No</label>
<input type="text" class="form-control" value="{{$pur2->prefix}}{{$pur2->Sale_inv_no}}" disabled>
<input type="hidden" name="pur2_id" value="{{$pur2->Sale_inv_no}}">
</div>

<div class="col-md-2">
<label>Date</label>
<input type="date" name="sa_date" value="{{$pur2->sa_date}}" class="form-control">
</div>

<div class="col-md-4">
<label>Customer</label>
<select class="form-control select2-js" name="account_name" required>
@foreach($coa as $row)
<option value="{{$row->ac_code}}" {{ $pur2->account_name==$row->ac_code?'selected':'' }}>
{{$row->ac_name}}
</option>
@endforeach
</select>
</div>

<div class="col-md-2">
<label>PO#</label>
<input type="text" name="pur_ord_no" value="{{$pur2->pur_ord_no}}" class="form-control">
</div>

<div class="col-md-2">
<label>Sale Inv</label>
<input type="text" id="sale-inv-no" value="{{$pur2->sales_against}}" class="form-control">
<input type="hidden" name="hidden_sales_against" id="hidden-sale-inv-no" value="{{$pur2->sales_against}}">
</div>

</div>
</div>

<div class="card-body" style="max-height:450px;overflow:auto">

<table class="table table-bordered" id="myTable">
<thead>
<tr>
<th>Code</th>
<th>Item</th>
<th>Remarks</th>
<th>Qty</th>
<th>Rate</th>
<th>Len</th>
<th>%</th>
<th>Weight</th>
<th>Amount</th>
<th>Date</th>
<th></th>
</tr>
</thead>

<tbody id="Quotation2Table">
@foreach($pur2_item as $i=>$row)
<tr>
<td><input class="form-control" name="item_cod[]" id="item_cod{{$i+1}}" value="{{$row->item_cod}}" onchange="getItemDetails({{$i+1}},1)"></td>

<td>
<select class="form-control select2-js" name="item_name[]" id="item_name{{$i+1}}" onchange="getItemDetails({{$i+1}},2)">
@foreach($items as $it)
<option value="{{$it->it_cod}}" {{ $it->it_cod==$row->item_cod?'selected':'' }}>{{$it->item_name}}</option>
@endforeach
</select>
</td>

<td><input class="form-control" name="remarks[]" value="{{$row->remarks}}"></td>

<td><input class="form-control" type="number" name="pur2_qty2[]" id="pur2_qty2_{{$i+1}}" value="{{$row->Sales_qty2}}" onchange="CalculateRowWeight({{$i+1}})"></td>

<td><input class="form-control" type="number" name="pur2_per_unit[]" id="pur2_per_unit{{$i+1}}" value="{{$row->sales_price}}" onchange="rowTotal({{$i+1}})"></td>

<td><input class="form-control" type="number" name="pur2_len[]" id="pur2_len{{$i+1}}" value="{{$row->length}}" onchange="rowTotal({{$i+1}})"></td>

<td>
<input class="form-control" type="number" name="pur2_percentage[]" id="pur2_percentage{{$i+1}}" value="{{$row->discount}}" onchange="rowTotal({{$i+1}})">
<input type="hidden" name="weight_per_piece[]" id="weight_per_piece{{$i+1}}" value="{{$row->weight_pc}}">
</td>

<td>
<input class="form-control" disabled id="pur2_qty{{$i+1}}" value="{{$row->weight_pc*$row->Sales_qty2}}">
<input type="hidden" name="pur2_qty[]" id="pur2_qty_show{{$i+1}}" value="{{$row->weight_pc*$row->Sales_qty2}}">
</td>

<td>
<input class="form-control" disabled id="amount{{$i+1}}" value="{{(($row->Sales_qty2*$row->sales_price)+(($row->Sales_qty2*$row->sales_price)*($row->discount/100)))*$row->length}}">
</td>

<td>
<input class="form-control" disabled value="{{$row->rat_dat}}">
<input type="hidden" name="pur2_price_date[]" value="{{$row->rat_dat}}">
</td>

<td>
<button type="button" class="btn btn-danger" onclick="removeRow(this)">✕</button>
</td>
</tr>
@endforeach
</tbody>
</table>

</div>

<div class="card-footer text-end">
<h4>Net Amount: PKR <span id="netTotal">0</span></h4>
<button class="btn btn-primary" type="submit">Update Quotation</button>
</div>

</div>
</form>
</section>
</div>

@include('../layouts.footerlinks')
</section>
</body>
</html>

<script>
let index = $('#Quotation2Table tr').length + 1;

function addNewRow_btn(){
    let table = $('#Quotation2Table');
    let row = `
    <tr>
        <td><input class="form-control" name="item_cod[]" id="item_cod${index}" onchange="getItemDetails(${index},1)"></td>
        <td>
            <select class="form-control select2-js" name="item_name[]" id="item_name${index}" onchange="getItemDetails(${index},2)">
                <option value="">Select</option>
                @foreach($items as $it)
                <option value="{{$it->it_cod}}">{{$it->item_name}}</option>
                @endforeach
            </select>
        </td>
        <td><input class="form-control" name="remarks[]"></td>
        <td><input class="form-control" type="number" name="pur2_qty2[]" id="pur2_qty2_${index}" onchange="CalculateRowWeight(${index})"></td>
        <td><input class="form-control" type="number" name="pur2_per_unit[]" id="pur2_per_unit${index}" onchange="rowTotal(${index})"></td>
        <td><input class="form-control" type="number" name="pur2_len[]" id="pur2_len${index}" onchange="rowTotal(${index})"></td>
        <td>
            <input class="form-control" type="number" name="pur2_percentage[]" id="pur2_percentage${index}" onchange="rowTotal(${index})">
            <input type="hidden" name="weight_per_piece[]" id="weight_per_piece${index}">
        </td>
        <td>
            <input class="form-control" disabled id="pur2_qty${index}">
            <input type="hidden" name="pur2_qty[]" id="pur2_qty_show${index}">
        </td>
        <td><input class="form-control" disabled id="amount${index}"></td>
        <td><input class="form-control" disabled></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">✕</button></td>
    </tr>`;
    table.append(row);
    $('.select2-js').select2();
    index++;
}

function removeRow(btn){
    $(btn).closest('tr').remove();
    tableTotal();
}

function getItemDetails(row,opt){
    let id = opt==1 ? $('#item_cod'+row).val() : $('#item_name'+row).val();
    $.get('/item2/detail',{id:id},res=>{
        $('#item_cod'+row).val(res[0].it_cod);
        $('#item_name'+row).val(res[0].it_cod).trigger('change');
        $('#pur2_per_unit'+row).val(res[0].sales_price);
        $('#weight_per_piece'+row).val(res[0].weight);
        CalculateRowWeight(row);
    });
}

function CalculateRowWeight(i){
    let qty = +$('#pur2_qty2_'+i).val();
    let w = +$('#weight_per_piece'+i).val();
    let weight = qty*w;
    $('#pur2_qty'+i).val(weight);
    $('#pur2_qty_show'+i).val(weight);
    rowTotal(i);
}

function rowTotal(i){
    let q=+$('#pur2_qty2_'+i).val(),
        r=+$('#pur2_per_unit'+i).val(),
        d=+$('#pur2_percentage'+i).val(),
        l=+$('#pur2_len'+i).val();

    let amt=((q*r)+((q*r)*(d/100)))*l;
    $('#amount'+i).val(amt.toFixed(2));
    tableTotal();
}

function tableTotal(){
    let total=0;
    $('[id^=amount]').each(function(){ total+=+$(this).val(); });
    $('#netTotal').text(total.toLocaleString());
}
</script>
