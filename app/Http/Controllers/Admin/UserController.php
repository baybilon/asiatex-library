<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller {
    public function index(Request $request) {
        $search = trim($request->input('search'));

        $users = DB::table('users')
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                             ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

        public function store(Request $request) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:1',
                'role' => 'required|string',
                'university_id' => 'required|string|max:12', 
            ]);

            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'university_id' => $request->university_id,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'New user profile created successfully!');
        }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
            'university_id' => 'required|string|max:12', 
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'university_id' => $request->university_id, 
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:1']);
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        return redirect()->back()->with('success', 'User profile updated smoothly.');
    }

    public function delete($id){
        DB::table('users')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'User completely dropped from records.');
    }

    // --- ACCOUNT REQUESTS METHODS ---
    public function requestsIndex() {

        $requests = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        return view('admin.requests.index', compact('requests'));
    }

    public function updateStatus(Request $request, $id) {
        $user = User::findOrFail($id);

        $newStatus = ($user->status === 'approved') ? 'pending' : 'approved';
        
        $user->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Account status updated successfully.');
    }
}