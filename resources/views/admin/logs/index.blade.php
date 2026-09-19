@extends('layouts.admin')
@section('title', 'Activity Logs')
@section('page_title', 'Activity Logs')
@section('page_subtitle', 'Track all user activities and system events')

@section('content')

<div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-5 mb-6">
    <form action="{{ route('admin.logs') }}" method="GET" class="flex items-center gap-3">
        <input type="text" name="search" placeholder="Search by action, description or IP..."
               class="flex-1 min-w-0 h-11 px-4 rounded-xl border border-primary-200 bg-white text-heading text-sm placeholder:text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
               value="{{ request('search') }}">
        <select name="action" class="h-11 px-4 pr-8 rounded-xl border border-primary-200 bg-white text-heading text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all appearance-none bg-no-repeat cursor-pointer" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-position: right 8px center; background-size: 16px;">
            <option value="">All Actions</option>
            @foreach($actionTypes as $type)
                <option value="{{ $type }}" {{ request('action') === $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
        <button type="submit" class="h-11 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm whitespace-nowrap inline-flex items-center justify-center">Filter</button>
        @if(request('search') || request('action'))
            <a href="{{ route('admin.logs') }}" class="h-11 px-5 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 whitespace-nowrap inline-flex items-center justify-center">Clear</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
    <div class="overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-primary-100">
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Time</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">User</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Action</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Description</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="border-b border-primary-50 last:border-0 hover:bg-primary-50/30 transition-colors">
                        <td class="px-5 py-4 text-xs text-muted whitespace-nowrap font-mono">
                            {{ $log->created_at->format('M d, H:i:s') }}
                            <br><span class="text-muted text-xs">{{ $log->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-5 py-4">
                            @if($log->user)
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-heading text-sm font-medium">{{ $log->user->name }}</p>
                                        <p class="text-muted text-xs">{{ $log->user->email }}</p>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted text-xs">System / Guest</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $actionColors = [
                                    'login' => 'bg-primary-50 text-primary-700 border-primary-200',
                                    'logout' => 'bg-gray-100 text-gray-600 border-gray-200',
                                    'register' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'create' => 'bg-primary-50 text-primary-700 border-primary-200',
                                    'update' => 'bg-secondary-50 text-secondary-700 border-secondary-200',
                                    'delete' => 'bg-red-50 text-red-700 border-red-200',
                                ];
                                $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg {{ $colorClass }} text-xs font-semibold border whitespace-nowrap capitalize">{{ $log->action }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-heading text-sm">{{ Str::limit($log->description, 80) }}</p>
                            @if($log->metadata)
                                <button onclick="alert(JSON.stringify(@js($log->metadata), null, 2))"
                                        class="text-primary-500 hover:text-primary-600 text-xs mt-1 font-medium">
                                    View Metadata →
                                </button>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <code class="text-muted text-xs font-mono">{{ $log->ip_address ?? '—' }}</code>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-16">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-primary-50 border border-primary-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/>
                                    </svg>
                                </div>
                                <h3 class="text-heading font-bold text-lg">No Activity Logs Found</h3>
                                <p class="text-muted text-sm">No logs match your current filters.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
        <div class="p-5 border-t border-primary-100">
            {{ $logs->links() }}
        </div>
    @endif
</div>

@endsection
