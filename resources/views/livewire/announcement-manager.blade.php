   <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
       <h2 class="text-2xl font-bold mb-6 text-gray-800">School Announcements</h2>

       @if (session()->has('message'))
           <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">{{ session('message') }}</div>
       @endif

       <!-- Create Announcement Form -->
       <form wire:submit.prevent="save" class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
           <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Announcement Title</label>
                   <input type="text" wire:model="title" placeholder="e.g. PTA Meeting Next Friday" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                   @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Date</label>
                   <input type="date" wire:model="date" class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                   @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
           </div>
           
           <!-- NEW IMAGE UPLOAD -->
           <div class="mb-4">
               <label class="block text-gray-700 font-semibold mb-2">Cover Image (Optional)</label>
               <input type="file" wire:model="image" class="border border-gray-300 p-2 w-full rounded-lg bg-white">
               @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               
               @if ($image)
                   <div class="mt-3">
                       <p class="text-xs text-gray-500 mb-1">Preview:</p>
                       <img src="{{ $image->temporaryUrl() }}" class="h-40 w-full object-cover rounded-lg border border-gray-200">
                   </div>
               @endif
           </div>

           <div class="mb-4">
               <label class="block text-gray-700 font-semibold mb-2">Message / Details</label>
               <textarea wire:model="content" rows="4" placeholder="Write the full announcement here..." class="border border-gray-300 p-2.5 w-full rounded-lg outline-none focus:ring-2 focus:ring-blue-500"></textarea>
               @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
           </div>
           <div class="flex justify-end">
               <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow-md transition">
                   <i class="fas fa-bullhorn mr-2"></i> Publish Announcement
               </button>
           </div>
       </form>

       <!-- Announcements Feed -->
       <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Recent Announcements</h3>
       <div class="space-y-4">
           @forelse($announcements as $announcement)
               <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition bg-white relative">
                   @if($announcement->image)
                       <img src="{{ asset('storage/' . $announcement->image) }}" class="w-full h-48 object-cover rounded-lg mb-4">
                   @endif
                   <div class="flex justify-between items-start mb-2">
                       <h4 class="font-bold text-xl text-gray-800">{{ $announcement->title }}</h4>
                       <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ \Carbon\Carbon::parse($announcement->date)->format('M d, Y') }}</span>
                   </div>
                   <p class="text-gray-600 whitespace-pre-line mb-4">{{ $announcement->content }}</p>
                   <div class="flex justify-end border-t pt-3">
                       <button wire:click="delete({{ $announcement->id }})" wire:confirm="Are you sure you want to delete this announcement?" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                           <i class="fas fa-trash mr-1"></i> Delete
                       </button>
                   </div>
               </div>
           @empty
               <div class="text-center text-gray-400 py-8">No announcements published yet.</div>
           @endforelse
       </div>
   </div>