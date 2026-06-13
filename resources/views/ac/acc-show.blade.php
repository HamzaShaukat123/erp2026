@include('../layouts.header')

<style>
    /* ================= A4 PRINT SETUP ================= */
    @page {
        size: A4;
        margin: 12mm;
    }

    body {
        background: #fff !important;
    }

    /* ================= PRINT ONLY STYLES ================= */
    @media print {

        .no-print {
            display: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        .table td,
        .table th {
            padding: 6px !important;
            font-size: 12px !important;
        }

        body {
            -webkit-print-color-adjust: exact;
        }
    }

    /* ================= WATERMARK ================= */
    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 90px;
        font-weight: bold;
        opacity: 0.05;
        z-index: 0;
        pointer-events: none;
        white-space: nowrap;
    }

    .invoice {
        position: relative;
        z-index: 1;
    }

    /* ================= HEADER LOOK ================= */
    .report-title {
        font-size: 22px;
        font-weight: bold;
        color: #0d6efd;
    }

    .sub-title {
        font-size: 16px;
        font-weight: 600;
    }
</style>

<body>

<div class="watermark">MFI</div>

<section class="body">
<div class="inner-wrapper">

<section role="main" class="content-body" style="margin:0px;padding:20px 10px !important">

@include('../layouts.pageheader')

<section class="card shadow-sm border-0">

<div class="card-body">

<div class="invoice">

{{-- ================= HEADER ================= --}}
<header class="mb-3 border-bottom pb-2">

    <div class="row align-items-center">

        <div class="col-md-6">

            <div class="report-title">
                ACCOUNT DETAIL SHEET
            </div>

            <div class="sub-title mt-2">
                {{ $acc->ac_code ?? '-' }} - {{ $acc->ac_name ?? '-' }}
            </div>

        </div>

        <div class="col-md-6 text-end">
            <img width="90" src="/assets/img/logo.png" alt="MFI Logo">
        </div>

    </div>

</header>

{{-- ================= TABLE ================= --}}
<div class="table-responsive">

<table class="table table-bordered table-striped align-middle">

    <tbody>

        {{-- BASIC INFO --}}
        <tr class="table-light">
            <th width="20%">Account Code / Name</th>
            <td>{{ $acc->ac_code ?? '-' }} - {{ $acc->ac_name ?? '-' }}</td>

            <th width="20%">Status</th>
            <td>
                @if(($acc->status ?? 1) == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>
        </tr>

        {{-- CONTACT INFO --}}
        <tr>
            <th>Opening Date</th>
            <td>
                {{ !empty($acc->opp_date) ? \Carbon\Carbon::parse($acc->opp_date)->format('d-m-Y') : '-' }}
            </td>

            <th>Phone No</th>
            <td>{{ $acc->phone_no ?? '-' }}</td>
        </tr>

        {{-- FINANCIAL INFO --}}
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

        {{-- LIMITS --}}
        <tr>
            <th>Credit Limit</th>
            <td>{{ number_format($acc->credit_limit ?? 0, 2) }}</td>

            <th>Days Limit</th>
            <td>{{ $acc->days_limit ?? 0 }}</td>
        </tr>

        {{-- LOCATION --}}
        <tr class="table-light">
            <th>City</th>
            <td>{{ $acc->city ?? '-' }}</td>

            <th>Area</th>
            <td>{{ $acc->area ?? '-' }}</td>
        </tr>

        {{-- CLASSIFICATION --}}
        <tr>
            <th>Account Type</th>
            <td>{{ $acc->sub ?? '-' }}</td>

            <th>Group Code</th>
            <td>{{ $acc->group_name ?? '-' }}</td>
        </tr>

        {{-- ADDRESS --}}
        <tr class="table-light">
            <th>Address</th>
            <td colspan="3">{{ $acc->address ?? '-' }}</td>
        </tr>

        {{-- REMARKS --}}
        <tr>
            <th>Remarks</th>
            <td colspan="3">{{ $acc->remarks ?? '-' }}</td>
        </tr>

    </tbody>

</table>

</div>

{{-- ================= PRINT BUTTON ================= --}}
<div class="text-end no-print">
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