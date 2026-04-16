@include('../layouts.header')
	<body>
		<section class="body">
		@include('../layouts.pageheader')
		<div class="inner-wrapper cust-pad">
				<section role="main" class="content-body" style="margin:0px">
					<form method="post" action="{{ route('update-tpo') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';" id="addForm">
						@csrf
						<div class="row">	
							<div class="col-12 mb-3">								
								<section class="card">
									<header class="card-header"  style="display: flex;justify-content: space-between;">
										<h2 class="card-title">Edit PO Pipe/Garder</h2>
										<div class="card-actions">
											<button type="button" class="btn btn-primary" onclick="addNewRow_btn()"> <i class="fas fa-plus"></i> Add New Row </button>
										</div>
									</header>

									<div class="card-body">
										<div class="row form-group mb-2">
											<div class="col-6 col-md-2 mb-2">
												<label class="col-form-label" >PO No.</label>
												<input type="text" placeholder="(Edit PO No)" class="form-control" value="{{$pur2->prefix}}{{$pur2->Sale_inv_no}}" disabled>
												<input type="hidden" placeholder="Invoice #" class="form-control" value="{{$pur2->Sale_inv_no}}" name="pur2_id">
												<input type="hidden" id="itemCount" name="items" value="1" class="form-control">
											</div>
											<div class="col-6 col-md-2 mb-2">
												<label class="col-form-label" >Date</label>
												<input type="date" name="sa_date" value="{{$pur2->sa_date}}" class="form-control">
											</div>
											
											<div class="col-sm-12 col-md-3 mb-3">
												<label class="col-form-label">Company Name<span style="color: red;"><strong>*</strong></span></label>
												<select data-plugin-selecttwo class="form-control select2-js"  name="account_name" required>
													<option value="" disabled selected>Select Company Name</option>
													@foreach($coa as $key => $row)	
														<option value="{{$row->ac_code}}" {{ $pur2->account_name == $row->ac_code ? 'selected' : '' }}>{{$row->ac_name}}</option>
													@endforeach
												</select>
											</div>

											
											<div class="col-sm-3 col-md-3 mb-2">
												<label class="col-form-label" >Name of Person</label>
												<input type="text" placeholder="Name of Person" name="Cash_pur_name" id="Cash_pur_name" value="{{$pur2->Cash_pur_name}}" class="form-control">
											</div>

											<div class="col-sm-12 col-md-2 mb-2">
												<label class="col-form-label">Pur Inv#</label>
												<label class="col-form-label" style="cursor: pointer; color: blue; text-decoration: underline; float: right;" id="edit-sale-inv">Enable</label>
												<input type="text" placeholder="Pur Inv. No." name="sales_against" value="{{$pur2->sales_against}}" id="sale-inv-no" disabled class="form-control">

												<!-- Hidden Input Field -->
												<input type="hidden" placeholder="Pur Inv. No.." class="form-control" value="{{$pur2->sales_against}}" name="hidden_sales_against" id="hidden-sale-inv-no">
											</div>
											

											

											<div class="col-sm-3 col-md-3 mb-2">
												<label class="col-form-label" >Person Address</label>
												<input type="text" placeholder="Person Address" name="cash_Pur_address" value="{{$pur2->cash_Pur_address}}" class="form-control">
	
													<label class="col-form-label">Attachements</label>
													<input type="file" class="form-control" name="att[]" multiple accept=".zip, appliation/zip, application/pdf, image/png, image/jpeg">
												</div>
											<div class="col-12 col-md-4 mb-12">
												<label class="col-form-label">Remarks</label>
												<textarea rows="4" cols="50" name="Sales_Remarks" id="Sales_Remarks"  placeholder="Remarks" class="form-control cust-textarea">{{$pur2->Sales_Remarks}}</textarea>
											</div>
											<div class="col-12 col-md-5 mb-12">
												<label class="col-form-label">Terms And Conditions</label>
												<textarea rows="4" cols="50" name="tc" id="tc" placeholder="Terms And Conditions" class="form-control cust-textarea">{{$pur2->tc}}</textarea>
											</div>	
									  </div>
									</div>
									
									<div class="card-body" style="overflow-x:auto;min-height:450px;max-height:450px;overflow-y:auto">
										<table class="table table-bordered table-striped mb-0" id="myTable" >
											<thead>
												<tr>
													<th width="7%">Code<span style="color: red;"><strong>*</strong></span></th>
													<th width="20%">Item Name<span style="color: red;"><strong>*</strong></span></th>
													<th width="15%">Remarks</th>
													<th width="7%">Quantity<span style="color: red;"><strong>*</strong></span></th>
													<th width="7.5%">Price/Unit<span style="color: red;"><strong>*</strong></span></th>
													<th width="7%">Length<span style="color: red;"><strong>*</strong></span></th>
													<th width="7%">Percent<span style="color: red;"><strong>*</strong></span></th>
													<th width="7%">Weight</th>
													<th width="7%">Amount</th>
													<th width="7%">Price Date</th>
													<th width="15%">Dipatch To</th>
													<th width=""></th>
												</tr>
											</thead>
											<tbody id="Tpo2Table">
												@foreach ($pur2_item as $pur2_key => $pur2_items)
													<tr>
														<td>
															<input type="text" class="form-control" name="item_cod[]" id="item_cod{{$pur2_key+1}}" value="{{$pur2_items->item_cod}}" onchange="getItemDetails({{$pur2_key+1}},1)" required>
														</td>
														<td>
															<select data-plugin-selecttwo class="form-control select2-js"  id="item_name{{$pur2_key+1}}" name="item_name[]" onchange="getItemDetails({{$pur2_key+1}},2)" required>
																<option value="" selected disabled>Select Item</option>
																@foreach($items as $key => $row)	
																	<option value="{{$row->it_cod}}" {{ $pur2_items->item_cod == $row->it_cod ? 'selected' : '' }}>{{$row->item_name}}</option>
																@endforeach
															</select>													
														</td>
														<td>
															<input type="text" class="form-control" id="remarks{{$pur2_key+1}}" value="{{$pur2_items->remarks}}" name="remarks[]">
														</td>	
														<td>
															<input type="number" class="form-control" name="pur2_qty2[]" id="pur2_qty2_{{$pur2_key+1}}" onchange="CalculateRowWeight(1)" value="{{$pur2_items->Sales_qty2}}" step="any" required>
														</td>
														<td>
															<input type="number" class="form-control" name="pur2_per_unit[]" onchange="rowTotal({{$pur2_key+1}})" id="pur2_per_unit{{$pur2_key+1}}" value="{{$pur2_items->sales_price}}" step="any" required>
														</td>
														<td>
															<input type="number" class="form-control" name="pur2_len[]" id="pur2_len{{$pur2_key+1}}" onchange="rowTotal({{$pur2_key+1}})" value="{{$pur2_items->length}}" step="any" required>
														</td>
														<td>
															<input type="number" class="form-control" name="pur2_percentage[]" id="pur2_percentage{{$pur2_key+1}}" onchange="rowTotal({{$pur2_key+1}})" value="{{$pur2_items->discount}}" step="any" required>
															<input type="hidden" class="form-control" name="weight_per_piece[]" id="weight_per_piece{{$pur2_key+1}}" onchange="CalculateRowWeight({{$pur2_key+1}})" value="{{$pur2_items->weight_pc}}" step="any" required>
														</td>
														<td>
															<input type="number" class="form-control" id="pur2_qty{{$pur2_key+1}}" step="any" value="{{$pur2_items->weight_pc * $pur2_items->Sales_qty2}}" required disabled>
															<input type="hidden" class="form-control" name="pur2_qty[]" id="pur2_qty_show{{$pur2_key+1}}" value="{{$pur2_items->weight_pc * $pur2_items->Sales_qty2}}"  step="any" required>
														</td>
														<td>
															<input type="number" class="form-control" id="amount{{$pur2_key+1}}" onchange="tableTotal()" value="{{(($pur2_items->Sales_qty2 * $pur2_items->sales_price)+(($pur2_items->Sales_qty2 * $pur2_items->sales_price) * ($pur2_items->discount/100))) * $pur2_items->length}}" required step="any" disabled>
														</td>
														<td>
															<input type="date" class="form-control" disabled id="pur2_price_date{{$pur2_key+1}}" value="{{$pur2_items->rat_dat}}">
															<input type="hidden" class="form-control" name="pur2_price_date[]" id="pur2_price_date_show{{$pur2_key+1}}" value="{{$pur2_items->rat_dat}}">
														</td>
														
														<td>
															<input type="text" class="form-control" id="dispatchto{{$pur2_key+1}}" value="{{$pur2_items->dispatch_to}}" name="dispatchto[]">
														</td>	

														<td style="vertical-align: middle;">
															<button type="button" onclick="removeRow(this)" class="btn btn-danger" tabindex="1"><i class="fas fa-times"></i></button>
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>

									<footer class="card-footer" >
										<div class="row">
											<div class="row form-group mb-3">
												<div class="col-6 col-md-2 pb-sm-3 pb-md-0">
													<label class="col-form-label">Total Amount</label>
													<input type="text" id="totalAmount" name="totalAmount" placeholder="Total Amount" class="form-control" disabled>
												</div>

												<div class="col-6 col-md-2 pb-sm-3 pb-md-0">
													<label class="col-form-label">Total Weight</label>
													<input type="text" id="total_weight" placeholder="Total Weight" class="form-control" disabled>
												</div>

												<div class="col-6 col-md-2 pb-sm-3 pb-md-0">
													<label class="col-form-label">Total Quantity</label>
													<input type="text" id="total_quantity" placeholder="Total Quantity" class="form-control" disabled>
												</div>

												<div class="col-6 col-md-2 pb-sm-3 pb-md-0">
													<label class="col-form-label">Convance Charges</label>
													<input type="text" id="convance_charges" onchange="netTotal()" value="{{$pur2->ConvanceCharges}}"  name="ConvanceCharges"  placeholder="Convance Charges" class="form-control">
												</div>

												<div class="col-6 col-md-2 pb-sm-3 pb-md-0">
													<label class="col-form-label">Labour Charges</label>
													<input type="text" id="labour_charges"  onchange="netTotal()" value="{{$pur2->LaborCharges}}"  name="LaborCharges" placeholder="Labour Charges" class="form-control">
												</div>

												<div class="col-12 col-md-2 pb-sm-3 pb-md-0">
													<label class="col-form-label">Bill Discount </label>
													<div class="row">
														<div class="col-8">
															<input type="number" id="bill_discount" onchange="netTotal()" value="{{$pur2->Bill_discount}}"  name="Bill_discount" placeholder="Bill Discount" class="form-control">
														</div>
														<div class="col-4">
															<input type="text" id="bill_perc" class="form-control" placeholder="0%" disabled>
														</div>
													</div>
												</div>

												<div class="col-12 pb-sm-3 pb-md-0">
													<h3 class="font-weight-bold mt-3 mb-0 text-5 text-end text-primary">Net Amount</h3>
													<span class="d-flex align-items-center justify-content-lg-end">
														<strong class="text-4 text-primary">PKR <span id="netTotal" class="text-4 text-danger">0.00 </span></strong>
													</span>
												</div>
											</div>
										</div>
									</footer>
									<footer class="card-footer">
										<div class="row form-group mb-2">
											<div class="text-end">
												<button type="button" class="btn btn-danger mt-2"  onclick="window.location='{{ route('all-tpo') }}'"> <i class="fas fa-trash"></i> Discard Changes</button>
												<button type="submit" class="btn btn-primary mt-2"> <i class="fas fa-save"></i> Update PO</button>
											</div>
										</div>
									</footer>
								</section>
							</div>

						</div>
					</form>
				</section>
			</div>
		</section>
        @include('../layouts.footerlinks')
	</body>
