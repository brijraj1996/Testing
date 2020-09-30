<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects= Project::all();
        return view('project.index',compact('projects'));
    }


    public function show(Project $project)
    {
        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('project.show',compact('project'));
    }

    public function store()
    {
         #validate
         $attributes=request()->validate([
             'title'=>'required', 
            'description'=>'required',
            ]);

        $attributes['owner_id']=auth()->id();

        auth()->user()->projects()->create($attributes);    
        
          

        #persist
       
        // Project::create(request([$attributes]));

       
        #return
        return redirect('/projects');
    }
}
