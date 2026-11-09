/**
 * ToonInput 2.0 - Hyper-Modern Comprehensible Input Platform
 * Architecture: 100% Client-Side SPA (ES6 Vanilla JS)
 * Features: Weekly Dynamic Curriculum, Daily Phrase Engine, Embed Resilience & Custom Content Studio
 * Authors: Ing. Anaili Hernandez, Miliangel Morillo, Mauricio Guevara, Ana Urrutia, Isamar Rodriguez
 */

// Global State
const STATE = {
  activeTab: 'catalog',
  movies: [],
  customMovies: [],
  series: [],
  podcasts: [],
  minigames: {},
  weeklyPacks: [],
  dailyPhrases: [],
  activePackIndex: 0,
  currentDailyPhrase: null,
  currentFilter: 'All',
  searchQuery: '',
  theme: localStorage.getItem('toon_theme') || 'light',
  currentModalMovie: null,
  tracker: {
    totalMinutes: 0,
    watchedIds: [],
    streakDays: 1,
    lastActiveDate: new Date().toISOString().split('T')[0]
  },
  // Mini-Games
  matchGame: {
    cards: [],
    selectedFirst: null,
    selectedSecond: null,
    matchedCount: 0,
    totalPairs: 6,
    score: 0,
    streak: 0
  },
  clozeIndex: 0,
  scrambleIndex: 0,
  scrambleCurrentTokens: [],
  idiomIndex: 0,
  audioIndex: 0
};

// Web Audio API Synthesizer (Zero External Audio Dependencies)
class SoundFX {
  static init() {
    if (!this.ctx) {
      const AudioCtx = window.AudioContext || window.webkitAudioContext;
      if (AudioCtx) this.ctx = new AudioCtx();
    }
  }

  static playCorrect() {
    try {
      this.init();
      if (!this.ctx) return;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'sine';
      osc.frequency.setValueAtTime(523.25, this.ctx.currentTime); // C5
      osc.frequency.exponentialRampToValueAtTime(659.25, this.ctx.currentTime + 0.12); // E5
      osc.frequency.exponentialRampToValueAtTime(783.99, this.ctx.currentTime + 0.25); // G5
      gain.gain.setValueAtTime(0.18, this.ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.4);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start();
      osc.stop(this.ctx.currentTime + 0.4);
    } catch (e) {}
  }

  static playWrong() {
    try {
      this.init();
      if (!this.ctx) return;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'sawtooth';
      osc.frequency.setValueAtTime(240, this.ctx.currentTime);
      osc.frequency.setValueAtTime(180, this.ctx.currentTime + 0.15);
      gain.gain.setValueAtTime(0.12, this.ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.3);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start();
      osc.stop(this.ctx.currentTime + 0.3);
    } catch (e) {}
  }

  static playChime() {
    try {
      this.init();
      if (!this.ctx) return;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(880, this.ctx.currentTime);
      gain.gain.setValueAtTime(0.15, this.ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.2);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start();
      osc.stop(this.ctx.currentTime + 0.2);
    } catch (e) {}
  }
}

// Native Web Speech API Pronunciation
function speakEnglish(text, rate = 0.9) {
  if (!('speechSynthesis' in window)) {
    showToast('Tu navegador no soporta síntesis de voz nativa');
    return;
  }
  window.speechSynthesis.cancel();
  const utterance = new SpeechSynthesisUtterance(text);
  utterance.lang = 'en-US';
  utterance.rate = rate;

  const voices = window.speechSynthesis.getVoices();
  const naturalVoice = voices.find(v => (v.lang === 'en-US' || v.lang === 'en-GB') && v.name.includes('Natural')) ||
                       voices.find(v => v.lang === 'en-US') ||
                       voices.find(v => v.lang.startsWith('en'));
  if (naturalVoice) utterance.voice = naturalVoice;

  window.speechSynthesis.speak(utterance);
}

// Confetti Helper
function triggerConfetti() {
  if (typeof confetti === 'function') {
    confetti({
      particleCount: 70,
      spread: 60,
      origin: { y: 0.65 }
    });
  }
}

// Initialization on DOMContentLoaded
document.addEventListener('DOMContentLoaded', async () => {
  applyTheme(STATE.theme);
  loadTrackerFromStorage();
  loadCustomMoviesFromStorage();
  setupRouting();
  await loadAllDatasets();
  initWeeklyCurriculum();
  initDailyPhrase();
  initEventListeners();
  renderApp();
  startWeeklyCountdown();
});

// Load All Datasets
async function loadAllDatasets() {
  try {
    const [resMovies, resSeries, resPodcasts, resGames, resPacks] = await Promise.all([
      fetch('./data/movies.json').catch(() => fetch('./datos.json')),
      fetch('./data/series.json').catch(() => ({ json: () => [] })),
      fetch('./data/podcasts.json').catch(() => ({ json: () => [] })),
      fetch('./data/minigames.json').catch(() => ({ json: () => ({}) })),
      fetch('./data/weekly_packs.json').catch(() => ({ json: () => ({ packs: [], daily_phrases_bank: [] }) }))
    ]);

    const baseMovies = await resMovies.json();
    STATE.movies = [...baseMovies, ...STATE.customMovies];
    STATE.series = await resSeries.json();
    STATE.podcasts = await resPodcasts.json();
    STATE.minigames = await resGames.json();

    const packsData = await resPacks.json();
    STATE.weeklyPacks = packsData.packs || [];
    STATE.dailyPhrases = packsData.daily_phrases_bank || [];
  } catch (err) {
    console.warn('Dataset load note:', err);
  }
}

// Theme Switcher
function applyTheme(theme) {
  STATE.theme = theme;
  document.documentElement.setAttribute('data-theme', theme);
  localStorage.setItem('toon_theme', theme);
  const icon = document.getElementById('theme-toggle-icon');
  if (icon) {
    icon.innerHTML = theme === 'dark' ? '☀️' : '🌙';
  }
}

function toggleTheme() {
  const newTheme = STATE.theme === 'dark' ? 'light' : 'dark';
  applyTheme(newTheme);
  SoundFX.playChime();
}

// LocalStorage Tracker
function loadTrackerFromStorage() {
  try {
    const raw = localStorage.getItem('tooninput_tracker_v2');
    if (raw) {
      STATE.tracker = Object.assign(STATE.tracker, JSON.parse(raw));
    }
    const today = new Date().toISOString().split('T')[0];
    if (STATE.tracker.lastActiveDate !== today) {
      const yesterday = new Date(Date.now() - 86400000).toISOString().split('T')[0];
      if (STATE.tracker.lastActiveDate === yesterday) {
        STATE.tracker.streakDays += 1;
      } else {
        STATE.tracker.streakDays = 1;
      }
      STATE.tracker.lastActiveDate = today;
      saveTrackerToStorage();
    }
  } catch (e) {}
}

function saveTrackerToStorage() {
  try {
    localStorage.setItem('tooninput_tracker_v2', JSON.stringify(STATE.tracker));
    updateTrackerUI();
  } catch (e) {}
}

function logImmersionMinutes(mins, reason = 'Video Short') {
  STATE.tracker.totalMinutes += mins;
  saveTrackerToStorage();
  SoundFX.playCorrect();
  triggerConfetti();
  showToast(`🎉 +${mins} mins logged to your Immersion Journal! (${reason})`);
}

// Custom User Content (Studio)
function loadCustomMoviesFromStorage() {
  try {
    const raw = localStorage.getItem('toon_custom_movies');
    if (raw) {
      STATE.customMovies = JSON.parse(raw);
    }
  } catch (e) {}
}

function saveCustomMovie(movieObj) {
  STATE.customMovies.unshift(movieObj);
  localStorage.setItem('toon_custom_movies', JSON.stringify(STATE.customMovies));
  STATE.movies.unshift(movieObj);
  renderCatalog();
  SoundFX.playCorrect();
  triggerConfetti();
  showToast(`✨ ¡Video "${movieObj.title}" agregado con éxito a tu catálogo!`);
}

