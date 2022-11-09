<x-admin-layout>

    <h1 class="text-3xl font-semibold mb-2">Nuevo Artículo</h1>

    <form class="bg-white rounded-lg p-6 shadow-lg" action="{{ route('admin.posts.store') }}" method="POST">
        @csrf

        <x-jet-validation-errors class="mb-4" />

        <div class="mb-4">
           <x-jet-label for="title">
            Título:
           </x-jet-label>
            <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"
                placeholder="Título del artículo" />
        </div>

        <div class="mb-4">
            <x-jet-label for="slug">
             Slug:
            </x-jet-label>
             <x-jet-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')"
                 placeholder="slug" />
         </div>

        <div class="mb-4">
            <x-jet-label for="category" value="{{ __('Categoría:') }}" />
            <select name="category_id" id="catetory" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <x-jet-label for="content">
             Contenido:
            </x-jet-label>
             <x-jet-input id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content')"
                 placeholder="Contenido del artículo" />
         </div>

        <div class="flex justify-end">
            <x-jet-button>
                Crear post
            </x-jet-button>
        </div>

    </form>



</x-admin-layout>
