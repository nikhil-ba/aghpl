<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Event_type;

class EventController extends Controller
{
    public function insertEvents(Request $request){
    	$data = array();
    	if(isset($request->action) && $request->action == 'edit'){
    		$title = 'Edit Event type';
    		$result = Event_type::where('id',$request->id)->get();

    		$myArray = json_decode(json_encode($result), true);
    		
    		$data['id'] = $myArray[0]['id'];
    		$data['event_name'] = $myArray[0]['event_name'];
    		$data['event_duration'] = $myArray[0]['event_duration'];
    	}else{
    		$title = 'Add Event type';
    		$data['event_name'] = '';
    		$data['event_duration'] = '';
    	}

    	$data['title'] = $title;
    	return view('events.insert',$data);
    }

    public function deleteEvents(Request $request){
        $data = array();
        $data['id'] = $request->id;
        return view('events.delete',$data);
    } 
}
