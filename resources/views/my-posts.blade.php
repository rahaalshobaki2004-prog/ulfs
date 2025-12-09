<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts - ULFS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"/>
    <style>
        :root { --primary: #006d77; --primary-hover: #005f6a; --danger: #770006;}
        .bg-primary { background-color: var(--primary); }
        .bg-danger { background-color: var(--danger); }
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
                <a href="{{ route('home') }}" class="text-4xl font-bold text-primary">ULFS</a>
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary">← Back</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12 max-w-6xl">
        <h1 class="text-5xl font-extrabold text-center mb-4">My Posts</h1>
        <p class="text-xl text-center text-gray-600 mb-12">All posts you have created</p>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($posts as $post)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition">
                        @if($post->image)
                            <img src="{{ asset('storage/'.$post->image) }}" class="w-full h-64 object-cover">
                        @else
                            <div class="h-64 flex items-center justify-center {{ $post->type == 'lost' ? 'bg-red-500' : 'bg-green-500' }}">
                                <span class="text-white text-6xl font-bold opacity-30">{{ strtoupper($post->type) }}</span>
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="px-4 py-2 rounded-full text-sm font-bold {{ $post->type == 'lost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $post->type == 'lost' ? 'LOST' : 'FOUND' }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $post->messages_count }} message{{ $post->messages_count != 1 ? 's' : '' }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $post->description }}</p>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                                <div class="flex gap-3">
                                    <a href="{{ route('posts.show', $post) }}" class="text-primary hover:underline text-sm">View</a>
                                    @if($post->status == 'pending')
                                        <span class="text-amber-600 text-sm font-medium">Pending Approval</span>
                                    @endif
                                </div>
                            </div>

                            @if($post->status == 'approved')
                                <a href="{{ route('posts.show', $post) }}" class="block mt-4 text-center bg-primary text-white py-2 rounded-lg hover:bg-primary-hover transition">
                                    {{ $post->messages_count }} New Message{{ $post->messages_count != 1 ? 's' : '' }}
                                </a>
                            @endif
                            <a href="{{ route('myposts.destroy', $post) }}" class="block mt-4 text-center bg-danger text-white py-2 rounded-lg transition">
                                     Delete Post
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-3xl text-gray-500">You haven't posted anything yet</p>
                <a href="{{ route('posts.create') }}" class="mt-6 inline-block bg-primary text-white px-8 py-4 rounded-full text-xl hover:bg-primary-hover transition">
                    + Create Your First Post
                </a>
            </div>
        </div>
        @endif
    </div>

    <footer class="bg-primary text-white py-10 mt-20">
        <div class="container mx-auto px-6 text-center">
            <p>© 2025 ULFS. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