</html>
 
<script>

let index = 1;
let itemCount = 0;

$(document).ready(function () {

    let rowCount = $('#Tpo2Table tr').length;

    index = rowCount + 1;
    itemCount = rowCount;

    $('#itemCount').val(itemCount);

    tableTotal();
});


// ===================== REMOVE ROW =====================
function removeRow(btn) {

    let rowCount = $("#Tpo2Table tr").length;

    if (rowCount > 1) {
        $(btn).closest('tr').remove();
        index--;
        itemCount--;
        $('#itemCount').val(itemCount);
    }

    tableTotal();
}


// ===================== ADD ROW =====================
function addNewRow() {

    let lastValue = $('#myTable tbody tr:last td:eq(1) select').val();

    if (!lastValue) return;

    let curr_disp_to = $('#Cash_pur_name').val();

    let row = `
    <tr>

        <td>
            <input type="text" class="form-control"
            id="item_cod${index}"
            onchange="getItemDetails(${index},1)"
            name="item_cod[]">
        </td>

        <td>
            <select class="form-control select2-js"
            id="item_name${index}"
            onchange="getItemDetails(${index},2)"
            name="item_name[]">
                <option value="">Select Item</option>
                @foreach($items as $row)
                    <option value="{{$row->it_cod}}">{{$row->item_name}}</option>
                @endforeach
            </select>
        </td>

        <td>
            <input type="text" class="form-control" id="remarks${index}" name="remarks[]">
        </td>

        <td>
            <input type="number" class="form-control"
            id="pur2_qty2_${index}"
            name="pur2_qty2[]"
            value="0"
            oninput="CalculateRowWeight(${index})">
        </td>

        <td>
            <input type="number" class="form-control"
            id="pur2_per_unit${index}"
            oninput="rowTotal(${index})"
            value="0"
            name="pur2_per_unit[]">
        </td>

        <td>
            <input type="number" class="form-control"
            id="pur2_len${index}"
            oninput="rowTotal(${index})"
            value="1"
            name="pur2_len[]">
        </td>

        <td>
            <input type="number" class="form-control"
            id="pur2_percentage${index}"
            oninput="rowTotal(${index})"
            value="0"
            name="pur2_percentage[]">

            <input type="hidden"
            id="weight_per_piece${index}"
            name="weight_per_piece[]"
            value="0">
        </td>

        <td>
            <input type="number" class="form-control"
            id="pur2_qty${index}" disabled>

            <input type="hidden"
            id="pur2_qty_show${index}"
            name="pur2_qty[]">
        </td>

        <td>
            <input type="number" class="form-control"
            id="amount${index}" disabled>
        </td>

        <td>
            <input type="date" class="form-control" disabled>
            <input type="hidden" name="pur2_price_date[]">
        </td>

        <td>
            <input type="text" class="form-control"
            id="dispatchto${index}"
            name="dispatchto[]"
            value="${curr_disp_to}">
        </td>

        <td>
            <button type="button" class="btn btn-danger" onclick="removeRow(this)">X</button>
        </td>

    </tr>
    `;

    $('#Tpo2Table').append(row);

    $('#myTable select').select2();

    index++;
    itemCount++;
    $('#itemCount').val(itemCount);
}


