<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $tasks = Task::with(['user', 'status'])->paginate(20);
        return view('dashboard.projects.tasks.taskList', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        return view('dashboard.projects.tasks.create', ['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Project $project, Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:64',
            'url' => 'required',
            'method' => 'required',
            'period' => 'required',
        ]);
        $user = auth()->user();
        $statusNew = Status::firstOrCreate(
            ['name'  => 'new'],
            ['class' => 'badge badge-pill badge-success']
        );

        $task = new Task();
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->url = $request->input('url');
        $task->method = $request->input('method');
        $task->body = $request->input('body');
        $task->period = $request->input('period');
        $task->status_id = $statusNew->id;
        $task->user_id = $user->id;
        $task->project_id = $project->id;
        $task->save();
        $request->session()->flash('message', 'Successfully created task');
        return redirect()->route('projects.show', ['project' => $project]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Project $project, $id)
    {
        $project = Project::with(['user', 'status'])->findOrFail($id);
        return view('dashboard.projects.tasks.projectShow', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Project $project, $id)
    {
        $project = Project::findOrFail($id);
        $statuses = Status::all();
        return view('dashboard.projects.tasks.edit', ['statuses' => $statuses, 'project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Project $project, Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:1|max:64',
            'description' => 'required',
        ]);
        $task = Task::findOrFail($id);
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->save();
        $request->session()->flash('message', 'Successfully edited project');
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Project $project, $id)
    {
        /** @var Task $task */
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('projects.show', ['project' => $project]);
    }}
