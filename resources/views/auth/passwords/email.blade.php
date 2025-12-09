

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Reset Password - ULFS</title>

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
<body class="bg-gray-50 min-h-screen gradient-bg flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <!-- Logo + Title -->
        <div class="text-center mb-12">
            <a href="index.html" class="text-5xl font-bold text-primary inline-block">ULFS</a>
            <p class="text-xl text-gray-600 mt-3">Reset Your Password</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-10">

            <!-- Success Message (hidden by default) -->
            <div id="success-message" class="hidden bg-green-50 border border-green-200 text-green-800 rounded-2xl p-6 text-center mb-8">
                <p class="text-lg font-bold">Check your email!</p>
                <p class="mt-2">We’ve sent you a password reset link.</p>
            </div>

             @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

            <!-- Reset Form -->
            <form id="reset-form" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-8">
                    <label for="email" class="block text-lg font-semibold text-gray-700 mb-3">
                         Email
                    </label>
                    <input type="email" id="email" name="email" required
                           class="@error('email') is-invalid @enderror w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition text-lg"
                           placeholder="enter your e-mail">
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>

                <button type="submit"
                        class="w-full bg-primary text-white text-xl font-bold py-5 rounded-full hover:bg-primary-hover transition shadow-xl hover:shadow-2xl transform hover:scale-105">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Remembered your password?
                    <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Back to Login</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-10 text-gray-500 text-sm">
            © 2025 ULFS - University Lost & Found Platform
        </div>
    </div>

    <!-- Fake Success Script (just for demo) -->
    <script>
        document.getElementById('reset-form').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('reset-form').classList.add('hidden');
            document.getElementById('success-message').classList.remove('hidden');
        });
    </script>
</body>
</html>
