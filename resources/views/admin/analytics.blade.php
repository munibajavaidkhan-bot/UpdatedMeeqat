@extends('layouts.admin')
@section('title', 'Analytics')
@section('page_title', 'Analytics & Reports')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @php
    $statCards = [
        ['label' => 'Total Users',    'value' => $stats['total_users'],    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>'],
        ['label' => 'Total Calcs',    'value' => $stats['total_calcs'],    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c-2.21 0-4.21-.86-5.66-2.25"/>'],
        ['label' => 'Total Searches', 'value' => $stats['total_searches'], 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>'],
        ['label' => 'Calcs/Month',    'value' => $stats['calcs_month'],    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/>'],
        ['label' => 'Searches/Month', 'value' => $stats['searches_month'], 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>'],
    ];
    @endphp

    @foreach($statCards as $card)
        <div class="bg-white rounded-2xl border border-primary-100 p-5 shadow-sm hover:shadow-md hover:border-primary-200 transition-all duration-200 text-center">
            <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                    {!! $card['icon'] !!}
                </svg>
            </div>
            <p class="font-heading font-black text-2xl text-heading">{{ number_format($card['value']) }}</p>
            <p class="text-muted text-xs mt-1">{{ $card['label'] }}</p>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- Chaddar Style Stats --}}
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-6">
        <h3 class="text-heading font-bold text-lg mb-5 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/>
                </svg>
            </div>
            Chaddar Style Usage
        </h3>
        @php $total = $styleStats->sum(); @endphp
        @foreach($styleStats as $style => $count)
            <div class="mb-4">
                <div class="flex justify-between mb-1.5">
                    <span class="text-heading text-sm capitalize">{{ $style }} Style</span>
                    <span class="text-heading font-bold text-sm">{{ $count }}</span>
                </div>
                <div class="w-full h-2 bg-primary-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-primary-500 to-primary-400 transition-all duration-700" style="width: {{ $total > 0 ? ($count/$total)*100 : 0 }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Top Countries --}}
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-6">
        <h3 class="text-heading font-bold text-lg mb-5 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                </svg>
            </div>
            Top Countries (Meeqat Searches)
        </h3>
        <div class="space-y-3">
            @foreach($topCountries as $index => $country)
                <div class="flex items-center gap-3">
                    <span class="text-muted text-sm w-5 font-bold">{{ $index + 1 }}</span>
                    <div class="flex-1">
                        <div class="flex justify-between mb-1">
                            <span class="text-heading text-sm">{{ $country->user_country }}</span>
                            <span class="text-heading font-bold text-sm">{{ $country->total }}</span>
                        </div>
                        <div class="w-full h-2 bg-blue-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-blue-400" style="width: {{ $topCountries->first()->total > 0 ? ($country->total/$topCountries->first()->total)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Activity Log --}}
<div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-primary-100 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/>
            </svg>
        </div>
        <h3 class="text-heading font-bold text-lg">Recent Activity Logs</h3>
    </div>
    <div class="overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-primary-100">
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">User</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Action</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Module</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">IP</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentLogs as $log)
                    <tr class="border-b border-primary-50 last:border-0 hover:bg-primary-50/30 transition-colors">
                        <td class="px-5 py-4 text-heading text-sm">{{ $log->user?->name ?? 'Guest' }}</td>
                        <td class="px-5 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">{{ str_replace('_', ' ', $log->action) }}</span></td>
                        <td class="px-5 py-4 text-muted text-sm">{{ $log->module }}</td>
                        <td class="px-5 py-4 text-muted text-xs font-mono">{{ $log->ip_address }}</td>
                        <td class="px-5 py-4 text-muted text-xs">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