// SPA Routing Controller
function setupRouting() {
  const handleRoute = () => {
    const hash = window.location.hash.replace('#', '') || 'catalog';
    switchTab(hash);
  };
  window.addEventListener('hashchange', handleRoute);
  handleRoute();
}

function switchTab(tabId) {
  STATE.activeTab = tabId;

  document.querySelectorAll('[data-nav-tab]').forEach(el => {
    const isTarget = el.getAttribute('data-nav-tab') === tabId;
    if (isTarget) {
      el.classList.add('bg-indigo-600', 'text-white', 'shadow-md', 'shadow-indigo-600/30');
      el.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/80');
    } else {
      el.classList.remove('bg-indigo-600', 'text-white', 'shadow-md', 'shadow-indigo-600/30');
      el.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-white/80');
    }
  });

  document.querySelectorAll('.view-section').forEach(sec => {
    if (sec.id === `view-${tabId}`) {
      sec.classList.remove('hidden');
    } else {
      sec.classList.add('hidden');
    }
  });

  if (tabId === 'catalog') renderCatalog();
  if (tabId === 'minigames') initMiniGamesHub();
  if (tabId === 'series') renderSeriesHub();
  if (tabId === 'podcasts') renderPodcastsHub();
  if (tabId === 'tracker') renderTrackerView();
  if (tabId === 'roulette') initRouletteView();

  window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ==========================================================================
   DYNAMIC WEEKLY CURRICULUM ENGINE
   Calculates current week of the year and serves fresh weekly content
   ========================================================================== */
function getWeekNumber(d = new Date()) {
  const target = new Date(d.valueOf());
  const dayNr = (d.getDay() + 6) % 7;
  target.setDate(target.getDate() - dayNr + 3);
  const firstThursday = target.valueOf();
  target.setMonth(0, 1);
  if (target.getDay() !== 4) {
    target.setMonth(0, 1 + ((4 - target.getDay()) + 7) % 7);
  }
  return 1 + Math.ceil((firstThursday - target) / 604800000);
}

function initWeeklyCurriculum() {
  if (STATE.weeklyPacks.length === 0) return;
  const currentWeek = getWeekNumber();
  STATE.activePackIndex = (currentWeek - 1) % STATE.weeklyPacks.length;
  renderWeeklySpotlight();
}

function cycleWeeklyPack() {
  if (STATE.weeklyPacks.length === 0) return;
  STATE.activePackIndex = (STATE.activePackIndex + 1) % STATE.weeklyPacks.length;
  renderWeeklySpotlight();
  SoundFX.playChime();
  showToast(`🌟 Explorando Pack Semanal #${STATE.activePackIndex + 1}`);
}

function renderWeeklySpotlight() {
  const container = document.getElementById('weekly-spotlight-container');
  if (!container || STATE.weeklyPacks.length === 0) return;

  const pack = STATE.weeklyPacks[STATE.activePackIndex];
  const featuredMovie = STATE.movies.find(m => m.id === pack.featured_movie_id) || STATE.movies[0];

  container.innerHTML = `
    <div class="weekly-spotlight-card p-6 sm:p-8 space-y-6">
      
      <!-- Card Top Ribbon -->
      <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
          <span class="px-3.5 py-1 rounded-full weekly-badge-glow text-xs font-mono font-black flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
            <span>Pack Semanal #${STATE.activePackIndex + 1}: ${pack.theme}</span>
          </span>
          <span class="text-xs font-mono text-slate-500 font-bold hidden sm:inline">Renovación automática cada lunes</span>
        </div>

        <div class="flex items-center gap-2">
          <button onclick="cycleWeeklyPack()" class="px-3 py-1 rounded-xl bg-white/90 hover:bg-white text-indigo-700 text-xs font-bold border border-indigo-200 shadow-2xs transition flex items-center gap-1">
            <span>🎲 Explorar Siguiente Semana</span>
          </button>
        </div>
      </div>

      <!-- Main Layout: Featured Short + 5 Weekly Phrases -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
        
        <!-- Left: Featured Short Card -->
        <div class="lg:col-span-5 space-y-3">
          <span class="text-[11px] font-mono font-bold text-slate-500 uppercase tracking-wider block">Cortometraje Destacado de la Semana:</span>
          
          <div class="p-4 rounded-2xl bg-white/90 border border-indigo-200/80 shadow-sm space-y-3 group cursor-pointer hover:border-indigo-400 transition" onclick="openVideoModal(${featuredMovie.id})">
            <div class="relative h-44 rounded-xl overflow-hidden bg-slate-900">
              <img src="${featuredMovie.thumbnail}" alt="${featuredMovie.title}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                  ▶
                </div>
              </div>
              <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded-lg bg-black/60 text-white font-mono text-[10px] font-bold">⏱️ ${featuredMovie.duration}</span>
              <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded-lg bg-indigo-600 text-white font-mono text-[10px] font-black">${featuredMovie.cefr || 'A2'}</span>
            </div>
            <div>
              <h4 class="font-heading font-black text-base text-slate-900 leading-snug group-hover:text-indigo-600 transition">${featuredMovie.title}</h4>
              <p class="text-xs text-slate-600 line-clamp-2 mt-1">${featuredMovie.description}</p>
            </div>
          </div>
        </div>

        <!-- Right: 5 Weekly Spoken Phrases -->
        <div class="lg:col-span-7 space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-[11px] font-mono font-bold text-slate-500 uppercase tracking-wider">5 Frases &amp; Modismos Clave de Esta Semana:</span>
            <span class="text-[10px] text-indigo-600 font-bold">Click 🔊 para escuchar</span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            ${pack.phrases.map(p => `
              <div class="p-3 rounded-2xl bg-white/90 border border-slate-200 hover:border-indigo-300 transition flex items-start justify-between gap-2 shadow-2xs">
                <div class="space-y-1">
                  <div class="flex items-center gap-1.5">
                    <span>${p.icon}</span>
                    <strong class="font-heading font-black text-xs text-slate-900">${p.phrase}</strong>
                  </div>
                  <span class="text-[10px] font-mono text-slate-400 block">${p.phonetic}</span>
                  <p class="text-[11px] text-slate-600 leading-tight font-medium">${p.meaning_es}</p>
                </div>
                <button 
                  onclick="speakEnglish('${p.phrase.replace(/'/g, "\\'")}')" 
                  class="w-7 h-7 rounded-xl bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white flex items-center justify-center transition shrink-0" 
                  title="Escuchar pronunciación nativa">
                  🔊
                </button>
              </div>
            `).join('')}
          </div>

          <!-- Weekly Challenge Bar -->
          <div class="p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-200/90 flex items-center justify-between gap-3 text-xs">
            <div>
              <strong class="text-emerald-900">🎯 Reto Semanal:</strong>
              <span class="text-emerald-800 ml-1 font-medium">${pack.challenge_desc}</span>
            </div>
            <button onclick="logImmersionMinutes(packTarget = ${pack.target_minutes}, '${pack.theme}')" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold shrink-0 transition shadow-xs">
              Completar Reto (+${pack.target_minutes}m)
            </button>
          </div>

        </div>

      </div>

    </div>
  `;
}

function startWeeklyCountdown() {
  const timerEl = document.getElementById('weekly-countdown-label');
  if (!timerEl) return;

  function update() {
    const now = new Date();
    const day = now.getDay(); // 0 is Sunday, 1 is Monday
    const daysUntilMonday = (8 - day) % 7 || 7;
    const nextMonday = new Date(now.getFullYear(), now.getMonth(), now.getDate() + daysUntilMonday, 0, 0, 0);
    const diff = nextMonday - now;

    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
    const h = Math.floor((diff / (1000 * 60 * 60)) % 24);
    const m = Math.floor((diff / (1000 * 60)) % 60);

    timerEl.textContent = `Próximo pack en ${d}d ${h}h ${m}m`;
  }
  update();
  setInterval(update, 60000);
}

/* ==========================================================================
   DAILY PHRASE GENERATOR
   ========================================================================== */
