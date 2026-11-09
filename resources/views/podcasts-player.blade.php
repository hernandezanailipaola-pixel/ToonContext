@extends('layouts.app')

@section('title', 'Podcast Audio Player - ToonInput')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6 pb-16" id="podcast-player-container" data-podcast-id="{{ $podcastId }}">
        
        <!-- Top Back Navigation Bar -->
        <div class="glass-panel p-3.5 px-6 rounded-2xl flex items-center justify-between gap-3">
            <a href="{{ route('podcasts.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-600 hover:text-emerald-600 transition-colors">
                <span>← Back to Podcasts Catalog</span>
            </a>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400 hidden sm:inline font-mono">Format:</span>
                <span class="px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-mono font-extrabold border border-emerald-200 shadow-2xs">
                    Official Audio Series
                </span>
            </div>
        </div>

        <!-- Dark Audio Platform Player Card -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-6 sm:p-10 shadow-2xl text-white space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Podcast Square Art & Meta Info -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Square Artwork Poster -->
                    <div class="relative w-full max-w-xs mx-auto lg:mx-0 aspect-square rounded-3xl overflow-hidden border-2 border-slate-800 shadow-2xl group">
                        <img 
                            id="podcast-cover" 
                            src="" 
                            alt="Podcast Cover" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-transparent"></div>
                        <span id="podcast-genre-badge" class="absolute bottom-3.5 left-3.5 px-3 py-1 rounded-xl text-xs font-mono font-extrabold bg-slate-900/90 text-emerald-400 border border-slate-700 backdrop-blur-md">
                            Loading...
                        </span>
                    </div>

                    <!-- Meta Text -->
                    <div class="space-y-1.5 text-center lg:text-left">
                        <h1 id="podcast-title" class="font-heading text-2xl sm:text-3xl font-black text-white leading-tight">Loading Podcast...</h1>
                        <p id="podcast-author" class="text-xs font-mono text-slate-400 font-semibold">...</p>
                    </div>

                    <!-- English Description Box -->
                    <div class="bg-slate-900/80 p-5 rounded-2xl border border-slate-800 space-y-2 text-xs text-slate-300 leading-relaxed">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-emerald-400 font-mono">About this Audio Series</h4>
                        <p id="podcast-description" class="font-medium text-slate-200">
                            Loading description...
                        </p>
                    </div>

                    <!-- Key Vocabulary Notes Section -->
                    <div class="space-y-2">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 font-mono">Key Vocabulary & Keywords:</h4>
                        <div id="podcast-vocab-box" class="flex flex-wrap gap-1.5 pt-1">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>
                </div>

                <!-- Right Column: Compact Audio Widget YouTube Player & Playlist Focus -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <div class="flex items-center justify-between">
                        <h3 class="font-heading font-black text-lg text-emerald-400 flex items-center gap-2">
                            <span>🎧</span>
                            <span>Audio Playlist Widget</span>
                        </h3>
                        <a id="external-podcast-link" href="#" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 bg-slate-900 hover:bg-emerald-600 border border-slate-800 rounded-xl text-xs font-mono text-slate-300 hover:text-white transition flex items-center gap-1.5 shadow-sm">
                            <span>Open on YouTube</span>
                            <span class="text-xs">↗</span>
                        </a>
                    </div>

                    <!-- YouTube Player Container -->
                    <div class="relative w-full aspect-video min-h-[380px] sm:min-h-[440px] rounded-2xl overflow-hidden bg-slate-900 border border-slate-800 shadow-2xl">
                        <iframe 
                            id="podcast-youtube-iframe" 
                            class="w-full h-full border-0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                        </iframe>
                        
                        <!-- Loading Overlay -->
                        <div id="podcast-loading-overlay" class="absolute inset-0 bg-slate-950 flex flex-col items-center justify-center space-y-3 z-10 transition-opacity duration-300">
                            <div class="w-10 h-10 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-xs font-mono font-bold text-slate-400">Loading Audio Playlist...</span>
                        </div>
                    </div>

                    <!-- Listening Tips & Notes -->
                    <div class="p-5 rounded-2xl bg-emerald-950/40 border border-emerald-800/60 space-y-2 text-xs text-slate-300">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <h4 class="font-mono font-extrabold text-emerald-400 uppercase tracking-wider">Auditory Immersion Principle (Stephen Krashen):</h4>
                        </div>
                        <p class="leading-relaxed">
                            Do not pause every time you miss a word. Allow your brain to connect tone, rhythm, and narrative clues subconsciously. The brain naturally filters noise and absorbs recurring syntax effortlessly.
                        </p>
                    </div>

                </div>

            </div>

        </div>

        <!-- Quick Switcher Gallery (Other Available Podcasts) -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 space-y-4">
            <h3 class="font-heading text-lg font-black text-slate-900">Explore More Podcasts</h3>
            <div id="other-podcasts-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Dynamically populated via JS -->
            </div>
        </div>

    </div>

    <!-- Script constructing YouTube playlist URL & rendering meta -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('podcast-player-container');
            const targetId = container.getAttribute('data-podcast-id');
            const iframe = document.getElementById('podcast-youtube-iframe');
            const loadingOverlay = document.getElementById('podcast-loading-overlay');
            const externalLink = document.getElementById('external-podcast-link');

            const titleEl = document.getElementById('podcast-title');
            const genreBadge = document.getElementById('podcast-genre-badge');
            const authorEl = document.getElementById('podcast-author');
            const descEl = document.getElementById('podcast-description');
            const coverEl = document.getElementById('podcast-cover');
            const vocabBox = document.getElementById('podcast-vocab-box');
            const otherGrid = document.getElementById('other-podcasts-grid');

            fetch('/data/podcasts.json')
                .then(res => res.json())
                .then(podcasts => {
                    const currentPodcast = podcasts.find(p => p.id === targetId) || podcasts[0];

                    if (currentPodcast) {
                        titleEl.textContent = currentPodcast.title;
                        genreBadge.textContent = currentPodcast.genre;
                        authorEl.textContent = `Author: ${currentPodcast.author} • ${currentPodcast.episodesCount}`;
                        descEl.textContent = currentPodcast.description;
                        coverEl.src = currentPodcast.cover;
                        coverEl.alt = currentPodcast.title;
                        externalLink.href = `https://www.youtube.com/playlist?list=${currentPodcast.playlistId}`;

                        // Render vocabulary keywords
                        vocabBox.innerHTML = (currentPodcast.vocabNotes || []).map(word => `
                            <span class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-700 text-emerald-400 text-xs font-mono font-bold">
                                #${word}
                            </span>
                        `).join('');

                        // Robust YouTube playlist embed URL
                        const firstVid = currentPodcast.firstVideoId;
                        const playlistUrl = firstVid
                            ? `https://www.youtube.com/embed/${firstVid}?list=${currentPodcast.playlistId}&index=1&hl=en&cc_load_policy=1&cc_lang_pref=en&autoplay=1`
                            : `https://www.youtube.com/embed/videoseries?list=${currentPodcast.playlistId}&hl=en&cc_load_policy=1&cc_lang_pref=en&autoplay=1`;

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

                    // Populate other podcasts switcher
                    const others = podcasts.filter(p => p.id !== currentPodcast.id);
                    otherGrid.innerHTML = others.map(item => `
                        <a href="/podcasts/${item.id}" class="p-3.5 bg-slate-50/90 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 rounded-2xl transition flex items-center gap-3 group shadow-2xs">
                            <img src="${item.cover}" alt="${item.title}" class="w-14 h-14 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform" />
                            <div class="overflow-hidden">
                                <h4 class="font-black text-xs text-slate-900 group-hover:text-emerald-600 transition truncate">${item.title}</h4>
                                <p class="text-[10px] text-slate-500 font-mono truncate">${item.genre}</p>
                            </div>
                        </a>
                    `).join('');
                })
                .catch(err => {
                    console.error('Error loading podcast metadata:', err);
                    loadingOverlay.innerHTML = `
                        <p class="text-xs text-rose-400 font-extrabold">Failed to load podcast data.</p>
                    `;
                });
        });
    </script>
@endsection
