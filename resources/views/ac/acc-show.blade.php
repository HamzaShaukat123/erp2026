@include('../layouts.header')
	<body>
		<section class="body">
			<div class="inner-wrapper">
				<section role="main" class="content-body" style="margin:0px;padding:75px 10px !important">
				@include('../layouts.pageheader')

                    <section class="card">

						<div class="card-body">

							<div class="invoice">

								<header class="clearfix">
									<div class="row">
										<div class="col-8 mt-3 mb-3">
											<h2 class="h2 mt-0 mb-1" style="color:#17365D">Account Name:</h2>
											<h4 class="h4 m-0 text-dark font-weight-bold">{{$acc->ac_code }}-{{$acc->ac_name}}</h4>
										</div>
										<div class="col-4 text-end mt-3 mb-3">
											<div class="ib">
												<img width="100px" src="/assets/img/logo.png" alt="MFI Logo" />
											</div>
										</div>
									</div>
								</header>
								<div class="bill-info">
									<div class="row">
										<div class="col-md-7">
											<div class="bill-to">
												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Opening Date: &nbsp </span>
													<span style="font-weight:400;color:black" class="value">  {{\Carbon\Carbon::parse($acc->opp_date)->format('d-m-y')}}</span>
												</h4>

												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Remarks: &nbsp </span>
													<span style="font-weight:400;color:black" class="value"> {{$acc->remarks}}</span>
												</h4>

												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Address: &nbsp </span>
													<span style="font-weight:400;color:black" class="value"> {{$acc->address}}</span>
												</h4>

												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Phone No: &nbsp </span>
													<span style="font-weight:400;color:black" class="value"> {{$acc->phone_no}}</span>
												</h4>
												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Group Code: &nbsp </span>
													<span style="font-weight:400;color:black" class="value"> {{$acc->group_cod}}</span>
												</h4>
											</div>
										</div>
										<div class="col-md-5">
											<div class="bill-data">
												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Dispatch From: &nbsp </span>
													<span style="font-weight:400;color:black" class="value"> {{$acc->disp_to}}</span>
												</h4>
												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Name Of Person: &nbsp </span>
													<span style="font-weight:400;color:black" class="value"> {{$acc->Cash_name}}</span>
												</h4>
												
												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Person Address: &nbsp </span>
													<span style="font-weight:400;color:black" class="value"> {{$acc->cash_Pur_address}}</span>
												</h4>

												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<a href="#" style="color:#53b21c" data-bs-toggle="modal" data-bs-target="#editBillModal">
														Bill No: &nbsp;
													</a>
													<span style="font-weight:400;color:black" class="value" id="billNoDisplay">{{ $acc->pur_ord_no }}</span>
												</h4>

												<h4 class="mb-0 h6 mb-1 text-dark font-weight-semibold">
													<span style="color:#17365D">Remarks: &nbsp </span>
													<span style="font-weight:400;color:black" class="value"> {{$acc->Sales_Remarks}}</span>
												</h4>
											</div>
										</div>
									</div>
								</div>

	

							</div>

						<div id="printModal" class="zoom-anim-dialog modal-block modal-block-danger mfp-hide" style="max-width: 350px;">
							<form method="get" action="{{ route('print-sales2-invoice') }}" target="_blank" enctype="multipart/form-data">
								@csrf
								<section class="card">
									<header class="card-header">
										<h2 class="card-title">Select Print Format</h2>
									</header>
									<div class="card-body">
										<div class="modal-wrapper">
											<select data-plugin-selecttwo class="form-control select2-js" autofocus name="print_type" required>
												<option value="" disabled selected>Select Print Format</option>
												<option value="1" >Show All</option>
												<option value="2" >Exclude Item Length</option>
												<option value="3" >Only Quantity & Price</option>
											</select>
											<input type="hidden" name="print_sale2" id="printID" >
										</div>
									</div>
									<footer class="card-footer">
										<div class="row">
											<div class="col-md-12 text-end">
												<button type="submit" class="btn btn-danger">Print Invoice</button>
												<button type="button" class="btn btn-default modal-dismiss">Cancel</button>
												{{-- <a href="{{ route('all-sale2invoices-paginate') }}" class="btn btn-primary mt-2 mb-2">
													<i class="fas fa-arrow-left"></i> Back
												</a> --}}
												<div class="btn-group dropup mt-2 mb-2 position-relative">
													<!-- Back Button -->
													<button type="button" onclick="window.location='{{ route('all-sale2invoices-paginate') }}'" class="btn btn-primary">
														<i class="fas fa-arrow-left"></i> Back
													</button>

													<!-- Dropdown Split Button -->
													<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
														<span class="visually-hidden">Toggle Dropdown</span>
													</button>

													<!-- Dropdown Menu -->
													<ul class="dropdown-menu dropdown-menu-end" style="inset: auto 100% 100% auto; transform: translateX(-8px);">
														<li>
															<a class="dropdown-item text-success fw-semibold" href="{{ route('new-sales2') }}">
																<i class="fas fa-plus me-2"></i> Add New
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</footer>
									
								</section>
							</form>
						</div>
					</section>
				</section>
			</div>
			</div>
		</section>
		
		


        @include('../layouts.footerlinks')
	</body>

	<script>


		function setPrintId(id){
			$('#printID').val(id);
		}
	</script>
	
</html>