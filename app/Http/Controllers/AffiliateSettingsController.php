<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AffiliateSetting;

class AffiliateSettingsController extends Controller
{
    static function routes() {
        \Route::group(['prefix' => 'affiliate-settings'], function () {
            \Route::get( '/',               'AffiliateSettingsController@index')    ->name('admin.affiliate-settings.index');
            \Route::post('save-setting',    'AffiliateSettingsController@save')     ->name('admin.affiliate-settings.save');
            \Route::post('/',               'AffiliateSettingsController@store')    ->name('admin.affiliate-settings.store');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $affSettings = AffiliateSetting::all();
        return view('admin.affiliate-settings.index', compact('affSettings'));
    }

    public function save(Request $request) {
        foreach ($request->except('_token') as $key => $value) {
            $affSetting = AffiliateSetting::where('name', $key)->first();
            if ($affSetting->type == 1) {
                $affSetting->update(['value' => $value]);
            } else {
                $affSetting->update(['value_int' => $value]);
            }
        }
        return redirect( route('admin.affiliate.dashboard') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.affiliate-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AffiliateSetting::create($request->except(['_token']));
        return redirect( route('admin.affiliate-settings.index') );
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
        //
    }
}
