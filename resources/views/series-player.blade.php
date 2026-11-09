@extends('layouts.app')

@section('title', 'Web Series Player - ToonInput')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6 pb-16" id="player-container" data-series-id="{{ $seriesId }}">
        
        <!-- Top Back Navigation Bar -->
        <div class="glass-panel p-3.5 px-6 rounded-2xl flex items-center justify-between gap-3">
            <a href="{{ route('series.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-600 hover:text-indigo-600 transition-colors">
                <span>← Back to Web Series Hub</span>
            </a>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400 hidden sm:inline font-mono">Format:</span>
                <span class="px-3 py-1 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-mono font-extrabold border border-indigo-200 shadow-2xs">
                    Official YouTube Series Playlist
                </span>
            </div>
        </div>

        <!-- Theater Mode Main Player Section -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-4 sm:p-8 shadow-2xl space-y-6 text-white">
            
            <!-- Video Container (16:9 Aspect Ratio) -->
            <div class="relative w-full aspect-video min-h-[380px] sm:min-h-[480px] rounded-2xl overflow-hidden bg-black border border-slate-800 shadow-2xl">
                <iframe 
                    id="youtube-player-iframe" 
                    class="w-full h-full border-0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
                
                <!-- Loading Placeholder Overlay -->
                <div id="player-loading-overlay" class="absolute inset-0 bg-slate-950 flex flex-col items-center justify-center space-y-3 z-10 transition-opacity duration-300">
                    <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                    <span class="text-xs font-mono font-bold text-slate-400">Loading Series Playlist...</span>
                </div>
            </div>

            <!-- Series Details Bar -->
            <div class="space-y-4 pt-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h1 id="series-title" class="font-heading text-2xl sm:text-3xl font-black text-white">Loading Series...</h1>
                            <span id="series-genre" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-indigo-950 text-indigo-400 border border-indigo-800 font-mono">
                                Loading...
                            </span>
                        </div>
                        <p id="series-creator" class="text-xs font-mono text-slate-400 font-semibold mt-1">...</p>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <a id="external-playlist-link" href="#" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-indigo-600 border border-slate-800 text-xs font-mono font-bold text-slate-300 hover:text-white transition flex items-center gap-1.5 shadow-sm">
                            <span>Open Playlist on YouTube</span>
                            <span class="text-xs">↗</span>
                        </a>
                        <span class="px-3 py-2 rounded-xl bg-slate-900 border border-slate-800 text-xs font-mono font-bold text-slate-300">
                            Captions: <strong class="text-emerald-400">English (Forced)</strong>
                        </span>
                    </div>
                </div>

                <!-- Synopsis Box -->
                <div class="bg-slate-900/80 p-5 rounded-2xl border border-slate-800 space-y-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                    <h3 class="font-bold text-xs uppercase tracking-wider text-indigo-400 font-mono">Series Synopsis & Immersion Context</h3>
                    <p id="series-synopsis" class="font-medium text-slate-200">
                        Loading series overview...
                    </p>
                </div>
            </div>

        </div>

        <!-- Quick Switcher Gallery (Other Available Series) -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 space-y-4">
            <h3 class="font-heading text-lg font-black text-slate-900">Discover More Animated Series</h3>
            <div id="other-series-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Dynamically populated via JS -->
            </div>
        </div>

    </div>

    <!-- Script constructing YouTube playlist iframe URL & updating UI -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('player-container');
            const targetId = container.getAttribute('data-series-id');
            const iframe = document.getElementById('youtube-player-iframe');
            const loadingOverlay = document.getElementById('player-loading-overlay');
            const externalLink = document.getElementById('external-playlist-link');

            const titleEl = document.getElementById('series-title');
            const genreEl = document.getElementById('series-genre');
            const creatorEl = document.getElementById('series-creator');
            const synopsisEl = document.getElementById('series-synopsis');
            const otherGrid = document.getElementById('other-series-grid');

            fetch('/data/series.json')
                .then(res => res.json())
                .then(seriesList => {
                    const currentSeries = seriesList.find(s => s.id === targetId) || seriesList[0];

                    if (currentSeries) {
                        titleEl.textContent = currentSeries.title;
                        genreEl.textContent = currentSeries.genre;
                        creatorEl.textContent = `By ${currentSeries.creator} • ${currentSeries.episodesCount}`;
                        synopsisEl.textContent = currentSeries.synopsis;
                        externalLink.href = `https://www.youtube.com/playlist?list=${currentSeries.playlistId}`;

                        const firstVid = currentSeries.firstVideoId;
                        const playlistUrl = firstVid
                            ? `https://www.youtube.com/embed/${firstVid}?list=${currentSeries.playlistId}&index=1&hl=en&cc_load_policy=1&cc_lang_pref=en&autoplay=1`
                            : `https://www.youtube.com/embed/videoseries?list=${currentSeries.playlistId}&hl=en&cc_load_policy=1&cc_lang_pref=en&autoplay=1`;

                        iframe.src = playlistUrl;

                        iframe.onload = () => {
                            loadingOverlay.classList.add('opacity-0');
                            setTimeout(() => loadingOverlay.classList.add('hidden'), 300);
                        };
                        setTimeout(() => {
                            loadingOverlay.classList.add('opacity-0');
                            setTimeout(() => loadingOverlay.classList.add('hidden'), 300);
                        }, 1200);
                    }

                    // Populate Quick Switcher Grid
                    const others = seriesList.filter(s => s.id !== currentSeries.id);
                    otherGrid.innerHTML = others.map(item => `
                        <a href="/web-series/${item.id}" class="p-3.5 bg-slate-50/90 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-2xl transition flex items-center gap-3 group shadow-2xs">
                            <img src="${item.cover}" alt="${item.title}" class="w-16 h-12 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform" />
                            <div class="overflow-hidden">
                                <h4 class="font-black text-xs text-slate-900 group-hover:text-indigo-600 transition truncate">${item.title}</h4>
                                <p class="text-[10px] text-slate-500 font-mono truncate">${item.genre}</p>
                            </div>
                        </a>
                    `).join('');
                })
                .catch(err => {
                    console.error('Error fetching series data:', err);
                    loadingOverlay.innerHTML = `
                        <p class="text-xs text-rose-400 font-extrabold">Failed to load series metadata.</p>
                    `;
                });
        });
    </script>
@endsection