function initDailyPhrase() {
  if (STATE.dailyPhrases.length === 0) return;
  const dayOfYear = Math.floor((new Date() - new Date(new Date().getFullYear(), 0, 0)) / 86400000);
  STATE.currentDailyPhrase = STATE.dailyPhrases[dayOfYear % STATE.dailyPhrases.length];
  renderDailyPhraseWidget();
}

function generateRandomDailyPhrase() {
  if (STATE.dailyPhrases.length === 0) return;
  const rand = STATE.dailyPhrases[Math.floor(Math.random() * STATE.dailyPhrases.length)];
  STATE.currentDailyPhrase = rand;
  renderDailyPhraseWidget();
  SoundFX.playChime();
  speakEnglish(rand.phrase);
}

function renderDailyPhraseWidget() {
  const container = document.getElementById('daily-phrase-widget');
  if (!container || !STATE.currentDailyPhrase) return;

  const p = STATE.currentDailyPhrase;
  container.innerHTML = `
    <div class="glass-panel p-5 rounded-3xl space-y-3 relative overflow-hidden">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
          <span class="text-[11px] font-mono font-bold text-amber-600 uppercase tracking-wider">Frase del Día</span>
        </div>
        <button onclick="generateRandomDailyPhrase()" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
          <span>✨ Generar Otra</span>
        </button>
      </div>

      <div class="flex items-center justify-between gap-3">
        <div>
          <div class="flex items-center gap-2">
            <span class="text-2xl">${p.icon}</span>
            <h4 class="font-heading font-black text-xl text-slate-900 leading-tight">"${p.phrase}"</h4>
            <button onclick="speakEnglish('${p.phrase.replace(/'/g, "\\'")}')" class="w-8 h-8 rounded-xl bg-amber-100 hover:bg-amber-600 text-amber-800 hover:text-white flex items-center justify-center transition shadow-2xs" title="Escuchar pronunciación">
              🔊
            </button>
          </div>
          <span class="text-xs font-mono text-slate-400 font-bold block mt-0.5">${p.phonetic}</span>
        </div>
      </div>

      <p class="text-xs text-slate-600 font-medium">
        <strong>Significado:</strong> ${p.meaning_es} <span class="text-slate-400">(${p.meaning})</span>
      </p>
    </div>
  `;
}

/* ==========================================================================
   CUSTOM CONTENT STUDIO MODAL (AGREGAR CUALQUIER VIDEO)
   ========================================================================== */
