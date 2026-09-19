@extends('layouts.admin')
@section('title', 'Manage Duas')
@section('page_title', 'Duas Library')

@section('content')

<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <form action="{{ route('admin.duas.index') }}" method="GET" class="flex items-center gap-3">
        <input type="text" name="search" placeholder="Search duas..."
               class="flex-1 min-w-0 h-11 px-4 rounded-xl border border-primary-200 bg-white text-heading text-sm placeholder:text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
               value="{{ request('search') }}">
        <select name="category" class="h-11 px-4 pr-8 rounded-xl border border-primary-200 bg-white text-heading text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all appearance-none bg-no-repeat cursor-pointer" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-position: right 8px center; background-size: 16px;">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name_en }}</option>
            @endforeach
        </select>
        <button type="submit" class="h-11 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm whitespace-nowrap inline-flex items-center justify-center">Filter</button>
    </form>
    <a href="{{ route('admin.duas.create') }}" class="h-11 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm whitespace-nowrap inline-flex items-center justify-center">+ Add New Dua</a>
</div>

<div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
    <div class="overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-primary-100">
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">#</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Title</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Category</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Arabic Preview</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Featured</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($duas as $dua)
                    <tr class="border-b border-primary-50 last:border-0 hover:bg-primary-50/30 transition-colors">
                        <td class="px-5 py-4 text-muted text-xs">{{ $dua->id }}</td>
                        <td class="px-5 py-4 text-heading font-medium max-w-xs">{{ Str::limit($dua->title_en, 40) }}</td>
                        <td class="px-5 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">{{ $dua->category->name_en }}</span></td>
                        <td class="px-5 py-4 arabic text-primary-600 text-sm max-w-xs">{{ Str::limit($dua->arabic_text, 30) }}</td>
                        <td class="px-5 py-4">
                            @if($dua->is_featured)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-secondary-50 text-secondary-700 text-xs font-semibold border border-secondary-200 whitespace-nowrap">Featured</span>
                            @else
                                <span class="text-muted text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.duas.edit', $dua) }}" class="p-2 rounded-lg bg-primary-50 hover:bg-primary-500 text-primary-600 hover:text-white border border-primary-100 hover:border-primary-500 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.duas.destroy', $dua) }}" method="POST" onsubmit="return confirm('Delete this dua?')">
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
    <div class="p-5 border-t border-primary-100">{{ $duas->links() }}</div>
</div>

@endsection
