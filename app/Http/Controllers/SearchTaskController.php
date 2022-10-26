<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Interfaces\SearhableInterface;

class SearchTaskController extends Controller
{
    public function search(Request $request) {
        $keyWord = $request->keyword;
        $tasks = Task::where('title', 'LIKE', '%' . $keyWord . '%' )->orWhere('difficulty', 'LIKE', '%' . $keyWord . '%')->orWhere('reward', 'LIKE', '%' . $keyWord . '%')->get(); 
        if($tasks){
            return view('results')->with('tasks', $tasks);
        }
        return 'Something went wrong';
    }
}
