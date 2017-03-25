<?php

namespace App\Http\Controllers;

use App\Repositories\MaterialRepository as Material;
use App\Repositories\Criteria\Material\MaterialsOutOfStock;
use App\Repositories\Criteria\Material\MaterialWhereNameLike;

use App\Models\SeedMaterial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;

class MaterialsController extends Controller
{
    private $material;

    public function __construct(Material $material)
    {
        $this->material = $material;
    }

    static function routes() {
        \Route::group(['prefix' => 'materials'], function () {
            \Route::post( '/',                    'MaterialsController@store')             ->name('admin.materials.store');
            \Route::patch('{mId}',                'MaterialsController@update')            ->name('admin.materials.update');
            \Route::get(  'create',               'MaterialsController@create')            ->name('admin.materials.create');
            \Route::get(  '{slug}',               'MaterialsController@index')             ->name('admin.materials.index');
            \Route::get(  'out-of-stock',         'MaterialsController@outOfStock')        ->name('admin.materials.out-of-stock');
            \Route::post( 'createPurchaseOrder',  'MaterialsController@createSelected')    ->name('admin.materials.order-selected');
            \Route::get(  'search',               'MaterialsController@search')            ->name('admin.materials.search');
            \Route::get(  '{mId}/edit',           'MaterialsController@edit')              ->name('admin.materials.edit');
            \Route::get(  '{mId}/delete',         'MaterialsController@destroy')           ->name('admin.materials.delete');
            \Route::get(  '{mId}/confirm-delete', 'MaterialsController@getModalDelete')    ->name('admin.materials.confirm-delete');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        if ($slug == 'bahan') {
            $materials        = $this->material->findAllBy('category', 1);
        } elseif ($slug == 'bibit') {
            $materials        = $this->material->findAllBy('category', 2);
        } elseif ($slug == 'peralatan') {
            $materials        = $this->material->findAllBy('category', 3);
        }

        $page_title       = trans('admin/materials/general.page.index.title');
        $page_description = trans('admin/materials/general.page.index.description');

        return view('admin.materials.index', compact('page_title', 'page_description', 'materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title       = trans('admin/materials/general.page.create.title');
        $page_description = trans('admin/materials/general.page.create.description');

        return view('admin.materials.create', compact('page_title', 'page_description'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $material = $this->material->create($data);

        if ($request->category == 2) {
            SeedMaterial::create(['material_id' => $material->id]);
        }

        Flash::success( trans('admin/materials/general.status.created') );

        return redirect( route('admin.materials.index', 1) );
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
        $material         = $this->material->find($id);
        
        $page_title       = trans('admin/materials/general.page.edit.title');
        $page_description = trans('admin/materials/general.page.edit.description');

        return view('admin.materials.edit', compact('page_title', 'page_description', 'material'));
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
        $data = $request->only(['category', 'name', 'stock', 'price', 'min_stock']);

        $this->material->update($data, $id);

        if ($request->category == 2) {
            SeedMaterial::create(['material_id' => $id]);
        }

        if ($request->seedMaterial) {
            $seedMaterial = SeedMaterial::where('material_id', $id)->first();
            $seedMaterial->update($request->seedMaterial);
        }

        Flash::success( trans('admin/materials/general.status.updated') );

        return redirect('/admin/materials');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->material->delete($id);

        Flash::success( trans('admin/materials/general.status.deleted') );

        return redirect('/admin/materials');
    }

    /**
     * Delete Confirm
     *
     * @param   int   $id
     * @return  View
     */
    public function getModalDelete($id)
    {
        $error    = null;
        
        $material = $this->material->find($id);

        $modal_title = trans('admin/materials/dialog.delete-confirm.title');
        $modal_route = route('admin.materials.delete', array('id' => $material->id));
        $modal_body  = trans('admin/materials/dialog.delete-confirm.body', ['id' => $material->id, 'name' => $material->name]);

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));

    }

    public function outOfStock()
    {
        $materials = $this->material->pushCriteria(new MaterialsOutOfStock())->all();

        return view('admin.materials.index', compact('materials'));
    }

    public function createSelected(Request $request)
    {
        dd($request->all());
    }

    public function search(Request $request) {
        $return_arr = null;

        $query      = $request->input('term');

        $materials  = $this->material->pushCriteria(new MaterialWhereNameLike($query))->all();

        foreach ($materials as $value) {
            $entry_arr = [
                'id'              => $value->id,
                'value'           => $value->name,
                'price'           => $value->price
            ];
            $return_arr[] = $entry_arr;
        }
        return response()->json($return_arr);
    }
}
