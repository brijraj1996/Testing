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
         #validate
         $attributes=request()->validate([
             'title'=>'required', 
            'description'=>'required|max:100',
            'notes'=>'min:3'
            ]);
            
        // $project= $attributes['owner_id']=auth()->id();

        $project= auth()->user()->projects()->create($attributes);    
            
        #persist
       
        // Project::create(request([$attributes]));

        
        #return
        return redirect($project->path());
          

    }
    
    public function create()
    {
        
        return view('project.create');
    }

    public function update(Project $project)
    {
        
        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        
        $attributes=request()->validate([
            'title'=>'required', 
           'description'=>'required|max:100',
           'notes'=>'min:3'
           ]);
           

        $project->update($attributes);
   
        return redirect($project->path());
        
    }

    public function edit(Project $project)
    {
        return view('project.edit',compact($project));
    }
}
