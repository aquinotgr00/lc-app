<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\StoreCustomer;

class StoreCustomersController extends Controller
{
    static function routes() {
        \Route::group(['prefix' => 'store-customers'], function () {
            \Route::get('/',                    'StoreCustomersController@index')           ->name('admin.store-customers.index');
            \Route::get('{id}',                 'StoreCustomersController@show')            ->name('admin.store-customers.show');
            \Route::get('{id}/delete',          'StoreCustomersController@destroy')         ->name('admin.store-customers.delete');
            \Route::get('{id}/confirm-delete',  'StoreCustomersController@getModalDelete')  ->name('admin.store-customers.confirm-delete');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = StoreCustomer::orderBy('id', 'DESC')->get();
        return view('admin.store-customers.index', compact('customers'));
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
        $customer = StoreCustomer::find($id);
        return view('admin.store-customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aff = StoreCustomer::find($id);
        $aff->delete();
        return redirect( route('admin.store-customers.index') );
    }

    public function getModalDelete($id)
    {
        $error       = null;
        
        $param       = StoreCustomer::find($id);
        
        $modal_title = 'Hapus customer dari store?';
        $modal_route = route('admin.store-customers.delete', array('id' => $param->id));
        $modal_body  = 'Apakah kamu yakin ingin menghapus customer ID: '. $param->id .' dengan nama: '. $param->user->getFullNameAttribute() .' ? Proses ini tidak bisa dibatalkan.';

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));

    }
}
