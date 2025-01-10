@include('partials.header')
<body class="bg-gray-100">
    @include('partials.nav')    

    <main class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">        
        <!-- Newsfeed -->
        <section id="newsfeed" class="space-y-6">
            <!-- Barta Card -->
            @foreach ($posts as $post)
                <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
                    <!-- Barta Card Top -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">                            
                                <!-- User Avatar -->
                                <div class="flex-shrink-0">
                                    <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    src="{{ auth()->user()->profile_picture_url }}"
                                    alt="{{ auth()->user()->username }}" />
                                </div>
                                <!-- /User Avatar -->
                                
                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <a title="View all {{ $post->user->username }} posts" href="{{ route('profiles.show', $post->user->id) }}"
                                        class="hover:underline font-semibold line-clamp-1">
                                        {{ $post->user->fullname }}
                                    </a>
                                    
                                    <a title="View user profile" href="{{ route('profiles.index') }}"
                                        class="hover:underline text-sm text-gray-500 line-clamp-1">
                                        {{ '@'.$post->user->username }}
                                    </a>
                                </div>
                                <!-- /User Info -->
                            </div>

                            <!-- Card Action Dropdown -->
                            <div class="flex flex-shrink-0 self-center" x-data="{ open: false }">
                                <div class="relative inline-block text-left">
                                    <div>
                                        <button @click="open = !open" type="button"
                                            class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                                            id="menu-0-button">
                                            <span class="sr-only">Open options</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Dropdown menu -->
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                        tabindex="-1">
                                        @if( auth()->user()->id == $post->user->id )
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1" id="user-menu-item-0">Edit</a>
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1" id="user-menu-item-1">
                                            <form onclick="return confirm('Are you sure, you want to delete?')" method="POST"
                                            class="inline-block" action="{{ route('posts.destroy', $post) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button type="submit" class="btn btn-link p-0" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">Delete</button>
                                            </form>                                             
                                            </a>                                            
                                        @endif
                                        
                                    </div>
                                </div>

                            </div>
                            <!-- /Card Action Dropdown -->
                        </div>
                    </header>
                    
                    <!-- Content -->
                    <div class="py-4 text-gray-700 font-normal space-y-2">
                    @if( isset( $post->image ) )                       
                        <img
                        src="{{ asset( 'storage/' . $post->image ) }}"
                        class="min-h-auto w-full rounded-lg object-cover max-h-64 md:max-h-72"
                        alt="" />                        
                    @endif                        
                    <p>{!! $post->body !!}</p>
                    </div>
                    
                    <!-- Date Created & View Stat -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
                         <a class="hover:underline line-clamp-1" title="view post" href="{{ route('posts.show', $post->id) }}">
                         <span class="">{{ $post->created_at->diffForHumans() }}</span>
                        </a>
                        <span class="">3 comments</span>
                        <span>450 views</span>
                    </div>
                </article>
            @endforeach
        
        </section>
        <!-- /Newsfeed -->
    </main>
    
    <footer class="shadow bg-black mt-10">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="https://github.com/alnahian2003" class="flex items-center mb-4 sm:mb-0">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Barta</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium sm:mb-0 text-gray-100">
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">About</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">Licensing</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 sm:mx-auto border-gray-700 lg:my-8" />
            <span class="block text-sm sm:text-center text-gray-200">Â© 2023
                <a href="https://github.com/alnahian2003" class="hover:underline">Barta</a>. All Rights
                Reserved.</span>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/js/custom.js"></script>
</body>

</html>
