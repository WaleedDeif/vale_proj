<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use Validator;

class ProjectController extends Controller
{

    public function index()
    {
        // 
        $projects = Project::all();
        $tasks = Task::selectRaw('project_id,type_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('types', 'types.id', '=', 'tasks.type_id')
            ->groupBy('project_id')
            ->groupBy('type_id')
            ->get();

        return view('projects.index')->with(['projects'=>$projects,"tasks"=>$tasks]);
    }

    public function show($id)
    {
        //
        $project = Project::findOrFail($id);
        return view('projects.show')->with(['project'=>$project]);
    }
    
}
