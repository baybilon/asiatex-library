@extends('layouts.admin')

@section('content')
<div class="space-y-8 text-slate-700">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200/80 rounded-xl p-6 flex flex-col justify-between h-32 shadow-sm">
            <div class="flex justify-between items-center">
                <span class="text-xs font-semibold text-slate-400 tracking-wide">Borrowed Books</span>
                <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-100">▲ 5</span>
            </div>
            <p class="text-4xl font-bold tracking-tight text-slate-900">{{ sprintf('%02d', $borrowedBooksCount) }}</p>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-6 flex flex-col justify-between h-32 shadow-sm">
            <div class="flex justify-between items-center">
                <span class="text-xs font-semibold text-slate-400 tracking-wide">Total Users</span>
                <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-100">▲ 16</span>
            </div>
            <p class="text-4xl font-bold tracking-tight text-slate-900">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-6 flex flex-col justify-between h-32 shadow-sm">
            <div class="flex justify-between items-center">
                <span class="text-xs font-semibold text-slate-400 tracking-wide">Total Books</span>
                <span class="text-[10px] text-rose-600 font-bold bg-rose-50 px-1.5 py-0.5 rounded border border-rose-100">▼ -17</span>
            </div>
            <p class="text-4xl font-bold tracking-tight text-slate-900">{{ $totalBooks }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <div class="lg:col-span-7 bg-white border border-slate-200/80 rounded-xl p-6 shadow-sm space-y-5">
            <div class="flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Borrow Requests</h3>
                <a href="#" class="text-xs font-bold text-slate-500 hover:text-slate-800 bg-slate-100 px-3 py-1.5 rounded-md transition">View All</a>
            </div>

            <div class="space-y-3">
                @forelse($borrowRequests as $req)
                    <div class="bg-slate-100/80 border border-slate-200/40 rounded-md p-4 flex items-center justify-between shadow-xs hover:bg-slate-100 transition">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-16 bg-slate-200 border border-slate-300/60 rounded-sm overflow-hidden flex-shrink-0 flex items-center justify-center">
                                @if(!empty($req->cover_image))
                                    <img src="{{ $req->cover_image }}" alt="Cover" class="w-full h-full object-cover" onerror="this.src=''; this.parentElement.innerHTML='📘';">
                                @else
                                    <span class="text-xl text-slate-400">📘</span>
                                @endif
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="text-sm font-bold text-slate-900 leading-tight">{{ $req->title }}</h4>
                                <p class="text-xs text-slate-400 font-medium">by {{ $req->author }} <span class="mx-1 text-slate-300">•</span> {{ $req->category }}</p>
                                <div class="flex items-center space-x-3 pt-1.5">
                                    <span class="text-[10px] bg-white text-blue-600 font-semibold px-2 py-0.5 rounded border border-slate-200/60 shadow-2xs">{{ $req->user_name }}</span>
                                    <span class="text-[10px] text-slate-400">📅 {{ $req->date }}</span>
                                </div>
                            </div>
                        </div>
                        <button class="text-slate-400 hover:text-slate-800 bg-white border border-slate-200/60 p-2 rounded shadow-2xs transition">👁️</button>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic py-4">No active requests found.</p>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-5 bg-white border border-slate-200/80 rounded-xl p-6 shadow-sm space-y-5">
            <div class="flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Recently Added Books</h3>
                <a href="#" class="text-xs font-bold text-slate-500 hover:text-slate-800 bg-slate-100 px-3 py-1.5 rounded-md transition">View All</a>
            </div>

            <div class="space-y-3">
                <button @click="openBookModal = true" class="w-full group bg-slate-50/50 border border-dashed border-slate-300 hover:border-slate-400 rounded-md p-4 flex items-center justify-center space-x-3 transition">
                    <div class="w-6 h-6 flex items-center justify-center bg-white border border-slate-200 rounded-full text-slate-500 group-hover:text-slate-800 shadow-2xs text-xs font-bold">+</div>
                    <span class="text-xs font-bold text-slate-500 group-hover:text-slate-800 transition">Add New Book</span>
                </button>

                @forelse($recentBooks as $book)
                    <div class="bg-slate-100/80 border border-slate-200/40 rounded-md p-4 flex items-center space-x-4 shadow-xs hover:bg-slate-100 transition">
                        <div class="w-12 h-16 bg-slate-200 border border-slate-300/60 rounded-sm overflow-hidden flex-shrink-0 flex items-center justify-center">
                            @if(!empty($book->cover_image))
                                <img src="{{ $book->cover_image }}" alt="Book Cover" class="w-full h-full object-cover" onerror="this.src=''; this.parentElement.innerHTML='📖';">
                            @else
                                <span class="text-xl text-slate-400">📖</span>
                            @endif
                        </div>
                        <div class="space-y-0.5 min-w-0 flex-1">
                            <h4 class="text-sm font-bold text-slate-900 truncate leading-tight">{{ $book->title }}</h4>
                            <p class="text-xs text-slate-400 font-medium truncate">by {{ $book->author }} <span class="mx-1 text-slate-300">•</span> {{ $book->category }}</p>
                            <p class="text-[10px] text-slate-400 pt-1">📅 Added Recently</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic py-4">No recent library logs found.</p>
                @endforelse
            </div>
        </div>

    </div>

    <div x-show="openBookModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <div class="fixed inset-0 bg-slate-900/20 backdrop-blur-xs" @click="openBookModal = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white border border-slate-100 rounded-xl shadow-xl max-w-2xl w-full p-10 text-sm text-slate-700 space-y-6" @click.stop>
                
                <div class="space-y-1">
                    <h3 class="text-2xl font-bold tracking-tight text-slate-950">Add a New Book</h3>
                    <p class="text-xs text-slate-400">Fill in the fields below to add a new title to the library collection inventory.</p>
                </div>

                <form action="{{ route('admin.books.store') }}" method="POST" class="space-y-5 pt-2">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-2">Book Title</label>
                            <input type="text" name="title" required placeholder="e.g. JavaScript: The Good Parts" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 placeholder-slate-300 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-2">Author Name</label>
                            <input type="text" name="author" required placeholder="e.g. Douglas Crockford" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 placeholder-slate-300 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-2">Category / Genre</label>
                            <input type="text" name="category" required placeholder="e.g. Programming, Fiction" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 placeholder-slate-300 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-2">Total Inventory Stock</label>
                            <input type="number" name="total_stock" min="1" required placeholder="e.g. 10" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 placeholder-slate-300 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-2">Cover Image URL</label>
                        <input type="url" name="cover_image" placeholder="https://images-na.ssl-images-amazon.com/images/I/5131OWYQ86L.jpg" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 placeholder-slate-300 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-2">Description</label>
                        <input type="text" name="description" placeholder="Enter secondary catalog information, tag lines, or acquisition codes..." class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 placeholder-slate-300 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-2">Summary</label>
                        <textarea  name="summary" placeholder="Write a short summary about the book's contents..." class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 placeholder-slate-300 focus:outline-none focus:border-indigo-500 text-sm text-slate-800 resize-y h-48 max-h-56"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openBookModal = false" class="px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-500 font-semibold border border-slate-200 rounded-lg text-xs transition">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#1e224e] hover:bg-[#151838] text-white font-semibold rounded-lg text-xs transition shadow-sm">Save Book Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection