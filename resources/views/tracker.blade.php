@extends('layouts.app')

@section('title', 'Immersion Journal & Tracker - ToonInput')

@section('content')
    <!-- Hero Header -->
    <div class="text-center max-w-4xl mx-auto space-y-4 pt-2 pb-2">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-extrabold shadow-xs">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600"></span>
            </span>
            <span>Feature 2 • Client Immersion Journal (LocalStorage)</span>
        </div>
        
        <h1 class="font-heading text-4xl sm:text-6xl font-black text-slate-900 tracking-tight leading-tight">
            Stress-Free <span class="text-gradient-emerald">Immersion Journal</span>
        </h1>
        
        <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto leading-relaxed font-medium">
            Log your daily English acquisition minutes effortlessly. No accounts, no tests, and zero grammar pressure — your progress is automatically preserved in your browser.
        </p>
    </div>

    <!-- Main Progress Dashboard Card -->
    <div class="glass-panel rounded-3xl p-6 sm:p-8 max-w-5xl mx-auto space-y-6 shadow-sm relative overflow-hidden">
        
        <!-- Ambient decorative corner glow -->
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- 3 Core Metric Highlights -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 relative z-10">
            <!-- Stat 1: Total Completion -->
            <div class="bg-white/90 border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-1.5">
                <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider block">Acquisition Progress</span>
                <div class="flex items-baseline gap-2">
                    <span id="tracker-percentage" class="font-heading text-3xl sm:text-4xl font-black text-emerald-600">0%</span>
                    <span class="text-xs font-bold text-slate-500">completed</span>
                </div>
            </div>

            <!-- Stat 2: Immersion Minutes -->
            <div class="bg-white/90 border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-1.5">
                <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider block">Auditory Exposure</span>
                <div class="flex items-baseline gap-2">
                    <span id="tracker-minutes" class="font-heading text-3xl sm:text-4xl font-black text-indigo-600">0</span>
                    <span class="text-xs font-bold text-slate-500">total minutes</span>
                </div>
            </div>

            <!-- Stat 3: Shorts Logged -->
            <div class="bg-white/90 border border-slate-200/90 rounded-2xl p-5 shadow-2xs space-y-1.5 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider block">Completed Shorts</span>
                    <div class="flex items-baseline gap-1.5">
                        <span id="tracker-watched-count" class="font-heading text-3xl sm:text-4xl font-black text-slate-900">0</span>
                        <span class="text-slate-400 font-bold text-lg">/</span>
                        <span id="tracker-total-count" class="font-heading text-xl font-bold text-slate-600">7</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar Container -->
        <div class="space-y-2 relative z-10">
            <div class="flex items-center justify-between text-xs font-mono font-bold text-slate-600">
                <span>Overall Immersion Target</span>
                <span class="text-emerald-700">Subconscious Retention Mode</span>
            </div>
            <div class="w-full h-4 bg-slate-100/90 rounded-full overflow-hidden border border-slate-200/90 p-0.5 shadow-inner">
                <div id="tracker-progress-bar" class="h-full bg-gradient-to-r from-emerald-500 via-teal-500 to-indigo-600 rounded-full transition-all duration-700 w-0 shadow-sm"></div>
            </div>
        </div>

        <!-- Reset Button Toolbar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2 border-t border-slate-100 relative z-10 text-xs text-slate-500">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Data stored locally in browser storage (no tracking cookies)</span>
            </div>
            <button id="reset-tracker-btn" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-700 border border-slate-200 hover:border-rose-300 font-bold transition-all shadow-2xs">
                Reset Progress
            </button>
        </div>

    </div>

    <!-- 100% Celebration Banner (Initially hidden) -->
    <div id="celebration-banner" class="hidden max-w-5xl mx-auto p-6 bg-gradient-to-r from-emerald-600 via-teal-600 to-indigo-600 rounded-3xl text-white shadow-xl shadow-emerald-600/20 text-center space-y-2 animate-in fade-in zoom-in-95 duration-300">
        <span class="text-2xl">🎉</span>
        <h3 class="font-heading text-2xl font-black text-white">Full Immersion Cycle Complete!</h3>
        <p class="text-xs sm:text-sm text-emerald-100 max-w-xl mx-auto font-medium">
            You've completed all animated shorts in this catalog, lowering your affective filter and building intuitive English comprehension. Keep immersing with our Web Series and Podcasts!
        </p>
    </div>

    <!-- Episode Checklist Grid -->
    <div class="space-y-4">
        <div class="flex items-center justify-between border-b border-slate-200/80 pb-3">
            <h2 class="font-heading text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                <span>Immersion Checklist</span>
            </h2>
            <span class="text-xs font-mono text-slate-500">Click card button to mark as completed</span>
        </div>

        <div id="tracker-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Dynamic JS cards -->
        </div>
    </div>

    <!-- Script handling LocalStorage & Dynamic Sync -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const STORAGE_KEY = 'tooninput_laravel_tracker';
            let episodes = [];
            let watchedIds = getStoredWatched();

            const trackerList = document.getElementById('tracker-list');
            const watchedCountEl = document.getElementById('tracker-watched-count');
            const totalCountEl = document.getElementById('tracker-total-count');
            const minutesEl = document.getElementById('tracker-minutes');
            const percentageEl = document.getElementById('tracker-percentage');
            const progressBar = document.getElementById('tracker-progress-bar');
            const celebrationBanner = document.getElementById('celebration-banner');
            const resetBtn = document.getElementById('reset-tracker-btn');

            function getStoredWatched() {
                try {
                    const data = localStorage.getItem(STORAGE_KEY);
                    return data ? JSON.parse(data) : [];
                } catch(e) {
                    return [];
                }
            }

            function saveWatched(array) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(array));
            }

            // Fetch live catalog data to ensure perfect sync
            fetch('/data/movies.json')
                .then(r => r.json())
                .then(data => {
                    episodes = data;
                    renderTracker();
                })
                .catch(() => {
                    episodes = [
                        { id: 1, titulo: 'Pip: Guide Dog in Training', duracion_minutos: 4, nivel_i_mas_uno: 'Beginner', descripcion_contexto: 'Visual intro to routines and basic commands.' },
                        { id: 2, titulo: 'The Present', duracion_minutos: 4, nivel_i_mas_uno: 'Beginner', descripcion_contexto: 'Emotional storytelling and clear body language.' },
                        { id: 3, titulo: 'Coin Operated', duracion_minutos: 5, nivel_i_mas_uno: 'Beginner', descripcion_contexto: 'Space exploration dreams and perseverance.' },
                        { id: 4, titulo: 'Snack Attack', duracion_minutos: 5, nivel_i_mas_uno: 'Intermediate', descripcion_contexto: 'Cookie dispute with situational humor.' },
                        { id: 5, titulo: 'One Small Step', duracion_minutos: 8, nivel_i_mas_uno: 'Intermediate', descripcion_contexto: 'Luna and her shoemaker father.' },
                        { id: 6, titulo: 'In a Heartbeat', duracion_minutos: 4, nivel_i_mas_uno: 'Intermediate', descripcion_contexto: 'Silent romantic animated short.' },
                        { id: 7, titulo: 'Simon\'s Cat: Feeding Time', duracion_minutos: 4, nivel_i_mas_uno: 'Advanced', descripcion_contexto: 'British humor and authentic input.' }
                    ];
                    renderTracker();
                });

            function renderTracker() {
                if (!episodes || episodes.length === 0) return;

                totalCountEl.textContent = episodes.length;
                const validWatched = watchedIds.filter(id => episodes.some(ep => ep.id === id));
                watchedCountEl.textContent = validWatched.length;
                
                const totalMinutes = episodes
                    .filter(ep => validWatched.includes(ep.id))
                    .reduce((sum, ep) => sum + (ep.duracion_minutos || 4), 0);
                minutesEl.textContent = totalMinutes;

                const percent = Math.round((validWatched.length / episodes.length) * 100);
                percentageEl.textContent = `${percent}%`;
                progressBar.style.width = `${percent}%`;

                if (percent === 100) {
                    celebrationBanner?.classList.remove('hidden');
                } else {
                    celebrationBanner?.classList.add('hidden');
                }

                trackerList.innerHTML = episodes.map(ep => {
                    const isWatched = validWatched.includes(ep.id);
                    return `
                        <div class="glass-panel rounded-3xl p-6 transition-all duration-300 flex flex-col justify-between card-interactive relative overflow-hidden ${
                            isWatched 
                                ? 'border-emerald-300/80 bg-emerald-50/60' 
                                : ''
                        }">
                            ${isWatched ? '<div class="absolute top-0 right-0 w-16 h-16 bg-emerald-500/10 rounded-bl-full pointer-events-none"></div>' : ''}

                            <div class="space-y-3.5 relative z-10">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="px-3 py-1 rounded-xl text-xs font-mono font-extrabold shadow-2xs ${
                                        isWatched 
                                            ? 'bg-emerald-600 text-white' 
                                            : 'bg-slate-100 text-slate-700 border border-slate-200'
                                    }">
                                        ${isWatched ? '✓ Completed' : 'Pending'}
                                    </span>
                                    <span class="text-xs font-mono font-bold text-slate-500 bg-white/90 px-2.5 py-0.5 rounded-lg border border-slate-200 shadow-2xs">
                                        ⏱️ ${ep.duracion_minutos || 4} mins
                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <span class="text-[10px] font-mono font-extrabold uppercase tracking-wider ${
                                        ep.nivel_i_mas_uno === 'Beginner' ? 'text-emerald-700' :
                                        ep.nivel_i_mas_uno === 'Intermediate' ? 'text-amber-700' : 'text-rose-700'
                                    }">
                                        ${ep.nivel_i_mas_uno || 'Beginner'} i+1
                                    </span>
                                    <h3 class="font-heading text-lg font-black leading-snug ${isWatched ? 'text-emerald-950 line-through opacity-85' : 'text-slate-900'}">
                                        ${ep.titulo}
                                    </h3>
                                </div>

                                <div class="p-3 bg-white/80 rounded-2xl border border-slate-200/70 text-xs text-slate-600 leading-relaxed font-medium">
                                    ${ep.descripcion_contexto}
                                </div>
                            </div>

                            <div class="pt-4 mt-2 border-t border-slate-100/90 relative z-10">
                                <button 
                                    class="toggle-ep-btn w-full py-2.5 px-4 rounded-2xl font-extrabold text-xs transition-all duration-200 flex items-center justify-center gap-2 shadow-sm ${
                                        isWatched 
                                            ? 'bg-emerald-100 border border-emerald-300 text-emerald-900 hover:bg-rose-50 hover:border-rose-300 hover:text-rose-700' 
                                            : 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-indigo-600/30'
                                    }"
                                    data-id="${ep.id}">
                                    ${isWatched ? '✓ Completed (Click to Undo)' : '+ Mark as Immersed'}
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');

                document.querySelectorAll('.toggle-ep-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = parseInt(btn.getAttribute('data-id'), 10);
                        if (watchedIds.includes(id)) {
                            watchedIds = watchedIds.filter(item => item !== id);
                        } else {
                            watchedIds.push(id);
                        }
                        saveWatched(watchedIds);
                        renderTracker();
                    });
                });
            }

            resetBtn?.addEventListener('click', () => {
                if (confirm('Do you want to reset your immersion journal progress?')) {
                    watchedIds = [];
                    saveWatched([]);
                    renderTracker();
                }
            });
        });
    </script>
@endsection
