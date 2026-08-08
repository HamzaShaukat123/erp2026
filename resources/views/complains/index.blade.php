@include('../layouts.header')

<body>
<section class="body">

@include('layouts.homepageheader')
<div class="inner-wrapper cust-pad">
@include('layouts.leftmenu')

<section role="main" class="content-body">

<div class="row">
<div class="col-lg-12">

<section class="card">

<header class="card-header d-flex justify-content-between">
<h2 class="card-title">Complaints</h2>

<a class="btn btn-primary modal-with-form" href="#addModal">
<i class="fas fa-plus"></i> New Complaint
</a>
</header>

<div class="card-body">

<!-- SEARCH -->
<div class="row mb-3">
<div class="col-md-5 d-flex">
<select id="columnSelect" class="form-control me-2">
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

<!-- TABLE -->
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
@forelse($complains as $row)
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
@if($row->clear==0)
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

<a onclick="getComplainsDetails({{$row->id}})" href="#editModal">
<i class="fas fa-pencil-alt text-success"></i>
</a>

@if(session('user_role')==1)
<span>|</span>
<a onclick="setId({{$row->id}})" href="#deleteModal">
<i class="far fa-trash-alt text-danger"></i>
</a>
@endif

</td>
</tr>

@empty
<tr>
<td colspan="12" class="text-center">No Data Found</td>
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

<!-- ================= DELETE MODAL ================= -->
<div id="deleteModal" class="modal-block modal-block-danger mfp-hide">
<form method="POST" action="{{route('delete-complains')}}">
@csrf

<section class="card">
<header class="card-header">
<h2>Delete Complaint</h2>
</header>

<div class="card-body text-center">
<p>Are you sure you want to delete?</p>
<input type="hidden" id="deleteID" name="complain_id">
</div>

<footer class="card-footer text-end">
<button class="btn btn-danger">Delete</button>
<button type="button" class="btn btn-default modal-dismiss">Cancel</button>
</footer>

</section>
</form>
</div>

<!-- ================= ADD MODAL ================= -->
<div id="addModal" class="modal-block modal-block-primary mfp-hide">
<form method="POST" action="{{route('store-complains')}}" enctype="multipart/form-data">
@csrf

<section class="card">
<header class="card-header">
<h2>Add Complaint</h2>
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

<div class="col-md-12 mb-2">
<label>Details</label>
<textarea name="complain_detail" class="form-control"></textarea>
</div>

<div class="col-md-6 mb-2">
<label>Status</label>
<select name="clear" class="form-control">
<option value="0">Open</option>
<option value="1">Closed</option>
</select>
</div>

<div class="col-md-12 mb-2">
<label>Attachments</label>
<input type="file" name="att[]" multiple class="form-control">
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

<!-- ================= EDIT MODAL ================= -->
<div id="editModal" class="modal-block modal-block-primary mfp-hide">
<form method="POST" action="{{route('update-complains')}}">
@csrf

<section class="card">
<header class="card-header">
<h2>Edit Complaint</h2>
</header>

<div class="card-body">
<input type="hidden" id="complain_id" name="complain_id">

<div class="row">

<input type="date" id="inv_dat" name="inv_dat" class="form-control mb-2">

<input type="text" id="mfi_pur_number" name="mfi_pur_number" class="form-control mb-2">

<input type="text" id="mill_pur_number" name="mill_pur_number" class="form-control mb-2">

<select id="company_name" name="company_name" class="form-control mb-2 select2-js">
@foreach($acc as $row)
<option value="{{$row->ac_code}}">{{$row->ac_name}}</option>
@endforeach
</select>

<select id="party_name" name="party_name" class="form-control mb-2 select2-js">
@foreach($acc as $row)
<option value="{{$row->ac_code}}">{{$row->ac_name}}</option>
@endforeach
</select>

<textarea id="complain_detail" name="complain_detail" class="form-control mb-2"></textarea>

<select id="clear" name="clear" class="form-control mb-2">
<option value="0">Open</option>
<option value="1">Closed</option>
</select>

<input type="date" id="resolve_date" name="resolve_date" class="form-control mb-2">

<textarea id="resolve_remarks" name="resolve_remarks" class="form-control mb-2"></textarea>

</div>
</div>

<footer class="card-footer text-end">
<button class="btn btn-primary">Update</button>
</footer>

</section>
</form>
</div>

<!-- ================= ATTACHMENT MODAL ================= -->
<div id="attModal" class="modal-block modal-block-primary mfp-hide">
<section class="card">
<header class="card-header">
<h2>Attachments</h2>
</header>

<div class="card-body">
<div id="attachmentContainer"></div>
</div>

</section>
</div>

@include('../layouts.footerlinks')

<!-- ================= SCRIPT ================= -->
<script>
$(document).ready(function(){

var table = $('#datatable-complaints').DataTable();

$('#columnSearch').on('keyup', function(){
let col = $('#columnSelect').val();
if(col){
table.column(col).search(this.value).draw();
}
});

});

function setId(id){
$('#deleteID').val(id);
}

function getComplainsDetails(id){
$.get("/get-complain-details/"+id, function(res){
$('#complain_id').val(res.id);
$('#inv_dat').val(res.inv_dat);
$('#mfi_pur_number').val(res.mfi_pur_number);
$('#mill_pur_number').val(res.mill_pur_number);
$('#company_name').val(res.company_name).trigger('change');
$('#party_name').val(res.party_name).trigger('change');
$('#complain_detail').val(res.complain_detail);
$('#clear').val(res.clear);
$('#resolve_date').val(res.resolve_date);
$('#resolve_remarks').val(res.resolve_remarks);
});
}

function getAttachements(id){
$.get("/get-complain-attachments/"+id, function(res){

let html = '';

if(res.length === 0){
html = 'No files found';
}else{
res.forEach(function(file){
html += `<a href="/uploads/complains/${file.file_name}" target="_blank">${file.file_name}</a><br>`;
});
}

$('#attachmentContainer').html(html);

});
}
</script>

</body>
</html>