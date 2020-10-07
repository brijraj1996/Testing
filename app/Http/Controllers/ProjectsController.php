<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        
        $projects= auth()->user()->projects;
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
        //validate:
        $attributes = request()->validate([
                'title' => 'sometimes|required', 
                'description' => 'sometimes|required|max:100',
                'notes' => 'nullable'
            ]);
            
        $project= auth()->user()->projects()->create($attributes);    
            
        // persist:

        return redirect($project->path());
    }
    
    public function create()
    {
        return view('project.create');
    }

    public function update(Project $project)
    {
        if(auth()->user()->isNot($project->owner)) 
        {
            abort(403);
        }
        
        $attributes = request()->validate([
                'title' => 'sometimes|required',
                'description' => 'sometimes|required',
                'notes' => 'nullable'
            ]);
        
        $project->update($attributes);
   
        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('project.edit',compact('project'));
    }
}
