@extends('layouts.admin')
@section('title', 'FAQs')
@section('page_title', 'FAQs')
@section('page_subtitle', 'Manage frequently asked questions')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.faqs.create') }}" class="h-11 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm whitespace-nowrap inline-flex items-center justify-center">+ Add New FAQ</a>
</div>

<div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
    <div class="overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-primary-100">
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">#</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Question</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Category</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Status</th>
                    <th class="px-5 py-4 text-right text-xs font-semibold text-muted uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr class="border-b border-primary-50 last:border-0 hover:bg-primary-50/30 transition-colors">
                        <td class="px-5 py-4 text-muted text-xs">{{ $faq->id }}</td>
                        <td class="px-5 py-4">
                            <p class="text-heading font-medium">{{ $faq->question }}</p>
                        </td>
                        <td class="px-5 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">{{ $faq->category ?? 'General' }}</span></td>
                        <td class="px-5 py-4">
                            @if($faq->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-xs font-semibold border border-red-200 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="p-2 rounded-lg bg-primary-50 hover:bg-primary-500 text-primary-600 hover:text-white border border-primary-100 hover:border-primary-500 transition-all duration-200" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Delete this FAQ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-100 hover:border-red-500 transition-all duration-200" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-16">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-primary-50 border border-primary-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                                    </svg>
                                </div>
                                <h3 class="text-heading font-bold text-lg">No FAQs Yet</h3>
                                <p class="text-muted text-sm mb-2">FAQs module coming soon with database integration.</p>
                                <a href="{{ route('admin.faqs.create') }}" class="h-10 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">+ Add First FAQ</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
