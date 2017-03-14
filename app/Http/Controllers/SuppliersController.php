<?php

namespace App\Http\Controllers;

use App\Repositories\SupplierRepository as Supplier;
use App\Repositories\Criteria\Supplier\SupplierWhereNameLike;
use App\Repositories\Criteria\Supplier\SuppliersByNamesAscending;

use App\Models\SupplierDetail;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;

class SuppliersController extends Controller
{
    /**
     * @var $supplier
     */
    private $supplier;

    public function __construct(Supplier $supplier) {
        $this->supplier = $supplier;
    }

    static function routes() {
        \Route::group(['prefix' => 'suppliers'], function () {
            \Route::get(  '',                        'SuppliersController@index')         ->name('admin.suppliers.index');
            \Route::post( '',                        'SuppliersController@store')         ->name('admin.suppliers.store');
            \Route::get(  '/create',                 'SuppliersController@create')        ->name('admin.suppliers.create');
            \Route::get(  '/search',                 'SuppliersController@search')        ->name('admin.suppliers.search');
            \Route::patch('/{suppId}',               'SuppliersController@update')        ->name('admin.suppliers.update');
            \Route::get(  '/{suppId}/edit',          'SuppliersController@edit')          ->name('admin.suppliers.edit');
            \Route::get(  '/{suppId}/delete',        'SuppliersController@destroy')       ->name('admin.suppliers.delete');
            \Route::get(  '/{suppDId}/delete-detail','SuppliersController@destroyDetail') ->name('admin.suppliers.delete-detail');
            \Route::get(  '/{suppId}/confirm-delete','SuppliersController@getModalDelete')->name('admin.suppliers.confirm-delete');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers        = $this->supplier->pushCriteria(new SuppliersByNamesAscending)->all();
        
        $page_title       = trans('admin/suppliers/general.page.index.title');
        $page_description = trans('admin/suppliers/general.page.index.description');

        return view('admin.suppliers.index', compact('page_title', 'page_description', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title       = trans('admin/suppliers/general.page.create.title');
        $page_description = trans('admin/suppliers/general.page.create.description');

        return view('admin.suppliers.create', compact('page_title', 'page_description'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token']);

        $this->supplier->create($data);

        Flash::success( trans('admin/suppliers/general.status.created') );

        return redirect('/admin/suppliers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier         = $this->supplier->find($id);
        
        $page_title       = trans('admin/suppliers/general.page.edit.title');
        $page_description = trans('admin/suppliers/general.page.edit.description', ['name' => $supplier->name]);

        return view('admin.suppliers.edit', compact('page_title', 'page_description', 'supplier'));
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
        $data     = $request->except(['_token', '_method', 'material']);

        $supplier = $this->supplier->update($data, $id);

        if ($request->material) {
            $old = SupplierDetail::where('supplier_id', $id)->get();
            foreach ($old as $key => $value) {
                SupplierDetail::destroy($value->id);
            }
            foreach ($request->material as $key => $value) {
                SupplierDetail::create(['supplier_id' => $id, 'material_id' => $value['material_id'], 'price' => $value['price']]);
            }
        }

        Flash::success( trans('admin/suppliers/general.status.updated') );

        return redirect( route('admin.suppliers.edit', $id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->supplier->delete($id);

        Flash::success( trans('admin/suppliers/general.status.deleted') );

        return redirect('/admin/suppliers');
    }

    public function destroyDetail($id) {
        $supplier_id = SupplierDetail::find($id)->supplier_id;
        SupplierDetail::destroy($id);
        return redirect( route('admin.suppliers.edit', $supplier_id) );
    }

    /**
     * Delete Confirm
     *
     * @param   int   $id
     * @return  View
     */
    public function getModalDelete($id)
    {
        $error       = null;
        
        $supplier    = $this->supplier->find($id);
        
        $modal_title = trans('admin/suppliers/dialog.delete-confirm.title');
        $modal_route = route('admin.suppliers.delete', array('id' => $supplier->id));
        $modal_body  = trans('admin/suppliers/dialog.delete-confirm.body', ['id' => $supplier->id, 'name' => $supplier->name]);

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));

    }

    public function search(Request $request)
    {
        $return_arr = null;
        
        $query      = $request->input('term');

        if ($query == '') {
            $query = $request->input('query');
        }

        $suppliers = $this->supplier->pushCriteria(new SupplierWhereNameLike($query))->all();

        foreach ($suppliers as $e) {
            $id   = $e->id;
            $name = $e->name;
            $detail = $e->supplierDetails;

            $entry_arr    = [ 'id' => $id, 'text' => $name, 'value' => $name, 'detail' => $detail];
            $return_arr[] = $entry_arr;
        }

        return $return_arr;
    }
}
