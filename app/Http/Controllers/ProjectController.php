<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with(['user', 'status'])->paginate(20);
        return view('dashboard.projects.projectsList', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Status::all();
        return view('dashboard.projects.create', ['statuses' => $statuses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:64',
            'description' => 'required',
        ]);
        $user = auth()->user();
        $statusNew = Status::firstOrCreate(
            ['name'  => 'new'],
            ['class' => 'badge badge-pill badge-success']
        );

        $project = new Project();
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->status_id = $statusNew->id;
        $project->user_id = $user->id;
        $project->save();
        $request->session()->flash('message', 'Successfully created project');
        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with(['user', 'status'])->findOrFail($id);
        return view('dashboard.projects.projectShow', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $statuses = Status::all();
        return view('dashboard.notes.edit', ['statuses' => $statuses, 'project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:1|max:64',
            'description' => 'required',
        ]);
        $note = Project::findOrFail($id);
        $note->name = $request->input('name');
        $note->description = $request->input('description');
        $note->save();
        $request->session()->flash('message', 'Successfully edited project');
        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Project $project */
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index');
    }
}
