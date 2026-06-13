@include('../layouts.header')

<body>
<section class="body">
<div class="inner-wrapper">

<section role="main" class="content-body" style="margin:0px;padding:75px 10px !important">

@include('../layouts.pageheader')

<section class="card shadow-sm border-0">

<div class="card-body">

<div class="invoice">

{{-- HEADER --}}
<header class="mb-3 border-bottom pb-2">

    <div class="row align-items-center">

        <div class="col-md-6">

            <h3 class="mb-1 text-primary fw-bold">
                ACCOUNT DETAIL SHEET
            </h3>

            {{-- ACCOUNT CODE + NAME --}}
            <h5 class="mt-2 mb-0">
                <span class="text-dark fw-bold">
                    {{ $acc->ac_code ?? '-' }} - {{ $acc->ac_name ?? '-' }}
                </span>
            </h5>

        </div>

        <div class="col-md-6 text-end">
            <img width="90" src="/assets/img/logo.png" alt="MFI Logo">
        </div>

    </div>

</header>

{{-- TABLE --}}
<div class="table-responsive">

<table class="table table-bordered table-striped align-middle">

    <tbody>

        {{-- MOVED STATUS NEXT TO ACCOUNT CODE/NAME --}}
        <tr class="table-light">
            <th width="20%">Account Code / Name</th>
            <td>
                {{ $acc->ac_code ?? '-' }} - {{ $acc->ac_name ?? '-' }}
            </td>

            <th width="20%">Status</th>
            <td>
                @if(($acc->status ?? 1) == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>
        </tr>

        <tr>
            <th>Opening Date</th>
            <td>
                {{ !empty($acc->opp_date) ? \Carbon\Carbon::parse($acc->opp_date)->format('d-m-Y') : '-' }}
            </td>

            <th>Phone No</th>
            <td>{{ $acc->phone_no ?? '-' }}</td>
        </tr>

        <tr class="table-light">
            <th>Receivable</th>
            <td class="text-success fw-bold">
                {{ number_format($acc->rec_able ?? 0, 2) }}
            </td>

            <th>Payable</th>
            <td class="text-danger fw-bold">
                {{ number_format($acc->pay_able ?? 0, 2) }}
            </td>
        </tr>

        <tr>
            <th>Credit Limit</th>
            <td>{{ number_format($acc->credit_limit ?? 0, 2) }}</td>

            <th>Days Limit</th>
            <td>{{ $acc->days_limit ?? 0 }}</td>
        </tr>

        

        <tr class="table-light">
            <th>Account Type</th>
            <td>{{ $acc->sub ?? '-' }}</td>

            <th>Group Code</th>
            <td>{{ $acc->group_name ?? '-' }}</td>
        </tr>

        <tr>
            <th>City</th>
            <td>{{ $acc->city ?? '-' }}</td>

            <th>Area</th>
            <td>{{ $acc->area ?? '-' }}</td>
        </tr>

        <tr class="table-light">
            <th>Address</th>
            <td colspan="3">{{ $acc->address ?? '-' }}</td>
        </tr>

        <tr>
            <th>Remarks</th>
            <td colspan="3">{{ $acc->remarks ?? '-' }}</td>
        </tr>

    </tbody>

</table>

</div>

<div class="row mt-3">
    <div class="col-12 col-md-4 ms-auto text-end">
        <a onclick="window.location='{{ route('all-acc') }}'" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        <button type="button"
            class="btn btn-warning modal-with-zoom-anim ws-normal modal-with-form"
            onclick="getAccountDetails({{ $acc->ac_code }})"
            href="#updateModal"
            title="Edit JV1">
            <i class="fas fa-edit"></i> Edit
        </button>

        <button onclick="window.print()" class="btn btn-danger mt-2 mb-2">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

</div>

</section>

</section>
</div>
</section>

<div id="updateModal" class="modal-block modal-block-primary mfp-hide">
            <section class="card">
                <form method="post" id="updateForm" action="{{ route('update-acc') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <header class="card-header">
                        <h2 class="card-title">Update Account</h2>
                    </header>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label>Account Code</label>
                                <input type="number" class="form-control" placeholder="Account Code" id="ac_id" required disabled>
                                <input type="number" class="form-control"  name="ac_cod" id="update_ac_id" required hidden>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Account Name<span style="color: red;"><strong>*</strong></span></label>
                                <input type="text" class="form-control" placeholder="Account Name"  name="ac_name" id="update_ac_name" required>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Receivables<span style="color: red;"><strong>*</strong></span></label>
                                <input type="number" class="form-control" placeholder="Receivables" value="0" required name="rec_able" id="update_rec_able" step=".00001">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Payables<span style="color: red;"><strong>*</strong></span></label>
                                <input type="number" class="form-control" placeholder="Payables" value="0" name="pay_able" required id="update_pay_able" step=".00001">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Date</label>
                                <input type="date" class="form-control" placeholder="Date" name="opp_date" id="update_opp_date">
                            </div>  
                            <div class="col-lg-6 mb-2">
                                <label>Remarks</label>
                                <input type="text" class="form-control"  placeholder="Remarks" name="remarks" id="update_remarks">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Area</label>
                                <select data-plugin-selecttwo class="form-control select2-js"  name="area" id="update_area">
                                    <option value="">Select Area</option>
                                    @foreach($ac_area as $key => $row)	
                                        <option value="{{$row->id}}">{{$row->area}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>City</label>
                                <select data-plugin-selecttwo class="form-control select2-js"  name="city" id="update_city">
                                    <option value="">Select City</option>
                                    @foreach($ac_city as $key => $row)	
                                        <option value="{{$row->id}}">{{$row->city}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Address</label>
                                <textarea type="text" class="form-control" rows="2" placeholder="Address" name="address" id="update_address"></textarea>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Phone No.</label>
                                <input type="text" class="form-control"  placeholder="Phone No." name="phone_no" id="update_phone_no">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Credit Limit<span style="color: red;"><strong>*</strong></span></label>
                                <input type="text" class="form-control"  placeholder="Credit Limit." required name="credit_limit" id="update_credit_limit">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Days Limit<span style="color: red;"><strong>*</strong></span></label>
                                <input type="text" class="form-control"  placeholder="Days Limit" required name="days_limit" id="update_days_limit">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>Account Group</label>
                                <select data-plugin-selecttwo class="form-control select2-js"  name="group_cod" id="update_group_cod">
                                    <option value="">Select Group</option>
                                    @foreach($ac_group as $key => $row)	
                                        <option value="{{$row->group_cod}}">{{$row->group_name}}</option>
                                    @endforeach
                                </select>
                                <a href="{{ route('all-acc-groups') }}">Add New A.Group</a>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>Account Type<span style="color: red;"><strong>*</strong></span></label>
                                <select data-plugin-selecttwo class="form-control select2-js"  name="AccountType" required id="update_AccountType">
                                    <option disabled selected>Select Account Type</option>
                                    @foreach($sub_head_of_acc as $key => $row)	
                                        <option value="{{$row->id}}">{{$row->sub}}</option>
                                    @endforeach
                                </select>
                                <a href="{{ route('all-acc-sub-heads-groups') }}">Add New A.Type</a>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>Attachements</label>
                                <input type="file" class="form-control" name="att[]" id="update_att" multiple accept="application/pdf, image/png, image/jpeg">
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Update Account</button>
                                <button class="btn btn-default modal-dismiss">Cancel</button>
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>

@include('../layouts.footerlinks')

</body>
</html>

<script>
 function getAccountDetails(id){
        $.ajax({
            type: "GET",
            url: "/coa/detail",
            data: {id:id},
            success: function(result){
                $('#ac_id').val(result['ac_code']);
                $('#update_ac_id').val(result['ac_code']);
                $('#update_ac_name').val(result['ac_name']);
                $('#update_rec_able').val(result['rec_able']);
                $('#update_pay_able').val(result['pay_able']);
                $('#update_opp_date').val(result['opp_date']);
                $('#update_remarks').val(result['remarks']);
                $('#update_area').val(result['area']).trigger('change');
                $('#update_city').val(result['city']).trigger('change');
                $('#update_address').val(result['address']);
                $('#update_phone_no').val(result['phone_no']);
                $('#update_credit_limit').val(result['credit_limit']);
                $('#update_days_limit').val(result['days_limit']);
                $('#update_group_cod').val(result['group_cod']).trigger('change');
                $('#update_AccountType').val(result['AccountType']).trigger('change');
                $('#update_att').val(result['att']);
            },
            error: function(){
                alert("error");
            }
        });
	}

 </script>