@extends('layouts.app')

@section('content')
<section class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-800 pb-4">
        <div>
            <h1 class="text-xl font-bold text-white tracking-tight">Digital Repository</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                @if(!empty($search))
                    Showing results for "<span class="text-indigo-400 font-semibold">{{ $search }}</span>"
                @else
                    Browse our completely indexed inventory collection matrix.
                @endif
            </p>
        </div>

        <form action="{{ route('user.library') }}" method="GET" class="w-full md:w-72">
            <div class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by title or author..." 
                       class="w-full bg-slate-950 border border-slate-800 rounded-md px-3 py-2 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-slate-700 transition">
                @if(!empty($search))
                    <a href="{{ route('user.library') }}" class="absolute right-3 top-2.5 text-slate-500 hover:text-slate-300 text-xs">✕</a>
                @endif
            </div>
        </form>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @forelse($books as $book)
            <div class="bg-slate-950/50 border border-slate-800/80 rounded-lg p-3 hover:border-slate-700 transition flex flex-col justify-between">
                <div>
                    <div class="aspect-[2/3] w-full bg-slate-900 rounded-md overflow-hidden mb-3 relative border border-slate-800/40">
                        @if(!empty($book->cover_image))
                            <img src="{{ $book->cover_image }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xl text-slate-600">📘</div>
                        @endif
                        
                        <span class="absolute top-1.5 left-1.5 text-[9px] font-bold tracking-wide px-1.5 py-0.5 rounded-sm border {{ $book->available_stock > 0 ? 'bg-emerald-950/80 text-emerald-400 border-emerald-900/50' : 'bg-rose-950/80 text-rose-400 border-rose-900/50' }}">
                            {{ $book->available_stock > 0 ? 'In Stock' : 'Out' }}
                        </span>
                    </div>

                    <div class="space-y-0.5">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">{{ $book->category }}</span>
                        <h3 class="font-bold text-xs text-white line-clamp-1 hover:text-slate-300 transition">
                            <a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a>
                        </h3>
                        <p class="text-[11px] text-slate-500 truncate">by {{ $book->author }}</p>
                    </div>
                </div>
                
                <div class="pt-2 mt-3 border-t border-slate-800/60 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500">Qty: <strong class="text-slate-300 font-semibold">{{ $book->available_stock }}</strong></span>
                    <a href="{{ route('books.show', $book->id) }}" class="text-slate-400 font-bold hover:underline">
                        Details →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-slate-950/20 py-16 text-center border border-dashed border-slate-800 rounded-xl text-slate-500 text-sm">
                No catalog records matched your search parameters. <a href="{{ route('user.library') }}" class="text-indigo-400 underline ml-1">Clear filters</a>
            </div>
        @endforelse
    </div>
</section>
@endsection