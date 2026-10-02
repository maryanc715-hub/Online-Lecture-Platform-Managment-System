<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Approval — Online Lecture Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans min-h-screen bg-surface flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-xl font-bold text-primary">Account Pending Approval</h1>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-card shadow-glass border border-white p-8 text-center">
            <p class="text-slate-600 mb-6">Thanks for registering! Your account is pending approval by an administrator. You will be able to access the platform once your account has been approved.</p>

            @if (session('success'))
                <div class="mb-4 rounded-btn bg-secondary/10 border border-secondary/30 text-primary text-sm px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <p class="text-sm text-slate-500 mb-4">If you have any questions, please contact support.</p>

            <div class="mt-6 pt-4 border-t border-slate-200 space-y-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-500 hover:text-primary">Log out</button>
                </form>
                <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-primary">Back to login</a>
            </div>
        </div>
    </div>

</body>
</html>
