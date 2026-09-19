@extends('layouts.admin')
@section('title', 'Ihram Guides')
@section('page_title', 'Ihram Guides')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.ihram-guides.create') }}" class="h-11 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm whitespace-nowrap inline-flex items-center justify-center">+ Add New Guide</a>
</div>

<div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
    <div class="overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-primary-100">
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Guide</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Image</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Category</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Urdu Title</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Order</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Status</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guides as $guide)
                    <tr class="border-b border-primary-50 last:border-0 hover:bg-primary-50/30 transition-colors">
                        <td class="px-5 py-4">
                            <p class="text-heading font-medium text-sm">{{ Str::limit($guide->title_en, 35) }}</p>
                        </td>
                        <td class="px-5 py-4">
                            @if($guide->image)
                                <img src="{{ asset($guide->image) }}" alt="{{ $guide->title_en }}" class="w-16 h-12 object-cover rounded-lg border border-primary-100">
                            @else
                                <span class="text-muted text-xs">No image</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">
                                {{ $guide->category_label }}
                            </span>
                        </td>
                        <td class="px-5 py-4 urdu text-muted text-sm">{{ Str::limit($guide->title_ur, 25) ?? '—' }}</td>
                        <td class="px-5 py-4 text-muted text-sm">{{ $guide->sort_order }}</td>
                        <td class="px-5 py-4">
                            @if($guide->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-xs font-semibold border border-red-200 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.ihram-guides.edit', $guide) }}" class="p-2 rounded-lg bg-primary-50 hover:bg-primary-500 text-primary-600 hover:text-white border border-primary-100 hover:border-primary-500 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.ihram-guides.destroy', $guide) }}" method="POST" onsubmit="return confirm('Delete?')">
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
    <div class="p-5 border-t border-primary-100">{{ $guides->links() }}</div>
</div>

@endsection