function openAddVideoModal() {
  const modal = document.getElementById('custom-video-modal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
}

function closeAddVideoModal() {
  const modal = document.getElementById('custom-video-modal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
}

function handleAddVideoSubmit(e) {
  e.preventDefault();
  const urlInput = document.getElementById('custom-url-input');
  const titleInput = document.getElementById('custom-title-input');
  const levelSelect = document.getElementById('custom-level-select');
  const durationInput = document.getElementById('custom-duration-input');
  const descInput = document.getElementById('custom-desc-input');

  if (!urlInput || !titleInput) return;

  const url = urlInput.value.trim();
  // Extract YouTube ID
  let videoId = '';
  const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/);
  if (match && match[1]) {
    videoId = match[1];
  } else {
    alert('Por favor introduce un enlace de YouTube válido (ej. https://www.youtube.com/watch?v=07d2dXHYb94)');
    return;
  }

  const newMovie = {
    id: Date.now(),
    title: titleInput.value.trim() || 'Custom Added Video',
    title_es: titleInput.value.trim(),
    level: levelSelect ? levelSelect.value : 'Beginner',
    cefr: levelSelect ? levelSelect.value === 'Beginner' ? 'A1-A2' : levelSelect.value === 'Intermediate' ? 'B1' : 'B2-C1' : 'A2',
    duration: durationInput ? `${durationInput.value} mins` : '5 mins',
    duration_minutes: durationInput ? parseInt(durationInput.value) || 5 : 5,
    youtube_id: videoId,
    embed_url: `https://www.youtube-nocookie.com/embed/${videoId}?rel=0`,
    direct_youtube_url: `https://www.youtube.com/watch?v=${videoId}`,
    thumbnail: `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`,
    description: descInput ? descInput.value.trim() : 'Video agregado por la comunidad de ToonInput.',
    krashen_factor: 'Entrada comprensible añadida por el usuario para su inmersión personalizada.',
    tags: ['#CustomAdded', '#Comunidad', `#${levelSelect ? levelSelect.value : 'A2'}`],
    category: 'Custom Content',
    vocabulary: [
      {"word": "Input", "phonetic": "/ˈɪnpʊt/", "definition": "Language messages that a learner hears or reads.", "example": "This custom video adds high-value input."}
    ],
    quiz: [
      {
        "question": "¿Pudiste comprender el mensaje principal del video mediante el contexto?",
        "options": ["Sí, el contexto visual facilitó la comprensión", "Tuve que pausar varias veces", "Necesito revisarlo nuevamente"],
        "correctIndex": 0,
        "explanation": "¡Excelente! Cada minuto de inmersión construye tu adquisición subconsciente."
      }
    ]
  };

  saveCustomMovie(newMovie);
  closeAddVideoModal();
  e.target.reset();
}

/* ==========================================================================
   FEATURE 1: ANIMATED VIDEO CATALOG
   ========================================================================== */
function renderCatalog() {
  const grid = document.getElementById('catalog-grid');
  const countLabel = document.getElementById('catalog-count-label');
  if (!grid) return;

  const filtered = STATE.movies.filter(movie => {
    const matchesFilter = (STATE.currentFilter === 'All') || (movie.level === STATE.currentFilter);
    const matchesSearch = !STATE.searchQuery || 
      movie.title.toLowerCase().includes(STATE.searchQuery) ||
      (movie.title_es && movie.title_es.toLowerCase().includes(STATE.searchQuery)) ||
      movie.description.toLowerCase().includes(STATE.searchQuery) ||
      (movie.tags && movie.tags.some(t => t.toLowerCase().includes(STATE.searchQuery)));
    return matchesFilter && matchesSearch;
  });

  if (countLabel) {
    countLabel.textContent = `Mostrando ${filtered.length} de ${STATE.movies.length} Cortometrajes Activos`;
  }

  if (filtered.length === 0) {
    grid.innerHTML = `
      <div class="col-span-full py-16 text-center space-y-4">
        <div class="w-16 h-16 mx-auto rounded-3xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl font-bold">
          🔍
        </div>
        <h3 class="text-xl font-heading font-black text-slate-800">No hay cortometrajes que coincidan con la búsqueda</h3>
        <p class="text-xs text-slate-500 max-w-md mx-auto">Prueba limpiando los términos o agregando tu propio video con el botón '+ Agregar Video'.</p>
        <button onclick="clearCatalogFilters()" class="px-5 py-2.5 rounded-2xl bg-indigo-600 text-white text-xs font-bold shadow-md hover:bg-indigo-700 transition">
          Restablecer Filtros
        </button>
      </div>
    `;
    return;
  }

  grid.innerHTML = filtered.map(movie => {
    const isWatched = STATE.tracker.watchedIds.includes(movie.id);
    const levelBadgeClass = movie.level === 'Beginner' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' :
                            movie.level === 'Intermediate' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' :
                            'bg-purple-50 text-purple-700 border-purple-200';

    const mainVocab = movie.vocabulary && movie.vocabulary[0] ? movie.vocabulary[0].word : '';

    return `
      <div class="glass-panel rounded-3xl overflow-hidden card-interactive flex flex-col justify-between group relative">
        ${isWatched ? `
          <div class="absolute top-3 left-3 z-20 px-3 py-1 rounded-full bg-emerald-600/95 backdrop-blur-md text-white text-[11px] font-mono font-bold flex items-center gap-1.5 shadow-md">
            <span>✓</span>
            <span>Adquirido</span>
          </div>
        ` : ''}

        <!-- Media Thumbnail -->
        <div class="relative h-52 overflow-hidden bg-slate-900 cursor-pointer" onclick="openVideoModal(${movie.id})">
          <img 
            src="${movie.thumbnail}" 
            alt="${movie.title}" 
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
            loading="lazy"
            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=600&q=80';"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-transparent to-transparent"></div>
          
          <!-- Play Overlay Icon -->
          <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600/95 text-white flex items-center justify-center shadow-2xl scale-75 group-hover:scale-100 transition-transform duration-300">
              <svg class="w-6 h-6 fill-current translate-x-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </div>
          </div>

          <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs">
            <span class="px-2.5 py-1 rounded-xl bg-black/60 backdrop-blur-md font-mono font-bold">⏱️ ${movie.duration}</span>
            <span class="px-2.5 py-1 rounded-xl bg-indigo-600/90 backdrop-blur-md font-mono font-black">${movie.cefr || movie.level}</span>
          </div>
        </div>

        <!-- Content Body -->
        <div class="p-5 sm:p-6 space-y-3.5 flex-1 flex flex-col justify-between">
          <div class="space-y-2">
            <div class="flex items-center justify-between gap-2">
              <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-black border ${levelBadgeClass}">
                ${movie.level}
              </span>
              <span class="text-[11px] font-mono text-slate-400 font-bold">${movie.studio || movie.category || 'Animación'}</span>
            </div>

            <h3 class="font-heading text-lg font-black text-slate-900 group-hover:text-indigo-600 transition-colors leading-snug">
              ${movie.title}
            </h3>
            
            <p class="text-xs text-slate-600 leading-relaxed font-medium line-clamp-3">
              ${movie.description}
            </p>
          </div>

          <!-- Quick Audio Pronunciation Preview -->
          ${mainVocab ? `
            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between text-xs">
              <span class="text-[11px] text-slate-500 font-mono">Palabra clave: <strong class="text-indigo-700">${mainVocab}</strong></span>
              <button 
                type="button" 
                onclick="event.stopPropagation(); speakEnglish('${mainVocab.replace(/'/g, "\\'")}')" 
                class="w-6 h-6 rounded-lg bg-indigo-100 hover:bg-indigo-600 text-indigo-700 hover:text-white flex items-center justify-center transition" 
                title="Escuchar pronunciación">
                🔊
              </button>
            </div>
          ` : ''}

          <!-- Tags & Action Button -->
          <div class="pt-3 border-t border-slate-100 space-y-2.5">
            <div class="flex items-center justify-between gap-2">
              <button 
                type="button" 
                onclick="openVideoModal(${movie.id})" 
                class="flex-1 py-2.5 px-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 active:scale-98 text-white text-xs font-bold shadow-md shadow-indigo-600/25 flex items-center justify-center gap-2 transition-all">
                <span>Ver con Pistas i+1</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
              </button>

              <a 
                href="${movie.direct_youtube_url || `https://www.youtube.com/watch?v=${movie.youtube_id}`}" 
                target="_blank" 
                rel="noopener noreferrer" 
                class="p-2.5 rounded-2xl bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 border border-slate-200 transition" 
                title="Ver directamente en YouTube (Enlace externo oficial)">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
              </a>
            </div>
          </div>

        </div>

      </div>
    `;
  }).join('');
}

function clearCatalogFilters() {
  STATE.currentFilter = 'All';
  STATE.searchQuery = '';
  const searchInput = document.getElementById('catalog-search');
  if (searchInput) searchInput.value = '';
  document.querySelectorAll('.level-btn').forEach((b, idx) => {
    if (idx === 0) {
      b.classList.add('bg-indigo-600', 'text-white', 'shadow-md', 'shadow-indigo-600/30');
      b.classList.remove('text-slate-700', 'hover:text-slate-900', 'hover:bg-white');
    } else {
      b.classList.remove('bg-indigo-600', 'text-white', 'shadow-md', 'shadow-indigo-600/30');
      b.classList.add('text-slate-700', 'hover:text-slate-900', 'hover:bg-white');
    }
  });
  renderCatalog();
}

/* ==========================================================================
   VIDEO MODAL WITH EMBED RESILIENCE & COMPREHENSION QUIZ
   ========================================================================== */
function openVideoModal(movieId) {
  const movie = STATE.movies.find(m => m.id === movieId);
  if (!movie) return;

  STATE.currentModalMovie = movie;

  const modal = document.getElementById('catalog-modal');
  const iframe = document.getElementById('modal-video-iframe');
  const title = document.getElementById('modal-title');
  const desc = document.getElementById('modal-desc');
  const krashenFactor = document.getElementById('modal-krashen-factor');
  const vocabContainer = document.getElementById('modal-vocab-list');
  const quizContainer = document.getElementById('modal-quiz-container');
  const markWatchedBtn = document.getElementById('modal-mark-watched-btn');
  const directLinkBtn = document.getElementById('modal-direct-yt-link');

  if (title) title.textContent = movie.title;
  if (desc) desc.textContent = movie.description;
  if (krashenFactor) krashenFactor.textContent = movie.krashen_factor || 'La narración visual permite decodificar el significado sin ansiedad gramatical.';

  if (directLinkBtn) {
    const ytUrl = movie.direct_youtube_url || `https://www.youtube.com/watch?v=${movie.youtube_id}`;
    directLinkBtn.href = ytUrl;
  }

  if (iframe) {
    iframe.src = `https://www.youtube-nocookie.com/embed/${movie.youtube_id}?autoplay=1&rel=0&enablejsapi=1`;
  }

  // Render Vocab Chips with Audio
  if (vocabContainer) {
    if (movie.vocabulary && movie.vocabulary.length > 0) {
      vocabContainer.innerHTML = movie.vocabulary.map(v => `
        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col justify-between space-y-1.5 hover:border-indigo-300 transition shadow-2xs">
          <div class="flex items-center justify-between gap-1">
            <span class="font-heading font-black text-sm text-indigo-700">${v.word}</span>
            <button 
              type="button" 
              onclick="speakEnglish('${v.word.replace(/'/g, "\\'")}')" 
              class="w-7 h-7 rounded-xl bg-indigo-100 hover:bg-indigo-600 text-indigo-700 hover:text-white flex items-center justify-center transition shadow-2xs" 
              title="Escuchar pronunciación nativa">
              🔊
            </button>
          </div>
          <span class="text-[10px] font-mono text-slate-400 font-bold">${v.phonetic || ''}</span>
          <p class="text-[11px] text-slate-600 font-medium leading-snug">${v.definition}</p>
          ${v.example ? `<p class="text-[10px] italic text-slate-500 border-l-2 border-indigo-200 pl-2">"${v.example}"</p>` : ''}
        </div>
      `).join('');
    } else {
      vocabContainer.innerHTML = `<p class="text-xs text-slate-400 italic">Inmersión visual pura sin vocabulario explícito requerido.</p>`;
    }
  }

  // Render Quiz
  if (quizContainer) {
    if (movie.quiz && movie.quiz.length > 0) {
      quizContainer.innerHTML = movie.quiz.map((q, qIndex) => `
        <div class="p-4 rounded-2xl bg-white border border-slate-200 space-y-3 shadow-2xs">
          <div class="flex items-start gap-2">
            <span class="px-2 py-0.5 rounded-lg bg-indigo-100 text-indigo-800 font-mono text-[10px] font-black">Q${qIndex + 1}</span>
            <h5 class="text-xs font-bold text-slate-800 leading-snug">${q.question}</h5>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" id="quiz-options-${qIndex}">
            ${q.options.map((opt, optIndex) => `
              <button 
                type="button" 
                onclick="checkVideoQuizAnswer(${movie.id}, ${qIndex}, ${optIndex})" 
                class="quiz-btn text-left p-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 hover:bg-indigo-50 hover:border-indigo-300 transition">
                ${opt}
              </button>
            `).join('')}
          </div>
          <div id="quiz-feedback-${qIndex}" class="hidden text-[11px] font-medium p-2 rounded-xl"></div>
        </div>
      `).join('');
    } else {
      quizContainer.innerHTML = `<p class="text-xs text-slate-500">¡Disfruta del cortometraje sin presión evaluativa!</p>`;
    }
  }

  // Mark Watched Button
  if (markWatchedBtn) {
    const isWatched = STATE.tracker.watchedIds.includes(movie.id);
    markWatchedBtn.innerHTML = isWatched ? `
      <span>✓ Adquirido en Diario (+${movie.duration_minutes || 5}m)</span>
    ` : `
      <span>Marcar como Adquirido (+${movie.duration_minutes || 5} mins)</span>
    `;
    markWatchedBtn.onclick = () => {
      if (!STATE.tracker.watchedIds.includes(movie.id)) {
        STATE.tracker.watchedIds.push(movie.id);
      }
      logImmersionMinutes(movie.duration_minutes || 5, movie.title);
      markWatchedBtn.innerHTML = `<span>✓ Adquirido en Diario (+${movie.duration_minutes || 5}m)</span>`;
      renderCatalog();
    };
  }

  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }
}

