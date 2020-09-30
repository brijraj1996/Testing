<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>TestDemo</h2>
    <ul>
        @foreach($projects as $project)
    <li>
        <a href="{{$project->path()}}">{{$project->title}}</a>
    </li>
    {{-- <li>{{$project->description}}</li> --}}
    </ul>
    @endforeach
</body>
</html>