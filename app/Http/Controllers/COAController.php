<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use TCPDF;
use ZipArchive;
use Carbon\Carbon;
use App\Models\AC;
use App\Models\ac_att;
use App\Models\ac_group;
use App\Exports\ChartOfAccountExport;
use App\Models\ac_area;
use App\Models\ac_city;
use App\Traits\SaveImage;
use App\Models\sub_head_of_acc;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class COAController extends Controller
{
    //
    use SaveImage;

    public function index()
    {
        $acc = AC::join('sub_head_of_acc as shoa', 'shoa.id', '=', 'ac.AccountType')
                ->leftjoin('ac_group as ag', 'ag.group_cod', '=', 'ac.group_cod')
                ->leftjoin('ac_city as ac_city', 'ac_city.id', '=', 'ac.city')
                ->leftjoin('ac_area as ac_area', 'ac_area.id', '=', 'ac.area')
               ->select('ac.*' , 'ag.group_name', 'shoa.sub', 'ac_city.city', 'ac_area.area')
               ->get();
        $sub_head_of_acc = sub_head_of_acc::where('status', 1)->get();
        $ac_group = ac_group::where('status', 1)->get();
        $ac_area = ac_area::where('status', 1)->get();
        $ac_city = ac_city::where('status', 1)->get();

        return view('ac.index',compact('acc','sub_head_of_acc','ac_group','ac_area','ac_city'));
    }

    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ac_name' => 'required|unique:ac',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        else{
            return response()->json(['success' => "success"]);
        }
    }


   public function show(string $id)
    {
        $acc = AC::join('sub_head_of_acc as shoa', 'shoa.id', '=', 'ac.AccountType')
            ->leftJoin('ac_group as ag', 'ag.group_cod', '=', 'ac.group_cod')
            ->leftJoin('ac_city as ac_city', 'ac_city.id', '=', 'ac.city')
            ->leftJoin('ac_area as ac_area', 'ac_area.id', '=', 'ac.area')
            ->select(
                'ac.*',
                'ag.group_name',
                'shoa.sub',
                'ac_city.city',
                'ac_area.area'
            )
            ->where('ac.ac_code', $id)
            ->first();

        $sub_head_of_acc = sub_head_of_acc::where('status', 1)->get();
        $ac_group = ac_group::where('status', 1)->get();
        $ac_area = ac_area::where('status', 1)->get();
        $ac_city = ac_city::where('status', 1)->get();

        return view('ac.acc-show',compact('acc','sub_head_of_acc','ac_group','ac_area','ac_city'));

    }



    public function store(Request $request)
    {
        $acc = new AC();

        $acc->created_by = session('user_id');

        if ($request->has('ac_name') && $request->ac_name) {
            $acc->ac_name=$request->ac_name;
        }
        if ($request->has('rec_able') && $request->rec_able OR $request->rec_able==0 ) {
            $acc->rec_able=$request->rec_able;
        }
        if ($request->has('pay_able') && $request->pay_able OR $request->pay_able==0 ) {
            $acc->pay_able=$request->pay_able;
        }
        if ($request->has('opp_date') && $request->opp_date) {
            $acc->opp_date=$request->opp_date;
        }
        if ($request->has('remarks') && $request->remarks) {
            $acc->remarks=$request->remarks;
        }
        if ($request->has('area') && $request->area) {
            $acc->area=$request->area;
        }
        if ($request->has('city') && $request->city) {
            $acc->city=$request->city;
        }
        if ($request->has('address') && $request->address) {
            $acc->address=$request->address;
        }
        if ($request->has('phone_no') && $request->phone_no) {
            $acc->phone_no=$request->phone_no;
        }
        if ($request->has('credit_limit') && $request->credit_limit) {
            $acc->credit_limit=$request->credit_limit;
        }
        if ($request->has('days_limit') && $request->days_limit) {
            $acc->days_limit=$request->days_limit;
        }
        if ($request->has('group_cod') && $request->group_cod) {
            $acc->group_cod=$request->group_cod;
        }
        if ($request->has('AccountType') && $request->AccountType) {
            $acc->AccountType=$request->AccountType;
        }
        $acc->save();

        $latest_acc = AC::latest()->first();

        if($request->hasFile('att')){
            $files = $request->file('att');
            foreach ($files as $file)
            {
                $acc_att = new ac_att();
                $acc_att->created_by = session('user_id');                
                $acc_att->ac_code = $latest_acc['ac_code'];
                $extension = $file->getClientOriginalExtension();
                $acc_att->att_path = $this->coaDoc($file,$extension);
                $acc_att->save();
            }
        }
        return redirect()->route('all-acc');
    }
    
    public function destroy(Request $request)
    {
        $acc = AC::where('ac_code', $request->acc_id)->update([
            'status' => '0',
            'updated_by' => session('user_id'),
        ]);
        return redirect()->route('all-acc');
    }

    public function activate($id)
    {
        $acc = AC::where('ac_code', $id)->update(['status' => '1']);
        return redirect()->route('all-acc');
    }

    public function update(Request $request)
    {
        
        $acc = AC::where('ac_code', $request->ac_cod)->get()->first();

        $acc->updated_by = session('user_id');

        if ($request->has('ac_name') && $request->ac_name) {
            $acc->ac_name=$request->ac_name;
        }
        if ($request->has('rec_able') && $request->rec_able OR $request->rec_able==0) {
            $acc->rec_able=$request->rec_able;
        }
        if ($request->has('pay_able') && $request->pay_able OR $request->pay_able==0) {
            $acc->pay_able=$request->pay_able;
        }
        if ($request->has('opp_date') && $request->opp_date) {
            $acc->opp_date=$request->opp_date;
        }
        if ($request->has('remarks') && $request->remarks OR empty($request->remarks)) {
            $acc->remarks=$request->remarks;
        }
        if ($request->has('area') && $request->area OR empty($request->area)) {
            $acc->area=$request->area;
        }
        if ($request->has('city') && $request->city OR empty($request->city)) {
            $acc->city=$request->city;
        }
        if ($request->has('address') && $request->address OR empty($request->address)) {
            $acc->address=$request->address;
        }
        if ($request->has('phone_no') && $request->phone_no OR empty($request->phone_no)) {
            $acc->phone_no=$request->phone_no;
        }
        if ($request->has('credit_limit') && $request->credit_limit OR $request->credit_limit==0) {
            $acc->credit_limit=$request->credit_limit;
        }
        if ($request->has('days_limit') && $request->days_limit OR $request->days_limit==0) {
            $acc->days_limit=$request->days_limit;
        }
        if ($request->has('group_cod') && $request->group_cod OR empty($request->group_cod)) {
            $acc->group_cod=$request->group_cod;
        }
        if ($request->has('AccountType') && $request->AccountType) {
            $acc->AccountType=$request->AccountType;
        }

        AC::where('ac_code', $request->ac_cod)->update([
            'ac_name'=>$acc->ac_name,
            'rec_able'=>$acc->rec_able,
            'pay_able'=>$acc->pay_able,
            'opp_date'=>$acc->opp_date,
            'remarks'=>$acc->remarks,
            'area'=>$acc->area,
            'address'=>$acc->address,
            'city'=>$acc->city,
            'phone_no'=>$acc->phone_no,
            'credit_limit'=>$acc->credit_limit,
            'days_limit'=>$acc->days_limit,
            'group_cod'=>$acc->group_cod,
            'AccountType'=>$acc->AccountType,
            'updated_by'=> $acc->updated_by,
        ]);

        
        if($request->hasFile('att')){
            
            // ac_att::where('ac_code', $request->ac_cod)->delete();
            $files = $request->file('att');
            foreach ($files as $file)
            {
                $acc_att = new ac_att();
                $acc_att->ac_code = $request->ac_cod;
                $extension = $file->getClientOriginalExtension();
                $acc_att->att_path = $this->coaDoc($file,$extension);
                $acc_att->save();
            }
        }

        // return redirect()->route('all-acc');

        return redirect()->route('show-acc', ['ac_cod' => $request->ac_cod]);
    }

    public function getAccountDetails(Request $request)
    {
        $acc_details = AC::where('ac_code', $request->id)->get()->first();
        return $acc_details;
    }

    public function getAttachements(Request $request)
    {
        $acc_atts = ac_att::where('ac_code', $request->id)->get();
        return $acc_atts;
    }


    public function chartExcel(Request $request)
    {
        $AC = AC::select(
                'ac_code',
                'ac_name',
                'rec_able',
                'pay_able',
                'opp_date',
                'remarks',
                'address',
                'city',
                'area',
                'phone_no',
                'group_cod',
                'AccountType',
                'credit_limit',
                'days_limit',
                'created_by',
                'created_at',
                'updated_at',
                'status',
                'updated_by'
            )
            ->orderBy('ac_code')
            ->get();

        $filename = 'Chart_Of_Account_Report_' . now()->format('d-m-Y') . '.xlsx';

        return Excel::download(new ChartOfAccountExport($AC), $filename);
    }

   public function print()
    {
        $data = AC::where('ac.status', 1)
            ->join('sub_head_of_acc', 'ac.AccountType', '=', 'sub_head_of_acc.id')
            ->join('head_of_acc', 'sub_head_of_acc.main', '=', 'head_of_acc.ID')
            ->select(
                'ac.ac_code',
                'ac.ac_name',
                'ac.rec_able',
                'ac.opp_date',
                'ac.remarks',
                'ac.address',
                'ac.phone_no',
                'ac.group_cod',
                'ac.pay_able',
                'head_of_acc.heads',
                'sub_head_of_acc.sub'
            )
            ->groupBy(
            'ac.ac_code',
            'ac.ac_name',
            'ac.rec_able',
            'ac.opp_date',
            'ac.remarks',
            'ac.address',
            'ac.phone_no',
            'ac.group_cod',
            'ac.pay_able',
            'head_of_acc.heads',
            'sub_head_of_acc.sub'
        )
        ->orderBy('head_of_acc.heads')
        ->orderBy('sub_head_of_acc.sub')
        ->get();

    $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('MFI');
    $pdf->SetTitle('COA Report');

    $pdf->SetMargins(10, 15, 10);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->SetFont('helvetica', '', 10);

    $pdf->AddPage();

    $pdf->writeHTML('<h1 style="text-align:center;">Chart Of Account</h1>', true, false, true, false, '');
    $pdf->writeHTML('<h4 style="text-align:right;">Print Date: ' . date('d-m-Y') . '</h4>', true, false, true, false, '');

    $coas = $data->groupBy('heads');

    foreach ($coas as $head => $coa) {

        $pdf->writeHTML("<h2>$head</h2>", true, false, true, false, '');

        $sub_accs = $coa->groupBy('sub');

        foreach ($sub_accs as $sub => $items) {

            $pdf->writeHTML("<h3 style='text-align:center;'>$sub</h3>", true, false, true, false, '');

            $html = '
            <table border="1" cellpadding="4">
                <tr style="background:#ddd;font-weight:bold;">
                    <th width="12%">Ac Code</th>
                    <th width="12%">Date</th>
                    <th width="40%">Account Name</th>
                    <th width="18%">Debit</th>
                    <th width="18%">Credit</th>
                </tr>';

            $total_debit = 0;
            $total_credit = 0;
            $count = 1;

            foreach ($items as $item) {

                $debit = (float) $item->rec_able;
                $credit = (float) $item->pay_able;

                $total_debit += $debit;
                $total_credit += $credit;

                $bg = ($count % 2 == 0) ? 'style="background-color:#f5f5f5;"' : '';

                $html .= '
                <tr ' . $bg . '>
                    <td width="12%">' . $item->ac_code . '</td>
                    <td width="12%">' . \Carbon\Carbon::parse($item->opp_date)->format('d-m-Y') . '</td>
                    <td width="40%" align="left">' . $item->ac_name . '</td>
                    <td width="18%">' . number_format($debit, 2) . '</td>
                    <td width="18%">' . number_format($credit, 2) . '</td>
                </tr>';

                $count++;
            }

            // 🔥 SUB TOTAL ROW
            $html .= '
                <tr style="font-weight:bold;background:#eee;">
                    <td colspan="3" align="right">Sub Total</td>
                    <td>' . number_format($total_debit, 2) . '</td>
                    <td>' . number_format($total_credit, 2) . '</td>
                </tr>';

            $html .= '</table>';

            $pdf->writeHTML($html, true, false, true, false, '');
        }
    }

    $pdf->Output('COA Report.pdf', 'I');
    exit;
}
    public function downloadAtt($id)
    {
        $doc=ac_att::where('att_id', $id)->select('att_path')->first();
        $filePath = public_path($doc['att_path']);
        if (file_exists($filePath)) {
            return Response::download($filePath);
        } 
    }

    public function deleteAtt($id)
    {
        $doc=ac_att::where('att_id', $id)->select('att_path')->first();
        $filePath = public_path($doc['att_path']);

        if (File::exists($filePath)) {
            File::delete($filePath);
            $acc_att = ac_att::where('att_id', $id)->delete();
            return response()->json(['message' => 'File deleted successfully.']);
        } else {
            return response()->json(['message' => 'File not found.'], 404);
        }
    }

    public function addAtt(Request $request)
    {
        $coa_id=$request->att_id;

        if($request->hasFile('addAtt')){
            $files = $request->file('addAtt');
            foreach ($files as $file)
            {
                $acc_att = new ac_att();
                $acc_att->created_by = session('user_id');                
                $acc_att->ac_code = $coa_id;
                $extension = $file->getClientOriginalExtension();
                $acc_att->att_path = $this->coaDoc($file,$extension);
                $acc_att->save();
            }
        }
        return redirect()->route('all-acc');

    }

    public function view($id)
    {
        $doc=ac_att::where('att_id', $id)->select('att_path')->first();
        $filePath = public_path($doc['att_path']);
        if (file_exists($filePath)) {
            return Response::file($filePath);
        } 
    }
}