function closeVideoModal() {
  const modal = document.getElementById('catalog-modal');
  const iframe = document.getElementById('modal-video-iframe');
  if (iframe) iframe.src = '';
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
  }
}

function checkVideoQuizAnswer(movieId, qIndex, selectedIndex) {
  const movie = STATE.movies.find(m => m.id === movieId);
  if (!movie || !movie.quiz || !movie.quiz[qIndex]) return;

  const q = movie.quiz[qIndex];
  const optionsContainer = document.getElementById(`quiz-options-${qIndex}`);
  const feedback = document.getElementById(`quiz-feedback-${qIndex}`);
  if (!optionsContainer || !feedback) return;

  const buttons = optionsContainer.querySelectorAll('.quiz-btn');
  buttons.forEach((btn, idx) => {
    btn.disabled = true;
    if (idx === q.correctIndex) {
      btn.classList.add('bg-emerald-500', 'text-white', 'border-emerald-600', 'font-bold');
      btn.classList.remove('text-slate-700', 'hover:bg-indigo-50');
    } else if (idx === selectedIndex) {
      btn.classList.add('bg-rose-500', 'text-white', 'border-rose-600');
    }
  });

  feedback.classList.remove('hidden');
  if (selectedIndex === q.correctIndex) {
    SoundFX.playCorrect();
    triggerConfetti();
    feedback.className = 'text-[11px] font-bold p-2.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200';
    feedback.innerHTML = `🎉 ¡Correcto! ${q.explanation || ''}`;
  } else {
    SoundFX.playWrong();
    feedback.className = 'text-[11px] font-medium p-2.5 rounded-xl bg-rose-50 text-rose-800 border border-rose-200';
    feedback.innerHTML = `Cerca pero no. ${q.explanation || ''}`;
  }
}

/* ==========================================================================
   FEATURE 2: THE 5 INTERACTIVE MINI-GAMES
   ========================================================================== */
function initMiniGamesHub() {
  switchMiniGame('match');
}

function switchMiniGame(gameKey) {
  document.querySelectorAll('.game-tab-btn').forEach(b => {
    const isTarget = b.getAttribute('data-game') === gameKey;
    if (isTarget) {
      b.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
      b.classList.remove('text-slate-600', 'hover:bg-white');
    } else {
      b.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
      b.classList.add('text-slate-600', 'hover:bg-white');
    }
  });

  document.querySelectorAll('.game-stage').forEach(stage => {
    if (stage.id === `game-stage-${gameKey}`) {
      stage.classList.remove('hidden');
    } else {
      stage.classList.add('hidden');
    }
  });

  if (gameKey === 'match') startWordMatchGame();
  if (gameKey === 'cloze') renderDialogueClozeGame();
  if (gameKey === 'scramble') renderSentenceScrambleGame();
  if (gameKey === 'idiom') renderIdiomDetectiveGame();
  if (gameKey === 'audio') renderAudioListeningGame();
}

// GAME 1: CONTEXT WORD MATCH
function startWordMatchGame() {
  const container = document.getElementById('match-cards-container');
  if (!container || !STATE.minigames.word_match) return;

  const dataset = STATE.minigames.word_match;
  const shuffledItems = [...dataset].sort(() => Math.random() - 0.5).slice(0, 6);
  
  STATE.matchGame.totalPairs = shuffledItems.length;
  STATE.matchGame.matchedCount = 0;
  STATE.matchGame.score = 0;
  STATE.matchGame.streak = 0;
  STATE.matchGame.selectedFirst = null;
  STATE.matchGame.selectedSecond = null;

  const deck = [];
  shuffledItems.forEach(item => {
    deck.push({ id: item.id, type: 'term', text: `${item.icon} ${item.term}`, termWord: item.term });
    deck.push({ id: item.id, type: 'def', text: item.definition, termWord: item.term });
  });
  deck.sort(() => Math.random() - 0.5);

  updateMatchStatsUI();

  container.innerHTML = deck.map((card, idx) => `
    <div 
      class="match-card p-4 rounded-2xl bg-white border-2 border-slate-200 text-xs font-semibold text-slate-800 shadow-sm flex items-center justify-center text-center min-h-[90px]"
      data-card-idx="${idx}"
      data-pair-id="${card.id}"
      data-card-type="${card.type}"
      data-term="${card.termWord}"
      onclick="handleMatchCardClick(this)">
      ${card.text}
    </div>
  `).join('');
}

function handleMatchCardClick(el) {
  if (el.classList.contains('matched') || el.classList.contains('selected')) return;

  el.classList.add('selected');

  if (!STATE.matchGame.selectedFirst) {
    STATE.matchGame.selectedFirst = el;
    if (el.getAttribute('data-card-type') === 'term') {
      speakEnglish(el.getAttribute('data-term'));
    }
    return;
  }

  STATE.matchGame.selectedSecond = el;
  const first = STATE.matchGame.selectedFirst;
  const second = STATE.matchGame.selectedSecond;

  const id1 = first.getAttribute('data-pair-id');
  const id2 = second.getAttribute('data-pair-id');
  const type1 = first.getAttribute('data-card-type');
  const type2 = second.getAttribute('data-card-type');

  if (id1 === id2 && type1 !== type2) {
    SoundFX.playCorrect();
    first.classList.remove('selected');
    second.classList.remove('selected');
    first.classList.add('matched');
    second.classList.add('matched');

    STATE.matchGame.matchedCount++;
    STATE.matchGame.streak++;
    STATE.matchGame.score += 100 * STATE.matchGame.streak;
    speakEnglish(first.getAttribute('data-term'));

    STATE.matchGame.selectedFirst = null;
    STATE.matchGame.selectedSecond = null;
    updateMatchStatsUI();

    if (STATE.matchGame.matchedCount === STATE.matchGame.totalPairs) {
      setTimeout(() => {
        triggerConfetti();
        logImmersionMinutes(5, 'Context Word Match');
        showToast(`🎉 ¡Juego Completado! Puntuación Final: ${STATE.matchGame.score}`);
      }, 500);
    }
  } else {
    SoundFX.playWrong();
    STATE.matchGame.streak = 0;
    updateMatchStatsUI();
    setTimeout(() => {
      first.classList.remove('selected');
      second.classList.remove('selected');
      STATE.matchGame.selectedFirst = null;
      STATE.matchGame.selectedSecond = null;
    }, 700);
  }
}

function updateMatchStatsUI() {
  const scoreEl = document.getElementById('match-score');
  const streakEl = document.getElementById('match-streak');
  const progressEl = document.getElementById('match-progress');
  if (scoreEl) scoreEl.textContent = STATE.matchGame.score;
  if (streakEl) streakEl.textContent = `x${STATE.matchGame.streak}`;
  if (progressEl) progressEl.textContent = `${STATE.matchGame.matchedCount}/${STATE.matchGame.totalPairs}`;
}

