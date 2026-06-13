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
<header class="clearfix border-bottom pb-3 mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="mb-1 text-primary fw-bold">
                Account Profile
            </h3>
            <h4 class="m-0 fw-semibold text-dark">
                {{$acc->ac_code}} - {{$acc->ac_name}}
            </h4>
        </div>

        <div class="col-md-4 text-end">
            <img width="90px" src="/assets/img/logo.png" alt="MFI Logo" />
        </div>
    </div>
</header>

{{-- MAIN INFO --}}
<div class="row g-3">

    {{-- LEFT PANEL --}}
    <div class="col-md-6">

        <div class="card border h-100">
            <div class="card-header bg-light">
                <strong>Basic Information</strong>
            </div>
            <div class="card-body">

                <p><strong>Opening Date:</strong>
                    {{\Carbon\Carbon::parse($acc->opp_date)->format('d-m-Y')}}
                </p>

                <p><strong>Remarks:</strong> {{$acc->remarks ?? '-'}}</p>
                <p><strong>Address:</strong> {{$acc->address ?? '-'}}</p>
                <p><strong>Phone No:</strong> {{$acc->phone_no ?? '-'}}</p>
                <p><strong>Group Code:</strong> {{$acc->group_cod ?? '-'}}</p>

                <p>
                    <strong>Account Type:</strong>
                    <span class="badge bg-info">{{$acc->AccountType}}</span>
                </p>

            </div>
        </div>

    </div>

    {{-- RIGHT PANEL --}}
    <div class="col-md-6">

        <div class="card border h-100">
            <div class="card-header bg-light">
                <strong>Financial Summary</strong>
            </div>

            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted">Receivable</small>
                            <h5 class="mb-0 text-success">
                                {{ number_format($acc->rec_able,2) }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted">Payable</small>
                            <h5 class="mb-0 text-danger">
                                {{ number_format($acc->pay_able,2) }}
                            </h5>
                        </div>
                    </div>
                </div>

                <p><strong>Credit Limit:</strong>
                    <span class="text-primary">
                        {{ number_format($acc->credit_limit,2) }}
                    </span>
                </p>

                <p><strong>Days Limit:</strong>
                    <span class="badge bg-secondary">{{$acc->days_limit}}</span>
                </p>

                <hr>

                <p><strong>Dispatch From:</strong> {{$acc->disp_to ?? '-'}}</p>
                <p><strong>Person Name:</strong> {{$acc->Cash_name ?? '-'}}</p>
                <p><strong>Person Address:</strong> {{$acc->cash_Pur_address ?? '-'}}</p>

                <p>
                    <strong>Bill No:</strong>
                    <a href="#" style="color:#53b21c"
                       data-bs-toggle="modal"
                       data-bs-target="#editBillModal">
                        {{$acc->pur_ord_no}}
                    </a>
                </p>

                <p><strong>Sales Remarks:</strong> {{$acc->Sales_Remarks ?? '-'}}</p>

            </div>
        </div>

    </div>

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
                <button type="submit" class="btn btn-danger">Print Invoice</button>

                <button type="button" class="btn btn-default modal-dismiss">Cancel</button>

                <div class="btn-group dropup">
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