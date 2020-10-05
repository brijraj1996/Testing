<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Project;

class PracticeTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
    public function guests_cannot_manage_projects()
    {
        
        $project= factory('App\Project')->create(); 
      
        $this->post('/projects',$project->ToArray())->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects')->assertRedirect('login');
        $this->get($project->path().'/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes=[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->sentence,
            'notes' => 'General note here.'
        ]; 

        $response =$this->post('/projects', $attributes);

        $project= Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects',$attributes);

         $this->get($project->path())
         ->assertSee($attributes['title'])
         ->assertSee($attributes['description'])
         ->assertSee($attributes['notes']);
    }

    /** @test */
    public function user_can_update_a_project()
    {
       
        $this->signIn();
        
        $project= factory('App\Project')->create(['owner_id' =>auth()->id()]);

        $this->patch($project->path(), $attributes=['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
        ->assertRedirect($project->path());

        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects',$attributes);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->signIn();

        $this->withoutExceptionHandling();
        
        $project= factory('App\Project')->create(['owner_id' =>auth()->id()]);

        $this->get($project->path())
            ->assertOk()
            ->assertSee($project->title)
            ->assertSee($project->description); 
    }

     /** @test */
     public function an_authenticated_user_cannot_view_the_projects_of_others()
     {
        // $this->be(factory('App\User')->create());
        $this->signIn();
        

        // $this->withoutExceptionHandling();
        
        $project= factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);

     }


    /** @test */
    public function check_the_title()
    {
       $this->signIn();
        $attributes =factory('App\Project')->raw(['title'=>'']);
        $this->post('/projects',$attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function check_the_description()
    {
        $this->signIn();
        $attributes=factory('App\Project')->raw(['description'=>'']);
        $this->post('/projects',$attributes)->assertSessionHasErrors('description');
    }


   
}