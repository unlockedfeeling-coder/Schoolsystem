<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Fee Management ({{ $session ? $session->name : 'No Active Session' }})</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-bold">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 font-bold">{{ session('error') }}</div>
    @endif

    <div class="flex border-b mb-6">
        <button wire:click="$set('activeTab', 'types')" class="px-6 py-3 font-bold {{ $activeTab === 'types' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">1. Fee Types</button>
        <button wire:click="$set('activeTab', 'structures')" class="px-6 py-3 font-bold {{ $activeTab === 'structures' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">2. Fee Structures</button>
        <button wire:click="$set('activeTab', 'payments')" class="px-6 py-3 font-bold {{ $activeTab === 'payments' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">3. Record Payment</button>
    </div>

    @if($activeTab === 'types')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-50 p-6 rounded-lg border">
            <h3 class="font-bold mb-4">Add New Fee Type</h3>
            <form wire:submit.prevent="saveFeeType">
                <input type="text" wire:model="typeName" placeholder="e.g. Tuition Fee" class="border p-2 w-full rounded mb-2">
                <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">Add Type</button>
            </form>
        </div>
        <div class="md:col-span-2">
            <table class="w-full text-left">
                <thead><tr class="bg-gray-100"><th class="p-3">Name</th><th class="p-3">Action</th></tr></thead>
                <tbody>
                    @foreach($feeTypes as $type)
                    <tr class="border-b"><td class="p-3">{{ $type->name }}</td><td class="p-3"><button wire:click="deleteFeeType({{ $type->id }})" class="text-red-500">Delete</button></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($activeTab === 'structures')
    <div class="bg-gray-50 p-6 rounded-lg border mb-6">
        <h3 class="font-bold mb-4">Set Automatic Fee Rules</h3>
        <form wire:submit.prevent="saveFeeStructure" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <select wire:model="structureFeeTypeId" class="border p-2 rounded">
                <option value="">Select Fee Type</option>
                @foreach($feeTypes as $type) <option value="{{ $type->id }}">{{ $type->name }}</option> @endforeach
            </select>
            <select wire:model="structureClassId" class="border p-2 rounded">
                <option value="">Select Class</option>
                @foreach(\App\Models\ClassLevel::all() as $class) <option value="{{ $class->id }}">{{ $class->name }}</option> @endforeach
            </select>
            <input type="number" wire:model="structureAmount" placeholder="Amount (e.g. 500)" class="border p-2 rounded">
            <button class="bg-green-600 text-white px-4 py-2 rounded">Save Rule</button>
        </form>
    </div>
    <table class="w-full text-left">
        <thead><tr class="bg-gray-100"><th class="p-3">Fee Type</th><th class="p-3">Class</th><th class="p-3">Amount Required</th><th class="p-3">Action</th></tr></thead>
        <tbody>
            @foreach($feeStructures as $struct)
            <tr class="border-b">
                <td class="p-3">{{ $struct->feeType ? $struct->feeType->name : 'Unknown' }}</td>
                <td class="p-3">{{ $struct->classLevel ? $struct->classLevel->name : 'Unknown' }}</td>
                <td class="p-3 font-bold">GHS {{ number_format($struct->amount, 2) }}</td>
                <td class="p-3"><button wire:click="deleteFeeStructure({{ $struct->id }})" class="text-red-500">Delete</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($activeTab === 'payments')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-50 p-6 rounded-lg border">
            <h3 class="font-bold mb-4">Record New Payment</h3>
            <form wire:submit.prevent="recordPayment" class="space-y-3">
                <select wire:model.live="paymentStudentId" class="border p-2 w-full rounded">
                    <option value="">Select Student</option>
                    @foreach($students as $student) <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }} ({{ $student->classLevel ? $student->classLevel->name : '' }})</option> @endforeach
                </select>
                <select wire:model.live="paymentFeeTypeId" class="border p-2 w-full rounded">
                    <option value="">Select Fee Type</option>
                    @foreach($feeTypes as $type) <option value="{{ $type->id }}">{{ $type->name }}</option> @endforeach
                </select>
                <input type="number" wire:model="paymentAmount" placeholder="Amount Paid" class="border p-2 w-full rounded">
                <div class="grid grid-cols-2 gap-2">
                    <select wire:model="paymentMethod" class="border p-2 rounded">
                        <option>Cash</option><option>Mobile Money</option><option>Bank Transfer</option><option>Cheque</option>
                    </select>
                    <input type="text" wire:model="paymentReference" placeholder="Ref Number (Optional)" class="border p-2 rounded">
                </div>
                <input type="date" wire:model="paymentDate" class="border p-2 w-full rounded">
                <button class="bg-purple-600 text-white px-4 py-2 rounded w-full font-bold">Record Payment</button>
            </form>
        </div>

        <div>
            <h3 class="font-bold mb-4">Recent Payments</h3>
            <div class="overflow-y-auto max-h-[500px]">
                <table class="w-full text-left text-sm">
                    <thead><tr class="bg-gray-100"><th class="p-2">Student</th><th class="p-2">Fee</th><th class="p-2">Amount</th><th class="p-2">Action</th></tr></thead>
                    <tbody>
                        @foreach($recentPayments as $pay)
                        <tr class="border-b">
                            <td class="p-2">{{ $pay->student ? $pay->student->first_name : 'Unknown' }}</td>
                            <td class="p-2">{{ $pay->feeType ? $pay->feeType->name : 'Unknown' }}</td>
                            <td class="p-2 font-bold">GHS {{ number_format($pay->amount_paid, 2) }}</td>
                            <td class="p-2">
                                <!-- STANDARD LINK INSTEAD OF WIRE:CLICK TO PREVENT JSON ERROR -->
                                <a href="/admin/fees/receipt/{{ $pay->id }}" target="_blank" class="bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700 transition">
                                    <i class="fas fa-print"></i> Print
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>