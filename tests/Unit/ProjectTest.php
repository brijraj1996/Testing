<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\Project;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    public function it_has_a_path()
    {
       
        $project=factory('App\Project')->create();

        $this->assertEquals('/projects/',$project->path());

    }

    public function it_belongs_to_an_owner()
    {
        $project= factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);
    }

    public function it_can_add_a_task()
    {
        $project= factory('App\Project')->create();
        $task=$project->addTask('Test Task');
        $project=addTask('Test task');
        $this->assertCount(1, $project->tasks); //This ensures that atleast one task should be there in the project.
        $this->assertTrue($project->tasks->contains($task));//This checks whether the task is actually Test Task or not.


    }


}
