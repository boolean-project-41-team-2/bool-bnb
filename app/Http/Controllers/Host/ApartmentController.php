<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Apartment;
use App\Models\Feature;
use Illuminate\Support\Facades\Storage; 
use App\Models\Sponsorship;
use App\Models\Photo;
use App\User;

class ApartmentController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::where('user_id', Auth::user()->id)->orderBy('created_at','desc')->get();
      
        return view('host.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apartment = new Apartment();
        $sponsorships = Sponsorship::all();
        $features = Feature::all();
        $featureIds = $apartment->features->pluck('id')->toArray();
        $sponsorshipIds = $apartment->sponsorships->pluck('id')->toArray();

        return view('host.apartments.create', compact('apartment', 'sponsorships', 'features', 'featureIds','sponsorshipIds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = request()->all();
        $data['user_id'] = Auth::user()->id;
   
       /*  $data['image_thumb'] = Storage::put('apartments/images',$data['image_thumb']); */
        $apartment=  Apartment::create($data);
       
        $apartment->save();
       /*  if($request->hasfile('image_thumb'))
     {
        foreach($request->file('image_thumb') as $file)
        {
            $name = time().'.'.$file->extension();
            $file->move(public_path().'/files/', $name);  
            $data[] = $name;  

        }
     }
     $file= new Photo();
     $file->image_thumb=json_encode($data);
     $file->save(); */

        if(array_key_exists('features', $data)) $apartment->features()->sync($data['features']);
        if(array_key_exists('sponsorships', $data)) $apartment->sponsorships()->sync($data['sponsorships']);

        return redirect()->route('host.apartments.index', compact('apartment'));
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('host.apartments.show', compact('apartment'));
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
