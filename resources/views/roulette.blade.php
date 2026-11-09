@extends('layouts.app')

@section('title', 'Zero Decision Fatigue Roulette - ToonInput')

@section('content')
    <div class="max-w-4xl mx-auto space-y-10 text-center py-4">
        
        <!-- Header -->
        <div class="space-y-4 max-w-2xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-extrabold shadow-xs">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                </span>
                <span>Feature 3 • Zero Decision Fatigue (Input Roulette)</span>
            </div>
            
            <h1 class="font-heading text-4xl sm:text-6xl font-black text-slate-900 tracking-tight leading-tight">
                Zero Decision Fatigue: <br/>
                <span class="text-gradient-indigo">Give me Input!</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                Eliminate choosing anxiety. Press the arcade launcher below and our algorithm will instantly match you with a randomized comprehensible video dose.
            </p>
        </div>

        <!-- Arcade Interactive Launcher Station -->
        <div class="py-8 flex flex-col items-center justify-center relative">
            <!-- Concentric Pulse Glow Circles -->
            <div class="absolute w-80 h-80 sm:w-96 sm:h-96 rounded-full bg-indigo-500/10 animate-pulse-ring pointer-events-none"></div>
            <div class="absolute w-64 h-64 sm:w-72 sm:h-72 rounded-full bg-indigo-600/15 animate-ping pointer-events-none"></div>

            <!-- Big Roulette Button -->
            <button 
                id="big-roulette-btn" 
                class="group relative z-10 inline-flex items-center gap-4 px-10 py-6 sm:px-14 sm:py-7 rounded-3xl bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-heading font-black text-2xl sm:text-3xl shadow-2xl shadow-indigo-600/40 hover:shadow-indigo-600/60 hover:scale-105 active:scale-95 transition-all duration-300 ring-8 ring-indigo-200/50 cursor-pointer">
                
                <svg id="roulette-icon" class="w-8 h-8 group-hover:rotate-180 transition-transform duration-700 text-white drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>

                <span id="roulette-btn-text">Give me Input</span>
                
                <span class="w-3.5 h-3.5 rounded-full bg-emerald-400 border-2 border-white shadow-xs animate-pulse"></span>
            </button>

            <div class="flex items-center gap-2 mt-6 text-xs text-slate-500 font-mono">
                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                <span>Click anytime to shuffle an instant i+1 immersion session</span>
            </div>
        </div>

        <!-- Featured Video Player Card (Revealed upon click) -->
        <div id="roulette-player-card" class="hidden text-left glass-panel rounded-3xl overflow-hidden shadow-2xl transition-all duration-500 animate-in fade-in zoom-in-95">
            <div class="px-6 py-4 bg-slate-900 text-white border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span id="roulette-level-badge" class="px-3.5 py-1 rounded-xl text-xs font-extrabold font-mono shadow-sm">Beginner</span>
                    <h3 id="roulette-title" class="font-heading text-lg font-black text-white">Video Title</h3>
                </div>
                <div class="flex items-center gap-2 font-mono text-xs font-bold text-indigo-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Randomized Session</span>
                </div>
            </div>

            <!-- Video Embed Container -->
            <div class="relative aspect-video w-full bg-black">
                <iframe id="roulette-iframe" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

            <div class="p-6 space-y-4 bg-slate-50">
                <div class="bg-white border border-slate-200/90 p-5 rounded-2xl shadow-xs space-y-1.5">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 animate-pulse"></span>
                        <span class="text-xs font-mono font-black uppercase text-indigo-700 tracking-wider">Context & Visual Guide (Zero Affective Filter)</span>
                    </div>
                    <p id="roulette-context" class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium"></p>
                </div>
            </div>
        </div>

    </div>

    <!-- Script handling arcade randomized reveal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('big-roulette-btn');
            const btnText = document.getElementById('roulette-btn-text');
            const icon = document.getElementById('roulette-icon');
            const playerCard = document.getElementById('roulette-player-card');
            const iframe = document.getElementById('roulette-iframe');
            const titleEl = document.getElementById('roulette-title');
            const levelEl = document.getElementById('roulette-level-badge');
            const contextEl = document.getElementById('roulette-context');

            let playlistVideos = [];

            fetch('/data/movies.json')
                .then(r => r.json())
                .then(data => { playlistVideos = data; })
                .catch(() => {
                    playlistVideos = [
                        { titulo: 'Pip: Guide Dog in Training', nivel_i_mas_uno: 'Beginner', descripcion_contexto: 'Puppy in guide dog academy facing hurdles.', url_video_embed: 'https://www.youtube.com/embed/07d2dXHYb94' },
                        { titulo: 'The Present', nivel_i_mas_uno: 'Beginner', descripcion_contexto: 'Boy receives unexpected puppy gift.', url_video_embed: 'https://www.youtube.com/embed/WjqiU5FgsYc' },
                        { titulo: 'Coin Operated', nivel_i_mas_uno: 'Beginner', descripcion_contexto: 'Chasing space dreams with a coin rocket.', url_video_embed: 'https://www.youtube.com/embed/5L4DQfVIcdg' },
                        { titulo: 'Snack Attack', nivel_i_mas_uno: 'Intermediate', descripcion_contexto: 'Cookie dispute at a train station.', url_video_embed: 'https://www.youtube.com/embed/38y_1EWIE9I' },
                        { titulo: 'One Small Step', nivel_i_mas_uno: 'Intermediate', descripcion_contexto: 'Journey of an aspiring astronaut girl.', url_video_embed: 'https://www.youtube.com/embed/yWd4mzGqQYo' },
                        { titulo: 'In a Heartbeat', nivel_i_mas_uno: 'Intermediate', descripcion_contexto: 'Heart jumps out of chest in love.', url_video_embed: 'https://www.youtube.com/embed/2REkk9SCRn0' },
                        { titulo: 'Simon\'s Cat: Feeding Time', nivel_i_mas_uno: 'Advanced', descripcion_contexto: 'Cat waking up owner for food with British humor.', url_video_embed: 'https://www.youtube.com/embed/w0ffwDYo00Q' }
                    ];
                });

            function getLevelBadgeClass(level) {
                if (level === 'Beginner') return 'bg-emerald-500 text-white border border-emerald-400';
                if (level === 'Intermediate') return 'bg-amber-500 text-white border border-amber-400';
                return 'bg-rose-500 text-white border border-rose-400';
            }

            btn?.addEventListener('click', () => {
                if (playlistVideos.length === 0) return;

                btnText.textContent = 'Selecting...';
                icon.classList.add('animate-spin');

                setTimeout(() => {
                    btnText.textContent = 'Give me another!';
                    icon.classList.remove('animate-spin');

                    const random = playlistVideos[Math.floor(Math.random() * playlistVideos.length)];

                    titleEl.textContent = random.titulo;
                    levelEl.textContent = `${random.nivel_i_mas_uno} i+1`;
                    levelEl.className = `px-3.5 py-1 rounded-xl text-xs font-extrabold font-mono shadow-sm ${getLevelBadgeClass(random.nivel_i_mas_uno)}`;
                    contextEl.textContent = random.descripcion_contexto;
                    iframe.src = `${random.url_video_embed}?autoplay=1&enablejsapi=1`;

                    playerCard.classList.remove('hidden');
                    playerCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 350);
            });
        });
    </script>
@endsection
