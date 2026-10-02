<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Online Lecture Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans min-h-screen bg-surface flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-primary">Online Lecture Platform</h1>
            <p class="text-slate-600 text-base mt-1">Student Support System</p>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-card shadow-glass border border-white p-8">
            <h2 class="text-lg font-semibold text-primary mb-6">Sign in to your account</h2>

            @if ($errors->any())
                <div class="mb-4 rounded-btn bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <x-auth-input
                    label="Email address"
                    name="email"
                    type="email"
                    icon="mail"
                    placeholder="Enter your email address"
                    :value="old('email')"
                    required
                    autofocus
                />
                <x-auth-input
                    label="Password"
                    name="password"
                    type="password"
                    icon="lock"
                    placeholder="Enter your password"
                    required
                />
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-secondary focus:ring-secondary">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="text-secondary font-medium hover:underline">Forgot password?</a>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white rounded-btn py-2.5 font-medium hover:bg-primary-700 transition">
                    Sign in
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                New student? <a href="{{ route('register') }}" class="text-secondary font-medium hover:underline">Create an account</a>
            </p>
        </div>
    </div>

</body>
</html>
