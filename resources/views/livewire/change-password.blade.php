<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-2 text-gray-800">Change Your Password</h2>
    <p class="text-gray-500 mb-6 text-sm">For security reasons, please update your default password.</p>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-semibold">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="updatePassword" class="space-y-5">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Current Password</label>
            <input type="password" wire:model="current_password" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('current_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">New Password</label>
            <input type="password" wire:model="new_password" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
            @error('new_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Confirm New Password</label>
            <input type="password" wire:model="new_password_confirmation" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="pt-2">
            <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg hover:bg-blue-700 font-bold shadow-md transition">
                <i class="fas fa-lock mr-2"></i> Update Password
            </button>
        </div>
    </form>
</div>