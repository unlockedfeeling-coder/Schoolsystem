<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Admission Applications</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-bold">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 font-bold">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <th class="p-4">Passport</th>
                    <th class="p-4">Student Name</th>
                    <th class="p-4">Class Applied</th>
                    <th class="p-4">Parent/Guardian</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applications as $app)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <img src="{{ asset('storage/' . $app->passport_photo) }}" class="w-12 h-12 rounded-full object-cover border border-gray-200">
                        </td>
                        <td class="p-4 font-bold text-gray-800">
                            {{ $app->first_name }} {{ $app->last_name }}
                            <div class="text-xs text-gray-500 font-normal">DOB: {{ $app->date_of_birth }}</div>
                        </td>
                        <td class="p-4">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">
                                {{ $app->applying_for_class }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-600">
                            {{ $app->parent_name }}
                            <div class="text-xs text-blue-500">{{ $app->parent_phone }}</div>
                        </td>
                        <td class="p-4">
                            @if($app->status === 'Pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                            @elseif($app->status === 'Approved')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Approved</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Rejected</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <button wire:click="viewApp({{ $app->id }})" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-700 transition">
                                <i class="fas fa-eye mr-1"></i> View Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">
                            No admission applications received yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL FOR VIEWING DETAILS -->
    @if($showModal && $selectedApp)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 rounded-t-2xl flex justify-between items-center">
                <h3 class="text-2xl font-bold">Application Details</h3>
                <button wire:click="closeModal" class="text-white hover:text-gray-200 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-8">
                <!-- Student Info Section -->
                <div class="flex gap-6 mb-8">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $selectedApp->passport_photo) }}" class="w-32 h-32 rounded-full object-cover border-4 border-blue-100 shadow-lg">
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-2xl font-bold text-gray-800 mb-2">{{ $selectedApp->first_name }} {{ $selectedApp->last_name }}</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Date of Birth:</span>
                                <span class="font-semibold ml-2">{{ $selectedApp->date_of_birth }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Gender:</span>
                                <span class="font-semibold ml-2">{{ $selectedApp->gender }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Applying For:</span>
                                <span class="font-semibold ml-2 bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $selectedApp->applying_for_class }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Previous School:</span>
                                <span class="font-semibold ml-2">{{ $selectedApp->previous_school ?: 'None' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parent Info Section -->
                <div class="bg-gray-50 p-6 rounded-xl mb-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Parent/Guardian Information</h5>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Full Name:</span>
                            <span class="font-semibold ml-2 block">{{ $selectedApp->parent_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Phone Number:</span>
                            <span class="font-semibold ml-2 block">{{ $selectedApp->parent_phone }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-500">Email Address:</span>
                            <span class="font-semibold ml-2 block text-blue-600">{{ $selectedApp->parent_email ?: 'Not provided' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <span class="text-gray-500 text-sm">Current Status:</span>
                    @if($selectedApp->status === 'Pending')
                        <span class="ml-2 bg-yellow-100 text-yellow-800 px-4 py-1 rounded-full text-sm font-bold">Pending Review</span>
                    @elseif($selectedApp->status === 'Approved')
                        <span class="ml-2 bg-green-100 text-green-800 px-4 py-1 rounded-full text-sm font-bold">Approved</span>
                    @else
                        <span class="ml-2 bg-red-100 text-red-800 px-4 py-1 rounded-full text-sm font-bold">Rejected</span>
                    @endif
                </div>

                <!-- Action Buttons -->
                @if($selectedApp->status === 'Pending')
                <div class="flex gap-4 pt-4 border-t">
                    <button wire:click="approve({{ $selectedApp->id }})" wire:confirm="Are you sure? This will create the student account and link the parent. Default password will be 'password'." class="flex-1 bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-lg">
                        <i class="fas fa-check mr-2"></i> Approve Application
                    </button>
                    <button wire:click="reject({{ $selectedApp->id }})" wire:confirm="Reject this application?" class="flex-1 bg-red-600 text-white py-3 rounded-lg font-bold hover:bg-red-700 transition shadow-lg">
                        <i class="fas fa-times mr-2"></i> Reject Application
                    </button>
                </div>
                @else
                <div class="bg-gray-100 p-4 rounded-lg text-center text-gray-600">
                    This application has already been {{ strtolower($selectedApp->status) }}.
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>