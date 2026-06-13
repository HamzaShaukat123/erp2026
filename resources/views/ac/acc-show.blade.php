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

            <h5 class="mt-2 mb-0">
                <span class="text-dark fw-bold">
                    {{ $acc->ac_code ?? '-' }} - {{ $acc->ac_name ?? '-' }}
                </span>

                &nbsp; 

                @if(($acc->status ?? 1) == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
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

        {{-- 1. BASIC INFO --}}
        <tr class="table-light">
            <th width="20%">Account Code / Name</th>
            <td>
                {{ $acc->ac_code ?? '-' }} - {{ $acc->ac_name ?? '-' }}
            </td>

            <th width="20%">Phone No</th>
            <td>{{ $acc->phone_no ?? '-' }}</td>
        </tr>

        {{-- 2. FINANCIAL INFO --}}
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

        {{-- 3. LIMITS --}}
        <tr>
            <th>Credit Limit</th>
            <td>{{ number_format($acc->credit_limit ?? 0, 2) }}</td>

            <th>Days Limit</th>
            <td>{{ $acc->days_limit ?? 0 }}</td>
        </tr>

        {{-- 4. OPENING INFO --}}
        <tr class="table-light">
            <th>Opening Date</th>
            <td>
                {{ !empty($acc->opp_date) ? \Carbon\Carbon::parse($acc->opp_date)->format('d-m-Y') : '-' }}
            </td>

            <th>Status</th>
            <td>
                @if(($acc->status ?? 1) == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>
        </tr>

        {{-- 5. LOCATION --}}
        <tr>
            <th>City</th>
            <td>{{ $acc->city ?? '-' }}</td>

            <th>Area</th>
            <td>{{ $acc->area ?? '-' }}</td>
        </tr>

        {{-- 6. CLASSIFICATION --}}
        <tr class="table-light">
            <th>Account Type</th>
            <td>{{ $acc->sub ?? '-' }}</td>

            <th>Group Code</th>
            <td>{{ $acc->group_name ?? '-' }}</td>
        </tr>

        {{-- 7. ADDRESS --}}
        <tr>
            <th>Address</th>
            <td colspan="3">{{ $acc->address ?? '-' }}</td>
        </tr>

        {{-- 8. REMARKS --}}
        <tr class="table-light">
            <th>Remarks</th>
            <td colspan="3">{{ $acc->remarks ?? '-' }}</td>
        </tr>

    </tbody>

</table>

</div>

<div class="text-end">
    <button onclick="window.print()" class="btn btn-danger mt-2 mb-2">
        <i class="fas fa-print"></i> Print
    </button>
</div>

</div>

</section>

</section>
</div>
</section>

@include('../layouts.footerlinks')

</body>
</html>