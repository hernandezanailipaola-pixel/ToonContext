/**
 * ToonInput - Application Logic
 * Krashen's Comprehensible Input Theory Web App
 * 100% Static Architecture (Vanilla JS ES6)
 */

document.addEventListener('DOMContentLoaded', () => {
    // State management
    let allVideos = [];
    let currentFilter = 'Todos';
    let watchedVideoIds = getWatchedVideos();

    // DOM Elements
    const videoGrid = document.getElementById('video-grid');
    const filterContainer = document.getElementById('filter-container');
    const searchInput = document.getElementById('search-input');
    const statsWatchedCount = document.getElementById('stats-watched');
    const statsTotalCount = document.getElementById('stats-total');
    const progressBarInner = document.getElementById('progress-bar-inner');
    const ruletaBtn = document.getElementById('ruleta-btn');
    const theoryBtn = document.getElementById('theory-btn');

    // Video Modal Elements
    const videoModal = document.getElementById('video-modal');
    const videoIframe = document.getElementById('video-iframe');
    const modalTitle = document.getElementById('modal-title');
    const modalLevel = document.getElementById('modal-level');
    const modalContext = document.getElementById('modal-context');
    const modalTags = document.getElementById('modal-tags');
    const modalWatchedToggle = document.getElementById('modal-watched-toggle');
    const closeVideoModalBtn = document.getElementById('close-video-modal');

    // Theory Modal Elements
    const theoryModal = document.getElementById('theory-modal');
    const closeTheoryModalBtn = document.getElementById('close-theory-modal');

    // Initialize application
    init();

    async function init() {
        setupEventListeners();
        await loadVideoData();
        updateProgressUI();
    }

    // Fetch data from datos.json
    async function loadVideoData() {
        try {
            showLoadingState();
            const response = await fetch('./datos.json');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            allVideos = await response.json();
            renderFilterButtons();
            renderVideos(allVideos);
            updateProgressUI();
        } catch (error) {
            console.error('Error al cargar datos.json:', error);
            showErrorState('No se pudieron cargar los cortometrajes. Verifica que el archivo datos.json exista.');
        }
    }

    // Render loading indicator
    function showLoadingState() {
        if (!videoGrid) return;
        videoGrid.innerHTML = `
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-slate-400">
                <div class="w-12 h-12 border-4 border-amber-500 border-t-transparent rounded-full animate-spin mb-4"></div>
                <p class="text-sm font-medium">Cargando dosis de Input Comprensible...</p>
            </div>
        `;
    }

    // Render error message
    function showErrorState(message) {
        if (!videoGrid) return;
        videoGrid.innerHTML = `
            <div class="col-span-full bg-rose-950/40 border border-rose-800/60 rounded-2xl p-8 text-center max-w-xl mx-auto my-10">
                <div class="w-12 h-12 bg-rose-900/50 rounded-full flex items-center justify-center mx-auto mb-3 text-rose-400 text-xl font-bold">!</div>
                <h3 class="text-lg font-bold text-rose-200 mb-2">Error de Carga</h3>
                <p class="text-sm text-rose-300/80 mb-4">${message}</p>
                <button id="retry-btn" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white font-medium rounded-lg transition text-xs">
                    Reintentar
                </button>
            </div>
        `;
        document.getElementById('retry-btn')?.addEventListener('click', loadVideoData);
    }

    // Render level filter buttons dynamically
    function renderFilterButtons() {
        if (!filterContainer) return;
        const levels = ['Todos', 'Principiante', 'Intermedio', 'Avanzado'];
        filterContainer.innerHTML = levels.map(level => {
            const isActive = level === currentFilter;
            const activeClasses = isActive
                ? 'bg-gradient-to-r from-red-600 to-amber-600 text-white shadow-lg shadow-amber-900/30 font-semibold ring-1 ring-amber-400/50 scale-105'
                : 'bg-slate-800/70 text-slate-300 hover:bg-slate-700/80 hover:text-white border border-slate-700/60';
            
            return `
                <button 
                    data-level="${level}" 
                    class="filter-btn transition-all duration-300 px-4 py-1.5 rounded-full text-xs font-medium focus:outline-none ${activeClasses}">
                    ${level}
                </button>
            `;
        }).join('');

        // Attach click handlers to filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const selectedLevel = e.target.getAttribute('data-level');
                currentFilter = selectedLevel;
                renderFilterButtons();
                filterAndRender();
            });
        });
    }

    // Filter videos according to level filter and search query
    function filterAndRender() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        
        const filtered = allVideos.filter(video => {
            const matchesLevel = currentFilter === 'Todos' || video.nivel_i_mas_uno.toLowerCase() === currentFilter.toLowerCase();
            const matchesSearch = !query || 
                video.titulo.toLowerCase().includes(query) || 
                video.descripcion_contexto.toLowerCase().includes(query) ||
                (video.tags && video.tags.some(tag => tag.toLowerCase().includes(query)));
            
            return matchesLevel && matchesSearch;
        });

        renderVideos(filtered);
    }

    // Render video cards grid
    function renderVideos(videos) {
        if (!videoGrid) return;
        if (videos.length === 0) {
            videoGrid.innerHTML = `
                <div class="col-span-full text-center py-16 px-4 bg-slate-900/40 border border-slate-800 rounded-2xl">
                    <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <p class="text-slate-300 font-semibold text-base mb-1">No se encontraron cortometrajes</p>
                    <p class="text-slate-500 text-xs">Prueba seleccionando otro nivel o cambiando tu búsqueda.</p>
                </div>
            `;
            return;
        }

        videoGrid.innerHTML = videos.map(video => createVideoCardHTML(video)).join('');

        // Attach event listeners for card elements
        document.querySelectorAll('.play-trigger').forEach(trigger => {
            trigger.addEventListener('click', () => {
                const id = parseInt(trigger.getAttribute('data-id'), 10);
                openVideoModal(id);
            });
        });

        document.querySelectorAll('.toggle-watched-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(btn.getAttribute('data-id'), 10);
                toggleWatchedState(id);
            });
        });
    }

    // Generate HTML for a single card
    function createVideoCardHTML(video) {
        const isWatched = watchedVideoIds.includes(video.id);
        const levelBadgeColor = getLevelBadgeStyle(video.nivel_i_mas_uno);

        const tagsHTML = (video.tags || []).map(tag => `
            <span class="text-[10px] bg-slate-800/90 text-sky-300/90 border border-sky-500/20 px-2 py-0.5 rounded-md font-mono">${tag}</span>
        `).join('');

        return `
            <article class="group relative bg-slate-900/80 border ${isWatched ? 'border-emerald-500/40 bg-slate-900/90' : 'border-slate-800/80'} hover:border-amber-500/50 rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-amber-500/10 flex flex-col justify-between">
                
                <!-- Thumbnail & Badges Container -->
                <div class="relative aspect-video w-full overflow-hidden bg-slate-950 play-trigger cursor-pointer" data-id="${video.id}">
                    <img 
                        src="${video.url_thumbnail}" 
                        alt="${video.titulo}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                        onerror="this.src='https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=800&q=80'"
                    />
                    
                    <!-- Dark Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent opacity-70 group-hover:opacity-50 transition-opacity"></div>
                    
                    <!-- Top Badge: Level -->
                    <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold tracking-wide backdrop-blur-md shadow-md ${levelBadgeColor}">
                        ${video.nivel_i_mas_uno}
                    </span>

                    <!-- Top Badge: Duration -->
                    <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-950/80 border border-slate-700/60 text-amber-400 backdrop-blur-md shadow-md flex items-center gap-1">
                        <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        ${video.duracion || '5 mins'}
                    </span>

                    <!-- Watched Badge Indicator -->
                    ${isWatched ? `
                        <span class="absolute top-3 left-28 px-2 py-1 rounded-full text-[10px] font-bold bg-emerald-500/90 text-white backdrop-blur-md shadow-md flex items-center gap-1">
                            ✓ Visto
                        </span>
                    ` : ''}

                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 group-hover:shadow-amber-500/50 transition-all duration-300">
                            <svg class="w-7 h-7 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="text-lg font-bold text-slate-100 group-hover:text-amber-300 transition-colors leading-snug">
                                ${video.titulo}
                            </h3>
                            <button 
                                class="toggle-watched-btn p-1.5 rounded-lg border ${isWatched ? 'border-emerald-500/50 bg-emerald-500/20 text-emerald-400' : 'border-slate-800 text-slate-500 hover:text-slate-300 hover:bg-slate-800'} transition-all" 
                                data-id="${video.id}"
                                title="${isWatched ? 'Marcar como no visto' : 'Marcar como visto'}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Context Description (Krashen Affective Filter) -->
                        <div class="bg-slate-950/70 border border-slate-800/80 rounded-xl p-3.5 my-3 text-xs leading-relaxed text-slate-300">
                            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-amber-400 mb-1">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Contexto Previsto (Filtro Afectivo)
                            </div>
                            <p class="text-slate-300/90 leading-relaxed font-sans">
                                ${video.descripcion_contexto}
                            </p>
                        </div>
                    </div>

                    <div>
                        <!-- Tags list -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            ${tagsHTML}
                        </div>

                        <!-- Action Button -->
                        <button 
                            data-id="${video.id}" 
                            class="play-trigger w-full py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-gradient-to-r hover:from-amber-600 hover:to-rose-600 text-slate-200 hover:text-white font-medium text-xs tracking-wide transition-all duration-300 flex items-center justify-between border border-slate-700/60 hover:border-amber-400/50 shadow-md">
                            <span>Ver Inmersión</span>
                            <span class="text-amber-400 group-hover:text-white group-hover:translate-x-1 transition-transform">→</span>
                        </button>
                    </div>
                </div>
            </article>
        `;
    }

    // Level badge color utility
    function getLevelBadgeStyle(level) {
        switch (level.toLowerCase()) {
            case 'principiante':
                return 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40';
            case 'intermedio':
                return 'bg-amber-500/20 text-amber-300 border border-amber-500/40';
            case 'avanzado':
                return 'bg-rose-500/20 text-rose-300 border border-rose-500/40';
            default:
                return 'bg-sky-500/20 text-sky-300 border border-sky-500/40';
        }
    }

    // Video Modal Handlers
    function openVideoModal(id) {
        const video = allVideos.find(v => v.id === id);
        if (!video || !videoModal) return;

        if (modalTitle) modalTitle.textContent = video.titulo;
        if (modalLevel) {
            modalLevel.textContent = video.nivel_i_mas_uno;
            modalLevel.className = `px-3 py-1 rounded-full text-xs font-bold ${getLevelBadgeStyle(video.nivel_i_mas_uno)}`;
        }
        if (modalContext) modalContext.textContent = video.descripcion_contexto;

        if (modalTags) {
            modalTags.innerHTML = (video.tags || []).map(tag => `
                <span class="text-xs bg-slate-800 text-amber-300 border border-slate-700 px-2.5 py-1 rounded-md font-mono">${tag}</span>
            `).join('');
        }

        // Set video embed URL with autoplay
        if (videoIframe) videoIframe.src = `${video.url_video_embed}?autoplay=1&rel=0`;

        // Update modal watched toggle button state
        const isWatched = watchedVideoIds.includes(video.id);
        updateModalWatchedButton(video.id, isWatched);

        if (modalWatchedToggle) {
            modalWatchedToggle.onclick = () => {
                const newState = toggleWatchedState(video.id);
                updateModalWatchedButton(video.id, newState);
            };
        }

        // Show modal with animation
        videoModal.classList.remove('hidden');
        videoModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function updateModalWatchedButton(id, isWatched) {
        if (!modalWatchedToggle) return;
        if (isWatched) {
            modalWatchedToggle.className = 'px-3.5 py-2 bg-emerald-600/30 border border-emerald-500/50 text-emerald-300 rounded-xl text-xs font-semibold hover:bg-emerald-600/40 transition flex items-center gap-1.5';
            modalWatchedToggle.innerHTML = '✓ Marcado como Visto';
        } else {
            modalWatchedToggle.className = 'px-3.5 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-700 transition flex items-center gap-1.5';
            modalWatchedToggle.innerHTML = '+ Marcar como Visto';
        }
    }

    function closeVideoModal() {
        if (!videoModal) return;
        videoModal.classList.add('hidden');
        videoModal.classList.remove('flex');
        if (videoIframe) videoIframe.src = ''; // Stop video playback
        document.body.style.overflow = '';
    }

    // Theory Modal Handlers
    function openTheoryModal() {
        if (!theoryModal) return;
        theoryModal.classList.remove('hidden');
        theoryModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeTheoryModal() {
        if (!theoryModal) return;
        theoryModal.classList.add('hidden');
        theoryModal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // LocalStorage helper functions
    function getWatchedVideos() {
        try {
            const stored = localStorage.getItem('tooninput_watched_videos');
            return stored ? JSON.parse(stored) : [];
        } catch (e) {
            return [];
        }
    }

    function toggleWatchedState(id) {
        if (watchedVideoIds.includes(id)) {
            watchedVideoIds = watchedVideoIds.filter(vId => vId !== id);
        } else {
            watchedVideoIds.push(id);
        }
        try {
            localStorage.setItem('tooninput_watched_videos', JSON.stringify(watchedVideoIds));
        } catch (e) {
            console.error('LocalStorage save error:', e);
        }

        updateProgressUI();
        filterAndRender(); // Re-render grid to update badges
        return watchedVideoIds.includes(id);
    }

    function updateProgressUI() {
        const total = allVideos.length;
        const watchedCount = watchedVideoIds.length;
        const percentage = total > 0 ? Math.round((watchedCount / total) * 100) : 0;

        if (statsWatchedCount) statsWatchedCount.textContent = watchedCount;
        if (statsTotalCount) statsTotalCount.textContent = total;
        if (progressBarInner) progressBarInner.style.width = `${percentage}%`;
    }

    // Ruleta del Input (Idea #3 from user request: Random video selector)
    function triggerInputRoulette() {
        if (allVideos.length === 0) return;

        if (ruletaBtn) {
            ruletaBtn.classList.add('animate-bounce');
            setTimeout(() => ruletaBtn.classList.remove('animate-bounce'), 800);
        }

        const randomIndex = Math.floor(Math.random() * allVideos.length);
        const selectedVideo = allVideos[randomIndex];
        openVideoModal(selectedVideo.id);
    }

    // Setup global event listeners
    function setupEventListeners() {
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                filterAndRender();
            });
        }

        closeVideoModalBtn?.addEventListener('click', closeVideoModal);
        closeTheoryModalBtn?.addEventListener('click', closeTheoryModal);

        videoModal?.addEventListener('click', (e) => {
            if (e.target === videoModal) closeVideoModal();
        });
        theoryModal?.addEventListener('click', (e) => {
            if (e.target === theoryModal) closeTheoryModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeVideoModal();
                closeTheoryModal();
            }
        });

        theoryBtn?.addEventListener('click', openTheoryModal);
        ruletaBtn?.addEventListener('click', triggerInputRoulette);
    }
});
