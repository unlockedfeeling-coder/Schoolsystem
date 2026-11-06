<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Student Promotion Center</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-bold">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded mb-6">
        <strong>How it works:</strong> The system will check every student's exam results. 
        To be promoted, a student must score at least <strong>[Pass Score]</strong> in at least <strong>[Number]</strong> subjects.
    </div>

    <!-- CRITERIA SETTINGS -->
    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
        <h3 class="font-bold text-gray-700 mb-4">Set Promotion Criteria</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Minimum Pass Score (e.g., 45)</label>
                <input type="number" wire:model="min_pass_score" class="border border-gray-300 p-2.5 rounded-lg w-full outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Min. Subjects to Pass (e.g., 5)</label>
                <input type="number" wire:model="min_subjects_to_pass" class="border border-gray-300 p-2.5 rounded-lg w-full outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button wire:click="runPromotion" wire:confirm="Are you sure? This will permanently move students to new classes based on these criteria!" class="bg-purple-600 text-white px-6 py-2.5 rounded-lg hover:bg-purple-700 font-bold shadow-md transition w-full">
                    <i class="fas fa-rocket mr-2"></i> Run Automatic Promotion
                </button>
            </div>
        </div>
    </div>

    <!-- RESULTS TABLE -->
    @if(count($logs) > 0)
        <h3 class="font-bold text-lg mb-4">Promotion Results</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <th class="p-4">Student Name</th>
                        <th class="p-4">Previous Class</th>
                        <th class="p-4">New Class</th>
                        <th class="p-4">Subjects Passed</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-bold">{{ $log['name'] }}</td>
                            <td class="p-4">{{ $log['from'] }}</td>
                            <td class="p-4 font-bold text-blue-600">{{ $log['to'] }}</td>
                            <td class="p-4">
                                <span class="bg-gray-200 px-2 py-1 rounded text-xs font-bold">
                                    {{ $log['passed'] }} / {{ $log['total'] }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($log['status'] === 'Promoted')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Promoted</span>
                                @elseif($log['status'] === 'Completed')
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">Completed</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Retained</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>