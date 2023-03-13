@extends('layouts.app')

@section('title', 'Crea Progetto')


@section('content')


  <div class="card-title d-flex align-items-center justify-content-between my-4">
    <h1>Crea Progetto</h1>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-small btn-secondary">Indietro</a>
  </div>
  <hr>
  <div class="card-body">
    @include('includes.projects.form')
  </div>


@endsection