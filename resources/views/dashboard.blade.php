@extends('layout.main-layout')

@section('title', 'Create Facility')

@section('konten')

    

    <div class="col mx-auto text-center mt-4 gap-3 my-5">
        <h2>manager dashboard view</h2>
        <a href="{{ route('types.create') }}" class="btn text-white fw-semibold" style="background-color: #BA8B4E; border-color: #BA8B4E;">
            + Create New Type
        </a>
        <a href="{{ route('rooms.create') }}" class="btn text-white fw-semibold" style="background-color: #BA8B4E; border-color: #BA8B4E;">
            + Create New Room
        </a>
        <a href="{{ route(name: 'rents.create') }}" class="btn text-white fw-semibold" style="background-color: #BA8B4E; border-color: #BA8B4E;">
            + Create New Rents
        </a>
        <a href="{{ route('facility.create') }}" class="btn text-white fw-semibold" style="background-color: #BA8B4E; border-color: #BA8B4E;">
            + Create New Facility
        </a>
    </div>

@endsection