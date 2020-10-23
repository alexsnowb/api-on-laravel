<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\User as User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name'          => $this->faker->sentence(4,true),
            'description'   => $this->faker->paragraph(3,true),
            'url'           => 'https://google.com',
            'method'        => Task::METHOD_GET,
            'body'          => null,
            'period'        => 'everyMinute',
            'lastRunTime'   => $this->faker->dateTime('now'),
            'status_id'     => Status::factory()->create()->id,
            'user_id'       => User::factory()->create()->id,
            'project_id'    => Project::factory()->create()->id,
        ];
    }
}
