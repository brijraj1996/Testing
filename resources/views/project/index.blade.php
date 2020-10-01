@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <h2 class="text-grey text-lg font-normal">My projects</h2>

    <a href="/projects/create" class="underline">Create new project</a>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
        <div class="lg:w-1/3 px-3 pb-6">
        <div class="bg-white p-5 rounded-lg shadow" style="height:200px">

            <h3 class="font-normal text-xl py-4 -ml-5 -mb-3 border-l-4 border-blue pl-4">
            <a href="{{$project->path()}}" class="text-black no-underline">{{$project->title}}</a>

        <div>{{ Str::limit($project->description,100)}}</div>

        </div>
    </div>
        @empty

        <div>No projects yet</div>

        @endforelse
</main>
    @stop




   




{{-- <header class="flex items-center mb3" >
        
    <a href="/projects/create">Create new project</a>
</header>


<main class="flex flex-wrap">
    @forelse($projects as $project)
    <div class="w-1/3 px-3 pb-4">
    <div class="bg-white mr-4 p-3 rounded shadow" style="height:200px width=px">
        <h3 class="font-normal text-xl mb-6">{{$project->title}}</h3>

        <div class>{{Str::limit($project->description,100)}}</div>
    </div>
</main>
    @empty
        <div>No projects yet</div>
    @endforelse 
</div> --}}