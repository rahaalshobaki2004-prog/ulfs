<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Messages - ULFS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"/>
    <style>
        :root { --primary: #006d77; --primary-hover: #005f6a; }
        .bg-primary { background-color: var(--primary); }
        .hover\:bg-primary-hover:hover { background-color: var(--primary-hover); }
        .text-primary { color: var(--primary); }
        .gradient-bg { background: linear-gradient(135deg, #e8f4f8 0%, #f0f9fb 100%); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen gradient-bg">

    <nav class="bg-white shadow-xl sticky top-0 z-50">
        <div class="container mx-auto px-6 py-5">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-4xl font-bold text-primary">ULFS</a>
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary">← Back</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12 max-w-5xl">
        <h1 class="text-5xl font-extrabold text-center mb-4">My Messages</h1>
        <p class="text-xl text-center text-gray-600 mb-12">All messages sent to your posts</p>

        @if($messages->count() > 0)
            <div class="space-y-6">
                @foreach($messages as $msg)
                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="font-bold text-lg">{{ $msg->sender_name }}</span>
                                    <span class="text-gray-500 text-sm">{{ $msg->sender_contact }}</span>
                                    @if(!$msg->is_read)
                                        <span class="bg-green-600 text-white text-xs px-3 py-1 rounded-full">NEW</span>
                                    @endif
                                    <a href="{{ route('userDeleteMessage',$msg->id) }}" class="bg-red-600 text-white text-xs px-3 py-1 rounded-full">Delete</a>
                                </div>
                                <p class="text-gray-700 mb-3">{{ $msg->message }}</p>
                                <div class="text-sm text-gray-500">
                                    About your post: <a href="{{ route('posts.show', $msg->post) }}" class="text-primary hover:underline font-medium">{{ $msg->post->title }}</a>
                                    <span class="mx-2">•</span>
                                    {{ $msg->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $messages->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-3xl text-gray-500">No messages yet</p>
                <p class="text-lg text-gray-600 mt-4">When someone contacts you about your posts, messages will appear here.</p>
            </div>
        @endif
    </div>

    <footer class="bg-primary text-white py-10 mt-20">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2025 ULFS. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
