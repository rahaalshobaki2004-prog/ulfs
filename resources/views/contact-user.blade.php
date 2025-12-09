<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact Owner - ULFS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"/>
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
                <a href="{{ route('home') }}" class="text-4xl font-bold text-primary">ULFS</a>
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary font-medium">
                    ← Back to Posts
                </a>
            </div>
        </div>
    </nav>

    <!-- Post Details + Contact Section -->
    <section class="container mx-auto px-6 py-12">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12">

            <!-- Left: Post Details -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
                @else
                    <div class="h-64 flex items-center justify-center {{ $post->type == 'lost' ? 'bg-gradient-to-br from-red-400 to-pink-500' : 'bg-gradient-to-br from-teal-400 to-emerald-600' }}">
                        <span class="text-white text-7xl font-bold opacity-40">{{ strtoupper($post->type) }}</span>
                    </div>
                @endif
                <br>
                <span class="px-6 py-3 {{ $post->type == 'lost' ? 'bg-red-600' : 'bg-green-600' }} text-white text-2xl font-bold rounded-full shadow-xl">
                    {{ strtoupper($post->type) }}
                </span>



                <!-- Post Info -->
                <div class="p-8">
                    <h1 class="text-4xl font-extrabold text-gray-800 mb-4">{{ $post->title }}</h1>

                    <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-6 text-sm md:text-base">
                        <span class="font-bold text-primary">{{ $post->user->name }}</span>
                        <span>•</span>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                        @if($post->location)
                            <span>•</span>
                            <span>{{ $post->location }}</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h3 class="font-bold text-xl text-gray-800 mb-3">Description</h3>
                        <p class="text-lg text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $post->description }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4 mt-8">
                        <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold">
                            {{ substr($post->user->name, 0, 2) }}
                        </div>
                        <div>
                            <p class="font-bold text-xl text-gray-800">{{ $post->user->name }}</p>
                            <p class="text-gray-600">Post Owner</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 sticky top-24 h-fit">
                <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Contact the Owner</h2>
                <p class="text-lg text-gray-600 mb-8">
                    Fill in your details and send a message. The owner will receive it instantly.
                </p>

                <!-- رسالة النجاح -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded-2xl mb-6 text-center font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('messages.store', $post) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Your Name</label>
                        <input type="text" name="sender_name" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:border-primary outline-none transition text-lg"
                               placeholder="Enter your full name" value="{{ old('sender_name') }}">
                        @error('sender_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Your Email or Phone</label>
                        <input type="text" name="sender_contact" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:border-primary outline-none transition text-lg"
                               placeholder="email@uni.edu or 01xxxxxxxxx" value="{{ old('sender_contact') }}">
                        @error('sender_contact')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Your Message</label>
                        <textarea name="message" rows="6" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:border-primary outline-none transition text-lg resize-none"
                                  placeholder="Hi! I think this is mine because...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <p class="text-amber-800 font-medium">
                            Tip: Include proof (photo of your ID, receipt, etc.) to speed things up!
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white text-xl font-bold py-6 rounded-full hover:bg-primary-hover transition shadow-xl hover:shadow-2xl transform hover:scale-105">
                        Send Message Now
                    </button>
                </form>

                <div class="mt-8 text-center text-gray-500 text-sm">
                    <p>Your contact info will be shared only with the post owner.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-10 mt-20">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2025 ULFS. Connecting students, returning belongings.</p>
        </div>
    </footer>
</body>
</html>
