<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use App\Division;
use Illuminate\Support\Facades\Hash;

class ServController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->paginate(20);
        foreach($services as $service){
            $Chef_service =   User::findOrFail($service->Chef_Service); 
            $service->Chef_Service = $chef_service ? $chef_Service->nom." ".$chef_Service->prenom : '';

        }
        return $services;


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
        $this->validate($request,[
            'Service' => 'required|string|max:191',
            'Chef_service' => 'required',
        ]);


        $newService = new Service();
        $newService->Service = $request['service'];
        $newService->Chef_Service = $request['Chef_Service'];

        $newService->save();
        
        return ['message' => "created"];
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
        $service = Service::findOrFail($id);
        $this->validate($request,[
            'Service' => 'required|string|max:191',
            'Chef_Service' => 'required',
        ]);
        $newService->Service = $request['Service'];
        $newService->Chef_Service = $request['Chef_Service'];

        $newService->save();


        return ['message' => 'Updated the division info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        $service->delete();

        return ['message' => 'Service Deleted'];
    }
    public function UserServices(request $request){
        $userserv = User::all();
        $result = [];
       // $userdev = Division::all();
        foreach($userserv as $user){
            if(sizeof(Service::where('Chef_Service',$user->id)->get())==0)
            
             $result[] =  $user;
        }
 
         return ['data' => $result];
     }
}
    
     
