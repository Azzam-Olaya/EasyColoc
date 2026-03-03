<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EasyColoc Admin Dashboard</title>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

    {{-- Tailwind + Chart --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#ee2b8c',
                            light: '#fdf2f8',
                            dark: '#c41d6f',
                        }
                    },
                    borderRadius: { 'twelve': '12px' },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        body { background-color: #f9fafb; }
    </style>
</head>

<body class="font-sans text-slate-900 pb-10">

{{-- ================= HEADER ================= --}}
<header class="bg-white border-b border-slate-100 sticky top-0 z-50 px-5 py-4 flex items-center justify-between">
    <div>
        <h1 class="text-xl font-extrabold tracking-tight">
            EasyColoc <span class="text-brand">Admin</span>
        </h1>
        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">
            Global Access Control
        </p>
    </div>

    <div class="flex items-center gap-3">
        <span class="text-xs text-slate-500 font-medium hidden sm:block">
            {{ auth()->user()->name }}
        </span>

        <div class="h-10 w-10 rounded-full bg-brand/10 flex items-center justify-center border border-brand/20">
            <span class="text-brand font-bold text-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </span>
        </div>
    </div>
</header>

<main class="max-w-md mx-auto p-5 space-y-6">

{{-- ================= STATS ================= --}}
<section class="grid grid-cols-2 gap-3">

    <x-admin.stat-card 
        :value="$stats['users']"
        label="Utilisateurs"
        icon="users"
    />

    <x-admin.stat-card 
        :value="$stats['banned_users']"
        label="Surveillance"
        icon="ban"
    />

    <x-admin.stat-card 
        :value="$stats['colocations']"
        label="Colocations"
        icon="home"
    />

    <x-admin.stat-card 
        :value="$stats['expenses']"
        label="Dépenses"
        icon="calculator"
    />

</section>

{{-- ================= CHART ================= --}}
<section class="bg-white p-5 rounded-twelve shadow-sm border border-slate-100">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-slate-800">Aperçu plateforme</h2>
            <p class="text-xs text-slate-400 font-medium">Activité</p>
        </div>

        <div class="bg-slate-100 p-1 rounded-lg flex gap-1">
            <button id="btn-hebdo" onclick="switchChart('hebdo')" 
                class="text-[10px] font-bold px-3 py-1.5 rounded-md bg-white shadow-sm text-brand">
                HEBDO
            </button>

            <button id="btn-mensuel" onclick="switchChart('mensuel')" 
                class="text-[10px] font-bold px-3 py-1.5 rounded-md text-slate-500">
                MENSUEL
            </button>
        </div>
    </div>

    <div class="h-48">
        <canvas id="activityChart"></canvas>
    </div>
</section>

{{-- ================= USERS ================= --}}
<section class="space-y-4">

    <div class="flex items-center justify-between">
        <h2 class="font-bold text-slate-800">Utilisateurs récents</h2>
        <span class="text-xs font-bold text-brand">
            {{ $users->total() }} total
        </span>
    </div>

    <div class="space-y-3">

        @foreach ($users as $u)
        <div class="bg-white p-4 rounded-twelve border border-slate-100 flex items-center justify-between shadow-sm {{ $u->is_banned ? 'opacity-70' : '' }}">

            <div class="flex items-center gap-3">

                <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden font-bold {{ $u->is_banned ? 'text-slate-400' : 'text-brand' }}">
                    @if ($u->profile_photo_url)
                        <img src="{{ $u->profile_photo_url }}" class="h-full w-full object-cover {{ $u->is_banned ? 'grayscale' : '' }}">
                    @else
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    @endif
                </div>

                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm">{{ $u->name }}</span>

                        @if ($u->is_global_admin)
                            <span class="px-1.5 py-0.5 rounded bg-brand/10 text-brand text-[8px] font-bold uppercase">
                                ADMIN
                            </span>
                        @endif
                    </div>

                    <p class="text-[11px] text-slate-400 font-medium">
                        {{ $u->email }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col items-end gap-2">

                @if ($u->is_banned)
                    <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold">
                        Banni
                    </span>

                    <form method="POST" action="{{ route('admin.users.unban', $u) }}">
                        @csrf
                        <button class="text-[10px] font-bold text-brand bg-brand/5 border border-brand/20 px-3 py-1 rounded-lg">
                            Débannir
                        </button>
                    </form>
                @else
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">
                        Actif
                    </span>

                    <form method="POST" action="{{ route('admin.users.ban', $u) }}">
                        @csrf
                        <button class="text-[10px] font-bold text-slate-400 border border-slate-200 px-3 py-1 rounded-lg hover:bg-slate-50">
                            Bannir
                        </button>
                    </form>
                @endif

            </div>
        </div>
        @endforeach

    </div>

    <div class="pt-2">
        {{ $users->links() }}
    </div>
</section>

</main>

{{-- ================= CHART SCRIPT ================= --}}
<script>
const hebdoData = [45, 59, 80, 72, 56, 95, 110];
const mensuelData = [320, 410, 390, 500, 470, 610, 580, 490, 540, 620, 700, 750];

const hebdoLabels = ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'];
const mensuelLabels = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];

const ctx = document.getElementById('activityChart').getContext('2d');

const gradient = ctx.createLinearGradient(0, 0, 0, 200);
gradient.addColorStop(0, 'rgba(238, 43, 140, 0.2)');
gradient.addColorStop(1, 'rgba(238, 43, 140, 0)');

const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: hebdoLabels,
        datasets: [{
            data: hebdoData,
            borderColor: '#ee2b8c',
            borderWidth: 3,
            backgroundColor: gradient,
            fill: true,
            tension: 0.4,
            pointRadius: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { display: false }
        }
    }
});

function switchChart(mode) {
    if (mode === 'hebdo') {
        chart.data.labels = hebdoLabels;
        chart.data.datasets[0].data = hebdoData;
    } else {
        chart.data.labels = mensuelLabels;
        chart.data.datasets[0].data = mensuelData;
    }
    chart.update();
}
</script>

</body>
</html>