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

<header class="card-header d-flex justify-content-between">
<h2 class="card-title">Complaints</h2>
<button class="btn btn-primary modal-with-form" href="#addModal">
<i class="fas fa-plus"></i> New Complaint
</button>
</header>

<div class="card-body">

<!-- Search -->

<div class="row mb-3">
<div class="col-md-5 d-flex">
<select class="form-control me-2" id="columnSelect">
<option disabled selected>Search by</option>
<option value="0">ID</option>
<option value="1">Date</option>
<option value="2">Company</option>
<option value="3">Customer</option>
<option value="4">MFI Inv</option>
<option value="5">Mill Inv</option>
<option value="6">Details</option>
<option value="7">Resolve Date</option>
<option value="8">Remarks</option>
</select>
<input type="text" id="columnSearch" class="form-control" placeholder="Search...">
</div>
</div>

<!-- Table -->

<div class="table-responsive">
<table class="table table-bordered table-striped" id="datatable-complaints">
<thead>
<tr>
<th>ID</th>
<th>Date</th>
<th>Company</th>
<th>Customer</th>
<th>MFI Inv</th>
<th>Mill Inv</th>
<th>Details</th>
<th>Resolve Date</th>
<th>Remarks</th>
<th>Status</th>
<th>Attachment</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@forelse ($complains as $row)
<tr>
<td>{{$row->id}}</td>
<td>{{ \Carbon\Carbon::parse($row->inv_dat)->format('d-m-Y') }}</td>
<td>{{$row->company_name_display}}</td>
<td>{{$row->party_name_display}}</td>
<td>{{$row->mfi_pur_number}}</td>
<td>{{$row->mill_pur_number}}</td>
<td>{{$row->complain_detail}}</td>

<td>
@if($row->resolve_date)
{{ \Carbon\Carbon::parse($row->resolve_date)->format('d-m-Y') }}
@endif
</td>

<td>{{$row->resolve_remarks}}</td>

<td>
@if ($row->clear==0)
<span class="badge bg-danger">Open</span>
@else
<span class="badge bg-success">Closed</span>
@endif
</td>

<td>
<a onclick="getAttachements({{$row->id}})" href="#attModal" class="modal-with-zoom-anim">
View
</a>
</td>

<td>
<a href="{{route('print-complain',$row->id)}}" target="_blank">
<i class="fas fa-print text-primary"></i>
</a>

<span>|</span>

<a onclick="getComplainsDetails({{$row->id}})" href="#updateModal">
<i class="fas fa-pencil-alt text-success"></i>
</a>

@if(session('user_role')==1) <span>|</span> <a onclick="setId({{$row->id}})" href="#deleteModal"> <i class="far fa-trash-alt text-danger"></i> </a>
@endif

</td>
</tr>

@empty

<tr>
<td colspan="12" class="text-center">No complaints found</td>
</tr>
@endforelse
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

<!-- DELETE MODAL -->

<div id="deleteModal" class="modal-block modal-block-danger mfp-hide">
<form method="post" action="{{ route('delete-complains') }}">
@csrf

<section class="card">
<header class="card-header">
<h2>Delete Complaint</h2>
</header>

<div class="card-body text-center">
<p>Are you sure?</p>
<input type="hidden" name="complain_id" id="deleteID">
</div>

<footer class="card-footer text-end">
<button class="btn btn-danger">Delete</button>
<button class="btn btn-default modal-dismiss">Cancel</button>
</footer>
</section>

</form>
</div>

<!-- ADD MODAL -->

<div id="addModal" class="modal-block modal-block-primary mfp-hide">
<form method="post" action="{{ route('store-complains') }}" enctype="multipart/form-data">
@csrf

<section class="card">
<header class="card-header">
<h2>New Complaint</h2>
</header>

<div class="card-body">
<div class="row">

<div class="col-md-6 mb-2">
<label>Date *</label>
<input type="date" name="inv_dat" class="form-control" value="{{date('Y-m-d')}}" required>
</div>

<div class="col-md-6 mb-2">
<label>MFI Inv</label>
<input type="text" name="mfi_pur_number" class="form-control">
</div>

