<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event_type;

class EventController extends Controller
{


	public function index(){
		$response = [];
		$result = Event_type::all();
		if($result){
			$response['error'] = 0;
			$response['success']  = true;
			$response['data'] = $result;
			$response_code = 200;
			return response()->json($response,$response_code);
		}else{
			$response['error'] = 1;
			$response['success']  = false;
			$response['message'] = "Data Not Found";
			$response_code = 400;
			return response()->json($response,$response_code);
		}
	}


    public function create(Request $request){
    	$response = [];
		$response_code = '';
    	if(isset($request->event_name) && isset($request->event_duration)){
    		$dur_array = explode(" ",$request->event_duration);
    		$request->event_duration = $dur_array[0];
    		//$event_type = Event_type::create($request->all());
    		$event = new Event_type;
    		$event->event_name = $request->event_name;
    		$event->event_duration = $dur_array[0];
    		$event_type = $event->save();
    		$response['error'] = 0;
			$response['success']  = true;
			$response['message'] = "Your event is created";
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

    public function update(Request $request){
    	$response = [];
		$response_code = '';
		if(isset($request->event_name) && isset($request->event_duration)){
			$dur_array = explode(" ",$request->event_duration);
			// Event_type::where('id',$request->id)->update(['event_name'=>$request->event_name,'event_duration'=>$request->event_duration]);
			$post = new Event_type;
			$post->exists = true;
			$post->id = $request->id; //already exists in database.
			$post->event_name = $request->event_name;
			$post->event_duration = $dur_array[0];
			$post->save();
		}else{
			$response['error'] = 1;
			$response['success']  = false;
			$response['message'] = "Invalid data";
			$response_code = 400;
			return response()->json($response,$response_code);
		}
    }

    public function delete(Request $request){
        $data = array();
        if($request->id != ''){
            $result = Event_type::where('id',$request->id)->delete();
            if($result){
                $response['error'] = 0;
                $response['success']  = true;
                $response_code = 200;
            }else{
                $response['error'] = 1;
                $response['success']  = false;
                $response_code = 404;
            }
        }else{
            $response['error'] = 1;
            $response['success']  = false;
            $response_code = 404;
        }
        return response()->json($response,$response_code);
    }
}
