<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book - BookWise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fa] text-slate-800 min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="w-full max-w-2xl bg-white border border-slate-100 rounded-3xl p-8 sm:p-10 shadow-sm">
        
        <header class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-semibold text-slate-400 hover:text-indigo-600 bg-slate-100/60 hover:bg-slate-100 px-3 py-1.5 rounded-lg transition inline-flex items-center gap-1">
                <span>←</span> Back to Dashboard
            </a>
            <h1 class="text-2xl font-bold text-indigo-950 mt-4">Add a New Book</h1>
            <p class="text-sm text-slate-400 mt-0.5">Fill in the fields below to add a new title to the library collection inventory.</p>
        </header>

        <form action="{{ route('admin.books.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Book Title</label>
                    <input type="text" name="title" required placeholder="e.g. JavaScript: The Good Parts"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm placeholder-slate-400 text-slate-800 focus:outline-none focus:border-indigo-500/40 focus:ring-4 focus:ring-indigo-500/5 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Author Name</label>
                    <input type="text" name="author" required placeholder="e.g. Douglas Crockford"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm placeholder-slate-400 text-slate-800 focus:outline-none focus:border-indigo-500/40 focus:ring-4 focus:ring-indigo-500/5 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Category / Genre</label>
                    <input type="text" name="category" required placeholder="e.g. Programming, Fiction"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm placeholder-slate-400 text-slate-800 focus:outline-none focus:border-indigo-500/40 focus:ring-4 focus:ring-indigo-500/5 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Total Inventory Stock</label>
                    <input type="number" name="total_stock" min="1" required placeholder="e.g. 10"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm placeholder-slate-400 text-slate-800 focus:outline-none focus:border-indigo-500/40 focus:ring-4 focus:ring-indigo-500/5 transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Synopsis / Summary</label>
                <textarea name="description" rows="5" placeholder="Write a short summary about the book's contents..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm placeholder-slate-400 text-slate-800 focus:outline-none focus:border-indigo-500/40 focus:ring-4 focus:ring-indigo-500/5 transition"></textarea>
            </div>

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 rounded-xl border border-slate-100 hover:bg-slate-50 text-sm font-semibold text-slate-500 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-950 hover:bg-indigo-900 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    Save Book Record
                </button>
            </div>
        </form>
    </div>

</body>
</html>