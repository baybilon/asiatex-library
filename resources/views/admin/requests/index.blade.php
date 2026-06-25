@extends('layouts.admin')

@section('content')
<div class="space-y-8 text-slate-700">
    
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Account Registration Requests</h1>
        <p class="text-xs text-slate-400 mt-0.5">Manage new student requests and verify university ID submissions.</p>
    </div>

    <div class="bg-white border border-slate-200/80 rounded-xl p-6 shadow-sm">
        <table class="w-full text-left text-xs text-slate-600">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-semibold bg-slate-50/40">
                    <th class="py-4 px-4">Name</th>
                    <th class="py-4 px-4">Date Joined</th>
                    <th class="py-4 px-4">University ID No</th>
                    <th class="py-4 px-4">University ID Card</th>
                    <th class="py-4 px-4">Status</th>
                    <th class="py-4 px-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium">
                @foreach($requests as $user)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="py-4 px-4 font-bold text-slate-900">{{ $user->name }}</td>
                    <td class="py-4 px-4 text-slate-400">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="py-4 px-4">{{ $user->university_id }}</td>
                    <td class="py-4 px-4">
                        <a href="#" class="text-indigo-600 hover:underline font-bold">View ID Card ↗</a>
                    </td>
                    <td class="py-4 px-4">
                        <span class="px-2 py-0.5 rounded-full text-[10px] uppercase font-bold 
                            {{ $user->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                            {{ $user->status }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <form action="{{ route('admin.requests.update', $user->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit" class="px-4 py-2 rounded-md text-[10px] font-bold transition 
                                {{ $user->status === 'approved' 
                                    ? 'bg-rose-50 text-rose-500 hover:bg-rose-100' 
                                    : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                                {{ $user->status === 'approved' ? 'Revoke Account' : 'Approve Account' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection