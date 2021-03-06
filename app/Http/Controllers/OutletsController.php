<?php

namespace App\Http\Controllers;

use App\Repositories\OutletRepository as Outlet;
use App\Repositories\UserRepository as User;
use App\Repositories\RoleRepository as Role;
use App\Repositories\Criteria\Outlet\OutletsWithOutletSaleDailies;
use App\Repositories\Criteria\Outlet\OutletsWithOutletCustomers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;
use Auth;
use Excel;

class OutletsController extends Controller
{
    private $outlet;

    private $user;

    private $role;

    public function __construct(Outlet $outlet, User $user, Role $role)
    {
        $this->outlet = $outlet;
        $this->user   = $user;
        $this->role   = $role;
    }

    static function routes() {
        \Route::group(['prefix' => 'outlets'], function () {
            \Route::get(  '/',                     'OutletsController@index')           ->name('admin.outlets.index');
            \Route::post( '/',                     'OutletsController@store')           ->name('admin.outlets.store');
            \Route::get(  '/search',               'OutletsController@search')          ->name('admin.outlets.search');
            \Route::get(  '/create',               'OutletsController@create')          ->name('admin.outlets.create');
            \Route::get(  '/{oId}',                'OutletsController@show')            ->name('admin.outlets.show');
            \Route::patch('/{oId}',                'OutletsController@update')          ->name('admin.outlets.update');
            \Route::get(  '/{oId}/excel',          'OutletsController@excel')           ->name('admin.outlets.excel');
            \Route::get(  '/{oId}/delete',         'OutletsController@destroy')         ->name('admin.outlets.delete');
            \Route::get(  '/{oId}/confirm-delete', 'OutletsController@getModalDelete')  ->name('admin.outlets.confirm-delete');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user             = $this->user->find(Auth::user()->id);
        
        $page_title       = trans('admin/outlets/general.page.index.title');
        $page_description = trans('admin/outlets/general.page.index.description');

        if ( $user->hasRole('operationals') || $user->isRoot() || $user->can('manage-outlets') ) {
            $outlets = $this->outlet->all();
        } elseif (Auth::user()->username == 'indri') {
            $outlets = $this->outlet->findWhere(['id' => 4]);
            return view('admin.outlets.index', compact('page_title', 'page_description', 'outlets'));
        } elseif ( $user->hasRole('outlet-operators') ) {
            return redirect('/outlet');
        }

        return view('admin.outlets.index', compact('page_title', 'page_description', 'outlets'));
    }

    public function operatorIndex()
    {
        $user   = $this->user->find(Auth::user()->id);
        $outlet = $this->outlet
            ->pushCriteria(new OutletsWithOutletSaleDailies())
            ->pushCriteria(new OutletsWithOutletCustomers())
            ->findBy('user_id', $user->id);

        return view('admin.outlets.show', compact('outlet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->username == 'indri') {
            return redirect()->route('admin.outlets.index');
        }

        $page_title       = trans('admin/outlets/general.page.create.title');
        $page_description = trans('admin/outlets/general.page.create.description');

        return view('admin.outlets.create', compact('page_title', 'page_description'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data        = $request->all();

        $this->outlet->create($data);

        Flash::success( trans('admin/outlets/general.status.created') );

        return redirect('/admin/outlets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $outlet = $this->outlet
            ->pushCriteria(new OutletsWithOutletCustomers())
            ->pushCriteria(new OutletsWithOutletSaleDailies())
            ->find($id);

        $page_title       = trans('admin/outlets/general.page.show.title');
        $page_description = trans('admin/outlets/general.page.show.description', ['name' => $outlet->name]);

        if (Auth::user()->username == 'indri') {
            if ($id != 4) {
                return redirect()->route('admin.outlets.show', 4);
            }
            return view('admin.outlets.show', compact('page_title', 'page_description', 'outlet'));
        }

        return view('admin.outlets.show', compact('page_title', 'page_description', 'outlet'));
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
        $data = $request->except(['_method', '_token']);

        $this->outlet->update($data, $id);

        Flash::success( trans('admin/outlets/general.status.updated') );

        return redirect()->back();
    }

    /**
     * export to excel function
     * @param  int $id sale id
     * @return xls     excel doc extension
     */
    public function excel($id) {
        $outletName       = $this->outlet->find($id)->name;

        Excel::create('Outlet - '. $outletName .'', function($excel) use($id) {
            $excel->sheet('Outlet Sales', function ($sheet) use ($id) {
                $outlet   = $this->outlet->find($id);
                $details  = $this->outlet->find($id)->outletSaleDailies;
                $sheet->loadView('admin.outlets.excel', ['outlet' => $outlet, 'details' => $details]);
            });
        })->download('xls');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->username == 'indri') {
            return redirect()->route('admin.outlets.index');
        }

        $this->outlet->delete($id);

        Flash::success( trans('admin/outlets/general.status.deleted') );

        return redirect('/admin/outlets');
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
        
        $outlet      = $this->outlet->find($id);
        
        $modal_title = trans('admin/outlets/dialog.delete-confirm.title');
        $modal_route = route('admin.outlets.delete', array('id' => $outlet->id));
        $modal_body  = trans('admin/outlets/dialog.delete-confirm.body', ['id' => $outlet->id, 'name' => $outlet->name]);

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));

    }
}
