<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUSTAKA LOKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col">

    <nav class="bg-slate-950/90 border-b border-slate-800/60 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            
            <a href="{{ route('user.home') }}" class="flex items-center space-x-2">
                <span class="text-lg "><i class="fa-solid fa-book-open text-white"></i></span>
                <span class="text-base font-bold tracking-tight text-white">PUSLOK</span>
            </a>

            <div class="flex items-center space-x-6">
                <a href="{{ route('user.home') }}" class="text-xs font-semibold tracking-wide {{ Route::is('user.home') ? 'text-white' : 'text-slate-400 hover:text-white' }} transition">Home</a>
                <a href="{{ route('user.library') }}" class="text-xs font-semibold tracking-wide {{ Route::is('user.library') ? 'text-white' : 'text-slate-400 hover:text-white' }} transition">Library</a>
                
                @auth
                    <div class="relative group py-4">
                        <button class="flex items-center space-x-2 text-xs font-bold text-slate-200 hover:text-white transition focus:outline-none">
                            <div class="w-6 h-6 rounded-full bg-sky-500/20 text-sky-400 border border-sky-500/30 text-[10px] font-bold flex items-center justify-center uppercase">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <span class="text-[9px] text-slate-500 transition-transform group-hover:rotate-180">▼</span>
                        </button>

                        <div class="absolute right-0 top-full w-44 bg-slate-950 border border-slate-800 rounded-lg shadow-xl p-1.5 hidden group-hover:block animate-in fade-in slide-in-from-top-2 duration-150">
                            <a href="#" class="block px-3 py-2 text-[11px] font-semibold text-slate-400 hover:text-white hover:bg-slate-900 rounded-md transition">
                                Profile
                            </a>
                            <a href="#" class="block px-3 py-2 text-[11px] font-semibold text-slate-400 hover:text-white hover:bg-slate-900 rounded-md transition">
                                Borrowed Books
                            </a>
                            <div class="h-px bg-slate-800 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST" class="block w-full">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-[11px] font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-950/30 rounded-md transition">
                                Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-white hover:text-slate-300 transition">Sign In</a>
                @endauth
            </div>

        </div>
    </nav>

    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-8">
        @yield('content')
    </main>

</body>
</html>