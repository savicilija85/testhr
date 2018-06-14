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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function saveIdCardsImages(Request $request){
        $data = $request->all();
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);
        $data['username'] = $user['data'][0]['user']['username'];
        $validator = Validator::make($data,[
            'id_card_image_front' => 'required|file|mimes:jpg,jpeg,JPG,JPEG,png,PNG',
            'id_card_image_back' => 'required|file|mimes:jpg,jpeg,JPG,JPEG,png,PNG',
            'id_card_image_selfie' => 'required|file|mimes:jpg,jpeg,JPG,JPEG,png,PNG',
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            return response()->json(JsonResponse::response('invalidrequest',[] , $errors->first()), 400);
        }
        try{
            $idCardImageFront = $request->file('id_card_image_front');
            $idCardImageFrontFilename = $data['username'] . '-front' . '.' . $idCardImageFront->getClientOriginalExtension();
            $idCardImageFrontPath = 'uploads/id_cards/'. $data['username'] . '/';
            Storage::disk('ftp')->putFileAs($idCardImageFrontPath, $idCardImageFront, $idCardImageFrontFilename);

            $idCardImageBack = $request->file('id_card_image_back');
            $idCardImageBackFilename = $data['username'] . '-back' . '.' . $idCardImageBack->getClientOriginalExtension();
            $idCardImageBackPath = 'uploads/id_cards/'. $data['username'] . '/';
            Storage::disk('ftp')->putFileAs($idCardImageBackPath, $idCardImageBack, $idCardImageBackFilename);

            $idCardImageSelfie = $request->file('id_card_image_selfie');
            $idCardImageSelfieFilename = $data['username'] . '-selfie' . '.' . $idCardImageSelfie->getClientOriginalExtension();
            $idCardImageSelfiePath = 'uploads/id_cards/'. $data['username'] . '/';
            Storage::disk('ftp')->putFileAs($idCardImageSelfiePath, $idCardImageSelfie, $idCardImageSelfieFilename);

            $userDb = User::find($user['data'][0]['user']['id']);
            $userDb->id_card_path_front = $idCardImageFrontPath . $idCardImageFrontFilename;
            $userDb->id_card_path_back = $idCardImageBackPath . $idCardImageBackFilename;
            $userDb->id_card_path_selfie = $idCardImageSelfiePath . $idCardImageSelfieFilename;
            $userDb->verified = 'uploaded';
            $userDb->save();

            return response()->json(JsonResponse::response('success', [], 'Slike su uspesno uploudovane'), 200);

        } catch (\Exception $e){
            return response()->json(JsonResponse::response('error', [], $e->getMessage()), 500);
        }
    }

    public function getVerifiedStatus(){
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);
        $user = User::find($user['data'][0]['user']['id']);

        return response()->json(JsonResponse::response('success', $user->verified, ''), 200);
    }
}
