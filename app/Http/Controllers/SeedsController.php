<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Seed;

class SeedsController extends Controller
{
    static function routes() {
        \Route::get('product/perfume-seeds', 'SeedsController@index')->name('admin.seeds.index');
        \Route::group(['prefix' => 'seeds'], function () {
            \Route::get(    '{id}/edit',    'SeedsController@edit')  ->name('admin.seeds.edit');
            \Route::patch(  '{id}/update',  'SeedsController@update')->name('admin.seeds.update');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get product by category 10 (perfume seeds)
        $seeds = Product::where('category_id', 10)->get();

        return view('admin.seeds.index', compact('seeds'));
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
        $product = Product::find($id);
        return view('admin.seeds.edit', compact('product'));
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
        $data        = $request->except(['_method', '_token', 'seed']);
        $seed_prices = $request->seed;
        Product::find($id)->update($data);
        Seed::where('product_id', $id)->first()->update($seed_prices);
        return redirect( route('admin.seeds.index') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
