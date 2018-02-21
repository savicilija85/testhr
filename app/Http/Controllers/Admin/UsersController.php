<?php


namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/users';

    /**
     * Create a new controller instance.
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    public function showUser($id){
        $user = User::find($id);

        return view('admin.viewUser', compact('user'));
    }

    public function showEditUser($id){
        $user = User::find($id);

        return view('admin.editUser', compact('user'));
    }

    public function editUser($id, Request $request){
        $user = User::find($id);

        $user->update($request->all());

        return Redirect::to('admin/users');
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->destroy($id);
        Session::flash('success', "$user->name successfully deleted");

        return Redirect::to('admin/users');
    }

    public function getUserIdCardImageFront($id){
        $user = User::find($id);
        $file = Storage::disk('ftp')->get($user->id_card_path_front);

        return response($file)->header('Content-Type', 'image/png');
    }

    public function getUserIdCardImageBack($id){
        $user = User::find($id);
        $file = Storage::disk('ftp')->get($user->id_card_path_back);

        return response($file)->header('Content-Type', 'image/png');
    }
}