// GAME 2: DIALOGUE CLOZE
function renderDialogueClozeGame() {
  const container = document.getElementById('cloze-game-container');
  if (!container || !STATE.minigames.dialogue_cloze) return;

  const items = STATE.minigames.dialogue_cloze;
  const current = items[STATE.clozeIndex % items.length];

  container.innerHTML = `
    <div class="max-w-2xl mx-auto space-y-6">
      <div class="p-6 rounded-3xl bg-indigo-50/80 border border-indigo-200/90 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
          <span class="px-3 py-1 rounded-full bg-indigo-600 text-white font-mono text-[11px] font-bold">
            🎬 ${current.scene}
          </span>
          <span class="text-xs font-mono font-bold text-slate-500">Diálogo ${STATE.clozeIndex + 1} de ${items.length}</span>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-inner space-y-2">
          <div class="flex items-center gap-2">
            <span class="font-bold text-indigo-700 text-xs">${current.speaker}</span>
            <button onclick="speakEnglish('${current.sentence.replace('_____', current.blank_answer).replace(/'/g, "\\'")}')" class="text-slate-400 hover:text-indigo-600" title="Escuchar frase">
              🔊
            </button>
          </div>
          <p class="font-heading text-lg sm:text-xl font-bold text-slate-900 leading-relaxed">
            "${current.sentence.replace('_____', `<span id="cloze-blank-slot" class="inline-block px-4 py-1 mx-1 border-b-4 border-indigo-600 bg-indigo-100 text-indigo-900 font-black rounded-lg">_____</span>`)}"
          </p>
        </div>

        <div class="flex items-center justify-between text-xs text-slate-600 pt-1">
          <span>💡 <strong>Pista Contextual:</strong> ${current.hint}</span>
          <button onclick="toggleClozeTranslation()" class="text-indigo-600 font-bold hover:underline">
            [Ver traducción]
          </button>
        </div>

        <p id="cloze-trans-text" class="hidden text-xs text-slate-500 italic bg-white/70 p-3 rounded-xl border border-slate-200">
          ${current.translation_es}
        </p>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        ${current.options.map(opt => `
          <button 
            type="button" 
            onclick="handleClozeSelect('${opt}', '${current.blank_answer}', this)" 
            class="cloze-option p-4 rounded-2xl bg-white border-2 border-slate-200 font-heading font-black text-slate-800 text-sm hover:border-indigo-400 shadow-sm active:scale-95 transition">
            ${opt}
          </button>
        `).join('')}
      </div>

      <div id="cloze-feedback" class="hidden p-4 rounded-2xl text-center text-xs font-bold"></div>
    </div>
  `;
}

function toggleClozeTranslation() {
  const el = document.getElementById('cloze-trans-text');
  if (el) el.classList.toggle('hidden');
}

function handleClozeSelect(selected, correct, btn) {
  const feedback = document.getElementById('cloze-feedback');
  const blankSlot = document.getElementById('cloze-blank-slot');
  if (!feedback) return;

  document.querySelectorAll('.cloze-option').forEach(b => b.disabled = true);

  if (selected.toLowerCase() === correct.toLowerCase()) {
    SoundFX.playCorrect();
    triggerConfetti();
    btn.classList.add('correct');
    if (blankSlot) blankSlot.textContent = correct;
    feedback.className = 'p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-center';
    feedback.innerHTML = `🎉 ¡Excelente! Descifraste el diálogo mediante contexto natural.`;
    feedback.classList.remove('hidden');

    setTimeout(() => {
      STATE.clozeIndex++;
      renderDialogueClozeGame();
    }, 1800);
  } else {
    SoundFX.playWrong();
    btn.classList.add('wrong');
    feedback.className = 'p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 font-bold text-center';
    feedback.innerHTML = `No es esa palabra. Fíjate en la pista contextual.`;
    feedback.classList.remove('hidden');
    setTimeout(() => {
      document.querySelectorAll('.cloze-option').forEach(b => b.disabled = false);
      btn.classList.remove('wrong');
      feedback.classList.add('hidden');
    }, 1200);
  }
}

// GAME 3: SENTENCE SCRAMBLE
function renderSentenceScrambleGame() {
  const container = document.getElementById('scramble-game-container');
  if (!container || !STATE.minigames.sentence_scramble) return;

  const items = STATE.minigames.sentence_scramble;
  const current = items[STATE.scrambleIndex % items.length];

  STATE.scrambleCurrentTokens = [];
  const availableTokens = [...current.words].sort(() => Math.random() - 0.5);

  container.innerHTML = `
    <div class="max-w-2xl mx-auto space-y-6">
      <div class="p-6 rounded-3xl bg-purple-50/80 border border-purple-200/90 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
          <span class="px-3 py-1 rounded-full bg-purple-600 text-white font-mono text-[11px] font-bold">
            🧠 Laboratorio de Sintaxis Krashen (${current.level})
          </span>
          <span class="text-xs font-mono font-bold text-slate-500">Oración ${STATE.scrambleIndex + 1} de ${items.length}</span>
        </div>

        <p class="text-xs text-slate-600">Arma las palabras en el orden natural del inglés hablado:</p>

        <div id="scramble-drop-area" class="min-h-[70px] p-4 rounded-2xl bg-white border-2 border-dashed border-purple-300 flex flex-wrap items-center gap-2 shadow-inner">
          <span id="scramble-placeholder" class="text-xs text-slate-400 font-medium">Haz clic en las fichas de abajo para construir la frase...</span>
        </div>

        <p class="text-[11px] text-slate-500 italic">Significado: "${current.translation_es}"</p>
      </div>

      <div id="scramble-tokens-pool" class="flex flex-wrap gap-2.5 justify-center">
        ${availableTokens.map((w, idx) => `
          <button 
            type="button" 
            onclick="addScrambleToken(this, '${w}')" 
            class="scramble-token px-4 py-2.5 rounded-2xl bg-white border border-slate-200 hover:border-purple-500 font-heading font-black text-slate-800 text-sm shadow-sm active:scale-95 transition">
            ${w}
          </button>
        `).join('')}
      </div>

      <div class="flex items-center justify-center gap-3">
        <button onclick="resetScrambleSentence()" class="px-5 py-2.5 rounded-2xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold transition">
          ↺ Reiniciar
        </button>
        <button onclick="checkScrambleSolution('${current.solution}')" class="px-6 py-2.5 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md transition">
          ✓ Verificar Oración
        </button>
      </div>

      <div id="scramble-feedback" class="hidden p-4 rounded-2xl text-center text-xs font-bold"></div>
    </div>
  `;
}

function addScrambleToken(btn, word) {
  const dropArea = document.getElementById('scramble-drop-area');
  const placeholder = document.getElementById('scramble-placeholder');
  if (placeholder) placeholder.style.display = 'none';

  btn.style.display = 'none';
  STATE.scrambleCurrentTokens.push({ word, btnRef: btn });

  const tokenChip = document.createElement('span');
  tokenChip.className = 'px-3.5 py-1.5 rounded-xl bg-purple-600 text-white font-heading font-black text-xs shadow-sm cursor-pointer hover:bg-purple-700';
  tokenChip.textContent = word;
  tokenChip.onclick = () => {
    tokenChip.remove();
    btn.style.display = '';
    STATE.scrambleCurrentTokens = STATE.scrambleCurrentTokens.filter(t => t.btnRef !== btn);
    if (STATE.scrambleCurrentTokens.length === 0 && placeholder) {
      placeholder.style.display = '';
    }
  };

  dropArea.appendChild(tokenChip);
}

function resetScrambleSentence() {
  STATE.scrambleCurrentTokens.forEach(t => t.btnRef.style.display = '');
  STATE.scrambleCurrentTokens = [];
  const dropArea = document.getElementById('scramble-drop-area');
  const placeholder = document.getElementById('scramble-placeholder');
  if (dropArea) {
    dropArea.querySelectorAll('span:not(#scramble-placeholder)').forEach(s => s.remove());
  }
  if (placeholder) placeholder.style.display = '';
}

function checkScrambleSolution(expectedSolution) {
  const feedback = document.getElementById('scramble-feedback');
  if (!feedback) return;

  const userString = STATE.scrambleCurrentTokens.map(t => t.word).join(' ').trim();
  if (userString.toLowerCase() === expectedSolution.toLowerCase()) {
    SoundFX.playCorrect();
    triggerConfetti();
    speakEnglish(expectedSolution);
    feedback.className = 'p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-center';
    feedback.innerHTML = `🎉 ¡Perfecto! Sintaxis natural adquirida. Escuchando la oración...`;
    feedback.classList.remove('hidden');

    setTimeout(() => {
      STATE.scrambleIndex++;
      renderSentenceScrambleGame();
    }, 2200);
  } else {
    SoundFX.playWrong();
    feedback.className = 'p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 font-bold text-center';
    feedback.innerHTML = `El orden aún no suena natural en inglés. ¡Prueba cambiando las fichas!`;
    feedback.classList.remove('hidden');
  }
}

