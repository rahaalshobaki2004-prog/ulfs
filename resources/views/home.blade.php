<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ULFS - Lost & Found University Platform</title>
    <script src="https://cdn.tailwindcss.com"></script><div class="alert alert-danger" role="alert">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <style>
        :root {
            --primary: #006d77;
            --primary-hover: #005f6a;
        }
        .bg-primary { background-color: var(--primary); }
        .hover\:bg-primary-hover:hover { background-color: var(--primary-hover); }
        .text-primary { color: var(--primary); }
        .gradient-bg { background: linear-gradient(135deg, #e8f4f8 0%, #f0f9fb 100%); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen gradient-bg">

    <!-- Navbar -->
    <nav class="bg-white shadow-xl sticky top-0 z-50">
        <div class="container mx-auto px-6 py-5">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-4xl font-bold text-primary">ULFS</a>
                    <span class="hidden md:block text-gray-600 text-lg">University Lost & Found</span>
                </div>

                <div class="flex items-center space-x-8">
                    @auth
                        <a href="{{ route('my.messages') }}" class="relative text-primary font-semibold hover:underline">
                            Messages
                            @if(auth()->user()->unreadMessagesCount() > 0)
                                <span class="absolute -top-2 -right-4 bg-red-600 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                    {{ auth()->user()->unreadMessagesCount() }}
                                </span>
                            @endif
                        </a>
                            <a href="{{ route('my.posts') }}" class="text-primary font-semibold hover:underline">My Posts</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline font-medium">Logout</button>
                            </form>
                    @else
                        <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-primary-hover transition shadow-lg">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-20 text-center">
        <h1 class="text-5xl md:text-7xl font-extrabold text-gray-800 mb-6 leading-tight">
            Lost Something?<br class="hidden md:block">Found Something?
        </h1>
        <p class="text-xl md:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto">
            ULFS helps university students quickly recover lost items or return found belongings.
        </p>

        @auth
            <a href="{{ route('posts.create') }}" class="inline-block bg-primary text-white text-2xl font-bold px-12 py-5 rounded-full shadow-2xl hover:bg-primary-hover transition transform hover:scale-105">
                + Create New Post
            </a>
        @endauth
    </section>

    @if(Auth::user())

            <!-- Filters -->
            <div class="container mx-auto px-6 mb-12">
                <div class="flex flex-wrap justify-center gap-5">
                    <a href="{{ route('home') }}" class="px-10 py-4 rounded-full font-bold shadow-md {{ !request('type') ? 'bg-primary text-white' : 'bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white' }} transition">
                        All
                    </a>
                    <a href="{{ route('home', ['type' => 'lost']) }}" class="px-10 py-4 rounded-full font-bold shadow-md {{ request('type') == 'lost' ? 'bg-primary text-white' : 'bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white' }} transition">
                        Lost Items
                    </a>
                    <a href="{{ route('home', ['type' => 'found']) }}" class="px-10 py-4 rounded-full font-bold shadow-md {{ request('type') == 'found' ? 'bg-primary text-white' : 'bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white' }} transition">
                        Found Items
                    </a>
                </div>
            </div>

            <!-- Posts Grid -->
            <section class="container mx-auto px-6 pb-20">
                @if($posts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                        @foreach($posts as $post)

                            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-3">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
                                @else
                                    <div class="h-64 flex items-center justify-center {{ $post->type == 'lost' ? 'bg-gradient-to-br from-red-400 to-pink-500' : 'bg-gradient-to-br from-teal-400 to-emerald-600' }}">
                                        <span class="text-white text-7xl font-bold opacity-40">{{ strtoupper($post->type) }}</span>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="px-4 py-2 rounded-full text-sm font-bold {{ $post->type == 'lost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $post->type == 'lost' ? 'LOST' : 'FOUND' }}
                                        </span>
                                        <span class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $post->title }}</h3>
                                    <p class="text-gray-600 mb-6 line-clamp-3">{{ $post->description }}</p>

                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center font-bold text-lg">
                                                {{ substr($post->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">{{ $post->user->name }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('posts.show', $post) }}" class="bg-primary text-white px-7 py-3 rounded-full font-bold hover:bg-primary-hover transition">
                                            Contact
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <p class="text-4xl text-gray-500 font-bold">No posts yet.</p>
                        <p class="text-xl text-gray-600 mt-4">Be the first to help someone!</p>
                    </div>
                @endif
            </section>
    @else
            <div style="background-color: #f8d7da; font-weight: bold ; padding: 10px; border-radius: 5px; margin: 0 auto
            ; color:#721c24 ; text-align: center; font-size: 20px; width: 50%; "  >
                Login First to see posts !!
            </div>
            <br> <br>
    @endif




    <!-- Floating Button (Mobile) -->
    @auth
        <a href="{{ route('posts.create') }}" class="fixed bottom-8 right-8 bg-primary text-white w-16 h-16 rounded-full shadow-2xl flex items-center justify-center text-5xl font-bold hover:bg-primary-hover transition z-40 md:hidden">
            +
        </a>
    @endauth

    <!-- Footer -->
    <footer class="bg-primary text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">ULFS</h2>
            <p class="text-lg mb-6">Connecting students. Returning lost items. Building community.</p>
            <p>&copy; 2025 ULFS. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
