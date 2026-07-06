<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\petty_cash;


class DashboardPettyCashTabController extends Controller
{
    public function PettyCash(Request $request)
    {
        $query = petty_cash::query();

        // ✅ Apply filter if account selected
        if ($request->filled('account_id')) {
            $query->where('user_id', $request->account_id);
        }

        $petty_cash = $query->orderBy('date', 'asc')->get();

        return response()->json([
            'petty_cash' => $petty_cash,
        ]);
    }



    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'user_id_name' => 'required',
        // ]);
        
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        $jv1 = new petty_cash();
        $jv1->created_by = session('user_id');

        if ($request->has('user_id_hidden') && $request->user_id_hidden) {
            $jv1->user_id=$request->user_id_hidden;
        }
        if ($request->has('date') && $request->date) {
            $jv1->date=$request->date;
        }
        if ($request->has('debit') && $request->debit OR $request->debit==0 ) {
            $jv1->debit=$request->debit;
        }
        if ($request->has('credit') && $request->credit OR $request->credit==0 ) {
            $jv1->credit=$request->credit;
        }
        if ($request->has('detail') && $request->detail  OR empty($request->detail)) {
            $jv1->detail=$request->detail;
        }
        $jv1->save();

        $latest_jv1 = petty_cash::latest()->first();

        
        // return redirect()->route('home');
        return redirect('/home');
    }




    public function update(Request $request)
    {

        
        $jv1 = petty_cash::where('id', $request->update_id)->get()->first();

        if ($request->has('user_id_hidden') && $request->user_id_hidden) {
            $jv1->user_id=$request->user_id_hidden;
        }
        if ($request->has('update_add') && $request->update_add OR $request->update_add==0 ) {
            $jv1->debit=$request->update_add;
        }
        if ($request->has('update_less') && $request->update_less OR $request->update_less==0 ) {
            $jv1->credit=$request->update_less;
        }
        if ($request->has('update_date') && $request->update_date) {
            $jv1->date=$request->update_date;
        }
        if ($request->has('update_detail') && $request->update_detail OR empty($request->update_detail))  {
            $jv1->detail=$request->update_detail;
        }
        
        
    
        petty_cash::where('id', $request->user_id_hidden)->update([
            'user_id'=>$jv1->user_id,
            'debit'=>$jv1->debit,
            'credit'=>$jv1->credit,
            'date'=>$jv1->date,
            'detail'=>$jv1->detail,
            'updated_by' => session('user_id'),
        ]);

        return redirect('/home');

    }


    public function getPettyCashDetails(Request $request)
    {
        $jv1_details = petty_cash::where('id', $request->id)->get()->first();
        return $jv1_details;
    }

}
