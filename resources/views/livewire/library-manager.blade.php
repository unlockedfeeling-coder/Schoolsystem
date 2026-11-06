<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Library Management</h2>

    @if (session()->has('message')) <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">{{ session('message') }}</div> @endif
    @if (session()->has('error')) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">{{ session('error') }}</div> @endif

    <!-- ADD NEW BOOK -->
    <div class="mb-10">
        <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Add New Book</h3>
        <form wire:submit.prevent="addBook" class="grid grid-cols-1 md:grid-cols-5 gap-4 bg-gray-50 p-4 rounded-lg">
            <input type="text" wire:model="title" placeholder="Book Title" class="border p-2 rounded">
            <input type="text" wire:model="author" placeholder="Author" class="border p-2 rounded">
            <input type="text" wire:model="isbn" placeholder="ISBN" class="border p-2 rounded">
            <input type="number" wire:model="total_copies" placeholder="Total Copies" class="border p-2 rounded">
            <button class="bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Add Book</button>
        </form>
    </div>

    <!-- ISSUE BOOK -->
    <div class="mb-10">
        <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Issue Book to Student</h3>
        <form wire:submit.prevent="issueBook" class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg">
            <select wire:model="issue_student_id" class="border p-2 rounded bg-white">
                <option value="">Select Student</option>
                @foreach($students as $student) <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option> @endforeach
            </select>
            <select wire:model="issue_book_id" class="border p-2 rounded bg-white">
                <option value="">Select Book</option>
                @foreach($books as $book) <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available_copies }} left)</option> @endforeach
            </select>
            <input type="date" wire:model="issue_date" class="border p-2 rounded">
            <button class="bg-purple-600 text-white rounded hover:bg-purple-700 font-bold">Issue Book</button>
        </form>
    </div>

    <!-- BORROWING HISTORY -->
    <div>
        <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Borrowing History</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <th class="p-3">Student</th>
                        <th class="p-3">Book</th>
                        <th class="p-3">Borrowed</th>
                        <th class="p-3">Returned</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($borrowings as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-bold">{{ $log->student->first_name }} {{ $log->student->last_name }}</td>
                            <td class="p-3">{{ $log->book->title }}</td>
                            <td class="p-3">{{ $log->borrow_date }}</td>
                            <td class="p-3">{{ $log->return_date ?? '-' }}</td>
                            <td class="p-3">
                                @if($log->status === 'Borrowed')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">Borrowed</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">Returned</span>
                                @endif
                            </td>
                            <td class="p-3">
                                @if($log->status === 'Borrowed')
                                    <button wire:click="returnBook({{ $log->id }})" wire:confirm="Mark this book as returned?" class="text-green-600 hover:text-green-800 font-bold text-sm">
                                        <i class="fas fa-check-circle mr-1"></i> Return
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-6 text-center text-gray-400">No borrowing history yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>