<div class="col-md-6 mb-2">
<label>Mill Inv</label>
<input type="text" name="mill_pur_number" class="form-control">
</div>

<div class="col-md-6 mb-2">
<label>Company *</label>
<select name="company_name" class="form-control select2-js" required>
@foreach($acc as $row)
<option value="{{$row->ac_code}}">{{$row->ac_name}}</option>
@endforeach
</select>
</div>

<div class="col-md-6 mb-2">
<label>Customer *</label>
<select name="party_name" class="form-control select2-js" required>
@foreach($acc as $row)
<option value="{{$row->ac_code}}">{{$row->ac_name}}</option>
@endforeach
</select>
</div>

<div class="col-md-6 mb-2">
<label>Details</label>
<textarea name="complain_detail" class="form-control"></textarea>
</div>

<div class="col-md-6 mb-2">
<label>Status</label>
<select name="clear" class="form-control">
<option value="0" selected>Open</option>
<option value="1">Closed</option>
</select>
</div>

<div class="col-md-12 mb-2">
<label>Attachments</label>
<input type="file" name="att[]" class="form-control" multiple>
</div>

</div>
</div>

<footer class="card-footer text-end">
<button class="btn btn-primary">Save</button>
<button type="button" class="btn btn-default modal-dismiss">Cancel</button>
</footer>

</section>
</form>
</div>

@include('../layouts.footerlinks')

<script>
$(document).ready(function(){

var table = $('#datatable-complaints').DataTable();

$('#columnSearch').on('keyup', function(){
var col = $('#columnSelect').val();
if(col !== null){
table.column(col).search(this.value).draw();
}
});

});
</script>

</body>
</html>

<script>
    function setId(id){
        $('#deleteID').val(id);
    }

    function getAttachements(id){

        var table = document.getElementById('complains_attachements');
            while (table.rows.length > 0) {
            table.deleteRow(0);
        }

        $.ajax({
            type: "GET",
            url: "/complains/attachements",
            data: {id:id},
            success: function(result){
                $.each(result, function(k,v){
                    var html="<tr>";
                    html+= "<td>"+v['att_path']+"</td>"
                    html+= "<td class='text-center'><a class='mb-1 mt-1 mr-2 me-1 text-danger' href='/complains/download/"+v['att_id']+"'><i class='fas fa-download'></i></a></td>"
                    html+= "<td class='text-center'><a class='mb-1 mt-1 me-1 text-primary' href='/complains/view/"+v['att_id']+"' target='_blank'><i class='fas fa-eye text-primary'></i></a></td>"
                    html+= "<td class='text-center'><a class='mb-1 mt-1 me-1 text-primary' href='#' onclick='deleteFile("+v['att_id']+")'><i class='fas fa-trash'></i></a></td>"
                    html+="</tr>";
                    $('#complains_attachements').append(html);
                });
            },
            error: function(){
                alert("error");
            }
        });
    }

    function getComplainsDetails(id){
        $.ajax({
            type: "GET",
            url: "/complains/detail",
            data: {id:id},
        success: function(result) {
            $('#update_complain_id').val(result.id);
            $('#update_id_view').val(result.id);
            $('#update_mfi_purchase_number').val(result.mfi_pur_number);
            $('#update_mill_purchase_number').val(result.mill_pur_number);
            $('#update_company_name').val(result.company_name).trigger('change');
            $('#update_party_name').val(result.party_name).trigger('change');
            $('#update_complain_detail').val(result.complain_detail);
            $('#update_resolve_date').val(result.resolve_date);
            $('#update_resolve_remarks').val(result.resolve_remarks);
            $('#update_complain_status').val(result.clear).trigger('change');
            $('#update_complain_date').val(result.inv_dat);
        },
        error: function(xhr, status, error) {
           
        }
    });
}

function deleteFile(fileId) {
        if (!confirm('Are you sure you want to delete this file?')) {
            return;
        }

        fetch('/complains/deleteAttachment/' + fileId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                alert('File deleted successfully.');
                // Optionally, remove the element or reload the page
                location.reload();
            } else {
                return response.json().then(data => {
                    throw new Error(data.message || 'An error occurred.');
                });
            }
        })
        .catch(error => {
            alert(error.message);
        });
    }
</script>