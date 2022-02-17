<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

/**
 * used to perform all CRUD for general database tables
 */
class General extends Controller {

    public $table;
    public $TokenAPI = 'c3c067a65948d99055ab1ac60891c174';
    public $projectID = '2553591';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }
    public $server_ip = 'http://75.119.140.177:8081';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->data['breadcrumb'] = array('title' => 'Phone Calls','subtitle'=>'customer service','head'=>'operations');
        $this->data['phone_calls'] =  \App\Models\PhoneCall::latest()->get();

       $this->data['missed_calls'] =  \collect(DB::SELECT("select count(*),to_char(created_at::date,'Month') as month,extract(year from created_at::date) as year from admin.phone_calls where call_type = 'Missed' group by created_at::date"))->first();
       

       $url = 'https://www.pivotaltracker.com/services/v5/projects?token='.$this->TokenAPI.'';
       $this->data['projectdata'] = $this->get($url);
       $str = "https://www.pivotaltracker.com/services/v5/projects/$this->projectID/stories?filter=state:delivered,finished,rejected,started,unstarted,unscheduled&token=$this->TokenAPI";
       $this->data['stories'] = $this->get($str);

        return view('general.index', $this->data);
    }
//https://www.pivotaltracker.com/services/v5/projects/2553591/stories?token=c3c067a65948d99055ab1ac60891c174&filter=state:delivered,finished,rejected,started,unstarted,unscheduled

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $url = 'https://www.pivotaltracker.com/services/v5/projects?token='.$this->TokenAPI.'';
        $this->data['projectdata'] = $this->get($url);
        $str = "https://www.pivotaltracker.com/services/v5/projects/$this->projectID/stories?token=$this->TokenAPI";
        $this->data['stories'] = $this->get($str);
       return view('general.minutes', $this->data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stories() {
        // export TOKEN='your Pivotal Tracker API token'

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"name":"Exhaust ports are ray shielded 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"after_id":555,"before_id":567,"name":"Replace the lining in Darth Vader's helmet"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"current_state":"accepted","estimate":1,"name":"Exhaust ports are ray shielded 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"description":null,"name":"Exhaust ports are ray shielded 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"comments":[{"text":"Just ray shielding? What about proton weapons?"}],"name":"Exhaust ports are ray shielded 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories?fields=%3Adefault%2Ccomments"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"comments":[{"text":"Make sure the stamp on the latest shipment of seals matches the new Imperial logo (attached).","file_attachments":[{"type":"file_attachment","id":20,"filename":"empire.png","created_at":1644321600000,"uploader_id":100,"thumbnailable":true,"height":804,"width":1000,"size":82382,"download_url":"/attachments/0000/0020/empire_big.png","thumbnail_url":"/attachments/0000/0020/empire_thumb.png"}]}],"name":"replace seals on trash compactors","story_type":"chore"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"


        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"label_ids":[2008],"name":"Exhaust ports are ray shielded 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"labels":["plans","Inspected by TK-421"],"name":"Exhaust ports are ray shielded 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"labels":["Inspected by TK-421",{"id":2009,"name":"plans"},{"name":"mnt"}],"name":"Exhaust ports are ray shielded 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"
    /*Bulk*/
  //  curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/bulk?ids=552%2C553%2C2%2C0"
    
}
    
    public function singlestory() {
        // export TOKEN='your Pivotal Tracker API token'

        // export PROJECT_ID=99
        
        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"labels":[{"name":"newnew"},{"name":"labellabel"},{"id":2011}]}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/555"
        
        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"labels":["no life signs","look sir metal"]}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/555"
        
        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"labels":[]}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/555"
        
        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"before_id":556,"current_state":"started","estimate":1}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/567"
     
        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"current_state":"accepted","estimate":1,"name":"Exhaust ports have ray shielding 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/555"
        
        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"after_id":568,"before_id":null,"group":"scheduled","project_id":98}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/555"
    
    
        }

    public function storyFilter() {
        $url = "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories?date_format=millis&filter=label%3Aplans";
        
    }

    public function createStory() {
        // export TOKEN='your Pivotal Tracker API token'

        // export PROJECT_ID=99
        
        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"current_state":"started","estimate":1,"name":"Exhaust ports are ray shielded 👹"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories"

        
    }
    public function updateStory() {
        // export TOKEN='your Pivotal Tracker API token'
 
         // export PROJECT_ID=99
 
         //curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"description":"I want them alive. Bring them to me in order of seniority. Don't miss anyone!"}'
         // "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/555"
     }
 
     public function addCommentStory() {
        // export TOKEN='your Pivotal Tracker API token'
        // export PROJECT_ID=99
        // export STORY_ID=555
        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"text":"If this is a consular ship, then where is the ambassador 👅?"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments"

        /* With Attachment */
        // export FILE_PATH='/home/vader/art-projects/new-imperial-logo-6.jpg'
        // curl -X POST -H "X-TrackerToken: $TOKEN" -F file=@"$FILE_PATH" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/uploads"
        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments"
        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"text":"If this is a consular ship, then where is the ambassador 👅?"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"text":"If this is a consular ship, then where is the ambassador 👅?"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments"


        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"commit_identifier":"abc123","commit_type":"github"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments?fields=commit_identifier"


        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"person_id":104,"text":"Blame the clone for saying this."}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments"

        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"file_attachments":[{"id":24,"kind":"file_attachment","filename":"empire.png","size":82382,"width":1000,"height":804,"uploader_id":100,"thumbnail_url":"/attachments/0000/0024/empire_thumb.png","thumbnailable":true,"uploaded":true,"download_url":"/attachments/0000/0024/empire_big.png","created_at":"2022-02-08T12:00:00Z","content_type":"image/png"}],"text":"What if this were our new sigil?"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments?fields=%3Adefault%2Cfile_attachment_ids"

        // curl -X DELETE -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments/109"


        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments/109"
        
        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"text":"updated comment text"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments/109"

        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"file_attachment_ids_to_add":[21]}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments/109?fields=%3Adefault%2Cfile_attachments"

        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"file_attachment_ids_to_remove":[21]}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments/112?fields=%3Adefault%2Cfile_attachments"


        // curl -X PUT -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"google_attachment_ids_to_remove":[50]}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/comments/112?fields=%3Adefault%2Cgoogle_attachments"
     }
 
     public function deleteStory() {
       // export TOKEN='your Pivotal Tracker API token'

       // export PROJECT_ID=99
        
       // curl -X DELETE -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/555"
     }
 
    
    public function getProject() {
       // export TOKEN='your Pivotal Tracker API token'

       // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/99"
    }

   
    public function getTasks($id) {
        // export TOKEN='your Pivotal Tracker API token'

       // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/1/stories/42/tasks
    
       //filter_has_var If the request had instead been executed using the fields parameter, like GET 
        // /services/v5/projects/1/stories/42/tasks?fields=description,complete, then the response would have been:
        // GET /services/v5/projects/1/stories/42?fields=name,description,story_type,requested_by,owned_by,label_ids,comments,tasks could produce the following reply:
        
        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/tasks"
        
        
        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"description":"port 270"}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/tasks"
      
        // curl -X POST -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" -d '{"complete":true,"description":"port 270","position":1}' "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/tasks"
        // curl -X DELETE -H "X-TrackerToken: $TOKEN" -H "Content-Type: application/json" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/tasks/5"
   
    }

   
    public function memberships($id) {
      //  export TOKEN='your Pivotal Tracker API token'

      //  export PROJECT_ID=99
        
      //  curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/memberships"
    }

    public function projectMember(){
        // export TOKEN='your Pivotal Tracker API token'

        // export PROJECT_ID=99

        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/memberships/102"
    }
   
    public function myProfile($id) {
        // export TOKEN='your Pivotal Tracker API token'

        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/me?fields=%3Adefault"
    }

   
    public function notifications($id) {
        // export TOKEN='your Pivotal Tracker API token'

        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/my/notifications?envelope=true"

    }

   
    public function projects($id) {
       // export TOKEN='your Pivotal Tracker API token'

       // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects"
        
      //  curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects?account_ids=100"
    }

       
    public function iterations($id) {
        // export TOKEN='your Pivotal Tracker API token'

        // export PROJECT_ID=99
        
        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/iterations?limit=10&offset=1"
    
     }

       
     public function labels($id) {
        // export TOKEN='your Pivotal Tracker API token'

        // export PROJECT_ID=99

        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/labels?date_format=millis"

        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/labels?date_format=millis&with_type=epic"

        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/labels?date_format=millis&with_status=active"
        
        /* label ID */
        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/labels/2015"


     }

       
     public function storyLable($id) {
        // export TOKEN='your Pivotal Tracker API token'

        // export PROJECT_ID=99
        
        // export STORY_ID=556
        
        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/stories/$STORY_ID/labels"
        
        
     }

       
     public function releases($id) {
        // export TOKEN='your Pivotal Tracker API token'

        // export PROJECT_ID=99
        
        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/releases"
        
        // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/releases?with_state=accepted"

        /* Release ID */
       // curl -X GET -H "X-TrackerToken: $TOKEN" "https://www.pivotaltracker.com/services/v5/projects/$PROJECT_ID/releases/552"
     }



	
	public function get($url){

		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                                                                    
		$result = curl_exec($ch);
		return $result;
	}

	public function post($url, $data_string){
        $fields_string = http_build_query($data_string);
        //open connection
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        //execute post
        $result = curl_exec($ch);
		return $result;
	}

	public function put($url, $data_string){

		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
		curl_setopt($ch, CURLOPT_FAILONERROR, true);                                                                    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		 
		$result = curl_exec($ch);
		return $result;
	}

	public function delete($url, $data_string){

		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
		curl_setopt($ch, CURLOPT_FAILONERROR, true);                                                                    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		 
		$result = curl_exec($ch);
		return $result;
	}


    public function roadTask(){
        $id = request('story_id');
     
       $story_url = 'https://www.pivotaltracker.com/services/v5/projects/'.$this->projectID.'/stories/'.$id.'?token='.$this->TokenAPI;
       $url =  'https://www.pivotaltracker.com/services/v5/projects/'.$this->projectID.'/stories/'.$id.'/tasks?token='.$this->TokenAPI;
    $story = json_decode($this->get($story_url));
    $tasks = json_decode($this->get($url));

    //Load all story comments
    $coment_url = 'https://www.pivotaltracker.com/services/v5/projects/'.$this->projectID.'/stories/'.$id.'/comments?token='.$this->TokenAPI;
    $comments = json_decode($this->get($coment_url));

    if($story){
        echo '<div class="modal-header">
                <p class="modal-title"><b>#' .$story->id. ' -' .$story->name. '('.$story->story_type.')</b></p>
            </div>
        <div class="modal-body">';
      
      echo isset($story->description) ? '<p>'. $story->description . '</p>' : '';

      echo '<p> <strong>Current State - '.$story->current_state.'</strong></p>';
        if($tasks){
            echo '<h5><b>List of Tasks</b></h5>';
            echo '<ol>';
            foreach ($tasks as $key => $value) {
             if($value->complete == true){
                echo  isset($value->description) ? '<li> <strike><strong>'.  $value->description .'. </strike></strong> Resolve - '.timeAgo($value->updated_at).'</li>' : '';
             }else{
                echo  isset($value->description) ? '<li><strong>'.  $value->description .'.</strong> Added - '.timeAgo($value->created_at).'</li>' : '';
             }
            }
        echo '</ol>';
        if($comments){
            echo '<h5><b>List of Story Comments</b></h5>';
            echo '<ol>';
                foreach ($comments as $key => $value) {
                    echo  isset($value->text) ? '<li> <strong>'.  $value->text .'. </strong> Added - '.timeAgo($value->created_at).'</li>' : '';
            }
            echo '</ol>';
        }
    }
    echo '<hr><div class="col-sm-12" id="showcomment">
            <textarea rows="3" minlength="30" id="storycomment" class="form-control" placeholder="add new task comment" name="text"></textarea>
        <button onmousedown="send_storycomment('. $story->id.')" class="btn btn-primary waves-light">Save Comment</button>
    </div>';
    echo '<div style="display: none" id="sentcomment">Comment submited</div>';
    echo '</div>';
    }
}

public function postComment(){
        $id = request('story_id');
        $comment = request('text'); 
        $fields = [
            "token"  => "c3c067a65948d99055ab1ac60891c174",
            "text" => Auth::User()->name .' - '. $comment
        ];
        //Post story comments
        $coment_url = 'https://www.pivotaltracker.com/services/v5/projects/'.$this->projectID.'/stories/'.$id.'/comments?token='.$this->TokenAPI;
       $data1 = $this->post($coment_url, $fields);
       
}

}
