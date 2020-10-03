<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function it_belongs_to_a_project()
    {
        $task= factory(Task::class)->create();
        $this->assertInstanceOf(Project::class,$task->project);
    }


    public function it_has_a_path()
    {
        $task= factory(Task::class)->create();
        $this->assertEquals('/project/' . $task->project->id . '/tasks/' . $task->id, $task->path());

    }
}
