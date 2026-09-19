@extends('layouts.admin')
@section('title', 'Manage Users')
@section('page_title', 'Users Management')
@section('page_subtitle', 'Manage all registered users')

@section('content')

{{-- Filters --}}
<div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-5 mb-6">
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-3">
        <input type="text" name="search" placeholder="Search name or email..."
               class="flex-1 min-w-0 h-11 px-4 rounded-xl border border-primary-200 bg-white text-heading text-sm placeholder:text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
               value="{{ request('search') }}">
        <select name="role" class="h-11 px-4 pr-8 rounded-xl border border-primary-200 bg-white text-heading text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all appearance-none bg-no-repeat cursor-pointer" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-position: right 8px center; background-size: 16px;">
            <option value="">All Roles</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->label }}</option>
            @endforeach
        </select>
        <select name="status" class="h-11 px-4 pr-8 rounded-xl border border-primary-200 bg-white text-heading text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all appearance-none bg-no-repeat cursor-pointer" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-position: right 8px center; background-size: 16px;">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="h-11 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 active:bg-primary-700 transition-all duration-200 shadow-sm hover:shadow-md whitespace-nowrap inline-flex items-center justify-center">Search</button>
        <a href="{{ route('admin.users.index') }}" class="h-11 px-5 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 hover:border-primary-300 transition-all duration-200 whitespace-nowrap inline-flex items-center justify-center">Clear</a>
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-primary-100 flex items-center justify-between">
        <h3 class="text-heading font-bold text-lg">All Users ({{ $users->total() }})</h3>
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
                    <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
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
                            <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="cursor-pointer transition-opacity hover:opacity-80">
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
                                </button>
                            </form>
                        </td>
                        <td class="px-5 py-4 text-muted text-xs whitespace-nowrap">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="p-2 rounded-lg bg-primary-50 hover:bg-primary-500 text-primary-600 hover:text-white border border-primary-100 hover:border-primary-500 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this user?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-100 hover:border-red-500 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-primary-100">
        {{ $users->withQueryString()->links() }}
    </div>
</div>

@endsection
