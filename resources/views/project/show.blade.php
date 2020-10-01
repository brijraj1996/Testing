@extends('layouts.app')
@section('content')
<body>
    <h2>TestDemo</h2>
    <ul>
    <li>{{$project->title}}</li>
    <li>{{$project->description}}</li>
    </ul>
    <a href="/projects">Go back</a>
</body>
</html>
    
@stop