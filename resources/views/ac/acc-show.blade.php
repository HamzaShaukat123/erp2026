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
<header class="clearfix mb-3">
    <div class="row align-items-center">

        <div class="col-md-8">
            <h3 class="mb-1 text-primary fw-bold">
                ACCOUNT DETAIL SHEET
            </h3>

            <h4 class="mb-0 text-dark fw-semibold text-danger">
                {{$acc->ac_code ?? '-'}} - {{$acc->ac_name ?? '-'}}
            </h4>

			<h4 class="mb-0 text-dark text-danger">
				{{$acc->ac_code ?? '-' }} - {{$acc->ac_name ?? '-'}}
			</h4>
        </div>

        <div class="col-md-4 text-end">
            <img width="90px" src="/assets/img/logo.png" alt="MFI Logo">
        </div>

    </div>
</header>

{{-- ERP STYLE TABLE --}}
<div class="table-responsive">

<table class="table table-bordered table-striped align-middle">

    <tbody>

        <tr class="table-light">
            <th width="20%">Account Code</th>
            <td>{{$acc->ac_code ?? '-'}}</td>

            <th width="20%">Account Name</th>
            <td>{{$acc->ac_name ?? '-'}}</td>
        </tr>

        <tr>
            <th>Opening Date</th>
            <td>
                {{ !empty($acc->opp_date) ? \Carbon\Carbon::parse($acc->opp_date)->format('d-m-Y') : '-' }}
            </td>

            <th>Group Code</th>
            <td>{{$acc->group_cod ?? '-'}}</td>
        </tr>

        <tr class="table-light">
            <th>Receivable</th>
            <td class="text-success fw-bold">
                {{ number_format($acc->rec_able ?? 0,2) }}
            </td>

            <th>Payable</th>
            <td class="text-danger fw-bold">
                {{ number_format($acc->pay_able ?? 0,2) }}
            </td>
        </tr>

        <tr>
            <th>Credit Limit</th>
            <td>
                {{ number_format($acc->credit_limit ?? 0,2) }}
            </td>

            <th>Days Limit</th>
            <td>
                {{$acc->days_limit ?? 0}}
            </td>
        </tr>

        <tr class="table-light">
            <th>Phone No</th>
            <td>{{$acc->phone_no ?? '-'}}</td>

            <th>City / Area</th>
            <td>
                {{$acc->city ?? '-'}} / {{$acc->area ?? '-'}}
            </td>
        </tr>

        <tr>
            <th>Address</th>
            <td colspan="3">{{$acc->address ?? '-'}}</td>
        </tr>

        <tr class="table-light">
            <th>Remarks</th>
            <td colspan="3">{{$acc->remarks ?? '-'}}</td>
        </tr>

        <tr>
            <th>Account Type</th>
            <td>{{$acc->AccountType ?? '-'}}</td>

            <th>Status</th>
            <td>
                <span class="badge bg-success">Active</span>
            </td>
        </tr>

        <tr class="table-light">
            <th>Dispatch From</th>
            <td>{{$acc->disp_to ?? '-'}}</td>

            <th>Person Name</th>
            <td>{{$acc->Cash_name ?? '-'}}</td>
        </tr>

        <tr>
            <th>Person Address</th>
            <td colspan="3">{{$acc->cash_Pur_address ?? '-'}}</td>
        </tr>

        <tr class="table-light">
            <th>Sales Remarks</th>
            <td colspan="3">{{$acc->Sales_Remarks ?? '-'}}</td>
        </tr>

    </tbody>

</table>

</div>

</div>

</section>

</section>
</div>
</section>

@include('../layouts.footerlinks')

</body>
</html>