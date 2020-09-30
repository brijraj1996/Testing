<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Project</title>
    <link rel="stylesheet" type="text/css" href="https://cdjns.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css">
</head>
<body>
    <h1>Create project</h1>
    
    <form method="POST" action="/projects" class="container" style="padding-top:40px">
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
                <button type="submit" class="button-is-link">Create Project</button>
        </div>

        
    </form>
</body>
</html>