// ===================== ROW WEIGHT =====================
function CalculateRowWeight(i) {

    let qty = Number($('#pur2_qty2_' + i).val()) || 0;
    let wpp = Number($('#weight_per_piece' + i).val()) || 0;

    let weight = qty * wpp;

    $('#pur2_qty' + i).val(weight);
    $('#pur2_qty_show' + i).val(weight);

    rowTotal(i);
}


// ===================== ROW TOTAL =====================
function rowTotal(i) {

    let qty = Number($('#pur2_qty2_' + i).val()) || 0;
    let price = Number($('#pur2_per_unit' + i).val()) || 0;
    let discount = Number($('#pur2_percentage' + i).val()) || 0;
    let length = Number($('#pur2_len' + i).val()) || 0;

    let amount =
        ((qty * price) + ((qty * price) * (discount / 100))) * length;

    $('#amount' + i).val(amount);

    tableTotal();
}


// ===================== TABLE TOTAL =====================
function tableTotal() {

    let totalQty = 0;
    let totalWeight = 0;
    let totalAmount = 0;

    $('#Tpo2Table tr').each(function () {

        totalQty += Number($(this).find('input[name="pur2_qty2[]"]').val()) || 0;
        totalWeight += Number($(this).find('input[name="pur2_qty[]"]').val()) || 0;
        totalAmount += Number($(this).find('input[id^="amount"]').val()) || 0;
    });

    $('#total_quantity').val(totalQty);
    $('#total_weight').val(totalWeight);
    $('#totalAmount').val(totalAmount);

    netTotal();
}


// ===================== NET TOTAL =====================
function netTotal() {

    let total = Number($('#totalAmount').val()) || 0;
    let conv = Number($('#convance_charges').val()) || 0;
    let labour = Number($('#labour_charges').val()) || 0;
    let discount = Number($('#bill_discount').val()) || 0;

    let net = total + conv + labour - discount;

    $('#netTotal').text(net.toFixed(0));
}

</script>