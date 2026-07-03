<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\petty_cash;


class DashboardPettyCashTabController extends Controller
{
    public function PettyCash(Request $request)
    {
        $petty_cash = petty_cash::orderBy('date', 'asc')->get();
       

        return response()->json([
            'petty_cash' => $petty_cash,
        ]);
    }
}
