<aside class="w-64 shadow" aria-label="Sidebar">
    <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800 h-screen">
        <h2 class="text-3xl font-semibold">Xavi Casas</h2>
        <ul class="space-y-2 mt-6">
            @foreach ($links as $link)
            <li>
                <a href="{{$link['url']}}"
                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 {{$link['active'] ? 'bg-gray-200' : ''}}">
                    <svg aria-hidden="true"
                        class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">{{$link['titel']}}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</aside>