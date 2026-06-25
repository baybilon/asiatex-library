@extends('layouts.auth')

@section('title', 'User Login - Campus Library')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 text-slate-700 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M12 3.75l1.5 1.5Q15 6.75 15 9v12M12 3.75l-1.5 1.5Q9 6.75 9 9v12" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Welcome back</h1>
        <p class="text-slate-500 text-sm mt-1">Sign in to manage your borrowed books</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-slate-600 focus:ring-2 focus:ring-slate-100 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" name="password" required 
                   class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-slate-600 focus:ring-2 focus:ring-slate-100 transition">
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-slate-300 text-slate-700 focus:ring-slate-500">
            <label for="remember" class="ml-2 text-sm text-slate-600">Remember me for 30 days</label>
        </div>

        <button type="submit" 
                class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 px-4 rounded-xl shadow-sm hover:shadow transition duration-150">
            Sign In
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-slate-100 text-center text-sm text-slate-600">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-slate-800 hover:underline font-medium">Create one here</a>
    </div>
</div>
<div class="text-center mt-4">
    <a href="{{ route('admin.login') }}" class="text-xs text-slate-400 hover:text-slate-600 transition">Are you an administrator? Switch to Admin Login</a>
</div>
@endsection