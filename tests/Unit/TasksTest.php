<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

use App\Models\User;
use App\Models\Notes;


class TasksTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testCanReadListOfProjects()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Task[] $taskList */
        $taskList = Task::factory()->count(2)->create(['project_id' => Project::factory()->create()->id]);

        $response = $this->actingAs($user)->get('/projects/' . $taskList[0]->project->id);
        $response->assertSee($taskList[0]->name)
            ->assertSee($taskList[0]->url)
            ->assertSee($taskList[1]->name)
            ->assertSee($taskList[1]->url);
    }

    /**
     * @return void
     */
    public function testCanReadSingleProject()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Task $task */
        $task = Task::factory()->create();
        $response = $this->actingAs($user)->get('/projects/' . $task->project->id.'/tasks/'.$task->id);
        $response->assertSee($task->name)->assertSee($task->description);
    }

    /**
     * @return void
     */
    public function testCanOpenProjectCreateForm()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Project $project */
        $project = Project::factory()->create();
        $response = $this->actingAs($user)->get('/projects/'.$project->id.'/tasks/create');
        $response->assertSee('Create Task');
    }

    /**
     * @return void
     */
    public function testCanCreateNewProject()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Task $task */
        $task = Task::factory()->create();
        $this->actingAs($user)->post('/projects/'.$task->project->id.'/tasks/create', $task->toArray());
        $this->assertDatabaseHas('tasks', ['name' => $task->name, 'description' => $task->description]);
    }

    /**
     * @return void
     */
    public function testCanOpenProjectEdition()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Task $task */
        $task = Task::factory()->create();
        $response = $this->actingAs($user)->get('/projects/' . $task->project->id . '/tasks/'.$task->id.'/edit');
        $response->assertSee($task->name)->assertSee($task->description);
    }

    /**
     * @return void
     */
    public function testCanEditProject()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Task $task */
        $task = Task::factory()->create();
        $task->name = 'Updated name';
        $task->description = 'Updated description';
        $task->url = 'Updated url';
        $task->method = 'Updated method';
        $task->body = 'Updated body';
        $task->period = 'Updated period';
        $this->actingAs($user)->put('/projects/' . $task->project->id . '/tasks/'.$task->id, $task->toArray());
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated name',
            'description' => 'Updated description',
            'url' => 'Updated url',
            'method' => 'Updated method',
            'body' => 'Updated body',
            'period' => 'Updated period'
        ]);
    }

    /**
     * @return void
     */
    public function testCanDeleteProject()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Task $task */
        $task = Task::factory()->create();
        $this->actingAs($user);
        $this->delete('/projects/' . $task->project->id . '/tasks/'.$task->id);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
