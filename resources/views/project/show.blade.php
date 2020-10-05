@extends('layouts.app')
@section('content')

<header class="flex items-center mb-3 py-4">
    <div class="flex justify-between items-center w-full">
        <p class="text-grey text-lg font-normal">
           <a href="/projects"> My projects </a>/ {{$project->title}}
        </p>

<a href="/projects/create" class="underline">Create new project</a>
</header>


<main>
    <div class="lg:flex -mx-3">
    
        <div class="lg:w-3/4 px-3 mb-6">
            <div class="mb-8">
            <h2 class="text-lg font-normal mb-6">Tasks</h2>
           
            {{--Tasks--}}
            @foreach($project->tasks as $task)
            <div class="bg-white p-5 rounded-lg shadow mb-3">
            <form method="POST" action= "{{$task->path()}}">
                @method('PATCH')
                @csrf


                <div class ="flex">
                    
                       <input name="body" value="{{$task->body}}" class="w-full">
                       <input name="completed" type="checkbox" onChange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                    </div>
            </form>
        </div>
            @endforeach
            <div class="bg-white p-5 rounded-lg shadow mb-3">
            
            <form action="{{$project->path() . '/tasks'}}" method="POST">
                @csrf 
                
                <input placeholder="Begin adding tasks..." class="w-full" name="body">
            </form>

            </div>

            <div>
            <h2 class="text-lg font-normal">General Notes</h2>
            {{--General Notes--}}

            <form method="POST" action="{{$project->path()}}">
                @csrf
                @method('PATCH')
            <textarea
            name="notes" 
            class="bg-white p-5 rounded-lg shadow w-full"
             placeholder="Anything that you want to make note of?"
              style="height:200px">{{$project->notes}}</textarea>

              <button type="submit" class="button">Save</button>
            </form>
            </div>
    </div>
    <div class="lg:w-1/4 px-3">
        @include('project.card')
        <div><a href="/projects">Go back</a></div> 
      </div>
    </div>   
            
</main>
@stop