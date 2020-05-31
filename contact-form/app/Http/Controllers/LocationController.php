<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LocationMaster;
use Excel;
use Response;
use DB;
use App\Http\Controllers\MailController;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$locations = LocationMaster::all();
        return view('location.index',compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $file= public_path(). "/files/location.xlsx"; 
		ob_end_clean(); // this
		ob_start(); // and this
		return Response::download($file, 'location.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			$this->validate($request, [
              'select_file'  => 'required'
             ]);

            $extension = $request->file('select_file')->getClientOriginalExtension();
			$path = $request->file('select_file')->getRealPath();
			if($extension == 'csv'){
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			}
			else{
				//echo "Invalid File";
				return redirect('location')->with('Success', 'Invalid File .csv Format Only Allowed');
				die();
			}
			$reader->setReadDataOnly(TRUE); 
			$data = $reader->load($path); 
			$worksheet = $data->getActiveSheet();
			DB::beginTransaction();
			$rowcount = 0;
			$location_to_mail = '';
			try{
				foreach ($worksheet->getRowIterator() as $row) {
					$rowcount++;
																		

					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(FALSE); 
					
					$Location = $worksheet->getCellByColumnAndRow(1, $rowcount)->getValue();
					
					
					if($rowcount == 1){
						if( strtoupper($Location) != 'LOCATIONNAME'){
							//echo "Go back And check Heading Name";
							return redirect('location')->with('Success', 'Go back And check Heading Name');
							die();
						}
					}
					
					if($rowcount != 1){         
						$location_to_mail = $location_to_mail.','.$Location;
						$insert_data[] = array(
						 'location_name'  => $Location,
						 'created_at'=>now(),
						);
					   
					}
				}
				if(!empty($insert_data))
				{
					LocationMaster::insert($insert_data);
					DB::COMMIT();
				}
			 
             }
			 catch(Exception $e){
				//echo "Some thing Went Wrongs";
				return redirect('location')->with('Success', 'Some thing Went Wrongs.');
				DB::rollback();
				report($e);
				return false;
			 }
			 $mail = config('mail.from.address');
			 $data = "New Locations Added Locations are ".$location_to_mail;
			 MailController::basic_email($mail,$data);
             return redirect('location')->with('Success', 'Excel Data Imported successfully.');
	}
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function locationUpdate (request $request){
		//echo $request->location_id;
		
		
		$LocationMaster = LocationMaster::find($request->location_id);
		
		$location_old  =  $LocationMaster->location_name;
		$location_new  =  $request->location_name;
		$LocationMaster->location_name = $request->location_name;
		$LocationMaster->updated_at = now();
		$LocationMaster->save();
		
		$mail = config('mail.from.address');
		$data = "Locations  ".$location_old." Changed To ".$location_new;
		MailController::basic_email($mail,$data);
			 
		return back();
	}
    public function getLocationDataById(request $request)
    {
          return $location = LocationMaster::find($request->id);
		//return view('location.edit',compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
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
    public function LocationDelete(Request $request)
    {
		
        $location = LocationMaster::find($request->id);
		$location_name = $location->location_name;
		$location->delete();
		$mail = config('mail.from.address');
		$data = "Locations ".$location_name." Deleted";
		MailController::basic_email($mail,$data);
		
		return back();
    }
	
		
}
