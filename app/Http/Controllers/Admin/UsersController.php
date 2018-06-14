<?php


namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        //$users = User::all()->sortByDesc('verified');
        $users = User::all()->sortBy(function ($product, $key){
            switch ($product['verified']){
                case 'uploaded':
                    return $product['verified'];
                    break;
                case 'verificated':
                    return $product['verified'];
                    break;
                default:
                    return $key;
                    break;
            }

        });
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
        try{
            $user = User::find($id);
            $file = Storage::disk('ftp')->get($user->id_card_path_front);
        } catch (\Exception $e){
            Session::flash('error', "Greška: Fajl ne postoji" );
            return Redirect::to("admin/users/view/$id");
        }
        return response($file)->header('Content-Type', 'image/png');
    }

    public function getUserIdCardImageBack($id){
        try{
            $user = User::find($id);
            $file = Storage::disk('ftp')->get($user->id_card_path_back);
        } catch (\Exception $e){
            Session::flash('error', "Greška: Fajl ne postoji" );
            return Redirect::to("admin/users/view/$id");
        }
        return response($file)->header('Content-Type', 'image/png');
    }

    public function getUserIdCardImageSelfie($id){
        try{
            $user = User::find($id);
            $file = Storage::disk('ftp')->get($user->id_card_path_selfie);
        } catch (\Exception $e) {
            Session::flash('error', "Greška: Fajl ne postoji");
            return Redirect::to("admin/users/view/$id");
        }
        return response($file)->header('Content-Type', 'image/png');
    }

    public function updateVerifiedUser($id, Request $request){
        $user = User::find($id);
        $user->verified = 'verificated';
        $user->save();

        $data = [
            'email' => $user->email,
            'title' => 'Verifikacija dokumenata - Crypto Plus DOO',
            'name' => $user->name
        ];

        Mail::send('emails.verified_user', $data, function ($message) use ($data) {
            $message->from('cryptoplusrs@gmail.com');
            $message->to($data['email']);
            $message->subject($data['title']);
        });
        Session::flash('success', "$user->name uspešno je verifikovan");

        return view('admin.viewUser', compact('user'));
    }

    public function denyVerifiedUser($id, Request $request){
        $user = User::find($id);
        $user->verified = 'denied';
        $user->save();

        $data = [
            'email' => $user->email,
            'title' => 'Verifikacija dokumenata - Crypto Plus DOO',
            'name' => $user->name
        ];

        Mail::send('emails.denied_user', $data, function ($message) use ($data) {
            $message->from('cryptoplusrs@gmail.com');
            $message->to($data['email']);
            $message->subject($data['title']);
        });

        Session::flash('success', "$user->name uspešno je odbijen");

        return view('admin.viewUser', compact('user'));
    }
}