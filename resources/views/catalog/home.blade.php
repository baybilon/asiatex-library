@extends('layouts.app')

@section('content')
    
    @if($featuredBook)
        <section class="bg-slate-950 border border-slate-800 rounded-xl p-8 text-white mb-10 shadow-sm flex flex-col lg:flex-row items-center gap-8 relative">
            <div class="flex-1 space-y-4 text-center lg:text-left">
                <span class="bg-slate-900 text-slate-300 font-bold uppercase tracking-wider text-[10px] px-2.5 py-1 rounded-sm border border-slate-800">
                    Featured Recommendation
                </span>
                <h1 class="text-2xl md:text-4xl font-bold tracking-tight text-white">
                    {{ $featuredBook->title }}
                </h1>
                <p class="text-slate-400 text-xs">
                    by <span class="text-white font-semibold">{{ $featuredBook->author }}</span> • <span class="text-slate-300 font-bold">{{ $featuredBook->category }}</span>
                </p>
                
                @if(!empty($featuredBook->summary))
                    <p class="text-slate-400 text-xs leading-relaxed max-w-xl">
                        "{{ $featuredBook->summary }}"
                    </p>
                @endif

                <div class="pt-2 flex flex-col sm:flex-row justify-center lg:justify-start items-center gap-3">
                    <a href="{{ route('books.show', $featuredBook->id) }}" class="w-full sm:w-auto px-4 py-2 bg-white hover:bg-slate-100 text-slate-950 font-bold text-xs rounded-sm transition text-center">
                        Read Synopsis
                    </a>
                    <button class="w-full sm:w-auto px-4 py-2 bg-slate-900 hover:bg-slate-850 border border-slate-800 text-white font-semibold text-xs rounded-sm transition text-center">
                        Borrow This Book
                    </button>
                </div>
            </div>

            <div class="w-40 h-56 flex-shrink-0">
                @if(!empty($featuredBook->cover_image))
                    <img src="{{ $featuredBook->cover_image }}" alt="Cover" class="w-full h-full object-cover rounded-lg shadow border border-slate-800">
                @else
                    <div class="w-full h-full bg-slate-900 rounded-lg flex items-center justify-center font-bold text-xl text-slate-500 border border-slate-800">
                        📖
                    </div>
                @endif
            </div>
        </section>
    @endif

    <section class="space-y-6">
        <div class="flex justify-between items-center border-b border-slate-800 pb-3">
            <div>
                <h2 class="text-lg font-bold text-white">Explore the Library</h2>
                <p class="text-xs text-slate-500 mt-0.5">Browse available resource books currently stocked in our database.</p>
            </div>
            <a href="{{ route('user.library') }}" class="text-xs font-bold text-slate-400 hover:text-white transition">
                View Catalog Matrix →
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @forelse($books as $book)
                <div class="bg-slate-950/50 border border-slate-800/80 rounded-lg p-3 hover:border-slate-700 transition flex flex-col justify-between">
                    <div>
                        <div class="aspect-[2/3] w-full bg-slate-900 rounded-md overflow-hidden mb-3 relative border border-slate-800/40">
                            @if(!empty($book->cover_image))
                                <img src="{{ $book->cover_image }}" alt="Cover" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xl text-slate-600">
                                    📘
                                </div>
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
                <div class="col-span-full bg-slate-950/40 py-12 text-center border border-dashed border-slate-800 rounded-xl text-slate-500 text-sm">
                    No books have been logged in the library inventory catalog just yet.
                </div>
            @endforelse
        </div>
    </section>

@endsection