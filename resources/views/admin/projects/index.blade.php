@extends('layouts.app')

@section('title', 'Projects')
    
@section('content')
<header>
    <h1 class="my-5">My Projects</h1>
    <a " href="{{route('admin.projects.create')}}"><i class="fa-solid  fa-plus fs-2 mb-3"></i></a>
</header>

<table class="table table-hover">
    <thead>
        <tr class="text-center">
          <th scope="col">#</th>
          <th scope="col">Titolo</th>
          <th scope="col">slug</th>
          <th scope="col">Tipo di progetto</th>
          <th scope="col">Aggiornato il</th>

        </tr>
      </thead>
      <tbody class="text-center">
        @forelse ($projects as $project)
        <tr>
            <th scope="row">{{$project->id}}</th>
            <td>{{$project->title}}</td>
            <td>{{$project->slug}}</td>
            <td >@if ($project->type) <span class="badge" style="background-color:{{$project->type->color}}">{{$project->type->label}}</span>  
              @else
                -
            @endif</td>
            <td>{{$project->updated_at}}</td>
            <td>
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="{{route('admin.projects.show', $project->id)}}"><i class="fa-solid fa-eye me-2"></i></a>
                    <a href="{{route('admin.projects.edit', $project->id)}}"><i class="fa-solid fa-pencil"></i></a>

                <form action="{{route('admin.projects.destroy', $project->id)}}" method="POST" class="delete-form" dataEntity="progetto">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-small"><i class="fa-regular fa-trash-can"></i></button>
                </form>
                </div>
                
            </td>
          </tr>
        @empty
            <tr>
                <td colspan="6">non ci sono progetti</td>
            </tr>
        @endforelse
        
      </tbody>
  </table>
@endsection



