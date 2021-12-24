<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\EditUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::get();
        return view('users.index',compact('data'));
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
        //
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
        $data = User::findOrFail($id);
        if($data->email != $request->email && $request->password == ""){
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }elseif($data->email != $request->email && $request->password!=""){
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed','regex:/[a-z]/','regex:/[A-z]/','regex:/[@$!%*#?&]/','regex:/[0-9]/'],
            ],
            [
                'password.regex' => 'Password must have 
                - one uppercase letter,
                    one lowercase letter,
                    one numeric value,
                    one special character (@$!%*#?&)'
            ]
        );
        }elseif($data->email == $request->email && $request->password != ""){
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed','regex:/[a-z]/','regex:/[A-z]/','regex:/[@$!%*#?&]/','regex:/[0-9]/'],
            ],
            [
                'password.regex' => 'Password must have 
                - one uppercase letter,
                    one lowercase letter,
                    one numeric value,
                    one special character (@$!%*#?&)'
            ]
        );
        }else{
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
            ]);
        }

        if($data->name != $request->name){
            $data->name=$request->name;
        }

        if($data->lastname != $request->lastname){
            $data->lastname=$request->lastname;
        }

        if($data->email != $request->email){
            $data->email=$request->email;
        }

        if($request->password!=""){
            $data->password=Hash::make($request->password);
        }
        $data->save();
        return redirect()->back()->with('message','Record updated successfully');

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
    public function createFile($id){
        $data = User::findOrFail($id);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $text = $section->addText($data->name);
        $text = $section->addText($data->lastname);
        $text = $section->addText($data->email);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('word'.$data->id.'.docx');
        return response()->download(public_path('word'.$data->id.'.docx'));
    }
}
