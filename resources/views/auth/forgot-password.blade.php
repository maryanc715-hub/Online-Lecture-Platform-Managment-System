<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — Online Lecture Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans min-h-screen bg-surface flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-xl font-bold text-primary">Forgot Password</h1>
            <p class="text-slate-600 text-sm">Enter your email to receive a reset link</p>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-card shadow-glass border border-white p-8">
            @if (session('success'))
                <div class="mb-4 rounded-btn bg-secondary/10 border border-secondary/30 text-primary text-sm px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-btn bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
                <button type="submit"
                    class="w-full bg-primary text-white rounded-btn py-2.5 font-medium hover:bg-primary-700 transition">
                    Send Reset Link
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                <a href="{{ route('login') }}" class="text-secondary font-medium hover:underline">Back to login</a>
            </p>
        </div>
    </div>

</body>
</html>
