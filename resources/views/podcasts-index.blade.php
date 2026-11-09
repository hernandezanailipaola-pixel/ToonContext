@extends('layouts.app')

@section('title', 'English Audio Podcasts & Fiction - ToonInput')

@section('content')
    <div class="max-w-7xl mx-auto space-y-10 pb-16">
        
        <!-- Header Banner: Audio Platform Studio Style -->
        <div class="relative bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-12 text-white overflow-hidden shadow-2xl">
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="max-w-3xl space-y-4 relative z-10">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-extrabold font-mono shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Auditory Comprehensible Immersion</span>
                </span>
                
                <h1 class="font-heading text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                    English Audio Podcasts <br/>
                    <span class="text-emerald-400">& Storytelling Playlists</span>
                </h1>
                
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed font-medium">
                    Train your ears with captivating audio fiction, radio dramas, literature analysis, and expert lectures. Designed for low-anxiety listening with forced English subtitles and key vocabulary notes.
                </p>
            </div>
        </div>

        <!-- Featured Podcast Banner: Spotlight -->
        <div id="featured-podcast-box" class="hidden bg-slate-900/90 backdrop-blur-md rounded-3xl border border-slate-800 p-6 sm:p-10 shadow-2xl overflow-hidden relative">
            <!-- Dynamically populated if featured item exists -->
        </div>

        <!-- Podcast Catalog Grid -->
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200/80 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-8 bg-emerald-600 rounded-full"></div>
                    <h2 class="font-heading text-2xl font-black text-slate-900">Explore Audio Podcast Catalog</h2>
                </div>
                <span id="podcast-count-badge" class="px-3.5 py-1 rounded-xl bg-slate-100/90 border border-slate-200 text-slate-700 text-xs font-extrabold font-mono shadow-2xs">
                    Loading Podcasts...
                </span>
            </div>

            <!-- Dynamic Podcast Container (Square Cover Cards) -->
            <div id="podcast-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Skeleton Loader -->
                <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
                <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
                <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
            </div>
        </div>

    </div>

    <!-- Script fetching podcasts.json and dynamically rendering cards -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const podcastGrid = document.getElementById('podcast-grid');
            const featuredBox = document.getElementById('featured-podcast-box');
            const countBadge = document.getElementById('podcast-count-badge');

            fetch('/data/podcasts.json')
                .then(res => res.json())
                .then(podcasts => {
                    countBadge.textContent = `${podcasts.length} Podcasts Available`;

                    // Render Featured Podcast (The Magnus Archives)
                    const featured = podcasts.find(p => p.id === 'magnus-archives') || podcasts[0];
                    if (featured) {
                        featuredBox.classList.remove('hidden');
                        featuredBox.innerHTML = `
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                                <div class="md:col-span-4 flex justify-center">
                                    <div class="relative w-48 h-48 sm:w-56 sm:h-56 rounded-3xl overflow-hidden border-2 border-slate-700 shadow-2xl shrink-0 group">
                                        <img src="${featured.cover}" alt="${featured.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                        <div class="absolute inset-0 bg-slate-950/20 group-hover:bg-slate-950/0 transition-colors"></div>
                                    </div>
                                </div>
                                <div class="md:col-span-8 space-y-4">
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-xl text-xs font-mono font-black bg-emerald-600 text-white uppercase tracking-wider shadow-sm">
                                            Featured Audio Show
                                        </span>
                                        <span class="px-3 py-1 rounded-xl text-xs font-mono font-bold bg-slate-800 text-emerald-300 border border-slate-700">
                                            ${featured.genre}
                                        </span>
                                    </div>
                                    <h2 class="font-heading text-3xl sm:text-4xl font-black text-white leading-tight">${featured.title}</h2>
                                    <p class="text-xs font-semibold text-slate-400 font-mono">
                                        Author: <span class="text-slate-200">${featured.author}</span> • ${featured.episodesCount}
                                    </p>
                                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-medium">${featured.description}</p>
                                    <div class="pt-2">
                                        <a href="/podcasts/${featured.id}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs shadow-lg shadow-emerald-600/40 transition-all duration-200 group hover:scale-105">
                                            <span>Listen to Audio Playlist</span>
                                            <span class="text-base group-hover:translate-x-1 transition-transform">🎧</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    // Render Podcast Cards (Square Cover Platform Style)
                    podcastGrid.innerHTML = podcasts.map(podcast => `
                        <article class="glass-panel rounded-3xl overflow-hidden card-interactive flex flex-col justify-between group">
                            
                            <div class="p-6 space-y-4">
                                <!-- Square Artwork Poster -->
                                <div class="relative aspect-square w-full rounded-2xl overflow-hidden bg-slate-950 shadow-md">
                                    <a href="/podcasts/${podcast.id}">
                                        <img src="${podcast.cover}" alt="${podcast.title}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 ease-out" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent"></div>
                                        
                                        <span class="absolute top-3 left-3 px-3 py-1 rounded-xl text-[11px] font-mono font-extrabold bg-slate-900/90 text-emerald-400 border border-slate-700 backdrop-blur-md">
                                            ${podcast.genre}
                                        </span>

                                        <div class="absolute bottom-3 right-3 w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-emerald-500 transition-all duration-300">
                                            <span class="text-sm">🎧</span>
                                        </div>
                                    </a>
                                </div>

                                <!-- Metadata -->
                                <div class="space-y-1.5">
                                    <h3 class="font-heading text-xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors leading-snug">
                                        <a href="/podcasts/${podcast.id}">${podcast.title}</a>
                                    </h3>
                                    <p class="text-[11px] font-mono text-slate-500 font-semibold truncate">
                                        By <span class="text-slate-800 font-bold">${podcast.author}</span>
                                    </p>
                                    <p class="text-xs text-slate-600 leading-relaxed font-medium line-clamp-3">
                                        ${podcast.description}
                                    </p>
                                </div>

                                <!-- Vocabulary Highlights -->
                                <div class="space-y-1 pt-1">
                                    <span class="text-[10px] font-mono font-extrabold uppercase text-slate-400 block tracking-wider">Key Vocabulary:</span>
                                    <div class="flex flex-wrap gap-1">
                                        ${(podcast.vocabNotes || []).slice(0, 4).map(v => `<span class="text-[10px] bg-emerald-50 text-emerald-800 font-extrabold px-2 py-0.5 rounded-md border border-emerald-200 font-mono">${v}</span>`).join('')}
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <a href="/podcasts/${podcast.id}" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-emerald-600 text-slate-700 hover:text-white font-extrabold text-xs transition-all duration-200 flex items-center justify-center gap-2 group-hover:bg-emerald-600 group-hover:text-white shadow-2xs">
                                    <span>Open Audio Player</span>
                                    <span>→</span>
                                </a>
                            </div>

                        </article>
                    `).join('');
                })
                .catch(err => {
                    console.error('Error fetching podcast data:', err);
                    podcastGrid.innerHTML = `<div class="col-span-full text-center text-rose-600 font-bold py-12">Failed to load podcast catalog data.</div>`;
                });
        });
    </script>
@endsection
