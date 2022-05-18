<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //$this->authorize('isAdmin');
        return User::latest()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'nom' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $newUser = new User();
        $newUser->nom = $request['nom'];
        $newUser->prenom = $request['prenom'];
        $newUser->CNE = $request['CNE'];
        $newUser->Matricule = $request['Matricule'];
        $newUser->Sex = $request['Sex'];
        $newUser->Date_naissance = $request['Date_naissance'];
        $newUser->Adresse = $request['Adresse'];
        $newUser->Telephone = $request['Telepone'];
        $newUser->Date_recrutement = $request['Date_recrutement'];
        $newUser->Intitule = $request['Intitule'];
        $newUser->email = $request['email'];
        $newUser->type = $request['type'];
        $newUser->bio = $request['bio'];
        $newUser->photo = $request['photo'];
        $newUser->password = Hash::make($request['password']);

        $newUser->save();
        // return User::create([
        //     'nom' => $request['nom'],
        //     'prenom' => $request['prenom'],
        //     'CNE' => $request['CNE'],
        //     'Matricule' => $request['Matricule'],
        //     'Sex' => $request['Sex'],
        //     'Date_naissance' => Carbon::parse($request['Date_naissance'])->setTimezone('GMT')->toDateString(),
        //     'Adresse' => $request['Adresse'],
        //     'Telephone' => $request['Telephone'],
        //     'Date_recrutement' => $request['Date_recrutement'],
        //     'Intitule' => $request['Intitule'],
        //     'email' => $request['email'],
        //     'type' => $request['type'],
        //     'bio' => $request['bio'],
        //     'photo' => $request['photo'],
        //     'password' => Hash::make($request['password']),
        // ]);
        return ['message' => "created"];

    }


    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();


        $this->validate($request,[
            'nom' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);


        $currentPhoto = $user->photo;


        if($request->photo != $currentPhoto){
            $nom = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$nom);
            $request->merge(['photo' => $nom]);

            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }

        }


        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->nom = $request['nom'];
        $user->prenom = $request['prenom'];
        $user->CNE = $request['CNE'];
        $user->Matricule = $request['Matricule'];
        $user->Sex = $request['Sex'];
        $user->Date_naissance = $request['Date_naissance'];
        $user->Adresse = $request['Adresse'];
        $user->Telephone = $request['Telepone'];
        $user->Date_recrutement = $request['Date_recrutement'];
        $user->Intitule = $request['Intitule'];
        $user->email = $request['email'];
        $user->type = $request['type'];
        $user->bio = $request['bio'];
        $user->photo = $request['photo'];
        $user->password = Hash::make($request['password']);

        $user->save();

       // $user->update($request->all());
        return ['message' => "Success"];
    }


    public function profile()
    {
        $user = User::findOrFail(Auth::id());
        return $user;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $this->validate($request,[
            'nom' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6'
        ]);

        $user->update($request->all());
        return ['message' => 'Updated the user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //$this->authorize('isAdmin');

        $user = User::findOrFail($id);
        // delete the user

        $user->delete();

        return ['message' => 'User Deleted'];
    }
}
