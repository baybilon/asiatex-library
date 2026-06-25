@extends('layouts.auth')

@section('title', 'Create Account - Campus Library')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Create an account</h1>
        <p class="text-slate-500 text-sm mt-1">Join the campus library network today</p>
    </div>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                   class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-slate-600 focus:ring-2 focus:ring-slate-100 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">University ID Number</label>
            <input type="text" name="university_id" value="{{ old('university_id') }}" required placeholder="e.g., NIM / Student ID"
                   class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-slate-600 focus:ring-2 focus:ring-slate-100 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-slate-600 focus:ring-2 focus:ring-slate-100 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" name="password" required placeholder="Minimum 1 characters"
                   class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-slate-600 focus:ring-2 focus:ring-slate-100 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required 
                   class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-slate-600 focus:ring-2 focus:ring-slate-100 transition">
        </div>

        <button type="submit" 
                class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 px-4 rounded-xl shadow-sm hover:shadow transition duration-150">
            Submit Registration
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-slate-100 text-center text-sm text-slate-600">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-slate-800 hover:underline font-medium">Log in instead</a>
    </div>
</div>
@endsection