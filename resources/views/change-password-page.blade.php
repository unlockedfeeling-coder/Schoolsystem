@extends(auth()->user()->role === 'parent' ? 'layouts.parent-app' : (auth()->user()->role === 'student' ? 'layouts.student-app' : 'layouts.app'))

@section('content')
    <livewire:change-password />
@endsection