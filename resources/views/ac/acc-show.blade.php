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

            {{-- ACCOUNT CODE + NAME + STATUS --}}
            <h5 class="mt-2 mb-0">
                <span class="text-dark fw-bold">
                    {{ $acc->ac_code ?? '-' }} - {{ $acc->ac_name ?? '-' }}
                </span>

                @if(($acc->status ?? 1) == 1)
                    <span class="badge bg-success ms-2">Active</span>
                @else
                    <span class="badge bg-danger ms-2">Inactive</span>
                @endif
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

        <tr>
            <th width="20%">Opening Date</th>
            <td>
                {{ !empty($acc->opp_date) ? \Carbon\Carbon::parse($acc->opp_date)->format('d-m-Y') : '-' }}
            </td>

            <th width="20%">Phone No</th>
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
            href="#updateModal">
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