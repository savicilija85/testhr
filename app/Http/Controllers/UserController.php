<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Classes\JsonResponse;
use App\Classes\ZeroesOnAccountNumber;
use App\Http\Controllers\Auth\LoginController;
use App\Rules\CryptedPasswordValidation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private $zeroesOnAccNumber;
    private $authenticateUser;

    /**
     * UserController constructor.
     * @param ZeroesOnAccountNumber $zeroesOnAccNumber
     */
    public function __construct(ZeroesOnAccountNumber $zeroesOnAccNumber, LoginController $authenticateUser)
    {
        $this->middleware('auth.jwt');
        $this->zeroesOnAccNumber = $zeroesOnAccNumber;
        $this->authenticateUser = $authenticateUser;
    }

    public function index()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $categories = Category::all();
        return view('user.myAccount', compact('categories', 'user'));
    }

    public function showChangePasswordPage(){
        return view('user.changePassword');
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => ['required','string','min:6', new CryptedPasswordValidation()],
            'newPassword' => 'required|string|min:6',
            'confirmPassword' => 'required|string|min:6|same:newPassword',
        ]);
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request['newPassword']);
        $user->save();
        return Redirect::to('user/myAccount');
    }

    public function showChangePersonalDataPage(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('user.changePersonalData', compact('user'));
    }

    public function changePersonalData(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/\d{3}[\-]\d{2}[\-]\d{6}\d?/'
        ]);
        $user = User::find(Auth::user()->id);
        $user->name = $request['name'];
        $user->phone = $request['phone'];
        $user->save();

        return Redirect::to('user/myAccount');
    }

    public function showAddBankAccount(){
        return view('user.addBankAccount');
    }

    public function deleteBankAccount($id){
        $account = Account::find($id);
        $account->destroy($id);

        return Redirect::to('user/myAccount');
    }

    public function addBankAccount(Request $request){
        $accountArray = $this->zeroesOnAccNumber->concatAccountNumbers($request->accountSmall,$request->accountLarge,$request->accountMini);
        $user = Auth::user();
        foreach($accountArray as $acc){
            $account = Account::create([
                'user_id' => $user->id,
                'account_no' => $acc,
            ]);
            $account->save();
        }
        return Redirect::to('user/myAccount');
    }

    public function getName(){
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);
        $data['name'] = $user['data'][0]['user']['name'];

        return response()->json(JsonResponse::response('success', $data, 'User name have been successfully submitted'), 200);
    }
}
