<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Training;

class TrainingsController extends Controller
{
    static function routes() {
        \Route::group(['prefix' => 'trainings'], function () {
            \Route::post( '/',               'TrainingsController@store')    ->name('admin.trainings.store');
            \Route::get(  '{id}/delete',     'TrainingsController@destroy')  ->name('admin.trainings.delete');
        });
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Training::create($request->only(['customer_id', 'price', 'category']));
        return redirect( route('admin.customers.show', $request->customer_id) );
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
        Training::destroy($id);
        return back();
    }
}
