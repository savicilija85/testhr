<?php

namespace App\Http\Controllers\Admin;

use App\CryptoCurrency;
use App\Http\Controllers\Controller;
use App\Provision;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

class ProvisionController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/provision';

    /**
     * Create a new controller instance.
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showProvision(){
        $provisions = Provision::find(1);
        $currencies = CryptoCurrency::all();
        return view('admin.provision', compact('provisions', 'currencies'));
    }

    public function saveProvision(Request $request){
        $data =$request->all();

        $provision = Provision::find(1);
        $provision->{array_keys($data)[1]} = $data[array_keys($data)[1]];
        $provision->save();
        Session::flash('success', 'Provision successfully updated');

        return \Redirect::to('admin/provision');
    }
}
