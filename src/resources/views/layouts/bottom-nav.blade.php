<nav class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white border-t border-slate-100 flex items-center justify-around p-2 pb-6 z-50">
    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-slate-300 hover:text-slate-500' }}">
        <span class="material-symbols-outlined">grid_view</span>
        <span class="text-[10px] font-bold">DASH</span>
    </a>
    <a href="{{ route('colocations.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('colocations.*') ? 'text-primary' : 'text-slate-300 hover:text-slate-500' }}">
        <span class="material-symbols-outlined">payments</span>
        <span class="text-[10px] font-bold">DEPENSES</span>
    </a>
    <a href="{{ route('colocations.index') }}" class="flex flex-col items-center gap-1 text-slate-300 hover:text-slate-500">
        <span class="material-symbols-outlined">groups</span>
        <span class="text-[10px] font-bold">MEMBRES</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-slate-300 hover:text-slate-500' }}">
        <span class="material-symbols-outlined">settings</span>
        <span class="text-[10px] font-bold">CONFIG</span>
    </a>
</nav>
