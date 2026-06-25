

@if (session('error'))
    <div class="bg-rose-500/10 border border-rose-500 text-rose-500 p-4 rounded-lg mb-6 text-sm">
        {{ session('error') }}
    </div>
@endif

@extends('layouts.app')

@section('content')


<div class="space-y-6">
    <a href="{{ route('user.library') }}" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-white transition gap-1">
        ← Back to Repository Catalog
    </a>

    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 md:p-8 flex flex-col md:flex-row gap-8 shadow-md">
        
        <div class="w-full md:w-56 flex-shrink-0 flex justify-center md:block">
            <div class="w-44 h-64 bg-slate-900 border border-slate-800 rounded-lg overflow-hidden shadow">
                @if(!empty($book->cover_image))
                    <img src="{{ $book->cover_image }}" alt="Cover Asset" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-3xl text-slate-600">No-img</div>
                @endif
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="space-y-1.5 text-center md:text-left">
                    <span class="bg-slate-900 text-slate-400 border border-slate-800 text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-sm">
                        {{ $book->category }}
                    </span>
                    <h1 class="text-xl md:text-3xl font-bold text-white tracking-tight mt-2">
                        {{ $book->title }}
                    </h1>
                    <p class="text-sm text-slate-400 font-medium">
                        by <span class="text-slate-200 font-semibold">{{ $book->author }}</span>
                    </p>
                </div>

                @if(!empty($book->summary))
                    <div class="bg-slate-900/60 border-l-2 border-slate-700 p-3 rounded-r-md text-xs italic text-slate-300">
                        "{{ $book->summary }}"
                    </div>
                @endif

                <div class="space-y-1.5">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Synopsis Background</h2>
                    <p class="text-xs text-slate-400 leading-relaxed font-light">
                        {{ $book->description ?? 'No detailed textual breakdown or index summary is currently saved for this record catalog.' }}
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-400 space-x-4">
                    <span>Total Inventory: <strong class="text-white font-semibold">{{ $book->total_stock }}</strong></span>
                    <span class="text-slate-700">|</span>
                    <span>Available Allocations: <strong class="{{ $book->available_stock > 0 ? 'text-emerald-400' : 'text-rose-400' }} font-semibold">{{ $book->available_stock }}</strong></span>
                </div>

                <form action="{{ route('user.borrow') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    @if($book->available_stock > 0)
                        <button class="w-full sm:w-auto px-5 py-2 bg-white hover:bg-slate-100 text-slate-950 font-bold text-xs rounded-sm transition shadow">
                            Borrow this book
                        </button>
                    @else
                        <button disabled class="w-full sm:w-auto px-5 py-2 bg-slate-900 border border-slate-800 text-slate-600 font-bold text-xs rounded-sm cursor-not-allowed">
                            Allocation Exhausted
                        </button>
                    @endif
                </form>
            </div>

        </div>
    </div>
</div>
@endsection