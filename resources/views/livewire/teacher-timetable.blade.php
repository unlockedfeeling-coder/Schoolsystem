<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Timetable</h2>
        <div class="text-right">
            <p class="text-sm text-gray-500">Current Time</p>
            <p class="text-xl font-bold text-blue-600">{{ \Carbon\Carbon::parse($currentTime)->format('g:i A') }}</p>
            <p class="text-sm text-gray-600 font-semibold">{{ $currentDay }}</p>
        </div>
    </div>

    <!-- Smart Reminder Banner -->
    @if($nextLessonReminder)
        <div class="mb-6 p-4 rounded-lg border-l-4 
            {{ $currentLesson ? 'bg-blue-50 border-blue-500 text-blue-800' : 
               (str_contains($nextLessonReminder, '') ? 'bg-yellow-50 border-yellow-500 text-yellow-800' : 'bg-green-50 border-green-500 text-green-800') }}">
            <div class="flex items-start">
                <i class="fas {{ $currentLesson ? 'fa-chalkboard-teacher' : (str_contains($nextLessonReminder, '⏰') ? 'fa-bell' : 'fa-info-circle') }} text-2xl mr-3 mt-1"></i>
                <div>
                    <p class="font-bold text-sm mb-1">
                        {{ $currentLesson ? 'CURRENT LESSON' : (str_contains($nextLessonReminder, '⏰') ? 'UPCOMING LESSON' : 'SCHEDULE INFO') }}
                    </p>
                    <p class="text-sm">{{ $nextLessonReminder }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Today's Schedule -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-calendar-day mr-2 text-blue-600"></i> Today's Schedule ({{ $currentDay }})
        </h3>

        @if($todayLessons->count() > 0)
            <div class="space-y-3">
                @foreach($todayLessons as $lesson)
                    @php
                        $isCurrent = $currentLesson && $currentLesson->id === $lesson->id;
                        $isUpcoming = $upcomingLesson && $upcomingLesson->id === $lesson->id;
                    @endphp
                    <div class="flex items-center p-4 rounded-lg border-2 transition
                        {{ $isCurrent ? 'bg-blue-50 border-blue-500 shadow-md' : 
                           ($isUpcoming ? 'bg-yellow-50 border-yellow-400' : 'bg-gray-50 border-gray-200') }}">
                        
                        <div class="w-24 text-center">
                            <p class="text-xs text-gray-500">Start</p>
                            <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($lesson->start_time)->format('g:i A') }}</p>
                            <p class="text-xs text-gray-500 mt-1">End</p>
                            <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($lesson->end_time)->format('g:i A') }}</p>
                        </div>

                        <div class="flex-grow px-4 border-l-2 border-gray-300">
                            <p class="font-bold text-lg text-gray-800">{{ $lesson->subject->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-users mr-1"></i> {{ $lesson->classLevel->name ?? 'N/A' }}
                                @if($lesson->room)
                                    <span class="ml-2"><i class="fas fa-door-open mr-1"></i> {{ $lesson->room }}</span>
                                @endif
                            </p>
                        </div>

                        @if($isCurrent)
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                                NOW
                            </span>
                        @elseif($isUpcoming)
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                NEXT
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-100 p-6 rounded-lg text-center text-gray-500">
                <i class="fas fa-coffee text-3xl mb-2"></i>
                <p>No lessons scheduled for today.</p>
            </div>
        @endif
    </div>

    <!-- Full Week View -->
    <div>
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-calendar-week mr-2 text-purple-600"></i> Full Week Schedule
        </h3>

        @if($weekLessons->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="p-3">Day</th>
                            <th class="p-3">Time</th>
                            <th class="p-3">Subject</th>
                            <th class="p-3">Class</th>
                            <th class="p-3">Room</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($weekLessons as $lesson)
                            <tr class="hover:bg-gray-50 {{ $lesson->day === $currentDay ? 'bg-blue-50' : '' }}">
                                <td class="p-3 font-bold {{ $lesson->day === $currentDay ? 'text-blue-600' : '' }}">{{ $lesson->day }}</td>
                                <td class="p-3 text-sm">
                                    {{ \Carbon\Carbon::parse($lesson->start_time)->format('g:i A') }} - 
                                    {{ \Carbon\Carbon::parse($lesson->end_time)->format('g:i A') }}
                                </td>
                                <td class="p-3">{{ $lesson->subject->name ?? 'N/A' }}</td>
                                <td class="p-3"><span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">{{ $lesson->classLevel->name ?? 'N/A' }}</span></td>
                                <td class="p-3 text-gray-600">{{ $lesson->room ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg text-center text-yellow-700">
                No timetable entries assigned to you yet. Please contact the Admin.
            </div>
        @endif
    </div>
</div>