@extends('layouts.auth')

@section('title', 'User Login - Campus Library')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Welcome</h1>
        <p class="text-slate-500 text-sm mt-1">Sign in</p>
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