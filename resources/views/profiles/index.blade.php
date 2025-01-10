@extends('layouts.master')
@section('content')
<main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
    <!-- Cover Container -->
    <section
        class="bg-white border-2 p-8 border-gray-800 rounded-xl min-h-[400px] space-y-8 flex items-center flex-col justify-center">
        
        <!-- /Profile Info -->
        @if ( session('status') )
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('status') }}
          </div>        
        @endif        
        
        <!-- Profile Info -->
        <div class="flex gap-4 justify-center flex-col text-center items-center">
            <!-- User Meta -->
            <div>
                <h1 class="font-bold md:text-2xl">{{ auth()->user()->fullname }}</h1>
                <p class="text-gray-700">{{ auth()->user()->bio }}</p>
            </div>
            <!-- / User Meta -->
        </div>
        
        <!-- Profile Stats -->
        <div
          class="flex flex-row gap-16 justify-center text-center items-center">
          <!-- Total Posts Count -->
          <div class="flex flex-col justify-center items-center">
            <h4 class="sm:text-xl font-bold">{{ $posts_count }}</h4>
            <p class="text-gray-600">Posts</p>
          </div>

          <!-- Total Comments Count -->
          <div class="flex flex-col justify-center items-center">
            <h4 class="sm:text-xl font-bold">14</h4>
            <p class="text-gray-600">Comments</p>
          </div>
        </div>
        <!-- /Profile Stats -->        
        
        <!-- Edit Profile Button (Only visible to the profile owner) -->
        <a href="{{ route('profiles.edit', auth()->user()->id, 'edit') }}" type="button"
            class="-m-2 flex gap-2 items-center rounded-full px-4 py-2 font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            Edit Profile
        </a>
        <!-- /Edit Profile Button -->
    </section>
    <!-- /Cover Container -->
    
    <!-- Barta Create Post Card -->
    <form
    method="POST" action="{{ route('posts.store') }}"
    enctype="multipart/form-data"
    class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">
    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    @csrf
    <!-- Create Post Card Top -->
    <div>
        <div class="flex items-start /space-x-3/">
            <!-- Content -->
            <div class="text-gray-700 font-normal w-full">
            <textarea
                class="block w-full p-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
                name="body"
                rows="2"
                placeholder="What's going on, {{ auth()->user()->username }}?"></textarea>
            </div>
        </div>
    </div>
    
    <!-- Create Post Card Bottom -->
    <div>
    <!-- Card Bottom Action Buttons -->
    <div class="flex items-center justify-end">
        <div>
        <!-- Post Button -->
        <button
            type="submit"
            class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
            Post
        </button>
        <!-- /Post Button -->
        </div>
    </div>
    <!-- /Card Bottom Action Buttons -->
    </div>
    <!-- /Create Post Card Bottom -->
    </form>
    
<!-- User Specific Posts Feed -->
      <!-- Barta Card -->
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
                        <a href="{{ route('profiles.index') }}"
                            class="hover:underline font-semibold line-clamp-1">
                            {{ $post->user->fullname }}
                        </a>
                        
                        <a href="{{ route('profiles.index') }}"
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
      <!-- /Barta Card -->
      <!-- User Specific Posts Feed -->    
    
    
    
</main>
@endsection