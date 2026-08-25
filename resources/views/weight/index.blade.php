@include('../layouts.header')

<body>

    <section class="body">

        @include('layouts.homepageheader')

        <div class="inner-wrapper cust-pad">

            @include('layouts.leftmenu')

            <section role="main" class="content-body">

                <div class="row">

                    <div class="col">

                        <section class="card">

                            {{-- =====================================================
                                HEADER
                            ====================================================== --}}
                            <header class="card-header"
                                    style="display:flex;justify-content:space-between;">

                                <h2 class="card-title">
                                    All Weight Calculation
                                </h2>

                                <form class="text-end"
                                      action="{{ route('new-weight') }}"
                                      method="GET">

                                    <button type="submit"
                                            class="btn btn-primary mt-2">

                                        <i class="fas fa-plus"></i>
                                        New Weight

                                    </button>

                                </form>

                            </header>


                            {{-- =====================================================
                                TABLE
                            ====================================================== --}}
                            <div class="card-body">

                                <div class="modal-wrapper table-scroll">

                                    <table class="table table-bordered table-striped mb-0"
                                           id="cust-datatable-default">

                                        <thead>

                                            <tr>

                                                {{-- 1 --}}
                                                <th style="display:none;">
                                                    Qout #
                                                </th>

                                                {{-- 2 --}}
                                                <th>
                                                    Code
                                                </th>

                                                {{-- 3 --}}
                                                <th>
                                                    Date
                                                </th>

                                                {{-- 4 --}}
                                                <th>
                                                    Customer Name
                                                </th>

                                                {{-- 5 --}}
                                                <th>
                                                    Dispatch From
                                                </th>

                                                {{-- 6 --}}
                                                <th>
                                                    Person Name
                                                </th>

                                                {{-- 7 --}}
                                                <th>
                                                    Remarks
                                                </th>

                                                {{-- 8 --}}
                                                <th>
                                                    Weight (kg)
                                                </th>

                                                {{-- 9 --}}
                                                <th>
                                                    Att.
                                                </th>

                                                {{-- 10 --}}
                                                <th>
                                                    Action
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            @foreach ($quot2 as $key => $row)

                                                <tr>

                                                    {{-- =================================================
                                                        1. HIDDEN QUOTATION #
                                                    ================================================== --}}
                                                    <td style="display:none;">
                                                        {{ $row->Sale_inv_no }}
                                                    </td>


                                                    {{-- =================================================
                                                        2. CODE
                                                    ================================================== --}}
                                                    <td>
                                                        {{ $row->prefix }}{{ $row->Sale_inv_no }}
                                                    </td>


                                                    {{-- =================================================
                                                        3. DATE
                                                    ================================================== --}}
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($row->sa_date)->format('d-m-y') }}
                                                    </td>


                                                    {{-- =================================================
                                                        4. CUSTOMER NAME
                                                    ================================================== --}}
                                                    <td>
                                                        {{ $row->acc_name }}
                                                    </td>


                                                    {{-- =================================================
                                                        5. DISPATCH FROM
                                                    ================================================== --}}
                                                    <td>
                                                        {{ $row->disp_to }}
                                                    </td>


                                                    {{-- =================================================
                                                        6. PERSON NAME
                                                    ================================================== --}}
                                                    <td>
                                                        {{ $row->Cash_pur_name }}
                                                    </td>


                                                    {{-- =================================================
                                                        7. REMARKS
                                                    ================================================== --}}
                                                    <td class="limited-text">
                                                        {{ $row->Sales_Remarks }}
                                                    </td>


                                                    {{-- =================================================
                                                        8. WEIGHT
                                                    ================================================== --}}
                                                    <td>
                                                        {{ $row->weight_sum }}
                                                    </td>


                                                    {{-- =================================================
                                                        9. ATTACHMENTS
                                                    ================================================== --}}
                                                    <td>

                                                        <a class="mb-1 mt-1 me-1 modal-with-zoom-anim ws-normal"
                                                           onclick="getAttachements({{ $row->Sale_inv_no }})"
                                                           href="#attModal">

                                                            View

                                                        </a>

                                                    </td>


                                                    {{-- =================================================
                                                        10. ACTION
                                                    ================================================== --}}
                                                    <td class="actions">

                                                        {{-- VIEW --}}
                                                        <a href="{{ route('show-weight', $row->Sale_inv_no) }}"
                                                           title="View">

                                                            <i class="fas fa-eye text-primary"></i>

                                                        </a>


                                                        <span class="separator">
                                                            |
                                                        </span>


                                                        {{-- EDIT --}}
                                                        <a href="{{ route('edit-weight', $row->Sale_inv_no) }}"
                                                           title="Edit">

                                                            <i class="fas fa-pencil-alt text-success"></i>

                                                        </a>


                                                        {{-- DELETE --}}
                                                        @if(session('user_role') == 1)

                                                            <span class="separator">
                                                                |
                                                            </span>

                                                            <a class="mb-1 mt-1 me-1 modal-with-zoom-anim ws-normal"
                                                               onclick="setId({{ $row->Sale_inv_no }})"
                                                               href="#deleteModal"
                                                               title="Delete">

                                                                <i class="far fa-trash-alt text-danger"></i>

                                                            </a>

                                                        @endif

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </section>

                    </div>

                </div>

            </section>

        </div>

    </section>



    {{-- ============================================================
        DELETE WEIGHT MODAL
    ============================================================= --}}

    <div id="deleteModal"
         class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">

        <form method="post"
              action="{{ route('delete-weight') }}"
              enctype="multipart/form-data">

            @csrf

            <section class="card">

                <header class="card-header">

                    <h2 class="card-title">
                        Delete Weight
                    </h2>

                </header>


                <div class="card-body">

                    <div class="modal-wrapper">

                        <div class="modal-icon">

                            <i class="fas fa-question-circle"></i>

                        </div>


                        <div class="modal-text">

                            <p class="mb-0">
                                Are you sure that you want to delete this Weight?
                            </p>

                            <input name="delete_quot2"
                                   id="deleteID"
                                   hidden>

                        </div>

                    </div>

                </div>


                <footer class="card-footer">

                    <div class="row">

                        <div class="col-md-12 text-end">

                            <button type="submit"
                                    class="btn btn-danger">

                                Delete

                            </button>


                            <button type="button"
                                    class="btn btn-default modal-dismiss">

                                Cancel

                            </button>

                        </div>

                    </div>

                </footer>

            </section>

        </form>

    </div>



    {{-- ============================================================
        ATTACHMENTS MODAL
    ============================================================= --}}

    <div id="attModal"
         class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">

        <section class="card">

            <header class="card-header">

                <h2 class="card-title">
                    All Attachments
                </h2>

            </header>


            <div class="card-body">

                <div class="modal-wrapper">

                    {{-- IMPORTANT:
                         Different ID from main DataTable --}}
                    <table class="table table-bordered table-striped mb-0"
                           id="weightAttachmentsTable">

                        <thead>

                            <tr>

                                <th>
                                    Attachment Path
                                </th>

                                <th>
                                    Download
                                </th>

                                <th>
                                    View
                                </th>

                                <th>
                                    Delete
                                </th>

                            </tr>

                        </thead>


                        <tbody id="quotation_attachements">

                        </tbody>

                    </table>

                </div>

            </div>


            <footer class="card-footer">

                <div class="row">

                    <div class="col-md-12 text-end">

                        <button type="button"
                                class="btn btn-default modal-dismiss">

                            Cancel

                        </button>

                    </div>

                </div>

            </footer>

        </section>

    </div>



    @include('../layouts.footerlinks')


