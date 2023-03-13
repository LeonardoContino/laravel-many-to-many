@extends('layouts.app')

@section('title', $project->title)

@section('content')

<div class="d-flex justify-content-between align-items-center">
    <h1 class="my-5">
        {{$project->title}}
    
    </h1>
    
    <div class="d-flex justify-content-end gap-3">
        <a href="{{route('admin.projects.index')}}" class="btn btn-secondary">Torna ai Progetti</a>
    <a href="{{route('admin.projects.edit', $project->id)}}" class="btn btn-primary">Modifica progetto</a>

    <form action="{{route('admin.projects.destroy', $project->id)}}" method="POST" class="delete-form" dataEntity="progetto">
        @csrf
        @method('DELETE')
        <button class="btn btn-small btn-danger ">Elimina</button>
    </form>
    </div>
    
</div>


<div class="clearfix">
    @if($project->image)
    <img class="float-start img-fluid me-3" src="{{ asset('storage/' . $project->image)}}" alt="{{$project->title}}">
    @endif
    <p>{{$project->content}}</p>
    
</div>
<div class="mt-3 d-flex gap-2">
    <h5><strong>Data:</strong>{{$project->updated_at}}</h5>
    <h5><strong>Categoria:</strong>{{$project->type?->label}}</h5>


</div>

@endsection