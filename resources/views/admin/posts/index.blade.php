<x-admin-layout>

<div class="flex justify-end mb-6">
    <a class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{route('admin.posts.create')}}">Nuevo Post</a>
</div>

    <ul class="space-y-8">
        @foreach ($posts as $post)
            <li class="grid grid-cols-2">

                <figure>
                    <img class="aspect-[16/9] object-cover object-center" src="{{ $post->image }}" alt="{{ $post->title }}">
                </figure>

                <div class="mx-6">
                    <h1 class="text-xl font-semibold">
                        {{$post->title}}
                    </h1>
                    <hr class="mt-1 mb-2">

                    <span @class([
                        'bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800' => $post->is_published,
                        'bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900' => !$post->is_published,
                        ])>
                        {{$post->is_published ? 'Publicado' : 'Sin Publicar'}}
                    </span>

                    <p class="mt-2 mb-4">
                        {{$post->summary}}
                    </p>
                    
                    <a class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{route('admin.posts.edit', $post)}}">Editar</a>
                </div>

            </li>
        @endforeach
    </ul>
    <div class="mt-4">
        {{$posts->links()}}
    </div>
    
</x-admin-layout>
