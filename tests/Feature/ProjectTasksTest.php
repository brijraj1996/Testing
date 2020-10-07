<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Project;
use App\User;
// use Facades\Tests\Setup\ProjFactory;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
   
    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project= factory('App\Project')
            ->create();

        $this->post($project->path() .'/tasks')
            ->assertRedirect('login');
    }

    /** @test */
    public function only_owner_of_a_project_may_add_tasks()
    {
    
        $this->signIn(); //we get a signed in user

        // $project= ProjFactory::withTasks(1)->create();

        $project= factory('App\Project')
            ->create(); //we get a project created by somebody who is not a signed in user.

        $this->post($project->path() .'/tasks', ['body' => 'Test Task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Title task']);
        
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project= ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() .'/tasks', ['body' => 'Test Task']);    //When this end point is reached a new task (body =>Test task) will be added to the project

        $this->get($project->path())
            ->assertSee('Test Task');
    }

     /** @test */
    public function only_owner_of_a_project_may_update_a_task()
    {
    
        $this->signIn(); //we get a signed in use

        $project= ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
        
    }

    /** @test */
    public function a_task_can_be_updated()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),[
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
        $project = ProjectFactory::create();

        $attributes= factory('App\Task')->raw(['body'=>'']); // we are calling task factory

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }
}
