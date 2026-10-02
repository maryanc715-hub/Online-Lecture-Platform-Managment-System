<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Online Lecture Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans min-h-screen bg-surface flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <h1 class="text-2xl lg:text-3xl font-bold text-primary">Online Lecture Platform</h1>
            </a>
            <p class="text-slate-600 text-base mt-1">Student Support System</p>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-card shadow-glass border border-white p-8">
            <h2 class="text-lg font-semibold text-primary mb-6">Create your account</h2>

            @if ($errors->any())
                <div class="mb-4 rounded-btn bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <x-auth-input
                    label="Full name"
                    name="name"
                    type="text"
                    icon="user"
                    placeholder="Enter your full name"
                    :value="old('name')"
                    required
                    autofocus
                />
                <x-auth-input
                    label="Email address"
                    name="email"
                    type="email"
                    icon="mail"
                    placeholder="Enter your email address"
                    :value="old('email')"
                    required
                />
                <x-auth-input
                    label="Password"
                    name="password"
                    type="password"
                    icon="lock"
                    placeholder="Create a password"
                    required
                />
                <x-auth-input
                    label="Confirm password"
                    name="password_confirmation"
                    type="password"
                    icon="lock"
                    placeholder="Confirm your password"
                    required
                />
                <button type="submit"
                    class="w-full bg-primary text-white rounded-btn py-2.5 font-medium hover:bg-primary-700 transition">
                    Create Account
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Already have an account? <a href="{{ route('login') }}" class="text-secondary font-medium hover:underline">Sign in</a>
            </p>
        </div>
    </div>

</body>
</html>
