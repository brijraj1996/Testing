<?php

namespace App\Http\Controllers;
use App\Project;

use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        if(auth()->user()!=($project->owner))
        {
            abort(403);
        }

        request()->validate(['body' => 'required']);

        $project->addTask(request('body')); // we are passing body to the post request in the ProjectTasksTest

        return redirect($project->path());

    }
}
