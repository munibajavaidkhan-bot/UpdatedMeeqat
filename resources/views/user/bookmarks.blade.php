@extends('layouts.app')
@section('title', 'My Bookmarks')

@section('content')

{{-- Page Header --}}
<div class="relative pt-32 pb-16 overflow-hidden">
    <div class="absolute inset-0 bg-mesh" aria-hidden="true"></div>
    <div class="absolute top-1/4 -right-32 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>

    <div class="container-app relative">
        <nav class="flex items-center gap-2 text-sm mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-500 font-medium">My Bookmarks</span>
        </nav>

        <h1 class="text-3xl font-black text-white mb-4">My <span class="text-primary-400">Bookmarks</span></h1>
        <p class="text-dark-300 text-body">Your saved duas and favorite prayers.</p>
    </div>
</div>

{{-- Main Content --}}
<div class="bg-background py-10 pb-20">
    <div class="container-app">

        @forelse($bookmarks as $dua)
            <div class="card p-6 mb-4 hover:border-primary-300 hover:shadow-card-hover transition-all">
                <div class="flex justify-between items-start mb-3">
                    <span class="badge-green text-xs">{{ $dua->category->name_en }}</span>
                    <form action="{{ route('duas.bookmark.remove', $dua->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1 text-muted hover:text-red-500 transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Remove
                        </button>
                    </form>
                </div>
                <a href="{{ route('duas.show', $dua->id) }}" class="block">
                    <h3 class="text-heading font-bold mb-1">{{ $dua->title_en }}</h3>
                    @if($dua->title_ur)
                        <p class="urdu text-sm mb-2" style="font-weight:700;color:#1e293b;direction:rtl;text-align:right">{{ $dua->title_ur }}</p>
                    @endif
                    <p class="arabic text-lg text-primary-600 text-right">{{ Str::limit($dua->arabic_text, 100) }}</p>
                </a>
            </div>
        @empty
            <div class="card p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-primary-50 border border-primary-200 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
                    </svg>
                </div>
                <h3 class="text-heading font-bold mb-2">No Bookmarks Yet</h3>
                <p class="text-muted text-sm mb-6">Bookmark duas so you can easily find them later.</p>
                <a href="{{ route('duas.index') }}" class="btn btn-primary">Browse Duas</a>
            </div>
        @endforelse

    </div>
</div>

@endsection
