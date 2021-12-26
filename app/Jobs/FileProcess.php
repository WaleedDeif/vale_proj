<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Task;
use App\Models\Project;
use App\Models\Type;

class FileProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $request;
    protected $projectName;
    protected $taskType;
    protected $file;
    protected $count;

    public function __construct($projectName, $taskType, $file)
    {
        //
        $this->projectName = $projectName;
        $this->taskType = $taskType;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // check if project exists
        $projectExist = $this->checkIfProjectExists($this->projectName);
        if(!$projectExist){
            $project = new Project();
            $project->name = $this->projectName;
            $project->save();
        }
        
        $projectId = $project->id ?? $projectExist ;
        // update project to has running task 
        $project = Project::find($projectId);
        $project->hasRunningTask = 1;
        $project->save();

        // insert new task
        $task = new Task();
        $task->project_id = $projectId;
        $task->type_id =  $this->taskType;
        $task->count = 0;
        $task->status = 0;        
        $task->save(); 

        $type = $this->getTaskType($this->taskType);
        $myfile = fopen(public_path()."/uploads/".$this->file, "r") or die("Unable to open file!");
        $linesCount = 0;
        $words = 0;
        $chars = 0;

        if($type == "Count Lines"){
            while(!feof($myfile)) {
                $line = trim(fgets($myfile));
                $linesCount++;
            }
            $this->count = $linesCount;
        }

        elseif($type == "Count Words"){
            while(!feof($myfile)) {
                $line = trim(fgets($myfile));
                $arr = explode(" ", $line);
                $words += count($arr);
            }
            $this->count = $words;
        }

        elseif ($type == "Count Characters") {
           while(!feof($myfile)) {
                $line = trim(fgets($myfile));
                $chars += strlen($line);
            } 
            $this->count = $chars;
        }

        fclose($myfile);

        // update the task status at the end of the process
        $task = Task::find($task->id);
        $task->status = 1;
        $task->count = $this->count;
        $task->ended = $this->count;
        $task->save();

        // update project that has no running tasks
        $project = Project::find($projectId);
        $project->hasRunningTask = 0;
        $project->save();
    }

    function getTaskType($id){
        return Type::where('id',$id)->value('name');
    }

    function checkIfProjectExists($name)
    {
        return Project::where('name',$name)->value('id');
    }
}
