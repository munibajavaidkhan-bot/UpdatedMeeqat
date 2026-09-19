@extends('layouts.admin')
@section('title', 'Messages')
@section('page_title', 'Contact Messages')

@section('content')

@if($unread > 0)
    <div class="flex items-start gap-3 p-4 rounded-xl bg-secondary-50 border border-secondary-200 text-secondary-700 mb-6">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
        </svg>
        <p class="text-sm font-medium">You have <strong>{{ $unread }}</strong> unread messages.</p>
    </div>
@endif

<div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
    <div class="overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-primary-100">
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">From</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Subject</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Message</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Date</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                    <tr class="border-b border-primary-50 last:border-0 hover:bg-primary-50/30 transition-colors {{ !$msg->is_read ? 'bg-primary-50/50' : '' }}">
                        <td class="px-5 py-4">
                            <div>
                                <p class="text-heading text-sm font-medium {{ !$msg->is_read ? 'font-bold' : '' }}">{{ $msg->name }}</p>
                                <p class="text-muted text-xs">{{ $msg->email }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-heading text-sm">{{ Str::limit($msg->subject, 30) ?? '—' }}</td>
                        <td class="px-5 py-4 text-muted text-sm">{{ Str::limit($msg->message, 40) }}</td>
                        <td class="px-5 py-4 text-muted text-xs whitespace-nowrap">{{ $msg->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="p-2 rounded-lg bg-primary-50 hover:bg-primary-500 text-primary-600 hover:text-white border border-primary-100 hover:border-primary-500 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-100 hover:border-red-500 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-primary-100">{{ $messages->links() }}</div>
</div>

@endsection
