   <div class="max-w-4xl mx-auto py-12 px-4">
       <div class="text-center mb-10">
           <h1 class="text-4xl font-bold text-gray-900">Online Admission Application</h1>
           <p class="text-gray-600 mt-4">Join EduManage International School. Fill out the form below to apply.</p>
       </div>

       @if (session()->has('message'))
           <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 font-bold text-center">
               {{ session('message') }}
           </div>
       @endif

       <form wire:submit.prevent="save" class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 space-y-6">
           <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Student Information</h3>
           <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">First Name</label>
                   <input type="text" wire:model="first_name" class="border p-2.5 w-full rounded-lg focus:ring-2 focus:ring-blue-500">
                   @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Last Name</label>
                   <input type="text" wire:model="last_name" class="border p-2.5 w-full rounded-lg focus:ring-2 focus:ring-blue-500">
                   @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Date of Birth</label>
                   <input type="date" wire:model="date_of_birth" class="border p-2.5 w-full rounded-lg focus:ring-2 focus:ring-blue-500">
                   @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Gender</label>
                   <select wire:model="gender" class="border p-2.5 w-full rounded-lg bg-white focus:ring-2 focus:ring-blue-500">
                       <option value="">Select Gender</option>
                       <option value="Male">Male</option>
                       <option value="Female">Female</option>
                   </select>
                   @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
               <div class="md:col-span-2">
                   <label class="block text-gray-700 font-semibold mb-2">Passport Picture</label>
                   <input type="file" wire:model="passport_photo" class="border p-2 w-full rounded-lg bg-white">
                   @error('passport_photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                   @if ($passport_photo)
                       <img src="{{ $passport_photo->temporaryUrl() }}" class="mt-2 h-32 w-32 object-cover rounded-full border-4 border-blue-100">
                   @endif
               </div>
           </div>

           <h3 class="text-xl font-bold text-gray-800 border-b pb-2 pt-4">Parent/Guardian Information</h3>
           <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Parent Full Name</label>
                   <input type="text" wire:model="parent_name" class="border p-2.5 w-full rounded-lg focus:ring-2 focus:ring-blue-500">
                   @error('parent_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                   <input type="text" wire:model="parent_phone" class="border p-2.5 w-full rounded-lg focus:ring-2 focus:ring-blue-500">
                   @error('parent_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
               <div class="md:col-span-2">
                   <label class="block text-gray-700 font-semibold mb-2">Email Address (Optional)</label>
                   <input type="email" wire:model="parent_email" class="border p-2.5 w-full rounded-lg focus:ring-2 focus:ring-blue-500">
               </div>
           </div>

           <h3 class="text-xl font-bold text-gray-800 border-b pb-2 pt-4">Academic Details</h3>
           <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Previous School (Optional)</label>
                   <input type="text" wire:model="previous_school" class="border p-2.5 w-full rounded-lg focus:ring-2 focus:ring-blue-500">
               </div>
               <div>
                   <label class="block text-gray-700 font-semibold mb-2">Applying For Class</label>
                   <select wire:model="applying_for_class" class="border p-2.5 w-full rounded-lg bg-white focus:ring-2 focus:ring-blue-500">
                       <option value="">Select Class</option>
                       <option value="KG 1">KG 1</option><option value="KG 2">KG 2</option>
                       <option value="Basic 1">Basic 1</option><option value="Basic 2">Basic 2</option>
                       <option value="Basic 3">Basic 3</option><option value="Basic 4">Basic 4</option>
                       <option value="Basic 5">Basic 5</option><option value="Basic 6">Basic 6</option>
                       <option value="JHS 1">JHS 1</option><option value="JHS 2">JHS 2</option><option value="JHS 3">JHS 3</option>
                   </select>
                   @error('applying_for_class') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
               </div>
           </div>

           <div class="pt-4">
               <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                   Submit Application
               </button>
           </div>
       </form>
   </div>