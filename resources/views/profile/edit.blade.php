@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="pt-32 pb-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-black text-white mb-8">My <span class="text-primary-400">Profile</span></h1>

    <div class="space-y-6">
        {{-- Update Profile Information --}}
        <div class="card-premium p-6 md:p-8">
            <div class="mb-6">
                <h2 class="text-white font-heading font-bold text-xl">Profile Information</h2>
                <p class="text-dark-400 text-sm mt-1">Update your account's profile information and email address.</p>
            </div>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('patch')

                <div>
                    <label class="form-label">Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required autocomplete="name">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="email">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm text-dark-400">
                                Your email address is unverified.
                                <button form="send-verification" class="text-primary-400 hover:text-primary-300 underline text-sm">Click here to re-send the verification email.</button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-primary-400">A new verification link has been sent to your email address.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-sm text-primary-400 font-medium">Saved!</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="card-premium p-6 md:p-8">
            <div class="mb-6">
                <h2 class="text-white font-heading font-bold text-xl">Update Password</h2>
                <p class="text-dark-400 text-sm mt-1">Ensure your account is using a long, random password to stay secure.</p>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('put')

                <div>
                    <label class="form-label">Current Password <span class="text-red-400">*</span></label>
                    <input type="password" name="current_password" class="form-input" required autocomplete="current-password">
                    @error('current_password', 'updatePassword') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">New Password <span class="text-red-400">*</span></label>
                    <input type="password" name="password" class="form-input" required autocomplete="new-password">
                    @error('password', 'updatePassword') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Confirm Password <span class="text-red-400">*</span></label>
                    <input type="password" name="password_confirmation" class="form-input" required autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="btn btn-primary">Save Password</button>
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-sm text-primary-400 font-medium">Saved!</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- Delete Account --}}
        <div class="card-premium p-6 md:p-8">
            <div class="mb-6">
                <h2 class="text-white font-heading font-bold text-xl">Delete Account</h2>
                <p class="text-dark-400 text-sm mt-1">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            </div>

            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            >Delete Account</x-danger-button>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white font-heading font-bold">Are you sure you want to delete your account?</h2>
            <p class="mt-1 text-sm text-dark-400">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>

            <div class="mt-6">
                <label class="form-label">Password <span class="sr-only">Enter your password to confirm deletion</span></label>
                <input type="password" name="password" class="form-input" placeholder="Enter your password">
                @error('password', 'userDeletion') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-danger-button>Delete Account</x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
@endsection
