@extends('layouts.admin')

@section('content')
<div class="space-y-8 text-slate-700" 
     x-data="{ 
        openEditModal: false, 
        openDeleteModal: false,
        deleteActionUrl: '',
        bookData: { id: '', title: '', author: '', category: '', total_stock: '', cover_image: '', description_text: '', description: '' },
        populateEditModal(el) {
            this.bookData.id = el.getAttribute('data-id');
            this.bookData.title = el.getAttribute('data-title');
            this.bookData.author = el.getAttribute('data-author');
            this.bookData.category = el.getAttribute('data-category');
            this.bookData.total_stock = el.getAttribute('data-stock');
            this.bookData.cover_image = el.getAttribute('data-image');
            this.bookData.description_text = el.getAttribute('data-summary');
            this.bookData.description = el.getAttribute('data-desc');
            this.openEditModal = true;
        },
        triggerDeleteConfirmation(actionUrl) {
            this.deleteActionUrl = actionUrl;
            this.openDeleteModal = true;
        }
     }">
    

    <div class="bg-white border border-slate-200/80 rounded-xl p-6 shadow-sm space-y-6">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-bold text-slate-900">All Books</h3>
            <button @click="window.location.href='{{ route('admin.dashboard') }}?open_create=true'" class="text-xs bg-[#1e224e] hover:bg-[#151838] text-white font-bold px-4 py-2.5 rounded-md transition shadow-xs">
                + Create a New Book
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-semibold bg-slate-50/40">
                        <th class="py-4 px-4">Book Title</th>
                        <th class="py-4 px-4">Author</th>
                        <th class="py-4 px-4">Genre</th>
                        <th class="py-4 px-4">Date Created</th>
                        <th class="py-4 px-4 text-center">View</th>
                        <th class="py-4 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($books as $book)
                        <tr class="hover:bg-slate-50/60 transition text-slate-700">
                            <td class="py-4 px-4 flex items-center space-x-3">
                                <div class="w-7 h-10 bg-slate-100 border border-slate-200/60 rounded-sm overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if(!empty($book->cover_image))
                                        <img src="{{ $book->cover_image }}" alt="Thumb" class="w-full h-full object-cover" onerror="this.src=''; this.parentElement.innerHTML='📖';">
                                    @else
                                        <span>📖</span>
                                    @endif
                                </div>
                                <span class="font-bold text-slate-900">{{ $book->title }}</span>
                            </td>
                            <td class="py-4 px-4 text-slate-600">{{ $book->author }}</td>
                            <td class="py-4 px-4 text-slate-500">{{ $book->category }}</td>
                            <td class="py-4 px-4 text-slate-400">
                                {{ $book->created_at ? date('M d, Y', strtotime($book->created_at)) : 'N/A' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <button class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 px-3 py-1.5 rounded transition">
                                    View
                                </button>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center space-x-3.5">
                                    <button 
                                        type="button"
                                        @click="populateEditModal($el)"
                                        data-id="{{ $book->id }}"
                                        data-title="{{ $book->title ?? '' }}"
                                        data-author="{{ $book->author ?? '' }}"
                                        data-category="{{ $book->category ?? '' }}"
                                        data-stock="{{ $book->total_stock ?? 1 }}"
                                        data-image="{{ $book->cover_image ?? '' }}"
                                        data-summary="{{ $book->summary ?? '' }}"
                                        data-desc="{{ $book->description ?? '' }}"
                                        class="text-teal-500 hover:text-teal-600 text-sm transition">
                                        ✏️
                                    </button>
                                    <button type="button" @click="triggerDeleteConfirmation('{{ route('admin.books.delete', $book->id) }}')" class="text-rose-400 hover:text-rose-500 text-sm transition">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No books found match criteria records.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4 border-t border-slate-100">
            {{ $books->appends(request()->query())->links() }}
        </div>
    </div>

    <div x-show="openEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs" @click="openEditModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white border border-slate-100 rounded-xl shadow-xl max-w-2xl w-full p-10 text-sm text-slate-700 space-y-6" @click.stop>
                <div class="space-y-1">
                    <button type="button" @click="openEditModal = false" class="text-xs text-slate-400 hover:text-slate-600 bg-slate-50 px-2.5 py-1 rounded-md border border-slate-200/60 font-medium mb-2 inline-flex items-center">
                        ← Close Window
                    </button>
                    <h3 class="text-2xl font-bold tracking-tight text-[#1e224e]">Modify Book Entry</h3>
                </div>

                <form :action="'/admin/books/' + bookData.id" method="POST" class="space-y-5 pt-2">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Book Title</label>
                            <input type="text" name="title" x-model="bookData.title" required class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Author Name</label>
                            <input type="text" name="author" x-model="bookData.author" required class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Category / Genre</label>
                            <input type="text" name="category" x-model="bookData.category" required class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Total Inventory Stock</label>
                            <input type="number" name="total_stock" x-model="bookData.total_stock" min="1" required class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Cover Image URL</label>
                        <input type="url" name="cover_image" x-model="bookData.cover_image" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Description / Notes</label>
                        <input type="text" name="description_text" x-model="bookData.description_text" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Synopsis / Summary</label>
                        <textarea name="description" x-model="bookData.description" rows="3" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800 resize-y min-h-[80px] max-h-[220px]"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-500 font-semibold border border-slate-200 rounded-lg text-xs transition">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#1e224e] hover:bg-[#151838] text-white font-semibold rounded-lg text-xs transition shadow-sm">Update Book Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="openDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs" @click="openDeleteModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white border border-slate-200 rounded-xl shadow-xl max-w-sm w-full p-6 text-center space-y-4" @click.stop>
                <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-xl mx-auto font-bold">⚠️</div>
                <div class="space-y-1">
                    <h4 class="text-base font-bold text-slate-900">Are you absolutely sure?</h4>
                    <p class="text-xs text-slate-400 px-2">This action is permanent and cannot be undone.</p>
                </div>
                <form :action="deleteActionUrl" method="POST" class="flex justify-center space-x-2.5 pt-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="openDeleteModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition">No, Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg text-xs transition shadow-sm">Yes, Delete Record</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection