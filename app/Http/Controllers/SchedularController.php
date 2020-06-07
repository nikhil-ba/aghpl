<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Appointment;
use App\Appointment_user;
use DB;

class SchedularController extends Controller
{
    public function index($id){
    	$result = User::where('id',$id)->get();
		$myArray = json_decode(json_encode($result), true);
	
    	$data = array();
    	$data['id'] = $myArray[0]['id'];
    	$data['name'] = $myArray[0]['name'];
    	return view('scheduler',$data);
    }

    public function appointment($name,$event_type,$duration,$id){
    	$data = array();
    	$data['name'] = $name;
    	$data['event_type'] = $event_type;
    	$data['duration'] = $duration;
    	$data['user_id'] = $id;
    	return view('appointment',$data);
    }

    public function insert_appointment(Request $request){
    	$response = [];
		$response_code = '';

    	if(isset($request->appoinment_date) && isset($request->time_slot) && isset($request->user_id) && isset($request->event_type)){
    		//$event_type = Event_type::create($request->all());
    		$event = new Appointment();
    		$event->appoinment_date = $request->appoinment_date;
    		$event->time_slot = $request->time_slot;
    		$event->user_id = $request->user_id; 
            $event->event_type = $request->event_type;
    		
    		$event_type = $event->save();

    		$response['last_inserted_id'] = $event->id;
    		$response['error'] = 0;
			$response['success']  = true;
			$response['message'] = "Appointment inserted successfully";
			$response['data'] = $event_type;
			$response_code = 201;
        	return response()->json($response,$response_code);
    	}else{
    		$response['error'] = 1;
			$response['success']  = false;
			$response['message'] = "Invalid data";
			$response_code = 400;
			return response()->json($response,$response_code);
    	}
    }

    public function appointment_user($name,$event_type,$duration,$selected_date,$timeslot,$last_inserted_id,$user_id){
    	$data = array();
    	$data['name'] = $name;
    	$data['event_type'] = $event_type;
    	$data['duration'] = $duration;
    	$data['selected_date'] = $selected_date;
    	$data['timeslot'] = $timeslot;
    	$data['last_inserted_id'] = $last_inserted_id;
        $data['user_id'] = $user_id;
    	return view('appointment_user',$data);
    }

    public function insert_appointment_user(Request $request){
        $response = [];
        $response_code = '';
        if(isset($request->appointment_id) && isset($request->fname) && isset($request->lname) && isset($request->email)){
            $event = new Appointment_user();
            $event->appointment_id = $request->appointment_id;
            $event->fname = $request->fname;
            $event->lname = $request->lname;
            $event->email = $request->email;
            if($event->save()){
                $response['error'] = 0;
                $response['success']  = true;
                $response['message'] = "Appointment users inserted successfully";
                $response_code = 201;
            return response()->json($response,$response_code);
            }else{
                $response['error'] = 1;
                $response['success']  = false;
                $response['message'] = "Unable to insert appointment users";
                $response_code = 400;
                return response()->json($response,$response_code);
            }
        }else{
            $response['error'] = 1;
            $response['success']  = false;
            $response['message'] = "Invalid data";
            $response_code = 400;
            return response()->json($response,$response_code);
        }
    }

    public function show_appointment_confirmed($name,$event_type,$selected_date,$timeslot,$message,$user_id){
        $data = array();
        $data['name'] = $name;
        $data['event_type'] = $event_type;
        $data['selected_date'] = $selected_date;
        $data['timeslot'] = $timeslot;
        $data['timeslot'] = $timeslot;
        $data['message'] = 'Confirmed';
        $data['user_id'] = $user_id;
        return view('appointment_confirm',$data);
    }

    public function getDistinctDate(){
      $response = [];
      $response_code = '';
      $result = Appointment::distinct()->get(['appoinment_date']);

      $result = DB::table('appointments')
                    ->join('appointment_users', 'appointment_users.appointment_id', '=', 'appointments.id')->
                    distinct()->get(['appointments.appoinment_date']);

      if($result){
        $response['data'] = $result;
        $response_code = 200;
        return response()->json($response,$response_code);
      }else{
        $response['error'] = 1;
        $response['success']  = false;
        $response['message'] = "No data available";
        $response_code = 200;
        return response()->json($response,$response_code);
      }
    }

    public function getEventByDate(Request $request){
        $response = [];
        $response_code = '';
        if($request->app_date){
            if(isset($request->app_type)){
                if($request->app_type == 'upcoming'){
                    $result = Appointment::where('appoinment_date', '>', \DB::raw('NOW()'))->get();

                    $result = DB::table('appointments')
                    ->join('appointment_users', 'appointment_users.appointment_id', '=', 'appointments.id')
                    ->where('appointments.appoinment_date', '>', \DB::raw('NOW()'))
                    ->get();
                    $app_type = $request->app_type;
                }

                if($request->app_type == 'past'){
                      $result = DB::table('appointments')
                    ->join('appointment_users', 'appointment_users.appointment_id', '=', 'appointments.id')
                    ->where('appointments.appoinment_date', '<', \DB::raw('NOW()'))
                    ->get();
                    $app_type = $request->app_type;
                }
                
                if($result){
                    $response['data'] = $result;
                    $response['app_type'] = $app_type;
                    $response_code = 200;
                    return response()->json($response,$response_code);
                }else{
                    $response['error'] = 1;
                    $response['success']  = false;
                    $response['message'] = "No data available";
                    $response_code = 200;
                    return response()->json($response,$response_code);
                }

            }else{
                $response['error'] = 1;
                $response['success']  = false;
                $response['message'] = "undefined appointment type";
                $response_code = 200;
                return response()->json($response,$response_code);
            }

        }else{
            $response['error'] = 1;
            $response['success']  = false;
            $response['message'] = "No data available";
            $response_code = 200;
            return response()->json($response,$response_code);
        }
    }


}
