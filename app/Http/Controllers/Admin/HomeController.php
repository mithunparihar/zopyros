<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function setting($id = null)
    {
        return view('admin.setting', compact('id'));
    }

    //ckeditorupload
    public function ckeditorupload(Request $request)
    {
        if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('file')->move(public_path('ck-images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('ck-images/' . $fileName);
            $msg = 'Image uploaded successfully';
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    /// DASHBOARD
    public function performanceChart()
    {
        $lastMonths = [];
        $lastQuote = [];
        $lastBulk = [];
        $totalQuote = 0;
        $totalBulk = 0;
        for ($A = 0; $A <= 6; $A++) {
            $bulkrequest = \App\Models\BulkRequest::whereBetween('created_at', [
                \Carbon\Carbon::now()->subMonth($A)->startOfMonth(),
                \Carbon\Carbon::now()->subMonth($A)->endOfMonth(),
            ])->count();
            $totalBulk += $bulkrequest;
            array_push($lastBulk, $bulkrequest);

            $quotes = \App\Models\QuoteRequest::whereBetween('created_at', [
                \Carbon\Carbon::now()->subMonth($A)->startOfMonth(),
                \Carbon\Carbon::now()->subMonth($A)->endOfMonth(),
            ])->count();
            $totalQuote += $quotes;
            array_push($lastQuote, $quotes);

            $monthData = \Carbon\Carbon::now()->subMonth($A)->format('M');
            array_push($lastMonths, $monthData);
        }
        return [$lastMonths, $lastQuote, $lastBulk, $totalQuote, $totalBulk];
    }

    public function performanceChart2()
    {
        $lastMonths = [];
        $lastBuylead = [];
        $lastPost = [];
        $totaBuylead = 0;
        $totalPost = 0;
        for ($A = 0; $A <= 6; $A++) {
            $leadrequest = \App\Models\BuyLeadRequest::whereBetween('created_at', [
                \Carbon\Carbon::now()->subMonth($A)->startOfMonth(),
                \Carbon\Carbon::now()->subMonth($A)->endOfMonth(),
            ])->count();
            $totaBuylead += $leadrequest;
            array_push($lastBuylead, $leadrequest);

            $postrequest = \App\Models\PostRequirementRequest::whereBetween('created_at', [
                \Carbon\Carbon::now()->subMonth($A)->startOfMonth(),
                \Carbon\Carbon::now()->subMonth($A)->endOfMonth(),
            ])->count();
            $totalPost += $postrequest;
            array_push($lastPost, $postrequest);

            $monthData = \Carbon\Carbon::now()->subMonth($A)->format('M');
            array_push($lastMonths, $monthData);
        }
        return [$lastMonths, $lastPost, $lastBuylead, $totalPost, $totaBuylead];
    }

    public function visitorsChart()
    {
        $lastweek = [];
        $visitors = [];
        for ($A = 6; $A >= 0; $A--) {
            $visitor = \App\Models\LogActivity::whereRole('visitor')
                ->whereDate('created_at', \Carbon\Carbon::now()->subDay($A))
                ->count();
            array_push($visitors, $visitor);

            $monthData = \Carbon\Carbon::now()->subDay($A)->format('D');
            array_push($lastweek, substr($monthData, 0, 1));
        }
        return [$lastweek, $visitors];
    }

    public function registrationChart()
    {
        $lastweek = [];
        $registers = [];
        for ($A = 6; $A >= 0; $A--) {
            $register = \App\Models\User::whereDate('created_at', \Carbon\Carbon::now()->subDay($A))->count();
            array_push($registers, $register);

            $monthData = \Carbon\Carbon::now()->subDay($A)->format('D');
            array_push($lastweek, substr($monthData, 0, 1));
        }
        return [$lastweek, $registers];
    }

    public function totalIncomeChart()
    {
        $lastMonths = [];
        $lastSales = [];
        $maxSales = 0;
        $minSales = 0;
        for ($A = 11; $A >= 0; $A--) {
            $sales = \App\Models\Order::where(['delivered_status' => 1, 'canceled_status' => 0])
                ->whereBetween('created_at', [
                    \Carbon\Carbon::now()->subMonth($A)->startOfMonth(),
                    \Carbon\Carbon::now()->subMonth($A)->endOfMonth(),
                ])->sum('total');
            array_push($lastSales, (int) $sales);

            $monthData = \Carbon\Carbon::now()->subMonth($A)->format('M');
            array_push($lastMonths, $monthData);

            if ($sales >= $maxSales) {
                $maxSales = $sales;
            }
            if ($sales <= $minSales) {
                $minSales = $sales;
            }
        }

        return [$lastMonths, $lastSales, $minSales, $maxSales];
    }
}
