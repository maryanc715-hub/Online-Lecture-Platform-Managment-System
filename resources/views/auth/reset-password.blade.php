<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Online Lecture Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans min-h-screen bg-surface flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-xl font-bold text-primary">Reset Password</h1>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-card shadow-glass border border-white p-8">
            @if ($errors->any())
                <div class="mb-4 rounded-btn bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email address</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus
                        class="w-full rounded-btn border-slate-200 bg-slate-50 focus:ring-2 focus:ring-secondary focus:border-secondary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">New password</label>
                    <input type="password" name="password" required
                        class="w-full rounded-btn border-slate-200 bg-slate-50 focus:ring-2 focus:ring-secondary focus:border-secondary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Confirm password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-btn border-slate-200 bg-slate-50 focus:ring-2 focus:ring-secondary focus:border-secondary">
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white rounded-btn py-2.5 font-medium hover:bg-primary-700 transition">
                    Reset Password
                </button>
            </form>
        </div>
    </div>

</body>
</html>
