<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function index()
    {
        // Fetch count of user creations per day
        $usersByDay = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                          ->groupBy('date')
                          ->get();

        // Calculate total number of users
        $totalUsers = User::count();

        // Fetch product data for pie chart
        $products = Product::select('name', \DB::raw('COUNT(*) as count'))
                           ->groupBy('name')
                           ->get();

        $productLabels = $products->pluck('name');
        $productCounts = $products->pluck('count');

        // Prepare data for the chart
        $labels = $usersByDay->pluck('date');
        $userCreations = $usersByDay->pluck('count');
        $totalUsersData = collect([$totalUsers])->pad(count($labels), $totalUsers)->toArray();

        // Pass data to the view
        return view('chart', compact('labels', 'userCreations', 'totalUsers', 'totalUsersData', 'productLabels', 'productCounts'));
    }
}
