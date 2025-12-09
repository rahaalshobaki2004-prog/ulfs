<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ULFS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <style>
        :root { --primary: #006d77; --primary-hover: #005f6a; }
        .bg-primary { background-color: var(--primary); }
        .hover\:bg-primary-hover:hover { background-color: var(--primary-hover); }
        .text-primary { color: var(--primary); }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <h1 class="text-3xl font-bold text-primary">ULFS Admin</h1>
                    <a href="{{ route('admin.dashboard') }}" class="text-primary font-bold">Dashboard</a>
                    <a href="{{ route('admin.posts.index') }}" class="text-gray-700 hover:text-primary">Posts</a>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition">
                         Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10">

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h3 class="text-3xl font-bold text-primary">{{ $stats['total_posts'] }}</h3>
                <p class="text-gray-600"> total posts</p>
            </div>
            <div class="bg-orange-100 p-6 rounded-xl shadow text-center">
                <h3 class="text-3xl font-bold text-orange-600">{{ $stats['pending_posts'] }}</h3>
                <p class="text-gray-700"> pending</p>
            </div>
            <div class="bg-green-100 p-6 rounded-xl shadow text-center">
                <h3 class="text-3xl font-bold text-green-600">{{ $stats['approved_posts'] }}</h3>
                <p class="text-gray-700">approved</p>
            </div>
            <div class="bg-red-100 p-6 rounded-xl shadow text-center">
                <h3 class="text-3xl font-bold text-red-600">{{ $stats['rejected_posts'] }}</h3>
                <p class="text-gray-700">rejected</p>
            </div>
            <div class="bg-blue-100 p-6 rounded-xl shadow text-center">
                <h3 class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] }}</h3>
                <p class="text-gray-700">total users</p>
            </div>
            <div class="bg-purple-100 p-6 rounded-xl shadow text-center">
                <h3 class="text-3xl font-bold text-purple-600">{{ $stats['total_messages'] }}</h3>
                <p class="text-gray-700">messages</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-10">
            <!-- Pending Posts -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold mb-6 text-primary">pending posts</h2>
                @if($pendingPosts->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingPosts as $post)
                            <div class="border rounded-xl p-5 flex justify-between items-center hover:bg-gray-50">
                                <div>
                                    <p class="font-bold">{{ $post->title }}</p>
                                    <p class="text-sm text-gray-600">by: {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex gap-3">
                                    <form action="{{ route('admin.posts.approve', $post) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">approve</button>
                                    </form>
                                    <form action="{{ route('admin.posts.reject', $post) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700">reject</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-10">no pending posts</p>
                @endif
            </div>

            <!-- Users Management -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold mb-6 text-primary"> users management</h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($users as $user)
                        <div class="border rounded-xl p-4 flex justify-between items-center hover:bg-gray-50">
                            <div>
                                <p class="font-bold">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('are you sure ؟')">
                                @csrf @method('DELETE')
                                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Approved Posts -->
        <div class="mt-10 bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold mb-6 text-primary">latest approved posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentPosts as $post)
                    <div class="border rounded-xl p-5 hover:shadow-lg transition">
                        <h3 class="font-bold text-lg">{{ $post->title }}</h3>
                        <p class="text-sm text-gray-600">by: {{ $post->user->name }}</p>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="mt-3" onsubmit="return confirm('delete post ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-sm underline"> delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed bottom-5 right-5 bg-green-600 text-white px-8 py-4 rounded-xl shadow-2xl text-lg font-bold z-50">
            {{ session('success') }}
        </div>
    @endif

    <script>
        setTimeout(() => document.querySelector('.fixed')?.remove(), 4000);
    </script>
</body>
</html>
