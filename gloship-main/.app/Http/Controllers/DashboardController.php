<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Item;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller

{
    public function __construct()
    {
    }

    /**
     * Display a listig of the resource.
     *
     * @param null
     * @return Renderable.
     */
    public function dashboard()
    {
        $datax['page_title'] = trans_choice('messages.Dashboard', 1);
        $chart_options = [
            'chart_title' =>  trans_choice('messages.Shipment', 2),
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Shipment',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'top_results' => 7,
            'filter_field' => 'created_at',
            //'continuous_time' => true,
            //'filter_days' => 7, // show only transactions for last 30 days
            //'filter_period' => 'week', // show only transactions for this week
            'chart_color' => "0,96,255",
            //'chart_height' => '300'
        ];
        $chart_options2 = [
            'chart_title' => trans_choice('messages.Shipment', 1),
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Shipment',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'pie',
            'chart_color' => "0,96,255",
            'top_results' => 12,
            //'chart_height' => '500'

        ];

        // Percentage stat
        $chart1 = new LaravelChart($chart_options);
        $chart2 = new LaravelChart($chart_options2);

        // $startDateWeek = Carbon::now()->startOfWeek();
        // $endDateWeek = Carbon::now()->endOfWeek();

        // $newUsersThisWeek = User::whereBetween('created_at', [$startDateWeek, $endDateWeek])->count();

        // $lastWeekStartDate = Carbon::now()->startOfWeek()->subWeek();
        // $lastWeekEndDate = Carbon::now()->endOfWeek()->subWeek();

        // $lastWeekUsers = User::whereBetween('created_at', [$lastWeekStartDate, $lastWeekEndDate])->count();

        // $percentageIncreaseThisWeek = round((($newUsersThisWeek - $lastWeekUsers) / $lastWeekUsers) * 100, 2);

        $role = Auth()->user()->role;
        $owner = Auth()->user()->id;
        $branch = Auth()->user()->branch;

        $startDateMonth = Carbon::now()->startOfMonth();
        $endDateMonth = Carbon::now()->endOfMonth();
        $lastMonthStartDate = Carbon::now()->startOfMonth()->subMonth();
        $lastMonthEndDate = Carbon::now()->endOfMonth()->subMonth();

        // customers
        if ($role == 1) {

            // shipments
            $newUsersThisMonth = Shipment::whereRaw("owner_id = '$owner'")->whereBetween('created_at', [$startDateMonth, $endDateMonth])->count();
            $lastMonthUsers = Shipment::whereRaw("owner_id = '$owner'")->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])->count();
            if ($lastMonthUsers == 0) {
                $percentageIncreaseThisMonth = 0;
            } else {
                $percentageIncreaseThisMonth = round((($newUsersThisMonth - $lastMonthUsers) / $lastMonthUsers) * 100, 2);
            }
            // PENDING
            $newUsersThisMonthP = Shipment::whereRaw("status = 0 AND owner_id = '$owner'")
                ->whereBetween('created_at', [$startDateMonth, $endDateMonth])->count();
            $lastMonthUsersP = Shipment::whereRaw("status = 0 AND owner_id = '$owner'")
                ->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])->count();
            if ($lastMonthUsersP == 0) {
                $percentageIncreaseThisMonth_Pending = 0;
            } else {
                $percentageIncreaseThisMonth_Pending = round((($newUsersThisMonthP - $lastMonthUsersP) / $lastMonthUsersP) * 100, 2);
            }


            // Shipped
            $newUsersThisMonthS = Shipment::whereRaw("status = 4 AND owner_id = '$owner'")
                ->whereBetween('created_at', [$startDateMonth, $endDateMonth])->count();
            $lastMonthUsersS = Shipment::whereRaw("status = 4 AND owner_id = '$owner'")
                ->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])->count();
            if ($lastMonthUsersS == 0) {
                $percentageIncreaseThisMonth_Shipped = 0;
            } else {
                $percentageIncreaseThisMonth_Shipped = round((($newUsersThisMonthS - $lastMonthUsersS) / $lastMonthUsersS) * 100, 2);
            }



            // Delivered
            $newUsersThisMonthD = Shipment::whereRaw("status = 13 AND owner_id = '$owner'")->whereBetween('created_at', [$startDateMonth, $endDateMonth])->count();
            $lastMonthUsersD = Shipment::whereRaw("status = 13 AND owner_id = '$owner'")->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])->count();
            if ($lastMonthUsersD == 0) {
                $percentageIncreaseThisMonth_Delivered = 0;
            } else {
                $percentageIncreaseThisMonth_Delivered = round((($newUsersThisMonthS - $lastMonthUsersD) / $lastMonthUsersD) * 100, 2);
            }
        }

        // management
        if ($role > 1) {
            // ALL
            $newUsersThisMonth = Shipment::whereBetween('created_at', [$startDateMonth, $endDateMonth])->count();
            $lastMonthUsers = Shipment::whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])->count();
            if ($lastMonthUsers == 0) {
                $percentageIncreaseThisMonth = 0;
            } else {
                $percentageIncreaseThisMonth = round((($newUsersThisMonth - $lastMonthUsers) / $lastMonthUsers) * 100, 2);
            }



            // PENDING
            $newUsersThisMonthP = Shipment::where('status', 0)->whereBetween('created_at', [$startDateMonth, $endDateMonth])->count();
            $lastMonthUsersP = Shipment::where('status', 0)->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])->count();
            if ($lastMonthUsersP == 0) {
                $percentageIncreaseThisMonth_Pending = 0;
            } else {
                $percentageIncreaseThisMonth_Pending = round((($newUsersThisMonthP - $lastMonthUsersP) / $lastMonthUsersP) * 100, 2);
            }


            // Shipped
            $newUsersThisMonthS = Shipment::where('status', 4)->whereBetween('created_at', [$startDateMonth, $endDateMonth])->count();
            $lastMonthUsersS = Shipment::where('status', 4)->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])->count();
            if ($lastMonthUsersS == 0) {
                $percentageIncreaseThisMonth_Shipped = 0;
            } else {
                $percentageIncreaseThisMonth_Shipped = round((($newUsersThisMonthS - $lastMonthUsersS) / $lastMonthUsersS) * 100, 2);
            }



            // Delivered
            $newUsersThisMonthD = Shipment::where('status', 13)->whereBetween('created_at', [$startDateMonth, $endDateMonth])->count();
            $lastMonthUsersD = Shipment::where('status', 13)->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])->count();
            if ($lastMonthUsersD == 0) {
                $percentageIncreaseThisMonth_Delivered = 0;
            } else {
                $percentageIncreaseThisMonth_Delivered = round((($newUsersThisMonthS - $lastMonthUsersD) / $lastMonthUsersD) * 100, 2);
            }
        }


        return view(get_theme_dir('dashboard', 'dashboard'), compact('chart1', 'chart2'))->with([
            'page_title' => $datax['page_title'],
            'percentageIncreaseThisMonth' => $percentageIncreaseThisMonth,
            'percentageIncreaseThisMonthP' => $percentageIncreaseThisMonth_Pending,
            'percentageIncreaseThisMonthS' => $percentageIncreaseThisMonth_Shipped,
            'percentageIncreaseThisMonthD' => $percentageIncreaseThisMonth_Delivered
        ]);
    }
}