</body>

</html>


<script>

    /* ============================================================
       DATATABLE
    ============================================================= */

    $(document).ready(function () {

        $('#cust-datatable-default').DataTable();

    });



    /* ============================================================
       SET DELETE ID
    ============================================================= */

    function setId(id) {

        $('#deleteID').val(id);

    }



    /* ============================================================
       GET ATTACHMENTS
    ============================================================= */

    function getAttachements(id) {

        var table =
            document.getElementById('quotation_attachements');


        /* Clear old attachments */

        while (table.rows.length > 0) {

            table.deleteRow(0);

        }


        $.ajax({

            type: "GET",

            url: "/weight/attachements",

            data: {
                id: id
            },


            success: function(result) {

                $.each(result, function(k, v) {

                    var html = "<tr>";


                    /* Attachment Path */

                    html +=
                        "<td>" +
                        v['att_path'] +
                        "</td>";


                    /* Download */

                    html +=
                        "<td class='text-center'>" +

                        "<a class='mb-1 mt-1 mr-2 me-1 text-danger' " +
                        "href='/weight/download/" +
                        v['att_id'] +
                        "'>" +

                        "<i class='fas fa-download'></i>" +

                        "</a>" +

                        "</td>";


                    /* View */

                    html +=
                        "<td class='text-center'>" +

                        "<a class='mb-1 mt-1 me-1 text-primary' " +
                        "href='/weight/view/" +
                        v['att_id'] +
                        "' target='_blank'>" +

                        "<i class='fas fa-eye text-primary'></i>" +

                        "</a>" +

                        "</td>";


                    /* Delete */

                    html +=
                        "<td class='text-center'>" +

                        "<a class='mb-1 mt-1 me-1 text-primary' " +
                        "href='#' " +
                        "onclick='deleteFile(" +
                        v['att_id'] +
                        ")'>" +

                        "<i class='fas fa-trash'></i>" +

                        "</a>" +

                        "</td>";


                    html += "</tr>";


                    $('#quotation_attachements')
                        .append(html);

                });

            },


            error: function(xhr, status, error) {

                console.error(
                    "Attachment Error:",
                    error
                );

                alert("error");

            }

        });

    }



    /* ============================================================
       DELETE ATTACHMENT
    ============================================================= */

    function deleteFile(fileId) {

        if (!confirm(
            'Are you sure you want to delete this file?'
        )) {

            return;

        }


        fetch(
            '/tquotation/deleteAttachment/' + fileId,
            {
                method: 'DELETE',

                headers: {

                    'X-CSRF-TOKEN':
                        document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            .getAttribute('content'),

                    'Content-Type':
                        'application/json'

                }

            }
        )


        .then(function(response) {

            if (response.ok) {

                alert(
                    'File deleted successfully.'
                );

                location.reload();

            }

            else {

                return response
                    .json()
                    .then(function(data) {

                        throw new Error(
                            data.message ||
                            'An error occurred.'
                        );

                    });

            }

        })


        .catch(function(error) {

            alert(error.message);

        });

    }

</script>