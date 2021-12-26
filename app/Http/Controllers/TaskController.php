<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\FileProcess;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

use Validator;

class TaskController extends Controller
{

    public function create()
    {
        $types = Type::get();
        return view('tasks.create')->with(['types'=>$types]);
    }

    public function store(Request $request)
    {
        error_reporting(0);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10|min:10',
            'file' => 'required|max:50000|mimes:txt',
        ]);


        if ($validator->fails())
            return response()->json(["errors"=>$validator->getMessageBag()->toArray()]);

        $valid = $this->validateProjectName($request->input('name'));
        if(!$valid)
            return response()->json(["errors"=>"PRJ_ + 6 uppercase characters"]);

        $file = $request->file('file');
        $destinationPath = 'uploads';
        $file->move($destinationPath,$file->getClientOriginalName());

        FileProcess::dispatch($request->input('name'), $request->input('type'), $file->getClientOriginalName());

        return response()->json($valid);
    }

    protected function validateProjectName($name)
    {
        $nameParts = explode("_", $name);
        if(is_array($nameParts) && count($nameParts) != 2){
            return false;
        }
        else{
            if($nameParts[0]!="PRJ")
                return false;
            if(strlen($nameParts[1]) != 6 )
                return false;
            if(!ctype_upper($nameParts[1]))
                return false;
        }
        return true;
    }
    
}
