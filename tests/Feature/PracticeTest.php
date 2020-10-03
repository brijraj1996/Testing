<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PracticeTest extends TestCase
{
    use WithFaker,RefreshDatabase;

     /** @test */
    public function guests_cannot_create_project()
    {
        
        
        $attributes=factory('App\Project')->raw();
        $this->post('/projects',$attributes)->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_projects()
    { 
    
        $this->post('/projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_single_project()
    {
        $project= factory('App\Project')->create(); 
    
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function testExample()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $attributes=[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph,
        ]; 

        $this->post('/projects', $attributes);

        $this->assertDatabaseHas('projects',$attributes);

         $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->be(factory('App\User')->create());

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
        $this->be(factory('App\User')->create());
        

        // $this->withoutExceptionHandling();
        
        $project= factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);

     }


    /** @test */
    public function check_the_title()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes =factory('App\Project')->raw(['title'=>'']);
        $this->post('/projects',$attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function check_the_description()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes=factory('App\Project')->raw(['description'=>'']);
        $this->post('/projects',$attributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project= factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);
    }
}