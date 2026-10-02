<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Lecture Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans min-h-screen bg-surface">

    <div class="min-h-screen flex flex-col">
        <nav class="flex items-center justify-between px-6 lg:px-12 py-4 bg-white/80 backdrop-blur border-b border-slate-200">
            <div class="flex items-center gap-2">
                <span class="font-bold text-lg text-primary">Lecture Platform</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-primary transition">Sign in</a>
                <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium bg-primary text-white rounded-btn hover:bg-primary-700 transition">Register</a>
            </div>
        </nav>

        <main class="flex-1 flex items-center justify-center px-6 py-16">
            <div class="max-w-2xl text-center">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-primary mb-4">Online Lecture Platform</h1>
                <p class="text-lg text-slate-600 mb-8">A complete student support system — manage courses, assignments, grades, and support tickets all in one place.</p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-primary text-white rounded-btn font-semibold hover:bg-primary-700 transition">Sign in</a>
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white border-2 border-primary text-primary rounded-btn font-semibold hover:bg-primary/5 transition">Create Account</a>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-16 text-sm">
                    <div class="bg-white/80 backdrop-blur rounded-card p-5 border border-slate-200">
                        <div class="text-2xl font-bold text-primary mb-1">4</div>
                        <div class="text-slate-500">User Roles</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur rounded-card p-5 border border-slate-200">
                        <div class="text-2xl font-bold text-primary mb-1">20+</div>
                        <div class="text-slate-500">Database Tables</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur rounded-card p-5 border border-slate-200">
                        <div class="text-2xl font-bold text-primary mb-1">Full</div>
                        <div class="text-slate-500">RBAC System</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur rounded-card p-5 border border-slate-200">
                        <div class="text-2xl font-bold text-primary mb-1">100%</div>
                        <div class="text-slate-500">Open Source</div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="text-center text-sm text-slate-400 py-6 border-t border-slate-200">
            &copy; {{ date('Y') }} Online Lecture Platform. All rights reserved.
        </footer>
    </div>

</body>
</html>
