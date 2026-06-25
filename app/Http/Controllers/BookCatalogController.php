<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use Illuminate\View\View;

class BookCatalogController extends Controller {

    // =========================================================================
    // USER FUNCTIONALITY
    // =========================================================================

    public function home(){
        $books = DB::table('books')->get();
        
        $featuredBook = $books->first(); 

        return view('catalog.home', compact('books', 'featuredBook'));
    }

    public function library(Request $request) {
        $search = trim($request->input('search'));

        $books = DB::table('books')
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%");
                });
            })
            ->get();

        return view('catalog.library', compact('books', 'search'));
    }

    public function show(Book $book): View {
        return view('catalog.show', compact('book'));
    }

    public function borrow(Request $request) {
    $request->validate(['book_id' => 'required|exists:books,id']);

    try {
        $successMessage = DB::transaction(function () use ($request) {

            $book = DB::table('books')->where('id', $request->book_id)->lockForUpdate()->first();

            if (!$book) {
                throw new \Exception('Book not found in records.');
            }

            if ($book->available_stock <= 0) {
                throw new \Exception('This book is currently out of stock.');
            }

            \App\Models\BorrowRecord::create([
                'user_id'       => Auth::id(),
                'book_id'       => $request->book_id,
                'status'        => 'booked',
                'borrowed_date' => now(),
                'due_date'      => now()->addDays(7),
                'return_date'   => null, 
            ]);

            DB::table('books')->where('id', $request->book_id)->decrement('available_stock');

            return 'Request submitted! Wait for librarian approval.';
        });

        return redirect()->back()->with('success', $successMessage);
        
    }catch (\Exception $e) {
        // Using the logger() helper instead of the Log facade
        logger()->error('Borrowing Transaction Aborted: ' . $e->getMessage());
        
        return redirect()->back()->with('error', $e->getMessage());
    }
}

    public function confirmBorrow($id) {
        DB::table('borrow_records')
            ->where('id', $id)
            ->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);

        return back()->with(
            'success',
            'Book request approved and set to active.'
        );
    }


    // =========================================================================
    // ADMIN CRUD
    // =========================================================================

    public function index(Request $request) {
    $search = trim($request->input('search'));

    $books = DB::table('books')
        ->when(!empty($search), function ($query) use ($search) {
            return $query->where('title', 'LIKE', "%{$search}%")
                         ->orWhere('author', 'LIKE', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('admin.books.index', compact('books'));
}

    public function create() {
        return view('admin.books.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'total_stock' => 'required|integer|min:1',
            'summary' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string',
        ]);

        DB::table('books')->insert([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'total_stock' => $request->total_stock,
            'available_stock' => $request->total_stock,
            'summary' => $request->summary,
            'description' => $request->description,
            'cover_image' => $request->cover_image,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Book added successfully!');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'total_stock' => 'required|integer|min:1',
            'summary' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string',
        ]);

        DB::table('books')->where('id', $id)->update([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'total_stock' => $request->total_stock,
            'summary' => $request->summary,
            'description' => $request->description,
            'cover_image' => $request->cover_image,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Book record updated successfully!');
    }

    public function delete($id) {
    
        $book = DB::table('books')->where('id', $id);

        if ($book) {
            $book->delete();
            return redirect()->back()->with('success', 'Book deleted successfully!');
        }

        return redirect()->back()->with('error', 'Book not found.');
    }
}