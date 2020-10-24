<?php

namespace Tests\Unit;

use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

use App\Models\User;
use App\Models\Notes;


class ProjectsTest extends TestCase
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
        /** @var Project[] $projectList */
        $projectList = Project::factory()->count(2)->create();
        $response = $this->actingAs($user)->get('/projects');
        $response->assertSee($projectList[0]->name)
            ->assertSee($projectList[0]->description)
            ->assertSee($projectList[1]->name)
            ->assertSee($projectList[1]->description);
    }

    /**
     * @return void
     */
    public function testCanReadSingleProject()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Project $project */
        $project = Project::factory()->create();
        $response = $this->actingAs($user)->get('/projects/' . $project->id);
        $response->assertSee($project->name)->assertSee($project->description);
    }

    /**
     * @return void
     */
    public function testCanOpenProjectCreateForm()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        $response = $this->actingAs($user)->get('/projects/create');
        $response->assertSee('Create Project');
    }

    /**
     * @return void
     */
    public function testCanCreateNewProject()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        $project = Project::factory()->create();
        $this->actingAs($user)->post('/projects', $project->toArray());
        $this->assertDatabaseHas('projects', ['name' => $project->name, 'description' => $project->description]);
    }

    /**
     * @return void
     */
    public function testCanOpenProjectEdition()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Project $project */
        $project = Project::factory()->create();
        $response = $this->actingAs($user)->get('/projects/' . $project->id . '/edit');
        $response->assertSee($project->name)->assertSee($project->description);
    }

    /**
     * @return void
     */
    public function testCanEditProject()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Project $project */
        $project = Project::factory()->create();
        $project->name = 'Updated name';
        $project->description = 'Updated description';
        $this->actingAs($user)->put('/projects/' . $project->id, $project->toArray());
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'Updated name', 'description' => 'Updated description']);
    }

    /**
     * @return void
     */
    public function testCanDeleteProject()
    {
        $user = User::factory()->create();
        $roleUser = Role::create(['name' => 'user']);
        $user->assignRole($roleUser);
        /** @var Project $project */
        $project = Project::factory()->create();
        $this->actingAs($user);
        $this->delete('/projects/' . $project->id);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
