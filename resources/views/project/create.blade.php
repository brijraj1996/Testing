@extends('layouts.app')
@section('content')
<body>
    <h1>Create project</h1>
    
    <form method="POST" action="/projects"style="padding-top:40px">
        @csrf

        <div class="field">

            <label class="control">
                <input type="text" class="input" name="title" placeholder="Title">
        </div>

        <div class="field">

            <label class="control">
                <input type="text" class="input" name="description" placeholder="description">
        </div>

        <div class="field">

            <label class="control">
                <button type="submit" class="button-is-link">Create Project</button><br>
                <br>
                <a href="/projects">Cancel</a>
        </div>

        
    </form>
</body>
</html>

@stop