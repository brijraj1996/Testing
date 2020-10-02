<div class="bg-white p-5 rounded-lg shadow" style="height:200px">

    <h3 class="font-normal text-xl py-4 -ml-5 -mb-3 border-l-4 border-blue pl-4">
    <a href="{{$project->path()}}" class="text-black no-underline">{{$project->title}}</a>

<div>{{ Str::limit($project->description,100)}}</div>

</div>
</div>