<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUSLOK Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex" x-data="{ openBookModal: false }">

    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col justify-between fixed h-full z-40">
        <div class="p-6 space-y-10">
            <div class="flex items-center space-x-3 px-2 py-1">
                <span class="text-2xl"><i class="fa-solid fa-book-open"></i></span>
                <span class="text-lg font-bold tracking-tight text-slate-900">PUSLOK</span>
            </div>
            <nav class="space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-4 px-4 py-3.5 text-[13px] font-semibold rounded-md bg-slate-100 text-slate-900 border border-slate-200/60 transition">
                    <i class="fa-solid fa-house text-base w-5"></i>
                    <span>Home</span>
                </a>

                <a href="users" class="flex items-center space-x-4 px-4 py-3.5 text-[13px] font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-md transition">
                    <i class="fa-solid fa-users text-base w-5"></i>
                    <span>All Users</span>
                </a>

                <a href="books" class="flex items-center space-x-4 px-4 py-3.5 text-[13px] font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-md transition">
                    <i class="fa-solid fa-book text-base w-5"></i>
                    <span>All Books</span>
                </a>

                <a href="#" class="flex items-center space-x-4 px-4 py-3.5 text-[13px] font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-md transition">
                    <i class="fa-solid fa-book-bookmark text-base w-5"></i>
                    <span>Borrow Records</span>
                </a>

                <a href="requests" class="flex items-center space-x-4 px-4 py-3.5 text-[13px] font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-md transition">
                    <i class="fa-solid fa-user-clock text-base w-5"></i>
                    <span>Account Requests</span>
                </a>
            </nav>
        </div>

        <div class="p-5 border-t border-slate-200 bg-slate-50 flex items-center justify-between text-xs">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs shadow-2xs">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <span class="font-bold text-slate-700 truncate max-w-[120px]">{{ Auth::user()->name }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-rose-600 hover:text-rose-700 transition text-xs font-semibold underline">Logout</button>
            </form>
        </div>
    </aside>

    <div class="flex-1 pl-72 flex flex-col min-h-screen">
        <main class="flex-1 p-8 max-w-[1400px] w-full mx-auto">
            <div class="flex justify-between items-center pb-2">
            <div class="mb-14">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ Auth::user()->name }}</h1>
                <p class="text-xs text-slate-400 mt-0.5">Monitor all of your projects and tasks here</p>
            </div>
        </div>
            @yield('content')
        </main>
    </div>
@yield('scripts')
</body>
</html>