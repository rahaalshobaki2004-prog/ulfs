<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login  • ULFS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #e8f4f8 0%, #f0f9fb 100%); }
        .primary { @apply bg-[#006d77] hover:bg-[#005f6a] text-white; }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-[#006d77]">ULFS</h1>
            <p class="text-gray-600 mt-2">University-Lost-and-Found-System</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center"> Login</h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">E-mail</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-[#006d77]/20 focus:border-[#006d77] transition @error('email') is-invalid @enderror"
                        placeholder="email address" value="{{ old('email') }}" >
                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" name="password" required
                        class="@error('password') is-invalid @enderror w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-[#006d77]/20 focus:border-[#006d77] transition"
                        placeholder="••••••••">
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <a href="{{ route('password.request') }}" class="text-sm text-[#2a9d8f] hover:underline"> Forget Password ? </a>
                </div>

                <button type="submit"
                        class="w-full primary font-bold py-4 rounded-lg shadow-lg hover:shadow-xl transition text-lg">
                    Login
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Don't have account ?
                    <a href="{{ route('register') }}" class="font-bold text-[#006d77] hover:underline"> Register</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
