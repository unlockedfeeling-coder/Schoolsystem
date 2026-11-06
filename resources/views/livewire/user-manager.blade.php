<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Manage Staff, Parent & Student Accounts</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">{{ session('message') }}</div>
    @endif

    <!-- Create Account Form -->
    <form wire:submit.prevent="save" class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                <input type="text" wire:model="name" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email Address</label>
                <input type="email" wire:model="email" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Role</label>
                <select wire:model="role" class="border border-gray-300 p-2.5 w-full rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="teacher">Teacher</option>
                    <option value="parent">Parent</option>
                    <option value="student">Student</option> <!-- NEW STUDENT OPTION -->
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-bold shadow-md transition w-full">
                    <i class="fas fa-user-plus mr-2"></i> Create Account
                </button>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-3"><i class="fas fa-info-circle mr-1"></i> If no password is provided, the default password will be <strong>password</strong>.</p>
    </form>

    <!-- Users List -->
    <h3 class="font-bold text-lg mb-4">Existing Accounts</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-bold">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            @if($user->role === 'teacher')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Teacher</span>
                            @elseif($user->role === 'parent')
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold">Parent</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold">Student</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <button wire:click="delete({{ $user->id }})" wire:confirm="Delete this user?" class="text-red-500 hover:text-red-700 font-bold text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-6 text-center text-gray-400">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>