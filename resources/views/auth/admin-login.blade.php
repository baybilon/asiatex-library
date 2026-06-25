@extends('layouts.auth')

@section('title', 'Admin Portal - Login')

@section('content')
<div class="bg-slate-900 text-white rounded-2xl shadow-xl p-8 border border-slate-800">
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-slate-800 text-slate-300 mb-3 border border-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Admin Command Center</h1>
        <p class="text-slate-400 text-sm mt-1">Authorized library staff personnel only</p>
    </div>

    <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Administrative Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-white rounded-xl focus:outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Secure Password</label>
            <input type="password" name="password" required 
                   class="w-full px-3 py-2 bg-slate-800 border border-slate-700 text-white rounded-xl focus:outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 transition">
        </div>

        <button type="submit" 
                class="w-full bg-slate-100 hover:bg-white text-slate-900 font-semibold py-2 px-4 rounded-xl shadow-sm transition duration-150">
            Access Dashboard
        </button>
    </form>

    <div class="mt-6 pt-4 border-t border-slate-800 text-center text-xs">
        <a href="{{ route('login') }}" class="text-slate-400 hover:text-white transition">Return to Member Login Portal</a>
    </div>
</div>
@endsection