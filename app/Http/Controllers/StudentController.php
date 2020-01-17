<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Student,Career,License};
use App\Binnacle;
use App\Mail\LicenseCallReceived;
use QrCode;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return view('students.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = Career::all();
        return view('students.create',compact('careers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identity'      =>  'required|unique:students',
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'gender'        =>  'required',
            'email'         =>  'required|unique:students',
            'phone'         =>  'nullable',
            'photoAvatar'   =>  'required',
            'canvas'        =>  'required'
        ])->validate();

        $code_career = explode('-', $request->career_id);
        $career = Career::where('code',$code_career)->first();

        $student = Student::create([
            'identity'      =>  $request->identity,
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name,
            'gender'        =>  $request->gender,
            'email'         =>  $request->email,
            'phone'         =>  (!is_null($request->phone))?$request->phone:NULL,
            'photo'         =>  $request->photoAvatar,
            'photo_license' =>  $request->photoAvatarBlob,
            'photo_license_2'=>  $request->canvas,
        ]);        
        
        $student->careers()->attach($career->id);
        
        $binnacle = Binnacle::create([
            'action' => 'Registro Exitoso!',
            'identity' => $request->identity,
            'user_id' => \Auth::user()->id,
        ]);

        return $request->file('photoAvatarBlob');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
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
        $photo = Student::select(['photo_license_2','first_name','last_name'])->where('identity',$id)->first();
        return $photo;
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

    // METODO PARA BUSCAR LA FOTO DE ESTUDIANTE
    public function searchPhoto($id)
    {
        $photo = Student::select(['photo','first_name','last_name'])->where('identity',$id)->first();
        return $photo;
    }
    // METODO PARA BUSCAR LA FOTO DE ESTUDIANTE

    
}
