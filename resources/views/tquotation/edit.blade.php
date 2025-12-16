@include('../layouts.header')
	<body>
		<section class="body">
		@include('../layouts.pageheader')
		<div class="inner-wrapper cust-pad">
				<section role="main" class="content-body" style="margin:0px">
					<form method="post" action="{{ route('update-tquotation') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';" id="addForm">
						@csrf
						<div class="row">	
							<div class="col-12 mb-3">								
								<section class="card">
									<header class="card-header" style="display: flex;justify-content: space-between;">
										<h2 class="card-title">Edit Quotation Pipes/Garders</h2>
										<div class="card-actions">
											<button type="button" class="btn btn-primary" onclick="addNewRow_btn()"> <i class="fas fa-plus"></i> Add New Row </button>
										</div>
									</header>
									

									<div class="card-body">
										<div class="row form-group mb-2">
											<div class="col-6 col-md-2 mb-2">
												<label class="col-form-label" >Quotation No.</label>
												<input type="text" placeholder="(Edit Quotation)" class="form-control" value="{{$pur2->prefix}}{{$pur2->Sale_inv_no}}" disabled>
												<input type="hidden" placeholder="Invoice #" class="form-control" value="{{$pur2->Sale_inv_no}}" name="pur2_id">
												<input type="hidden" id="itemCount" name="items" value="1" class="form-control">
											</div>
											<div class="col-6 col-md-2 mb-2">
												<label class="col-form-label" >Date</label>
												<input type="date" name="sa_date" value="{{$pur2->sa_date}}" autofocus class="form-control">
											</div>
											
											<div class="col-sm-12 col-md-4 mb-3">
												<label class="col-form-label">Customer Name<span style="color: red;"><strong>*</strong></span></label>
												<select data-plugin-selecttwo class="form-control select2-js"  name="account_name" required>
													<option value="" disabled selected>Select Customer Name</option>
													@foreach($coa as $key => $row)	
														<option value="{{$row->ac_code}}" {{ $pur2->account_name == $row->ac_code ? 'selected' : '' }}>{{$row->ac_name}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-6 col-md-2 mb-2">
												<label class="col-form-label" >PO#</label>
												<input type="text" placeholder="PO#" name="pur_ord_no" value="{{$pur2->pur_ord_no}}" class="form-control">
											</div>
											<div class="col-6 col-md-2 mb-2">
												<label class="col-form-label">Sale Inv#</label>
												<label class="col-form-label" style="cursor: pointer; color: blue; text-decoration: underline; float: right;" id="edit-sale-inv">Enable</label>
												<input type="text" placeholder="Sale Inv. No." name="sales_against" value="{{$pur2->sales_against}}" id="sale-inv-no" disabled class="form-control">
													<!-- Hidden Input Field -->
													<input type="hidden" placeholder="Sale Inv. No." class="form-control" value="{{$pur2->sales_against}}" name="hidden_sales_against" id="hidden-sale-inv-no">
										
											</div>
											
											<div class="col-sm-12 col-md-4 mb-3">
												<label class="col-form-label">Dispatch From<span style="color: red;">*</span></label>
												<select data-plugin-selecttwo class="form-control select2-js"  name="disp_account_name" required>
													<option value="" disabled selected>Select Dispatch From</option>
													@foreach($coa as $key => $row)	
														<option value="{{$row->ac_code}}" {{ $pur2->Cash_pur_name_ac == $row->ac_code ? 'selected' : '' }}>{{$row->ac_name}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-sm-3 col-md-2 mb-2">
												<label class="col-form-label" >Name of Person</label>
												<input type="text" placeholder="Name of Person" name="Cash_pur_name" value="{{$pur2->Cash_pur_name}}" class="form-control">
											</div>
											

											<div class="col-sm-3 col-md-2 mb-2">
												<label class="col-form-label" >Person Address</label>
												<input type="text" placeholder="Person Address" name="cash_Pur_address" value="{{$pur2->cash_Pur_address}}" class="form-control">
											</div>

											<div class="col-sm-12 col-md-4 mb-3">
												<label class="col-form-label">Attachements</label>
												<input type="file" class="form-control" name="att[]" multiple accept=".zip, appliation/zip, application/pdf, image/png, image/jpeg">
											</div>

											<div class="col-6 mb-12">
												<label class="col-form-label">Remarks</label>
												<textarea rows="4" cols="50" name="Sales_Remarks" id="Sales_Remarks"  placeholder="Remarks" class="form-control cust-textarea">{{$pur2->Sales_Remarks}}</textarea>
											</div>	

											<div class="col-6 mb-2">
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
													<th width="20%">Remarks</th>
													<th width="7%">Quantity<span style="color: red;"><strong>*</strong></span></th>
													<th width="7.5%">Price/Unit<span style="color: red;"><strong>*</strong></span></th>
													<th width="7%">Length<span style="color: red;"><strong>*</strong></span></th>
													<th width="7%">Percent<span style="color: red;"><strong>*</strong></span></th>
													<th width="7%">Weight</th>
													<th width="7%">Amount</th>
													<th width="7%">Price Date</th>
													<th width=""></th>
												</tr>
											</thead>
											<tbody id="Quotation2Table">
												@foreach ($pur2_item as $pur2_key => $pur2_items)
													<tr>
														<td>
															<input type="text" class="form-control" name="item_cod[]" id="item_cod{{$pur2_key+1}}" value="{{$pur2_items->item_cod}}" onchange="getItemDetails({{$pur2_key+1}},1)" required>
														</td>
														<td>
															<select data-plugin-selecttwo class="form-control select2-js" autofocus id="item_name{{$pur2_key+1}}" name="item_name[]" onchange="getItemDetails({{$pur2_key+1}},2)" required>
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

												<div class="col-12 pb-sm-3 pb-md-0 text-end">
													<h3 class="font-weight-bold mt-3 mb-0 text-5 text-primary">Net Amount</h3>
													<span>
														<strong class="text-4 text-primary">PKR <span id="netTotal" class="text-4 text-danger">0.00 </span></strong>
													</span>
												</div>
											</div>
										</div>
									</footer>
									<footer class="card-footer">
										<div class="row form-group mb-2">
											<div class="text-end">
												<button type="button" class="btn btn-danger mt-2"  onclick="window.location='{{ route('all-tquotation') }}'"> <i class="fas fa-trash"></i> Discard Changes</button>
												<button type="submit" class="btn btn-primary mt-2"> <i class="fas fa-save"></i> Update Quotation</button>
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
