@extends('layouts.app')
@section('content')
<body>
    <h1>Edit your project</h1>
    
    <form method="POST" action="{{$project->path()}}" style="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        @csrf
        @method('PATCH')
        <div class="field">

            <label class="control">
                <input type="text" class="input" name="title" placeholder="Title" value={{$project->title}}>
        </div>

        <div class="field">

            <label class="control">
                <input type="text" class="input" name="description" placeholder="description" value={{$project->description}}>
        </div>

        <div class="field">

            <label class="control">
                <button type="submit" class="button-is-link">Update Project</button><br>
                <br>
                <a href={{$project->path()}}>Cancel</a>
        </div>

        
    </form>
</body>
</html>

@stop