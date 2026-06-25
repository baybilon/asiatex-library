@extends('layouts.admin')

@section('content')
<div class="space-y-8 text-slate-700" 
     x-data="{ 
        openCreateModal: {{ $errors->any() ? 'true' : 'false' }}, 
        openEditModal: false,
        openDeleteModal: false,
        deleteActionUrl: '',
        editActionUrl: '',
        userData: { id: '', name: '', email: '', role: '', university_id: '' },
        populateEditModal(el) {
            this.userData.id = el.getAttribute('data-id');
            this.userData.name = el.getAttribute('data-name');
            this.userData.email = el.getAttribute('data-email');
            this.userData.role = el.getAttribute('data-role');
            this.userData.university_id = el.getAttribute('data-university-id');
            this.editActionUrl = el.getAttribute('data-action');
            this.openEditModal = true;
        },
        triggerDeleteConfirmation(actionUrl) {
            this.deleteActionUrl = actionUrl;
            this.openDeleteModal = true;
        }
     }">
    
    <div class="flex justify-between items-center pb-2">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">User Management</h1>
            <p class="text-xs text-slate-400 mt-0.5">Control system users, update access profiles, and assign structural system permissions</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200/80 rounded-xl p-6 shadow-sm space-y-6">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-bold text-slate-900">All Registered Users</h3>
            <button @click="openCreateModal = true" class="text-xs bg-[#1e224e] hover:bg-[#151838] text-white font-bold px-4 py-2.5 rounded-md transition shadow-xs">
                + Create a New User
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-semibold bg-slate-50/40">
                        <th class="py-4 px-4">User Details</th>
                        <th class="py-4 px-4">Email Address</th>
                        <th class="py-4 px-4">Account Type / Role</th>
                        <th class="py-4 px-4">Registration Date</th>
                        <th class="py-4 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/60 transition text-slate-700">
                            <td class="py-4 px-4 flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 font-bold text-slate-700 flex items-center justify-center uppercase shadow-xs">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <span class="font-bold text-slate-900">{{ $user->name }}</span>
                            </td>
                            <td class="py-4 px-4 text-slate-600">{{ $user->email }}</td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 text-[10px] uppercase font-bold tracking-wider rounded-md {{ ($user->role ?? 'user') === 'admin' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $user->role ?? 'User' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-slate-400">
                                {{ $user->created_at ? date('M d, Y', strtotime($user->created_at)) : 'N/A' }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center space-x-3.5">
                                    
                                        @if($user->id !== auth()->id())
                                            <button 
                                                type="button"
                                                @click="populateEditModal($el)"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name ?? '' }}"
                                                data-email="{{ $user->email ?? '' }}"
                                                data-role="{{ $user->role ?? 'user' }}"
                                                data-university-id="{{ $user->university_id ?? '' }}"
                                                data-action="{{ route('admin.users.update', $user->id) }}"
                                                class="text-teal-500 hover:text-teal-600 text-sm transition">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                            <button type="button" @click="triggerDeleteConfirmation('{{ route('admin.users.delete', $user->id) }}')" class="text-rose-400 hover:text-rose-500 text-sm transition">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @else
                                            
                                            <span class="text-[10px] text-slate-400 italic">Current Session</span>
                                        @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No user records currently matched parameters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-600">
            <div>
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
            </div>

            @if($users->hasPages())
                <nav class="flex items-center space-x-1" role="navigation">
                    @if($users->onFirstPage())
                        <span class="px-3 py-2 bg-slate-50 text-slate-300 border border-slate-200 rounded-lg cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="px-3 py-2 bg-white text-slate-700 border border-slate-200 rounded-lg hover:bg-slate-50 transition">Previous</a>
                    @endif

                    @foreach($users->renderableElements() as $element)
                        @if(is_string($element))
                            <span class="px-3 py-2 text-slate-400">{{ $element }}</span>
                        @endif

                        @if(is_array($element))
                            @foreach($element as $page => $url)
                                @if($page == $users->currentPage())
                                    <span class="px-3.5 py-2 bg-[#1e224e] text-white rounded-lg border border-[#1e224e] font-bold shadow-xs">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3.5 py-2 bg-white text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 transition">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="px-3 py-2 bg-white text-slate-700 border border-slate-200 rounded-lg hover:bg-slate-50 transition">Next</a>
                    @else
                        <span class="px-3 py-2 bg-slate-50 text-slate-300 border border-slate-200 rounded-lg cursor-not-allowed">Next</span>
                    @endif
                </nav>
            @endif
        </div>
    </div>

    <div x-show="openCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs" @click="openCreateModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white border border-slate-100 rounded-xl shadow-xl max-w-lg w-full p-10 text-sm text-slate-700 space-y-6" @click.stop>
                <div class="space-y-1">
                    <button type="button" @click="openCreateModal = false" class="text-xs text-slate-400 hover:text-slate-600 bg-slate-50 px-2.5 py-1 rounded-md border border-slate-200/60 font-medium mb-2 inline-flex items-center">
                        ← Close Window
                    </button>
                    <h3 class="text-2xl font-bold tracking-tight text-[#1e224e]">Register New User</h3>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5 pt-2">
                    @csrf
    
                   @if ($errors->any())
                        <div class="p-4 mb-4 text-xs font-semibold text-rose-600 bg-rose-50 border border-rose-200 rounded-lg">
                            <p class="font-bold mb-1">Fix the following rules:</p>
                            <ul class="list-disc pl-4 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Full Name</label>
                        <input type="text" name="name" required placeholder="John Doe" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" required placeholder="johndoe@example.com" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">System Permission Tier / Role</label>
                        <select name="role" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                            <option value="user" selected>User / Subscriber</option>
                            <option value="admin">Admin / System Manager</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">University ID / Student Number</label>
                        <input type="text" name="university_id" required placeholder="e.g., 202610192" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Account Password</label>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openCreateModal = false" class="px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-500 font-semibold border border-slate-200 rounded-lg text-xs transition">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#1e224e] hover:bg-[#151838] text-white font-semibold rounded-lg text-xs transition shadow-sm">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="openEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs" @click="openEditModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white border border-slate-100 rounded-xl shadow-xl max-w-lg w-full p-10 text-sm text-slate-700 space-y-6" @click.stop>
                <div class="space-y-1">
                    <button type="button" @click="openEditModal = false" class="text-xs text-slate-400 hover:text-slate-600 bg-slate-50 px-2.5 py-1 rounded-md border border-slate-200/60 font-medium mb-2 inline-flex items-center">
                        ← Close Window
                    </button>
                    <h3 class="text-2xl font-bold tracking-tight text-[#1e224e]">Modify User Account</h3>
                </div>

                <form :action="editActionUrl" method="POST" class="space-y-5 pt-2">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Display Profile Name</label>
                        <input type="text" name="name" x-model="userData.name" required class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email Identity Address</label>
                        <input type="email" name="email" x-model="userData.email" required class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">System Permission Tier / Role</label>
                        <select name="role" x-model="userData.role" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                            <option value="user">User / Subscriber</option>
                            <option value="admin">Admin / System Manager</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">University ID / Student Number</label>
                        <input type="text" name="university_id" x-model="userData.university_id" required class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>
                    <div class="border-t border-slate-100 pt-4">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Override Password</label>
                        <p class="text-[11px] text-slate-400 mb-2">Leave blank if you don't wish to change their account credentials</p>
                        <input type="password" name="password" placeholder="••••••••" class="w-full border border-slate-200/70 rounded-lg px-4 py-3 bg-slate-50/50 focus:outline-none focus:border-indigo-500 text-sm text-slate-800">
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openEditModal = false" class="px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-500 font-semibold border border-slate-200 rounded-lg text-xs transition">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#1e224e] hover:bg-[#151838] text-white font-semibold rounded-lg text-xs transition shadow-sm">Save Profile Changes</button>
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
                    <h4 class="text-base font-bold text-slate-900">Delete this user account?</h4>
                    <p class="text-xs text-slate-400 px-2">This will instantly drop this profile record. This action cannot be reversed.</p>
                </div>
                <form :action="deleteActionUrl" method="POST" class="flex justify-center space-x-2.5 pt-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="openDeleteModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition">No, Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg text-xs transition shadow-sm">Yes, Terminate Profile</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection