<x-dashboard-layout
    title="Settings"
    subtitle="Manage your profile and account preferences"
    activeNav="settings"
    :activeColocation="$activeColocation ?? null"
>

    {{-- Session Messages --}}
    @if (session('status') === 'profile-updated')
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="text-sm font-medium">Profile updated successfully.</span>
        </div>
    @endif

    {{-- Profile Avatar Banner --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-primary/5 flex items-center gap-6">
        <div class="h-20 w-20 rounded-2xl bg-primary/10 border-2 border-primary/20 flex items-center justify-center shrink-0">
            @if (auth()->user()->profile_photo_url ?? false)
                <img alt="Profile" class="h-full w-full object-cover rounded-2xl" src="{{ auth()->user()->profile_photo_url }}"/>
            @else
                <span class="text-primary font-extrabold text-2xl">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
            @endif
        </div>
        <div>
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">{{ auth()->user()->name }}</h3>
            <p class="text-sm text-slate-500 mt-0.5">{{ auth()->user()->email }}</p>
            <span class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold">
                <span class="material-symbols-outlined text-[12px]">stars</span>
                Roommate Gold
            </span>
        </div>
    </div>

    {{-- Update Profile Info --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 overflow-hidden">
        <div class="px-6 py-4 border-b border-primary/5 flex items-center gap-3">
            <div class="h-8 w-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-sm">person</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Profile Information</h3>
                <p class="text-[11px] text-slate-400">Update your name and email address.</p>
            </div>
        </div>
        <div class="p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Update Password --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 overflow-hidden">
        <div class="px-6 py-4 border-b border-primary/5 flex items-center gap-3">
            <div class="h-8 w-8 bg-purple-50 text-purple-500 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-sm">lock</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Update Password</h3>
                <p class="text-[11px] text-slate-400">Ensure your account is using a strong password.</p>
            </div>
        </div>
        <div class="p-6">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Delete Account --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-red-100 dark:border-red-900/20 overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100 dark:border-red-900/20 flex items-center gap-3">
            <div class="h-8 w-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-sm">delete_forever</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-red-600 dark:text-red-400">Delete Account</h3>
                <p class="text-[11px] text-slate-400">Permanently delete your account and all data.</p>
            </div>
        </div>
        <div class="p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</x-dashboard-layout>