// GAME 4: IDIOM DETECTIVE
function renderIdiomDetectiveGame() {
  const container = document.getElementById('idiom-game-container');
  if (!container || !STATE.minigames.idiom_detective) return;

  const items = STATE.minigames.idiom_detective;
  const current = items[STATE.idiomIndex % items.length];

  container.innerHTML = `
    <div class="max-w-xl mx-auto space-y-6">
      <div class="p-6 rounded-3xl bg-amber-50/80 border border-amber-200/90 shadow-sm space-y-4 text-center">
        <div class="flex items-center justify-between">
          <span class="px-3 py-1 rounded-full bg-amber-600 text-white font-mono text-[11px] font-bold">
            🕵️ Detective de Modismos
          </span>
          <span class="text-xs font-mono font-bold text-slate-500">Modismo ${STATE.idiomIndex + 1} de ${items.length}</span>
        </div>

        <div class="text-5xl py-2">${current.icon}</div>

        <div class="flex items-center justify-center gap-2">
          <h3 class="font-heading text-2xl font-black text-slate-900 tracking-tight">
            "${current.idiom}"
          </h3>
          <button onclick="speakEnglish('${current.idiom.replace(/'/g, "\\'")}')" class="text-slate-400 hover:text-amber-600 text-lg" title="Pronunciar">
            🔊
          </button>
        </div>

        <div class="p-3.5 rounded-2xl bg-white border border-slate-200 text-xs text-slate-600 italic">
          🎬 En el cortometraje: "${current.cartoon_example}"
        </div>
      </div>

      <div class="space-y-2.5">
        ${current.options.map((opt, idx) => `
          <button 
            type="button" 
            onclick="handleIdiomChoice(${idx}, ${current.correctIndex}, this)" 
            class="idiom-option w-full p-4 rounded-2xl bg-white border-2 border-slate-200 text-left font-semibold text-slate-800 text-xs hover:border-amber-400 shadow-sm transition">
            ${opt}
          </button>
        `).join('')}
      </div>

      <div id="idiom-feedback" class="hidden p-4 rounded-2xl text-center text-xs font-bold"></div>
    </div>
  `;
}

function handleIdiomChoice(selectedIndex, correctIndex, btn) {
  const feedback = document.getElementById('idiom-feedback');
  if (!feedback) return;

  document.querySelectorAll('.idiom-option').forEach(b => b.disabled = true);

  if (selectedIndex === correctIndex) {
    SoundFX.playCorrect();
    triggerConfetti();
    btn.classList.add('bg-emerald-500', 'text-white', 'border-emerald-600');
    feedback.className = 'p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-center';
    feedback.innerHTML = `🎉 ¡Acertaste! Modismo decodificado con éxito.`;
    feedback.classList.remove('hidden');

    setTimeout(() => {
      STATE.idiomIndex++;
      renderIdiomDetectiveGame();
    }, 1800);
  } else {
    SoundFX.playWrong();
    btn.classList.add('bg-rose-500', 'text-white', 'border-rose-600');
    feedback.className = 'p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 font-bold text-center';
    feedback.innerHTML = `Significado incorrecto. Fíjate cómo reaccionan los personajes en la escena.`;
    feedback.classList.remove('hidden');

    setTimeout(() => {
      document.querySelectorAll('.idiom-option').forEach(b => b.disabled = false);
      btn.classList.remove('bg-rose-500', 'text-white', 'border-rose-600');
      feedback.classList.add('hidden');
    }, 1200);
  }
}

// GAME 5: AUDIO ACCENT & MINIMAL PAIR CHALLENGE
function renderAudioListeningGame() {
  const container = document.getElementById('audio-game-container');
  if (!container || !STATE.minigames.audio_listening) return;

  const items = STATE.minigames.audio_listening;
  const current = items[STATE.audioIndex % items.length];
  const options = [current.target_word, current.pair_word].sort(() => Math.random() - 0.5);

  container.innerHTML = `
    <div class="max-w-xl mx-auto space-y-6 text-center">
      <div class="p-6 rounded-3xl bg-emerald-50/80 border border-emerald-200/90 shadow-sm space-y-5">
        <div class="flex items-center justify-between">
          <span class="px-3 py-1 rounded-full bg-emerald-600 text-white font-mono text-[11px] font-bold">
            🎧 Laboratorio de Discriminación Auditiva
          </span>
          <span class="text-xs font-mono font-bold text-slate-500">Par ${STATE.audioIndex + 1} de ${items.length}</span>
        </div>

        <div class="py-4 space-y-3">
          <button 
            type="button" 
            onclick="speakEnglish('${current.target_word}', 0.8)" 
            class="w-20 h-20 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-3xl shadow-xl shadow-emerald-600/30 active:scale-95 transition mx-auto flex items-center justify-center cursor-pointer">
            🔊
          </button>
          <p class="text-xs font-bold text-slate-700">Haz clic en el altavoz para escuchar la palabra</p>
          <p class="text-[11px] text-slate-500">Foco Fonético: ${current.vowel_sound}</p>
        </div>

        <div class="p-3.5 rounded-2xl bg-white border border-slate-200 text-xs text-slate-600">
          💡 Pista: "${current.hint}"
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        ${options.map(opt => `
          <button 
            type="button" 
            onclick="handleAudioChoice('${opt}', '${current.target_word}', this)" 
            class="audio-option p-6 rounded-2xl bg-white border-2 border-slate-200 font-heading font-black text-slate-900 text-xl hover:border-emerald-500 shadow-sm active:scale-95 transition">
            ${opt}
          </button>
        `).join('')}
      </div>

      <div id="audio-feedback" class="hidden p-4 rounded-2xl text-center text-xs font-bold"></div>
    </div>
  `;
}

function handleAudioChoice(selected, correct, btn) {
  const feedback = document.getElementById('audio-feedback');
  if (!feedback) return;

  document.querySelectorAll('.audio-option').forEach(b => b.disabled = true);

  if (selected.toLowerCase() === correct.toLowerCase()) {
    SoundFX.playCorrect();
    triggerConfetti();
    btn.classList.add('bg-emerald-500', 'text-white', 'border-emerald-600');
    feedback.className = 'p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-center';
    feedback.innerHTML = `🎉 ¡Correcto! Tu oído diferenció el fonema nativo con precisión.`;
    feedback.classList.remove('hidden');

    setTimeout(() => {
      STATE.audioIndex++;
      renderAudioListeningGame();
    }, 1800);
  } else {
    SoundFX.playWrong();
    btn.classList.add('bg-rose-500', 'text-white', 'border-rose-600');
    feedback.className = 'p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 font-bold text-center';
    feedback.innerHTML = `Escucha con atención nuevamente. Fíjate en la duración del sonido vocal.`;
    feedback.classList.remove('hidden');

    setTimeout(() => {
      document.querySelectorAll('.audio-option').forEach(b => b.disabled = false);
      btn.classList.remove('bg-rose-500', 'text-white', 'border-rose-600');
      feedback.classList.add('hidden');
    }, 1200);
  }
}

/* ==========================================================================
   FEATURE 3: WEB SERIES PLATFORM
   ========================================================================== */
