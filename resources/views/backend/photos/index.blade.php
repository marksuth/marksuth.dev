@extends('layouts.backend', [
    'title' => 'Photos',
    'description' => 'Manage your photos',
])

@section('content')
    @livewire('photo-editor', ['photo' => $photo ?? null])
@endsection
