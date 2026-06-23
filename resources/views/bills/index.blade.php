@extends('components.layouts.app')

@section('title', 'Legislative Tracker')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Legislative Tracker</h1>
            <p class="mt-1 text-sm text-gray-500">Exhaustive directory of all bills currently before parliament</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition">&larr; Back to Dashboard</a>
    </div>

    {{-- Livewire bills table --}}
    <livewire:bills-table />
</div>
@endsection
