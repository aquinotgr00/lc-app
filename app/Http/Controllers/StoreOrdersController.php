<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\StoreOrder;
use App\Models\StoreOrderDetail;

class StoreOrdersController extends Controller
{
    static function routes() {
        \Route::group(['prefix' => 'store-orders'], function () {
            \Route::get('/',                   'StoreOrdersController@index')         ->name('admin.store-orders.index');
            \Route::get('{id}',                'StoreOrdersController@show')          ->name('admin.store-orders.show');
            \Route::get('{id}/edit',           'StoreOrdersController@edit')          ->name('admin.store-orders.edit');
            \Route::get('{id}/update',         'StoreOrdersController@update')        ->name('admin.store-orders.update');
            \Route::get('{id}/delete',         'StoreOrdersController@destroy')       ->name('admin.store-orders.delete');
            \Route::get('{id}/confirm-delete', 'StoreOrdersController@getModalDelete')->name('admin.store-orders.confirm-delete');
            \Route::get('{id}/proccess',       'StoreOrdersController@proccessOrder') ->name('admin.store-orders.proccess-order');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title       = 'Pesanan Online';
        $page_description = 'Pesanan dari toko online';
        $orders           = \App\Models\StoreOrder::orderBy('created_at', 'desc')->get();
        return view('admin.store-orders.index', compact('page_title', 'page_description', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = StoreOrder::find($id);
        $page_title = 'Detail Pesanan';
        $page_description = 'Pesanan dari user: '. $order->storeCustomer->user->getFullNameAttribute() .'';
        return view('admin.store-orders.show', compact('page_title', 'page_description', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = StoreOrder::find($id);
        return view('admin.store-orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function proccessOrder($id) {
        $order = StoreOrder::find($id);

        $order->update(['status' => 2]);

        $affiliator = $order->storeCustomer->affiliate;
        if ($affiliator) {
            $total                    = $order->total;
            if ($affiliator->type == 1) {
                $affiliator->decrement('temp_balance', 10/100*$total);
                $affiliator->increment('balance', 10/100*$total);
            } elseif ($affiliator->type == 2) {
                $affiliator->decrement('temp_balance', 20/100*$total);
                $affiliator->increment('balance', 20/100*$total);
            }
        }

        return redirect( route('admin.store-orders.show', $order->id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order   = StoreOrder::find($id);
        $details = StoreOrderDetail::where('order_id', $order->id)->get();

        foreach ($details as $key => $value) {
            $value->delete();
        }
        $order->delete();

        return redirect( route('admin.store-orders.index') );
    }

    public function getModalDelete($id)
    {
        $error       = null;
        
        $order       = StoreOrder::find($id);
        
        $modal_title = 'Hapus pesanan';
        $modal_route = route('admin.store-orders.delete', array('id' => $order->id));
        $modal_body  = 'Apakah kamu yakin ingin menghapus pesanan ID: '. $order->id .' atas nama: '. $order->storeCustomer->user->getFullNameAttribute() .' ? Proses ini tidak bisa dikembalikan.';

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));

    }
}
