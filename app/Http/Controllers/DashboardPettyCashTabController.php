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
}
