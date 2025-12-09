<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>posts - ULFS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        :root { --primary: #006d77; --primary-hover: #005f6a; }
        .bg-primary { background-color: var(--primary); }
        .hover\:bg-primary-hover:hover { background-color: var(--primary-hover); }
    </style>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-3xl font-bold text-primary">ULFS Admin</a>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-primary font-bold">Home</a>
                <a href="{{ route('admin.posts.index') }}" class="text-primary font-bold underline">Posts</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="bg-red-600 text-white px-6 py-2 rounded-full">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10">
        <h1 class="text-4xl font-bold text-center mb-8 text-primary">posts</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded-xl mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif


<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-max table-auto text-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-8 py-4 text-center font-bold">Title</th>
                    <th class="px-8 py-4 text-center font-bold">User</th>
                    <th class="px-8 py-4 text-center font-bold">Type</th>
                    <th class="px-8 py-4 text-center font-bold">Status</th>
                    <th class="px-8 py-4 text-center font-bold">Date</th>
                    <th class="px-8 py-4 text-center font-bold">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-50 transition-all duration-200">
                        <td class="px-8 py-5 text-center align-middle">
                            <div class="max-w-xs truncate">{{ $post->title }}</div>
                        </td>
                        <td class="px-8 py-5 text-center align-middle font-medium">
                            {{ $post->user->name }}
                        </td>
                        <td class="px-8 py-5 text-center align-middle">
                            <span class="px-4 py-2 rounded-full text-white font-bold text-xs {{ $post->type == 'lost' ? 'bg-red-600' : 'bg-green-600' }}">
                                {{ $post->type == 'lost' ? 'LOST' : 'FOUND' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center align-middle">
                            @if($post->status == 'approved')
                                <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-xs font-bold">Approved</span>
                            @elseif($post->status == 'rejected')
                                <span class="px-4 py-2 bg-red-100 text-red-700 rounded-full text-xs font-bold">Rejected</span>
                            @else
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Pending</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-center align-middle text-gray-600 text-xs">
                            {{ $post->created_at->diffForHumans() }}
                        </td>
                        <td class="px-8 py-5 text-center align-middle">
                            <div class="flex justify-center items-center gap-2">
                                @if($post->status == 'pending')
                                    <form action="{{ route('admin.posts.approve', $post) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-xs font-bold transition">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.posts.reject', $post) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-xs font-bold transition">
                                            Reject
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline"
                                      onsubmit="return confirm('are you sure ?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-gray-700 hover:bg-gray-900 text-white px-5 py-2 rounded-lg text-xs font-bold transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-gray-500 text-xl font-medium">
                           no posts now !
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $posts->links('pagination::tailwind') }}
    </div>
</div>

</body>
</html>
