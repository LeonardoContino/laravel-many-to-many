<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('updated_at', 'DESC')->get();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project;
        $types = Type::orderBy('label')->get();
        $technologies = Technology::select('id', 'label')->get();

        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:projects',
            'content' => 'required|string',
            'image' => 'nullable|image',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id'
        ],[
                'title.required' => 'il titolo è obbligatorio',
                'title.unique' => "esiste già un progetto $request->title",
                'title.min' => 'il titolo deve avere almeno 5 caratteri',
                'title.max' => 'il titolo deve avere max 20 caratteri',
                'content.required' => 'il progetto deve avere un contenuto',
                'image.image' => 'immagine non valida',
                'type_id' => 'Tipo non valido',
                'technologies' => 'tecnologia non valida'

        ]);
        $data = $request->all();

        $project = new Project();

        if(Arr::exists($data,'image')){
           $data['image'] = Storage::put('projects', $data['image']);
        }
        
        $project->fill($data);
        
        $project->slug = Str::slug($project->title, '-');
        
        $project->save();

        $project->technologies()->attach($data['technologies']);

        return to_route('admin.projects.index', $project->id)->with('type', 'success')->with('nuovo progetto creato');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::orderBy('label')->get();
        $technologies = Technology::select('id', 'label')->orderBy('id')->get();

        $project_technologies = $project->technologies->pluck('id')->toArray();

        
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => ['required','string',Rule::unique('projects')->ignore($project->id)],
            'content' => 'required|string',
            'image' => 'nullable|image',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id'

        ],
            [
                'title.required' => 'il titolo è obbligatorio',
                'title.unique' => "esiste già un progetto $request->title",
                'title.min' => 'il titolo deve avere almeno 5 caratteri',
                'title.max' => 'il titolo deve avere max 20 caratteri',
                'content.required' => 'il progetto deve avere un contenuto',
                'image.image' => 'immagine non valida',
                'type_id' => 'Tipo non valido',
                'technologies' => 'tecnologia non valida'


            ]);
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        if(Arr::exists($data,'image')){
            if($project->image) Storage::delete($project->image);
            $data['image'] = Storage::put('projects', $data['image']);
         }
        $project->update($data);

       if(Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        else if(count($project->technologies))$project->technologies()->detach();
        return to_route('admin.projects.show', $project->id)->with('type', 'success')->with('msg', 'Progetto modificato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        if($project->image) Storage::delete($project->image);

        if(count($project->technologies)) $project->technologies()->detach();
        $project->delete();

        return to_route('admin.projects.index')->with('msg', "Il progetto '$project->title' è stato eliminato")
        ->with('type','success');
    }
}
