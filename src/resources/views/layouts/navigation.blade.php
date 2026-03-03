<header class="p-4 flex items-center justify-between border-b border-slate-100 bg-white sticky top-0 z-50">
    <div class="flex items-center gap-2">
        <div class="bg-primary p-2 rounded-lg text-white">
            <span class="material-symbols-outlined filled">dashboard</span>
        </div>
        <h1 class="text-xl font-extrabold tracking-tight text-slate-900">{{ $navTitle ?? 'Dashboard' }}</h1>
    </div>
    <div class="relative" x-data="{ dropdown: false }">
        <button type="button" @click="dropdown = ! dropdown" class="size-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 overflow-hidden focus:outline-none hover:bg-slate-200 transition-colors">
            @if(optional(Auth::user())->profile_photo_url)
                <img alt="Profil" class="w-full h-full object-cover" src="{{ Auth::user()->profile_photo_url }}" />
            @else
                <span class="material-symbols-outlined">person</span>
            @endif
        </button>
        <div x-show="dropdown" @click.outside="dropdown = false" x-cloak
            class="absolute right-0 top-full mt-2 w-48 rounded-xl bg-white border border-slate-100 shadow-lg py-2 z-50">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-pink-50">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-pink-50">Déconnexion</button>
            </form>
        </div>
    </div>
</header>
