@extends('layouts.admin')
@section('title', 'Settings')
@section('page_title', 'Site Settings')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-6">
            @foreach($settings as $group => $groupSettings)
                <div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-primary-100 bg-primary-50/50">
                        <h3 class="text-heading font-bold capitalize">{{ $group }} Settings</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @foreach($groupSettings as $setting)
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label class="text-heading text-sm font-medium">
                                    {{ $setting->label ?? $setting->key }}
                                </label>
                                <div class="col-span-2">
                                    @if($setting->type === 'boolean')
                                        <select name="{{ $setting->key }}" class="h-11 px-4 pr-8 rounded-xl border border-primary-200 bg-white text-heading text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all appearance-none bg-no-repeat cursor-pointer w-full" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-position: right 8px center; background-size: 16px;">
                                            <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Enabled</option>
                                            <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Disabled</option>
                                        </select>
                                    @elseif($setting->type === 'image')
                                        <input type="file" name="{{ $setting->key }}" accept="image/*"
                                               class="block w-full text-sm text-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-600 file:font-medium file:cursor-pointer">
                                    @else
                                        <input type="text" name="{{ $setting->key }}"
                                               value="{{ $setting->value }}"
                                               class="h-11 px-4 rounded-xl border border-primary-200 bg-white text-heading text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all w-full">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <button type="submit" class="h-12 px-7 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 active:bg-primary-700 transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection
