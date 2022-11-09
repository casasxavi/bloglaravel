<x-admin-layout>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <form action="{{ route('admin.posts.update', $post) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-jet-validation-errors class="mb-4" />


        <div class="mb-6 relative">
            <figure>
                <img src="{{ $post->image }}" id="imgPreview" class="aspect-[16/9] w-full object-cover object-center">
            </figure>

            <div class="absolute bg-white rounded-lg top-8 right-8">
                <label class="flex px-4 py-2 bg-white rounded-lg cursor-pointer">
                    Actualizar imagen
                    <input type="file" accept="image/*" name="image" onchange="previewImage(event, '#imgPreview')"
                        class="hidden">
                </label>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">

            <div class="mb-4">
                <x-jet-label for="title">
                    Título:
                </x-jet-label>
                <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title"
                    value="{{ old('title', $post->title) }}" />
            </div>

            <div class="mb-4">
                <x-jet-label for="slug">
                    Slug:
                </x-jet-label>
                <x-jet-input id="slug" class="block mt-1 w-full" type="text" name="slug"
                    value="{{ old('slug', $post->slug) }}" />
            </div>

            <div class="mb-4">
                <x-jet-label for="category" value="{{ __('Categoría:') }}" />
                <select name="category_id" id="catetory"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <x-jet-label for="summary">
                    Resumen:
                </x-jet-label>

                <textarea
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                    name="summary" id="summary" rows="4">{{ old('summary', $post->summary) }}</textarea>

            </div>

            <div class="mb-4">
                <x-jet-label>
                    Etiquetas:
                </x-jet-label>

                <select class="js-example-basic-multiple w-full" name="tags[]" multiple="multiple">

                    @foreach ($post->tags as $tag)
                        <option value="{{ $tag->name }}" selected>{{ $tag->name }}</option>
                    @endforeach

                    {{--  @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" @selected($post->tags->contains($tag))>{{ $tag->name }}</option>
                    @endforeach --}}
                </select>

                {{-- <select class="js-example-basic-single w-full" name="tags">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select> --}}

            </div>

            <div class="mb-4">
                <x-jet-label>
                    Contenido:
                </x-jet-label>

                <textarea id="editor" name="content">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="mb-4">
                <input type="hidden" name="is_published" value="0">

                <label class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published) == 1)
                        class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Publicar post</span>
                </label>
            </div>

            <div class="flex justify-end">

                <x-jet-danger-button class="mr-2" type="button" onclick="deletePost()">
                    Eliminar
                </x-jet-danger-button>


                <x-jet-button>
                    Editar post
                </x-jet-button>
            </div>
    </form>

    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" id="formDeletePost">
        @csrf
        @method('DELETE')



    </form>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/35.2.0/classic/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });

            $(document).ready(function() {
                $('.js-example-basic-multiple').select2({
                    tags: true,
                    tokenSeparators: [',', ''],
                    ajax: {
                        url: "{{ route('tags.select2') }}",
                        dataType: "json",
                        delay: 250,
                        data: function(params) {
                            return {
                                term: params.term,
                            }
                        },
                        processResults: function(data) {
                            return {
                                results: data,
                            }
                        },
                    }
                });
            });

            function deletePost() {
                form = document.getElementById('formDeletePost');
                form.submit();
            }


            function previewImage(event, querySelector) {

                //Recuperamos el input que desencadeno la acción
                const input = event.target;

                //Recuperamos la etiqueta img donde cargaremos la imagen
                $imgPreview = document.querySelector(querySelector);

                // Verificamos si existe una imagen seleccionada
                if (!input.files.length) return

                //Recuperamos el archivo subido
                file = input.files[0];

                //Creamos la url
                objectURL = URL.createObjectURL(file);

                //Modificamos el atributo src de la etiqueta img
                $imgPreview.src = objectURL;

            }

            /* $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            }); */

            /* $(document).ready(function() {
                $('.js-example-basic-single').select2();
            }); */
        </script>
    @endpush


</x-admin-layout>
