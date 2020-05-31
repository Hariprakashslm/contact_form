<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactForm;
use App\LocationMaster;
use App\Http\Controllers\MailController;
class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$locations = LocationMaster::select('id','location_name')->get();
		$ContactForm = ContactForm::all();
		
        return view('ContactForm.create',compact('locations','ContactForm'));
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
		
        $validatedData = $request->validate([
			'FirstName' => 'required|max:255',
			'LastName' => 'required|max:255',
			'Email' => 'required|email',
			'PhoneNumber' => 'required|max:10|min:10',
			'Location' => 'required',
		]);
		$email_count = ContactForm::where('Email', $request->Email)->count();
		if($email_count <= 1){
			ContactForm::insert([
				'FirstName' => $request->FirstName,
				'LastName' => $request->LastName,
				'Email' => $request->Email,
				'PhoneNumber' => $request->PhoneNumber,
				'Location' => $request->Location,
				'created_at' => now()
			]);
			
			$mail = config('mail.from.address');
			$data = "New Contact Added.";
			MailController::basic_email($mail,$data);


			return back()->with('Success','Data Successfully Updated');
		}
		else{
			return back()->with('Success','Failed Email Repeating');
		}
		
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
