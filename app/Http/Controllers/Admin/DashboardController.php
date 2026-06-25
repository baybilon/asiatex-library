<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {

        $totalBooks = DB::table('books')->count();
        $totalStock = DB::table('books')->sum('total_stock') ?? 0;
        $totalUsers = DB::table('users')->where('role', '!=', 'admin')->count(); 
   
        $borrowedBooksCount = 5; 

        $recentBooks = DB::table('books')->orderBy('id', 'desc')->take(5)->get();

        $borrowRequests = collect([
            (object)[
                'title' => 'CSS in Depth',
                'author' => 'Keith J. Grant',
                'category' => 'Web Development',
                'user_name' => 'Sujata Gunale',
                'date' => 'Jan 02, 2025',
                'cover_image' => null
            ],
            (object)[
                'title' => 'Computer Science Distilled',
                'author' => 'Wladston Ferreira Filho',
                'category' => 'Computer Science',
                'user_name' => 'Sujata Gunale',
                'date' => 'Jan 02, 2025',
                'cover_image' => null
            ],
            (object)[
                'title' => 'Algorithms',
                'author' => 'Robert Sedgewick',
                'category' => 'Computer Science',
                'user_name' => 'Sujata Gunale',
                'date' => 'Jan 02, 2025',
                'cover_image' => null
            ]
        ]);

        return view('admin.dashboard', compact(
            'totalBooks', 
            'totalUsers', 
            'borrowedBooksCount',
            'recentBooks',
            'borrowRequests'
        ));
    }
}