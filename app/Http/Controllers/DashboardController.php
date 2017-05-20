<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Customer;
use App\Models\CustomerCandidate;
use App\Models\Sale;
use App\Models\CustomerFollowup;

use Carbon\Carbon;
use DateTime;
use DB;

class DashboardController extends Controller
{

    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Protect all dashboard routes. Users must be authenticated.
        $this->middleware('auth');
    }

    public function newCustomer() { 
	$customers = Customer::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
	return view('new_cust', compact('customers')); 
    }

    public function index() {
        $page_title       = "Dashboard";
        $page_description = "Sepintas Informasi Bulan Ini";

        $newCustomersCount = Customer::where(DB::raw('YEAR(created_at)'), Carbon::now()->year)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

	$newBoCount = Customer::where(DB::raw('YEAR(created_at)'), Carbon::now()->year)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->where('type', [1,6])
            ->count();

        $salesThisMonthCount = Sale::whereBetween('order_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        $incomeThisMount = Sale::where('status', 2)
            ->whereBetween('transfer_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->select('nominal', 'shipping_fee', 'packing_fee')
            ->get();
        $incomeThisMountTotal = $incomeThisMount->sum(function ($sale) {
            return $sale->nominal + $sale->shipping_fee + $sale->packing_fee;
        });

        $sales = Sale::
            whereBetween('transfer_date', [Carbon::now()->startOfMonth(), Carbon::today()])
            ->get();

        $salesLastMonth = Sale::
            whereBetween('transfer_date', [new DateTime('first day of previous month'), new DateTime('last day of previous month')])
            ->get();

        $latestSales = Sale::orderBy('id', 'desc')->take(5)->get();

        $latestFollowups = CustomerFollowup::orderBy('id', 'desc')->take(5)->get();

        $chemicalIndex      = [2,5,6,7,8,9];
        $materialIndex      = [10,11];

        $saleDetails = [
            'chemicals' => [
                'value'     => 0,
                'color'     => 'green',
                'highlight' => '#00a65a',
                'label'     => 'Chemicals'
            ],
            'materials' => [
                'value'     => 0,
                'color'     => 'blue',
                'highlight' => '#0073b7',
                'label'     => 'Materials'
            ],
            'equipments' => [
                'value'     => 0,
                'color'     => 'red',
                'highlight' => '#dd4b39',
                'label'     => 'Equipments'
            ],
        ];

        foreach ($sales as $key => $row) {
            foreach($row->saleDetails as $key => $d) {
                if(in_array( $d->product->category_id, $chemicalIndex)) {
                    $saleDetails['chemicals']['value'] += $d->total;
                } elseif (in_array( $d->product->category_id, $materialIndex)) {
                    $saleDetails['materials']['value'] += $d->total;
                } else {
                    $saleDetails['equipments']['value'] += $d->total;
                }
            }
        }

        $saleDetailsLastMonth = [
            'chemicals' => [
                'value'          => 0,
                'valueThisMonth' => $saleDetails['chemicals']['value'],
                'label'          => 'Chemicals'
            ],
            'materials' => [
                'value'          => 0,
                'valueThisMonth' => $saleDetails['materials']['value'],
                'label'          => 'Materials'
            ],
            'equipments' => [
                'value'          => 0,
                'valueThisMonth' => $saleDetails['equipments']['value'],
                'label'          => 'Equipments'
            ],
        ];

        foreach ($salesLastMonth as $key => $row) {
            foreach($row->saleDetails as $key => $d) {
                if(in_array( $d->product->category_id, $chemicalIndex)) {
                    $saleDetailsLastMonth['chemicals']['value'] += $d->total;
                } elseif (in_array( $d->product->category_id, $materialIndex)) {
                    $saleDetailsLastMonth['materials']['value'] += $d->total;
                } else {
                    $saleDetailsLastMonth['equipments']['value'] += $d->total;
                }
            }
        }

        $details = \App\Models\SaleDetail::where('description', '!=', '')->whereNotNull('description')->orderBy('description', 'asc')->lists('description');
        $first = [];
        $final = [];
        foreach ($details as $key => $value) {
            $first[] = $value;
        }
        $result = array_count_values($first);
        arsort($result);
        $final = array_slice($result, 0, 5);

        return view('dashboard', compact(
            'page_title',
            'page_description',
            'newCustomersCount',
            'salesThisMonthCount',
            'incomeThisMountTotal',
            'saleDetails',
            'saleDetailsLastMonth',
            'latestSales',
            'latestFollowups',
            'final',
	    'newBoCount'
        ));
    }

    public function search(Request $request) {
        $keyword = $request->input('term');

        $products      = Product::where('name', 'like', '%'.$keyword.'%')
                        ->orderBy('name', 'ASC')
                        ->take(50)
                        ->get();

        $customers     = Customer::where('name',     'LIKE', '%'.$keyword.'%')
                        ->orWhere('address',         'LIKE', '%'.$keyword.'%')
                        ->orWhere('laundry_address', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('send_address',    'LIKE', '%'.$keyword.'%')
                        ->orWhere('phone',           'LIKE', '%'.$keyword.'%')
                        ->take(50)
                        ->get();

        # TODO: create sales search by customer name

        $customerCandidates = CustomerCandidate::where('name','LIKE', '%'.$keyword.'%')
                ->orWhere('address', 'LIKE', '%'.$keyword.'%')
                ->orWhere('phone',   'LIKE', '%'.$keyword.'%')
                ->take(50)
                ->get();

        $page_title       = trans('general.page.search.title');
        $page_description = trans('general.page.search.description', ['keyword' => $keyword]);

        return view('search', compact(
            'page_title',
            'page_description',
            'keyword',
            'products',
            'customers',
            'customerCandidates'
        ));
    }

}
