@extends('layouts.auth')

@section('title', 'Admin Portal - Login')

@section('content')
<div class="bg-slate-900 text-white rounded-2xl shadow-xl p-8 border border-slate-800">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-white">Admin Login</h1>
    </div>

    <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-white rounded-xl focus:outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Password</label>
            <input type="password" name="password" required 
                   class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-white rounded-xl focus:outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 transition">
        </div>

        <button type="submit" 
                class="w-full bg-slate-100 hover:bg-white text-slate-900 font-semibold py-2 px-4 rounded-xl shadow-sm transition duration-150">
            Sign In
        </button>
    </form>

    <div class="mt-6 pt-4 border-t border-slate-800 text-center text-xs">
        <a href="{{ route('login') }}" class="text-slate-400 hover:text-white transition">Return to Member Login Portal</a>
    </div>
</div>
@endsection