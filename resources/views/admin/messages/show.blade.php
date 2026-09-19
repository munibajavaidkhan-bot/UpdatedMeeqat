@extends('layouts.admin')
@section('title', 'View Message')
@section('page_title', 'Message Detail')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-muted hover:text-primary-500 text-sm mb-6 transition-colors font-medium">
        ← Back to Messages
    </a>

    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-8">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-heading">{{ $message->subject ?? 'No Subject' }}</h2>
                <p class="text-muted text-sm mt-1">{{ $message->created_at->format('F d, Y — h:i A') }}</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span> Read
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-primary-50/50 rounded-xl border border-primary-100 p-4">
                <p class="text-muted text-xs mb-1">Name</p>
                <p class="text-heading font-semibold">{{ $message->name }}</p>
            </div>
            <div class="bg-primary-50/50 rounded-xl border border-primary-100 p-4">
                <p class="text-muted text-xs mb-1">Email</p>
                <a href="mailto:{{ $message->email }}" class="text-primary-600 font-semibold hover:underline">{{ $message->email }}</a>
            </div>
            @if($message->phone)
                <div class="bg-primary-50/50 rounded-xl border border-primary-100 p-4 col-span-2">
                    <p class="text-muted text-xs mb-1">Phone</p>
                    <p class="text-heading">{{ $message->phone }}</p>
                </div>
            @endif
        </div>

        <div class="bg-primary-50/30 rounded-xl border border-primary-100 p-5">
            <p class="text-muted text-xs mb-3 uppercase tracking-wider font-semibold">Message</p>
            <p class="text-heading leading-relaxed">{{ $message->message }}</p>
        </div>

        <div class="flex gap-3 mt-6">
            <a href="mailto:{{ $message->email }}" class="h-11 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm whitespace-nowrap inline-flex items-center justify-center">Reply via Email</a>
            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Delete message?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="h-11 px-5 rounded-xl bg-red-50 text-red-700 text-sm font-semibold border border-red-200 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200 inline-flex items-center justify-center">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
