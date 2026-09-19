@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Welcome back, ' . auth()->user()->name)

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @php
    $statCards = [
        [
            'label' => 'Total Users',
            'value' => $stats['total_users'],
            'sub'   => '+' . $stats['new_users_today'] . ' today',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
        ],
        [
            'label' => 'Total Duas',
            'value' => $stats['total_duas'],
            'sub'   => $stats['total_niyat'] . ' niyat also',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
        ],
        [
            'label' => 'Chaddar Calcs',
            'value' => $stats['chaddar_calculations'],
            'sub'   => '+' . $stats['calcs_today'] . ' today',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c-2.21 0-4.21-.86-5.66-2.25"/>',
        ],
        [
            'label' => 'Meeqat Searches',
            'value' => $stats['meeqat_searches'],
            'sub'   => '+' . $stats['searches_today'] . ' today',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>',
        ],
    ];
    @endphp

    @foreach($statCards as $card)
        <div class="bg-white rounded-2xl border border-primary-100 p-5 shadow-sm hover:shadow-md hover:border-primary-200 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        {!! $card['icon'] !!}
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-primary-50 text-primary-600 text-xs font-semibold border border-primary-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                    Live
                </span>
            </div>
            <p class="font-heading font-black text-3xl text-heading mb-1">{{ number_format($card['value']) }}</p>
            <p class="text-muted text-sm font-medium">{{ $card['label'] }}</p>
            <p class="text-primary-600 text-xs mt-1 font-medium">{{ $card['sub'] }}</p>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Recent Users --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-primary-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
                <h3 class="text-heading font-bold text-lg">Recent Users</h3>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-primary-500 text-sm font-semibold hover:text-primary-600 hover:underline transition-colors">View All →</a>
        </div>
        <div class="overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-primary-100">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">User</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Role</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Country</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Status</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                        <tr class="border-b border-primary-50 last:border-0 hover:bg-primary-50/30 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-xs font-bold shadow-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-heading text-sm font-semibold truncate">{{ $user->name }}</p>
                                        <p class="text-muted text-xs truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">
                                    {{ $user->role?->label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-heading text-sm">{{ $user->country ?? '—' }}</td>
                            <td class="px-5 py-4">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200 whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-xs font-semibold border border-red-200 whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-muted text-xs whitespace-nowrap">{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden p-5">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                </svg>
            </div>
            <h3 class="text-heading font-bold text-lg">Quick Actions</h3>
        </div>
        <div class="space-y-3">
            @php
            $quickActions = [
                [
                    'route' => 'admin.duas.create',
                    'label' => 'Add New Dua',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                ],
                [
                    'route' => 'admin.niyat.create',
                    'label' => 'Add New Niyat',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
                ],
                [
                    'route' => 'admin.ihram-guides.create',
                    'label' => 'Add Ihram Guide',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
                ],
                [
                    'route' => 'admin.categories.index',
                    'label' => 'Manage Categories',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>',
                ],
                [
                    'route' => 'admin.messages.index',
                    'label' => 'View Messages',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>',
                ],
                [
                    'route' => 'admin.settings',
                    'label' => 'Site Settings',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
                ],
            ];
            @endphp

            @foreach($quickActions as $action)
                <a href="{{ route($action['route']) }}"
                   class="flex items-center gap-3 p-3.5 rounded-xl bg-primary-50/50 hover:bg-primary-50 border border-primary-100 hover:border-primary-200 transition-all duration-200 group">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 group-hover:bg-primary-500 flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                        <svg class="w-5 h-5 text-primary-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                            {!! $action['icon'] !!}
                        </svg>
                    </div>
                    <span class="text-heading group-hover:text-primary-700 text-sm font-semibold transition-colors">{{ $action['label'] }}</span>
                    <svg class="w-4 h-4 text-muted group-hover:text-primary-500 ml-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="lg:col-span-3 bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-primary-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/>
                </svg>
            </div>
            <h3 class="text-heading font-bold text-lg">Recent Activity</h3>
        </div>
        <div class="p-5 space-y-3">
            @forelse($recentActivity as $log)
                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-primary-50/40 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-primary-50 border border-primary-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            @if($log->module === 'chaddar_calculator')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c-2.21 0-4.21-.86-5.66-2.25"/>
                            @elseif($log->module === 'meeqat_finder')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            @endif
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-heading text-sm">
                            <span class="font-semibold">{{ $log->user?->name ?? 'Guest' }}</span>
                            <span class="text-muted"> — {{ str_replace('_', ' ', $log->action) }}</span>
                        </p>
                        <p class="text-muted text-xs mt-0.5">{{ $log->created_at->diffForHumans() }} • {{ $log->ip_address }}</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-primary-50 text-primary-600 text-xs font-medium border border-primary-100 flex-shrink-0">{{ $log->module }}</span>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-muted text-sm">No recent activity</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
