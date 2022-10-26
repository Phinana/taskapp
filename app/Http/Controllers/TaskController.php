<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public $rowperpage = 1; // tek seferde çekilecek veri sayısı
    public function index(){
        $data['rowperpage'] = $this->rowperpage;
        $data['totalrecords'] = Task::select('*')->count();
        $data['tasks'] = Task::select('*') 
               ->skip(0) // burası ilk çalıştığı için skip 0 diyoruz
               ->take($this->rowperpage)
               ->get();

        return view('home', $data);
   }

   // kaç veri çekildiyse o kadar veri atlayıp veri alıyoruz
   public function getTasks(TaskRequest $request){
 
    $start = $request->get("start");

    // Fetch records
    $records = Task::select('*')
          ->skip($start)
          ->take($this->rowperpage)
          ->get();

     $html = "";
     // aldıklarımızı döngüyle html olarak yazıp yolluyoruz
     foreach($records as $record){
          $id = $record['id'];
          $title = $record['title'];
          $difficulty = $record['difficulty'];
          $reward = $record['reward'];

          $html .= '<div class="card w-75 post text-center '. $id .'element">
                <div class="card-body">
                     <h5 class="card-title">'.$title.'</h5>
                     <p class="card-text">'.$difficulty.'</p>
                     <p class="card-text">'.$reward.'</p>
                     <button value="'.$id.'" type="button" id="delete" data-bs-toggle="modal" data-bs-target="#deletemodal" class="btn btn-primary pull-right delete_button">Delete</button>
                    <button value="'.$id.'" type="button" id="add" data-bs-toggle="modal" data-bs-target="#addnew" class="btn btn-primary pull-right edit_button">Edit</button>
                </div>
           </div>';
      }

      $data['html'] = $html;

      return response()->json($data);
    }

    public function store(TaskRequest $request) {

        $task = Task::Create([
            'title' => $request->title,
            'difficulty' => $request->difficulty,
            'reward' => $request->reward
        ]);

        return redirect()->route('home_index');
    }

    public function destroy(Request $request) {
        $task=Task::find($request->taskId);
        $task->delete();

        return $task;
    }

    public function update(TaskRequest $request) {
        Task::find($request->id)->update([
            'title' => $request->title,
            'difficulty' => $request->difficulty,
            'reward' => $request->reward
        ]);
    }
}
