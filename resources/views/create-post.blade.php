<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Create Post - ULFS</title>
    <!-- Tailwind + Flowbite -->
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
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-4xl font-bold text-primary">ULFS</a>
                    <span class="hidden md:block text-gray-600 text-lg">University Lost & Found</span>
                </div>
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary font-medium">← Back to Home</a>
                    <a href="#" class="text-primary font-semibold hover:underline">My Posts</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Create Post Section -->
    <section class="container mx-auto px-6 py-12">
        <div class="max-w-3xl mx-auto">

            <!-- Title -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-extrabold text-gray-800 mb-4">Create New Post</h1>
                <p class="text-xl text-gray-600">Help someone find what they lost — or get your item back!</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-8 py-4 rounded-2xl mb-8 text-center text-lg font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Post Type Selection -->
                    <div class="mb-10">
                        <label class="block text-2xl font-bold text-gray-800 mb-6">What do you want to post?</label>
                        <div class="grid grid-cols-2 gap-6">
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="lost" class="hidden peer" {{ old('type') == 'lost' ? 'checked' : '' }} required>
                                <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-8 text-center transition-all peer-checked:bg-red-100 peer-checked:border-red-500">
                                    <div class="text-6xl mb-4">Lost Item</div>
                                    <p class="text-red-700 font-bold text-xl">I lost something</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="found" class="hidden peer" {{ old('type') == 'found' ? 'checked' : '' }} required>
                                <div class="bg-green-50 border-2 border-green-200 rounded-2xl p-8 text-center transition-all peer-checked:bg-green-100 peer-checked:border-green-500">
                                    <div class="text-6xl mb-4">Found Item</div>
                                    <p class="text-green-700 font-bold text-xl">I found something</p>
                                </div>
                            </label>
                        </div>
                        @error('type')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-8">
                        <label for="title" class="block text-lg font-semibold text-gray-700 mb-3">Title (Short & Clear)</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               class="w-full px-6 py-4 border-2 @error('title') border-red-500 @else border-gray-200 @enderror rounded-xl focus:border-primary focus:outline-none transition text-lg"
                               placeholder="e.g. Lost Black Backpack, Found Student ID">
                        @error('title')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <label for="description" class="block text-lg font-semibold text-gray-700 mb-3">Description</label>
                        <textarea id="description" name="description" rows="6" required
                                  class="w-full px-6 py-4 border-2 @error('description') border-red-500 @else border-gray-200 @enderror rounded-xl focus:border-primary focus:outline-none transition text-lg resize-none"
                                  placeholder="Where did you lose/find it? Any special marks? Color? Contents?">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-8">
                        <label for="location" class="block text-lg font-semibold text-gray-700 mb-3">Location (Optional but helpful)</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                               class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition text-lg"
                               placeholder="e.g. Engineering Building Gate, Library 3rd Floor">
                    </div>

                    <!-- Upload Image -->
                    <div class="mb-10">
                        <label class="block text-lg font-semibold text-gray-700 mb-3">Add Photo (Optional)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:border-primary transition cursor-pointer">
                            <input type="file" name="image" accept="image/*" class="hidden" id="image-upload">
                            <label for="image-upload" class="cursor-pointer block">
                                <div class="text-6xl text-gray-400 mb-4">Upload Photo</div>
                                <p class="text-gray-600">Click to upload or drag and drop<br><span class="text-sm">(JPG, PNG, WebP up to 5MB)</span></p>
                            </label>
                        </div>
                        @error('image')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                        <p class="text-lg font-medium text-gray-700">
                            Your contact: <span class="text-primary font-bold">{{ auth()->user()->email }}</span>
                        </p>
                        <p class="text-sm text-gray-600 mt-1">People will message you directly via email</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-center gap-6">
                        <a href="{{ route('home') }}" class="px-10 py-5 border-2 border-gray-300 text-gray-700 rounded-full font-bold hover:bg-gray-100 transition text-xl">
                            Cancel
                        </a>
                        <button type="submit" class="px-12 py-5 bg-primary text-white rounded-full font-bold hover:bg-primary-hover transition shadow-xl hover:shadow-2xl transform hover:scale-105 text-xl">
                            Publish Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-10 mt-20">
        <div class="container mx-auto px-6 text-center">
            <p>© 2025 ULFS. Helping students find what matters.</p>
        </div>
    </footer>
</body>
</html>
