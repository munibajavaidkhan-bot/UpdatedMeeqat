@extends('layouts.admin')
@section('title', 'Edit User')
@section('page_title', 'Edit User')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-8">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror"
                           value="{{ old('name', $user->name) }}">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input @error('email') border-red-500 @enderror"
                           value="{{ old('email', $user->email) }}">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Role</label>
                    <select name="role_id" class="form-select">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input"
                           value="{{ old('phone', $user->phone) }}">
                </div>
                <div>
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-input"
                           value="{{ old('country', $user->country) }}">
                </div>
                <div>
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-input"
                           value="{{ old('city', $user->city) }}">
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">New Password <span class="text-muted">(leave blank to keep same)</span></label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="h-11 px-6 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">Save Changes</button>
                <a href="{{ route('admin.users.index') }}" class="h-11 px-6 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 inline-flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
