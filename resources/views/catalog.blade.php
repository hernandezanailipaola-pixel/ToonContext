@extends('layouts.app')

@section('title', 'Static Animated Catalog - ToonInput')

@section('content')
    <!-- Hero Header -->
    <div class="text-center max-w-4xl mx-auto space-y-5 pt-2 pb-2">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50/90 border border-indigo-200/90 text-indigo-700 text-xs font-extrabold shadow-xs">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
            </span>
            <span>Feature 1 • Static JSON Immersion Catalog (movies.json)</span>
        </div>
        
        <h1 class="font-heading text-4xl sm:text-6xl font-black text-slate-900 tracking-tight leading-tight">
            Explore Animated Shorts with <span class="text-gradient-indigo">Input i+1</span>
        </h1>
        
        <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto leading-relaxed font-medium">
            Acquire English naturally through world-class animated storytelling. Visual context decodes meaning without drills, exams, or mental translation.
        </p>

        <div class="inline-flex items-center gap-2 text-[11px] font-mono text-slate-500 bg-white/80 px-4 py-1 rounded-full border border-slate-200 shadow-2xs">
            <span class="text-indigo-600 font-bold">Curated by:</span>
            <span>Anaili Hernandez, Miliangel Morillo, Mauricio Guevara, Ana Urrutia & Isamar Rodriguez</span>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="glass-panel p-4 sm:p-5 rounded-3xl space-y-4 sm:space-y-0 sm:flex sm:items-center sm:justify-between gap-4">
        <!-- Search input -->
        <div class="relative w-full sm:w-84">
            <input 
                type="text" 
                id="catalog-search" 
                placeholder="Search short, context clue, or tag..." 
                class="w-full bg-slate-50/90 border border-slate-200 focus:border-indigo-600 focus:bg-white text-slate-900 placeholder-slate-400 text-xs font-semibold rounded-2xl pl-10 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all shadow-inner"
            />
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <!-- Level Filter Buttons -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full sm:w-auto p-1 bg-slate-100/90 rounded-2xl border border-slate-200/90" id="level-filters">
            <button data-level="All" class="level-btn px-4 py-2 rounded-xl text-xs font-extrabold bg-indigo-600 text-white shadow-md shadow-indigo-600/30 transition-all">All Shorts</button>
            <button data-level="Beginner" class="level-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-slate-900 hover:bg-white transition-all">Beginner</button>
            <button data-level="Intermediate" class="level-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-slate-900 hover:bg-white transition-all">Intermediate</button>
            <button data-level="Advanced" class="level-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-slate-900 hover:bg-white transition-all">Advanced</button>
        </div>
    </div>

    <!-- Active Filter Counter & Quick Status -->
    <div class="flex items-center justify-between text-xs text-slate-500 px-2 font-mono">
        <span id="catalog-count-label" class="font-bold text-slate-700">Loading catalog items...</span>
        <span class="text-indigo-600 font-extrabold">Instant i+1 Acquisition</span>
    </div>

    <!-- Video Grid Container -->
    <div id="catalog-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Skeleton cards dynamically replaced -->
        <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
        <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
        <div class="glass-panel p-6 rounded-3xl animate-pulse h-96"></div>
    </div>

    <!-- Video Modal Player -->
    <div id="catalog-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 bg-slate-950/80 backdrop-blur-md transition-all duration-300">
        <div class="relative w-full max-w-4xl bg-white border border-slate-200/90 rounded-3xl overflow-hidden shadow-2xl flex flex-col max-h-[92vh] animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-slate-900 text-white border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span id="modal-level-badge" class="px-3 py-1 rounded-full text-xs font-extrabold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 font-mono">Beginner</span>
                    <h3 id="modal-video-title" class="font-heading text-base sm:text-lg font-black text-white truncate max-w-md sm:max-w-xl">Video Title</h3>
                </div>
                <button id="close-catalog-modal" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-full transition" title="Close (Esc)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Video Container -->
            <div class="relative aspect-video w-full bg-black">
                <iframe id="modal-iframe" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

            <!-- Modal Pre-Watched Context Information -->
            <div class="p-6 overflow-y-auto space-y-3 bg-slate-50">
                <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-1.5">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 animate-pulse"></span>
                        <span class="text-xs font-mono font-black uppercase text-indigo-700 tracking-wider">Pre-Watched Context (Low Affective Filter)</span>
                    </div>
                    <p id="modal-video-desc" class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic JSON Fetch & Render Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let movies = [];
            let activeFilter = 'All';

            const grid = document.getElementById('catalog-grid');
            const searchInput = document.getElementById('catalog-search');
            const countLabel = document.getElementById('catalog-count-label');
            const modal = document.getElementById('catalog-modal');
            const modalIframe = document.getElementById('modal-iframe');
            const modalTitle = document.getElementById('modal-video-title');
            const modalLevel = document.getElementById('modal-level-badge');
            const modalDesc = document.getElementById('modal-video-desc');
            const closeModalBtn = document.getElementById('close-catalog-modal');

            // Fetch movies.json
            fetch('/data/movies.json')
                .then(res => res.json())
                .then(data => {
                    movies = data;
                    renderCatalog(movies);
                })
                .catch(err => {
                    console.error('Error loading movies.json:', err);
                    grid.innerHTML = `<div class="col-span-full text-center text-rose-600 font-bold py-12">Failed to load movies data. Please refresh.</div>`;
                });

            function renderCatalog(items) {
                countLabel.textContent = `Showing ${items.length} of ${movies.length} animated shorts`;

                if (!items || items.length === 0) {
                    grid.innerHTML = `
                        <div class="col-span-full text-center py-16 px-6 glass-panel rounded-3xl space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto text-xl font-bold">🔍</div>
                            <h4 class="font-heading text-lg font-black text-slate-900">No Animated Shorts Found</h4>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto">Try clearing your search term or selecting another Krashen i+1 proficiency level.</p>
                        </div>
                    `;
                    return;
                }

                grid.innerHTML = items.map(movie => `
                    <article class="glass-panel rounded-3xl overflow-hidden card-interactive flex flex-col justify-between group">
                        
                        <!-- Thumbnail Header -->
                        <div class="relative aspect-video bg-slate-950 overflow-hidden cursor-pointer play-trigger" data-id="${movie.id}">
                            <img src="${movie.url_thumbnail}" alt="${movie.titulo}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 ease-out" />
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-80 group-hover:opacity-60 transition-opacity"></div>
                            
                            <!-- Level Badge Top Left -->
                            <span class="absolute top-3.5 left-3.5 px-3 py-1 rounded-xl text-xs font-mono font-extrabold shadow-sm backdrop-blur-md ${getLevelBadge(movie.nivel_i_mas_uno)}">
                                ${movie.nivel_i_mas_uno} i+1
                            </span>
                            
                            <!-- Duration Badge Top Right -->
                            <span class="absolute top-3.5 right-3.5 px-2.5 py-1 rounded-xl text-[11px] font-extrabold bg-slate-900/90 text-slate-200 border border-slate-700/80 shadow-sm font-mono backdrop-blur-md">
                                ⏱️ ${movie.duracion_minutos}m
                            </span>

                            <!-- Centered Play Button Micro-interaction -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-13 h-13 rounded-2xl bg-indigo-600/95 text-white flex items-center justify-center shadow-xl shadow-indigo-600/40 group-hover:scale-115 group-hover:bg-indigo-500 transition-all duration-300 backdrop-blur-xs">
                                    <svg class="w-6 h-6 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-3">
                                <h3 class="font-heading text-lg font-black text-slate-900 group-hover:text-indigo-600 transition-colors leading-snug">
                                    ${movie.titulo}
                                </h3>

                                <div class="p-3.5 bg-slate-50/80 border-l-4 border-indigo-500 rounded-r-2xl border-t border-r border-b border-slate-200/70 text-xs text-slate-700 leading-relaxed font-medium">
                                    <span class="font-mono font-black text-indigo-700 uppercase tracking-wider block text-[10px] mb-1">Visual Context Clue:</span>
                                    ${movie.descripcion_contexto}
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                                <div class="flex flex-wrap gap-1">
                                    ${(movie.tags || []).map(t => `<span class="text-[10px] bg-slate-100 text-slate-600 font-extrabold px-2 py-0.5 rounded-lg border border-slate-200 font-mono">${t}</span>`).join('')}
                                </div>
                                <button class="play-trigger text-xs font-black text-indigo-600 hover:text-indigo-800 flex items-center gap-1.5 group-hover:translate-x-1 transition-all" data-id="${movie.id}">
                                    <span>Watch</span>
                                    <span class="text-sm">▶</span>
                                </button>
                            </div>
                        </div>

                    </article>
                `).join('');

                document.querySelectorAll('.play-trigger').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = parseInt(btn.getAttribute('data-id'), 10);
                        const movie = movies.find(m => m.id === id);
                        if (movie) openModal(movie);
                    });
                });
            }

            function getLevelBadge(level) {
                if (level === 'Beginner') return 'bg-emerald-500/90 text-white border border-emerald-400';
                if (level === 'Intermediate') return 'bg-amber-500/90 text-white border border-amber-400';
                return 'bg-rose-500/90 text-white border border-rose-400';
            }

            function filterMovies() {
                const query = searchInput.value.toLowerCase().trim();
                const filtered = movies.filter(m => {
                    const matchesLevel = activeFilter === 'All' || m.nivel_i_mas_uno === activeFilter;
                    const matchesQuery = !query 
                        || m.titulo.toLowerCase().includes(query) 
                        || m.descripcion_contexto.toLowerCase().includes(query)
                        || (m.tags && m.tags.some(t => t.toLowerCase().includes(query)));
                    return matchesLevel && matchesQuery;
                });
                renderCatalog(filtered);
            }

            document.querySelectorAll('.level-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    document.querySelectorAll('.level-btn').forEach(b => {
                        b.className = 'level-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-slate-900 hover:bg-white transition-all';
                    });
                    e.target.className = 'level-btn px-4 py-2 rounded-xl text-xs font-extrabold bg-indigo-600 text-white shadow-md shadow-indigo-600/30 transition-all';
                    activeFilter = e.target.getAttribute('data-level');
                    filterMovies();
                });
            });

            searchInput?.addEventListener('input', filterMovies);

            function openModal(movie) {
                modalTitle.textContent = movie.titulo;
                modalLevel.textContent = `${movie.nivel_i_mas_uno} i+1`;
                modalDesc.textContent = movie.descripcion_contexto;
                modalIframe.src = `${movie.url_video_embed}?autoplay=1&enablejsapi=1`;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modalIframe.src = '';
            }

            closeModalBtn?.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