function renderSeriesHub() {
  const container = document.getElementById('series-grid-container');
  if (!container || !STATE.series) return;

  container.innerHTML = STATE.series.map(s => `
    <div class="glass-panel rounded-3xl overflow-hidden card-interactive flex flex-col justify-between group">
      <div class="relative h-60 overflow-hidden bg-slate-900">
        <img src="${s.cover}" alt="${s.title}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-transparent to-transparent"></div>
        <div class="absolute bottom-3 left-3 right-3 text-white">
          <span class="px-2.5 py-1 rounded-xl bg-indigo-600/90 text-[10px] font-mono font-bold">${s.cefr_level || 'B2'}</span>
          <h3 class="font-heading text-xl font-black mt-1 leading-tight">${s.title}</h3>
        </div>
      </div>

      <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
        <div class="space-y-2">
          <div class="flex items-center justify-between text-xs text-slate-500 font-mono">
            <span>${s.creator}</span>
            <span class="font-bold">${s.episodesCount}</span>
          </div>
          <p class="text-xs text-slate-600 leading-relaxed">${s.synopsis}</p>
        </div>

        <div class="pt-3 border-t border-slate-100 space-y-3">
          ${s.key_phrases ? `
            <div class="space-y-1">
              <span class="text-[10px] font-mono font-black text-indigo-700 uppercase">Frases Coloquiales Clave:</span>
              <div class="flex flex-wrap gap-1">
                ${s.key_phrases.map(kp => `
                  <span class="px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 text-[10px] font-bold" title="${kp.meaning}">${kp.phrase}</span>
                `).join('')}
              </div>
            </div>
          ` : ''}

          <a 
            href="https://www.youtube.com/watch?v=${s.firstVideoId}&list=${s.playlistId}" 
            target="_blank" 
            rel="noopener noreferrer" 
            class="w-full py-2.5 px-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/25 flex items-center justify-center gap-2 transition">
            <span>Ver Serie Completa en YouTube</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
          </a>
        </div>
      </div>
    </div>
  `).join('');
}

/* ==========================================================================
   FEATURE 4: AUDIO PODCASTS PLATFORM
   ========================================================================== */
function renderPodcastsHub() {
  const container = document.getElementById('podcasts-grid-container');
  if (!container || !STATE.podcasts) return;

  container.innerHTML = STATE.podcasts.map(p => `
    <div class="glass-panel rounded-3xl p-6 card-interactive space-y-4 flex flex-col justify-between">
      <div class="flex items-start gap-4">
        <img src="${p.cover}" alt="${p.title}" class="w-20 h-20 rounded-2xl object-cover shadow-md shrink-0">
        <div class="space-y-1">
          <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-mono font-bold">
            ${p.cefr_level || 'B2'}
          </span>
          <h3 class="font-heading text-lg font-black text-slate-900 leading-snug">${p.title}</h3>
          <p class="text-[11px] font-mono text-slate-400 font-bold">${p.author}</p>
        </div>
      </div>

      <p class="text-xs text-slate-600 leading-relaxed">${p.description}</p>

      <div class="space-y-3 pt-3 border-t border-slate-100">
        ${p.vocabNotes ? `
          <div class="flex flex-wrap gap-1">
            ${p.vocabNotes.map(n => `
              <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-mono font-bold">${n}</span>
            `).join('')}
          </div>
        ` : ''}

        <a 
          href="https://www.youtube.com/watch?v=${p.firstVideoId}&list=${p.playlistId}" 
          target="_blank" 
          rel="noopener noreferrer" 
          class="w-full py-2.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/25 flex items-center justify-center gap-2 transition">
          <span>🎧 Escuchar Episodios de Audio</span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
      </div>
    </div>
  `).join('');
}

/* ==========================================================================
   FEATURE 5: IMMERSION TRACKER VIEW
   ========================================================================== */
function renderTrackerView() {
  updateTrackerUI();
}

function updateTrackerUI() {
  const totalMins = STATE.tracker.totalMinutes;
  const streak = STATE.tracker.streakDays;
  const watchedCount = STATE.tracker.watchedIds.length;

  const hours = (totalMins / 60).toFixed(1);
  let stageTitle = 'Novice Explorer';
  let nextStageHours = 20;
  let progressPct = Math.min(100, Math.round((totalMins / (nextStageHours * 60)) * 100));

  if (totalMins >= 1200) {
    stageTitle = 'Fluent Thinker (B2-C1)';
    progressPct = 100;
  } else if (totalMins >= 600) {
    stageTitle = 'Conversationalist (B1)';
    nextStageHours = 20;
    progressPct = Math.min(100, Math.round((totalMins / 1200) * 100));
  } else if (totalMins >= 180) {
    stageTitle = 'Active Listener (A2)';
    nextStageHours = 10;
    progressPct = Math.min(100, Math.round((totalMins / 600) * 100));
  }

  const streakEl = document.getElementById('tracker-streak-val');
  const minutesEl = document.getElementById('tracker-minutes-val');
  const watchedEl = document.getElementById('tracker-watched-val');
  const levelEl = document.getElementById('tracker-level-badge');
  const progressInner = document.getElementById('tracker-progress-fill');
  const pctLabel = document.getElementById('tracker-progress-pct');

  if (streakEl) streakEl.textContent = `${streak} Días 🔥`;
  if (minutesEl) minutesEl.textContent = `${totalMins} mins (${hours}h)`;
  if (watchedEl) watchedEl.textContent = `${watchedCount} cortos`;
  if (levelEl) levelEl.textContent = stageTitle;
  if (progressInner) progressInner.style.width = `${progressPct}%`;
  if (pctLabel) pctLabel.textContent = `${progressPct}%`;
}

function manualLogMinutes(amount) {
  logImmersionMinutes(amount, 'Sesión de Inmersión Independiente');
}

/* ==========================================================================
   FEATURE 6: ZERO DECISION FATIGUE ROULETTE
   ========================================================================== */
function initRouletteView() {
  const btn = document.getElementById('big-roulette-btn');
  if (btn) {
    btn.onclick = spinRoulette;
  }
}

function spinRoulette() {
  const icon = document.getElementById('roulette-icon');
  const btn = document.getElementById('big-roulette-btn');
  if (icon) icon.classList.add('animate-spin');
  if (btn) btn.disabled = true;

  SoundFX.playCorrect();

  setTimeout(() => {
    if (icon) icon.classList.remove('animate-spin');
    if (btn) btn.disabled = false;

    if (STATE.movies.length > 0) {
      const randomIndex = Math.floor(Math.random() * STATE.movies.length);
      const chosen = STATE.movies[randomIndex];
      openVideoModal(chosen.id);
    }
  }, 1200);
}

// Global Event Listeners Setup
function initEventListeners() {
  const mobileToggle = document.getElementById('mobile-nav-toggle');
  const mobileMenu = document.getElementById('mobile-nav-menu');
  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }

  const searchInput = document.getElementById('catalog-search');
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      STATE.searchQuery = e.target.value.toLowerCase().trim();
      renderCatalog();
    });
  }

  document.querySelectorAll('.level-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.level-btn').forEach(b => {
        b.classList.remove('bg-indigo-600', 'text-white', 'shadow-md', 'shadow-indigo-600/30');
        b.classList.add('text-slate-700', 'hover:text-slate-900', 'hover:bg-white');
      });
      btn.classList.add('bg-indigo-600', 'text-white', 'shadow-md', 'shadow-indigo-600/30');
      btn.classList.remove('text-slate-700', 'hover:text-slate-900', 'hover:bg-white');
      STATE.currentFilter = btn.getAttribute('data-level');
      renderCatalog();
    });
  });

  const closeModalBtn = document.getElementById('close-video-modal');
  const modal = document.getElementById('catalog-modal');
  if (closeModalBtn && modal) {
    closeModalBtn.addEventListener('click', closeVideoModal);
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeVideoModal();
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeVideoModal();
      closeAddVideoModal();
    }
  });

  // Custom Content Form
  const customForm = document.getElementById('custom-video-form');
  if (customForm) {
    customForm.addEventListener('submit', handleAddVideoSubmit);
  }
}

function renderApp() {
  renderCatalog();
  updateTrackerUI();
}

// Toast Helper
function showToast(message) {
  let toast = document.getElementById('toonToast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toonToast';
    toast.className = 'toon-toast';
    document.body.appendChild(toast);
  }

  toast.innerHTML = `
    <span class="text-amber-400 font-bold">●</span>
    <span>${message}</span>
  `;

  toast.classList.add('show');
  setTimeout(() => {
    toast.classList.remove('show');
  }, 3200);
}
