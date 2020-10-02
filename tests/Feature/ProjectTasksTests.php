<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Project;

class ProjectTasksTests extends TestCase
{
    use RefreshDatabase;
   

    public function guests_cannot_add_tasks_to_projects()
    {
        $project= factory('App\Project')->create();
        $this->post($project->path() .'/tasks')->assertRedirect('login');
    }

    public function a_project_can_have_tasks()
    {
        
        $this->signIn();

        $project= factory(Project::class)->create(['owner_id'=> auth()->id()]);

        $this->post($project->path() .'/tasks', ['body' => 'Test Task']); //When this end point is reached a new task (body =>Test task) will be added to the project

        $this->get($project->path())
            ->assertSee('Test Task');

    }

    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project= factory(Project::class)->create(['owner_id'=> auth()->id()]);

        $attributes= factory('App\Task')->raw(['body'=>'']); // we are calling task factory

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
