<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Project;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
   
    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project= factory('App\Project')->create();
        $this->post($project->path() .'/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_owner_of_a_project_may_add_tasks()
    {
    
        $this->signIn(); //we get a signed in user
        $project= factory('App\Project')->create(); //we get a project created by somebody who is not a signed in user.
        $this->post($project->path() .'/tasks', ['body' => 'Test Task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Title task']);
        
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project= factory(Project::class)->create(['owner_id'=> auth()->id()]);

        $this->post($project->path() .'/tasks', ['body' => 'Test Task']); //When this end point is reached a new task (body =>Test task) will be added to the project

        $this->get($project->path())
            ->assertSee('Test Task');
    }

     /** @test */
    public function only_owner_of_a_project_may_update_a_task()
    {
    
        $this->signIn(); //we get a signed in user
        $project= factory('App\Project')->create(); //we get a project created by somebody who is not a signed in user.
        $task = $project->addTask('Test Task');
        $this->patch($task->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
        
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        // $project= factory(Project::class)->create(['owner_id'=> auth()->id()]);
        $project =auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task= $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id,[
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project= factory(Project::class)->create(['owner_id'=> auth()->id()]);

        $attributes= factory('App\Task')->raw(['body'=>'']); // we are calling task factory

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
