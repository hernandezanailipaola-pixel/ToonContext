@extends('layouts.app')

@section('title', 'Animated Web Series Streaming Hub - ToonInput')

@section('content')
    <div class="max-w-7xl mx-auto space-y-10 pb-16">
        
        <!-- Streaming Header Hero Banner -->
        <div class="relative bg-gradient-to-r from-slate-950 via-indigo-950 to-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-12 text-white overflow-hidden shadow-2xl">
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="max-w-3xl space-y-4 relative z-10">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-xs font-extrabold font-mono shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 animate-ping"></span>
                    <span>Subconscious Immersion • Indie Web Series</span>
                </span>
                
                <h1 class="font-heading text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                    Animated Web Series <br/>
                    <span class="text-indigo-400">& English Streaming Hub</span>
                </h1>
                
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed font-medium">
                    Immerse yourself in top-tier indie animated web series. Watch official YouTube playlists with forced English audio and closed captions to build spontaneous language intuition.
                </p>
            </div>
        </div>

        <!-- Featured Banner: Spotlight -->
        <div id="featured-hero-box" class="hidden bg-slate-900/90 backdrop-blur-md rounded-3xl border border-slate-800 p-6 sm:p-10 shadow-2xl overflow-hidden relative">
            <!-- Dynamically populated if featured item exists -->
        </div>

        <!-- Series Catalog Grid Section -->
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200/80 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-8 bg-indigo-600 rounded-full"></div>
                    <h2 class="font-heading text-2xl font-black text-slate-900">Explore Web Series Catalog</h2>
                </div>
                <span id="series-count-badge" class="px-3.5 py-1 rounded-xl bg-slate-100/90 border border-slate-200 text-slate-700 text-xs font-extrabold font-mono shadow-2xs">
                    Loading Series...
                </span>
            </div>

            <!-- Dynamic Series Container -->
            <div id="series-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Skeleton Loader -->
                <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
                <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
                <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
            </div>
        </div>

    </div>

    <!-- Script fetching series.json and dynamically rendering cards -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const seriesGrid = document.getElementById('series-grid');
            const featuredHero = document.getElementById('featured-hero-box');
            const countBadge = document.getElementById('series-count-badge');

            fetch('/data/series.json')
                .then(res => res.json())
                .then(seriesList => {
                    countBadge.textContent = `${seriesList.length} Series Playlists Available`;

                    // Render Featured Hero Banner if available
                    const featured = seriesList.find(s => s.featured) || seriesList[0];
                    if (featured) {
                        featuredHero.classList.remove('hidden');
                        featuredHero.innerHTML = `
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                                <div class="lg:col-span-7 space-y-4">
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-xl text-xs font-mono font-black bg-indigo-600 text-white uppercase tracking-wider shadow-sm">
                                            Featured Series
                                        </span>
                                        <span class="px-3 py-1 rounded-xl text-xs font-mono font-bold bg-slate-800 text-indigo-300 border border-slate-700">
                                            ${featured.episodesCount}
                                        </span>
                                    </div>
                                    <h2 class="font-heading text-3xl sm:text-4xl font-black text-white leading-tight">${featured.title}</h2>
                                    <p class="text-xs font-semibold text-slate-400 font-mono">
                                        <span class="text-slate-200">Creator:</span> ${featured.creator} • 
                                        <span class="text-indigo-400">${featured.genre}</span>
                                    </p>
                                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-medium">${featured.synopsis}</p>
                                    <div class="pt-2">
                                        <a href="/web-series/${featured.id}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold text-xs shadow-lg shadow-indigo-600/40 transition-all duration-200 group hover:scale-105">
                                            <span>Watch Full Series Playlist</span>
                                            <span class="text-base group-hover:translate-x-1 transition-transform">▶</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="lg:col-span-5 flex justify-center">
                                    <div class="relative w-full rounded-2xl overflow-hidden border border-slate-700 shadow-2xl group max-h-64">
                                        <img src="${featured.cover}" alt="${featured.title}" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-700" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    // Render Catalog Cards
                    seriesGrid.innerHTML = seriesList.map(series => `
                        <article class="glass-panel rounded-3xl overflow-hidden card-interactive flex flex-col justify-between group">
                            
                            <!-- Cover Thumbnail -->
                            <div class="relative aspect-video bg-slate-950 overflow-hidden cursor-pointer">
                                <a href="/web-series/${series.id}">
                                    <img src="${series.cover}" alt="${series.title}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 ease-out" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent"></div>
                                    
                                    <span class="absolute top-3.5 left-3.5 px-3 py-1 rounded-xl text-xs font-mono font-extrabold bg-slate-900/90 text-indigo-400 border border-slate-700/90 shadow-sm backdrop-blur-md">
                                        ${series.episodesCount}
                                    </span>
                                    
                                    <!-- Play Hover Icon -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-13 h-13 rounded-2xl bg-indigo-600/95 text-white flex items-center justify-center shadow-xl shadow-indigo-600/40 group-hover:scale-115 group-hover:bg-indigo-500 transition-all duration-300 backdrop-blur-xs">
                                            <svg class="w-6 h-6 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Card Details -->
                            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="text-[10px] font-mono font-extrabold bg-indigo-50 text-indigo-700 px-2.5 py-0.5 rounded-lg border border-indigo-200">${series.genre}</span>
                                    </div>
                                    <h3 class="font-heading text-xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors leading-snug">
                                        <a href="/web-series/${series.id}">${series.title}</a>
                                    </h3>
                                    <p class="text-[11px] font-mono text-slate-500 font-semibold">
                                        <span class="text-slate-900 font-bold">Creator:</span> ${series.creator}
                                    </p>
                                    <p class="text-xs text-slate-600 leading-relaxed font-medium line-clamp-3">
                                        ${series.synopsis}
                                    </p>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-[11px] font-mono font-bold text-slate-400">Captions: English</span>
                                    <a href="/web-series/${series.id}" class="text-xs font-black text-indigo-600 hover:text-indigo-800 flex items-center gap-1 group-hover:translate-x-1 transition-all">
                                        <span>Watch Playlist</span>
                                        <span class="text-sm">▶</span>
                                    </a>
                                </div>
                            </div>

                        </article>
                    `).join('');
                })
                .catch(err => {
                    console.error('Error loading series.json:', err);
                    seriesGrid.innerHTML = `<div class="col-span-full text-center text-rose-600 font-bold py-12">Failed to load series catalog data.</div>`;
                });
        });
    </script>
@endsection
