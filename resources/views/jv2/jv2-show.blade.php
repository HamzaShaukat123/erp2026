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
											<h2 class="h2 mt-0 mb-1" style="color:#17365D">Voucher NO:</h2>
											<h4 class="h4 m-0 text-dark font-weight-bold">JV2-{{$jv2->jv_no}}</h4>
										</div>
										<div class="col-4 text-end mt-3 mb-3">
											<div class="ib">
												<img width="100px" src="/assets/img/logo.png" alt="MFI Logo" />
											</div>
										</div>
									</div>
								</header>

								<div class="bill-info">
									<div class="row align-items-center">
										<!-- Date -->
										<div class="col-md-7">
											<div class="bill-to">
												<h4 class="h6 mb-0 text-dark font-weight-semibold d-flex align-items-center">
													<span style="color:#17365D;">Date:&nbsp;</span>
													<span style="font-weight:400; color:black;">
														{{ \Carbon\Carbon::parse($jv2->jv_date)->format('d-m-y') }}
													</span>
												</h4>
											</div>
										</div>

										<!-- Narration & Attachment Link -->
										<div class="col-md-5">
											<div class="bill-data d-flex justify-content-between align-items-center">
												<h4 class="h6 mb-0 text-dark font-weight-semibold mb-1">
													<span style="color:#17365D;">Narration:&nbsp;</span>
													<span style="font-weight:400; color:black;">
														{{ $jv2->narration }}
													</span>
												</h4>

												<a href="#attModal"
												onclick="getAttachements({{ $jv2->jv_no }})"
												class="modal-with-zoom-anim text-primary"
												style="font-size:13px; text-decoration:underline;">
												Show Attachment
												</a>
											</div>
										</div>
									</div>
								</div>


								<table class="table table-responsive-md table-striped invoice-items" style="font-size: 18px;">
									<thead>
										<tr class="text-dark">
											<th width="20%" class="text-center font-weight-semibold" style="color:#17365D;">Account Name</th>
											<th width="20%" class="text-center font-weight-semibold" style="color:#17365D;">Remarks</th>
											<th width="15%" class="text-center font-weight-semibold" style="color:#17365D;">Bank Name</th>
											<th width="15%" class="text-center font-weight-semibold" style="color:#17365D;">Inst/Slip #</th>
											<th width="15%" class="text-center font-weight-semibold" style="color:#17365D;">Debit</th>
											<th width="15%" class="text-center font-weight-semibold" style="color:#17365D;">Credit</th>
										</tr>
									</thead>
									<tbody>
										@foreach($entries as $entry)
											<tr>
												<td class="font-weight-semibold text-dark text-center">{{ $entry->account_name }}</td>
												<td class="font-weight-semibold text-dark text-center">{{ $entry->remarks }}</td>
												<td class="font-weight-semibold text-dark text-center">{{ $entry->bankname }}</td>
												<td class="font-weight-semibold text-dark text-center">
													{{ $entry->instrumentnumber && $entry->slip 
														? $entry->instrumentnumber . '-' . $entry->slip 
														: ($entry->instrumentnumber ?? $entry->slip) }}
												</td>
												<td class="font-weight-semibold text-dark text-center">{{ number_format($entry->debit) }}</td>
												<td class="font-weight-semibold text-dark text-center">{{ number_format($entry->credit) }}</td>
											</tr>
										@endforeach
									</tbody>

								</table>
								
								<div class="row">
									<div class="col-12 col-md-8">
										<h3 style="color:#17365D; text-decoration: underline;" id="numberInWords"></h3>
									</div>
									<div class="col-12 col-md-4">
										<div class="text-end">
											<a onclick="window.location='{{ route('all-jv2') }}'" class="btn btn-primary mt-2">
												<i class="fas fa-arrow-left"></i> Back
											</a>

											<a href="{{ route('edit-jv2', $jv2->jv_no) }}" class="btn btn-warning mt-2">
												<i class="fas fa-edit"></i> Edit
											</a>

											<a href="{{ route('print-jv2', $jv2->jv_no) }}" class="btn btn-danger mt-2" target="_blank">
												<i class="fas fa-print"></i> Print
											</a>
										</div>

									</div>
								<div>
							</div>
						</div>

					</section>
				</section>
			</div>
			</div>
		</section>


		<div id="attModal" class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">
            <section class="card">
                <header class="card-header">
                    <h2 class="card-title">All Attachements</h2>
                </header>
                <div class="card-body">
                    <div class="modal-wrapper">

                        <table class="table table-bordered table-striped mb-0" id="datatable-default">
                            <thead>
                                <tr>
                                    <th>Attachement Path</th>
                                    <th>Download</th>
                                    <th>View</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="jv2_attachements">

                            </tbody>
                        </table>
                    </div>
                </div>
                <footer class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button class="btn btn-default modal-dismiss">Cancel</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>

        @include('../layouts.footerlinks')
	</body>


	<script>
		
		var netAmount = <?php echo json_encode($jv2->amount); ?>;
		var words = convertCurrencyToWords(netAmount);
		document.getElementById('numberInWords').innerHTML = words;



		
		function getAttachements(id) {
			var table = document.getElementById('jv2_attachements');
			while (table.rows.length > 0) {
				table.deleteRow(0);
			}

			$.ajax({
				type: "GET",
				url: "/vouchers2/attachements",
				data: { id: id },
				success: function(result) {
					$.each(result, function(k, v) {
						var html = "<tr>";
						html += "<td>" + v['att_path'] + "</td>";
						html += "<td class='text-center'><a class='mb-1 mt-1 text-danger' href='/vouchers2/download/" + v['att_id'] + "'><i class='fas fa-download'></i></a></td>";
						html += "<td class='text-center'><a class='mb-1 mt-1 text-primary' href='/vouchers2/view/" + v['att_id'] + "' target='_blank'><i class='fas fa-eye'></i></a></td>";
						html += "<td class='text-center'><a class='mb-1 mt-1 text-primary' href='#' onclick='deleteFile(" + v['att_id'] + ")'><i class='fas fa-trash'></i></a></td>";
						html += "</tr>";
						$('#jv2_attachements').append(html);
					});
				},
				error: function() {
					alert("Error fetching attachments.");
				}
			});
		}



	</script>
	
	
</html>