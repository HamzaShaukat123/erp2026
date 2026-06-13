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

            <h4 class="mb-0 text-dark fw-semibold">
                {{$acc->ac_code}} - {{$acc->ac_name}}
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
            <td>{{$acc->ac_code}}</td>

            <th width="20%">Account Name</th>
            <td>{{$acc->ac_name}}</td>
        </tr>

        <tr>
            <th>Opening Date</th>
            <td>
                {{ \Carbon\Carbon::parse($acc->opp_date)->format('d-m-Y') }}
            </td>

            <th>Group Code</th>
            <td>{{$acc->group_cod ?? '-'}}</td>
        </tr>

        <tr class="table-light">
            <th>Receivable</th>
            <td class="text-success fw-bold">
                {{ number_format($acc->rec_able,2) }}
            </td>

            <th>Payable</th>
            <td class="text-danger fw-bold">
                {{ number_format($acc->pay_able,2) }}
            </td>
        </tr>

        <tr>
            <th>Credit Limit</th>
            <td>
                {{ number_format($acc->credit_limit,2) }}
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
            <td>{{$acc->AccountType}}</td>

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

{{-- PRINT MODAL (UNCHANGED) --}}
<div id="printModal" class="zoom-anim-dialog modal-block modal-block-danger mfp-hide" style="max-width: 350px;">

    <form method="get" action="{{ route('print-sales2-invoice') }}" target="_blank">

        @csrf

        <section class="card">

            <header class="card-header">
                <h2 class="card-title">Select Print Format</h2>
            </header>

            <div class="card-body">

                <select class="form-control select2-js" name="print_type" required>
                    <option value="" disabled selected>Select Print Format</option>
                    <option value="1">Show All</option>
                    <option value="2">Exclude Item Length</option>
                    <option value="3">Only Quantity & Price</option>
                </select>

                <input type="hidden" name="print_sale2" id="printID">

            </div>

            <footer class="card-footer text-end">

                <button type="submit" class="btn btn-danger">
                    Print Invoice
                </button>

                <button type="button" class="btn btn-default modal-dismiss">
                    Cancel
                </button>

                <div class="btn-group dropup mt-2">

                    <button type="button"
                            onclick="window.location='{{ route('all-sale2invoices-paginate') }}'"
                            class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>

                    <button type="button"
                            class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown">
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item text-success fw-semibold"
                               href="{{ route('new-sales2') }}">
                                <i class="fas fa-plus me-2"></i> Add New
                            </a>
                        </li>

                    </ul>

                </div>

            </footer>

        </section>

    </form>

</div>

</section>
</section>
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