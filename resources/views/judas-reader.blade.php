@extends('layouts.app')

@section('title', 'Judas (CBR Comic Reader) - ToonInput')

@section('content')
    <div class="max-w-6xl mx-auto space-y-5">
        
        <!-- Navigation Hub & Comic Switcher Bar -->
        <div class="glass-panel p-3.5 px-6 rounded-2xl flex items-center justify-between gap-3">
            <a href="{{ route('comic') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-600 hover:text-rose-600 transition-colors">
                <span>← Back to Comic Library</span>
            </a>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400 hidden sm:inline font-mono">Switch Title:</span>
                <a href="{{ route('comic-reader') }}" class="px-3.5 py-1.5 rounded-xl bg-slate-100/90 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 text-xs font-extrabold transition-all border border-slate-200 flex items-center gap-1.5 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span>Shadowhunters (PDF)</span>
                </a>
            </div>
        </div>

        <!-- Reader Sticky Top Control Bar -->
        <div class="sticky top-20 z-30 bg-slate-900/95 backdrop-blur-xl border border-slate-800 p-4 sm:p-5 rounded-3xl shadow-2xl flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Comic Header & Title -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-rose-600/20 border border-rose-500/40 text-rose-400 flex items-center justify-center font-black text-xs shadow-sm shrink-0 font-mono">
                    JPG
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="font-heading text-xl font-black text-white">Judas</h1>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-950 text-rose-400 border border-rose-800 font-mono">
                            CBR Reader
                        </span>
                    </div>
                    <p class="text-[11px] font-mono text-slate-400 font-semibold">4 Chapters • Digital Comic Collection</p>
                </div>
            </div>

            <!-- Chapter Selector Pills -->
            <div class="flex items-center gap-1.5 bg-slate-950/90 p-1.5 rounded-2xl border border-slate-800 shadow-inner overflow-x-auto w-full md:w-auto">
                @for ($ch = 1; $ch <= $totalChapters; $ch++)
                    <a 
                        href="{{ route('judas.reader', ['chapter' => $ch]) }}" 
                        class="chapter-btn px-3.5 py-1.5 rounded-xl text-xs font-mono font-extrabold transition-all duration-200 whitespace-nowrap {{ $currentChapter == $ch ? 'bg-rose-600 text-white shadow-md shadow-rose-600/40' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}"
                        data-chapter="{{ $ch }}">
                        Ch {{ $ch }}
                    </a>
                @endfor
            </div>

            <!-- Toolbar (Navigation & Zoom) -->
            <div class="flex flex-wrap items-center justify-center gap-2 bg-slate-950/90 p-2 rounded-2xl border border-slate-800 shadow-inner">
                
                <!-- Previous Button -->
                <button 
                    id="judas-prev-btn" 
                    class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-rose-600 text-white font-extrabold text-xs transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-slate-800 flex items-center gap-1 shadow-sm">
                    <span>← Prev</span>
                </button>

                <!-- Page Direct Jump Input -->
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 rounded-xl border border-slate-800 text-xs font-mono text-slate-300">
                    <span>Page</span>
                    <input 
                        type="number" 
                        id="judas-page-input" 
                        min="1" 
                        max="{{ $totalPages }}" 
                        value="1" 
                        class="w-12 bg-slate-950 border border-slate-700 text-center font-extrabold text-rose-400 rounded-lg py-0.5 focus:outline-none focus:border-rose-500" 
                    />
                    <span>of <strong id="judas-total-pages" class="text-white">{{ $totalPages }}</strong></span>
                </div>

                <!-- Next Button -->
                <button 
                    id="judas-next-btn" 
                    class="px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-extrabold text-xs transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-rose-600 flex items-center gap-1 shadow-sm">
                    <span>Next →</span>
                </button>

                <!-- Zoom Controls Bar -->
                <div class="flex items-center gap-1 pl-2 border-l border-slate-800">
                    <button id="judas-zoom-out" class="px-2.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition" title="Zoom Out">-</button>
                    <span id="judas-zoom-val" class="text-[11px] font-mono text-slate-300 font-bold px-1.5">100%</span>
                    <button id="judas-zoom-fit" class="px-2.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition font-mono" title="Fit Screen">Fit</button>
                    <button id="judas-zoom-in" class="px-2.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition" title="Zoom In">+</button>
                </div>

            </div>
        </div>

        <!-- Main Display Container (Dark Comic Cinema View) -->
        <div id="judas-reader-box" class="relative bg-slate-950 border border-slate-800 rounded-3xl p-4 sm:p-6 shadow-2xl group">
            
            <!-- Floating Hover Overlay Arrows -->
            <button 
                id="judas-floating-prev" 
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-slate-900/90 hover:bg-rose-600 text-white font-extrabold flex items-center justify-center border border-slate-700 shadow-2xl opacity-0 group-hover:opacity-100 transition-all duration-300 disabled:hidden">
                ←
            </button>

            <button 
                id="judas-floating-next" 
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-slate-900/90 hover:bg-rose-600 text-white font-extrabold flex items-center justify-center border border-slate-700 shadow-2xl opacity-0 group-hover:opacity-100 transition-all duration-300 disabled:hidden">
                →
            </button>

            <!-- Loading Spinner -->
            <div id="judas-loading" class="absolute inset-0 z-20 bg-slate-950/90 backdrop-blur-sm flex flex-col items-center justify-center space-y-3 hidden">
                <div class="w-10 h-10 border-4 border-rose-600 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-xs font-mono font-bold text-slate-300 animate-pulse">Loading Chapter Pages...</p>
            </div>

            <!-- Page Image Display Wrapper with Scrollable Overflow -->
            <div id="judas-img-wrapper" class="w-full overflow-auto rounded-2xl border border-slate-800 shadow-2xl bg-slate-900/90 p-3 max-h-[82vh] text-center">
                <img 
                    id="judas-active-page" 
                    src="{{ count($pages) > 0 ? $pages[0] : '' }}" 
                    alt="Judas Page 1" 
                    class="mx-auto block max-h-[80vh] w-auto h-auto rounded-xl object-contain shadow-2xl transition-all duration-200"
                />
            </div>

            <!-- Thumbnail Navigation Strip -->
            <div id="judas-thumb-strip" class="w-full mt-6 flex items-center gap-3 overflow-x-auto p-2.5 bg-slate-900/80 rounded-2xl border border-slate-800/80">
                @foreach ($pages as $idx => $pageUrl)
                    <img 
                        src="{{ $pageUrl }}" 
                        alt="Page {{ $idx + 1 }}" 
                        class="thumb-item w-16 h-24 object-cover rounded-lg border-2 cursor-pointer transition-all duration-200 shrink-0 hover:scale-105 {{ $idx === 0 ? 'border-rose-500 ring-2 ring-rose-500/50 scale-105' : 'border-slate-800 opacity-60 hover:opacity-100' }}" 
                        data-index="{{ $idx }}"
                    />
                @endforeach
            </div>

        </div>

    </div>

    <!-- Script handling CBR comic viewer interactivity & zoom -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let pages = @json($pages);
            let totalPages = {{ $totalPages }};
            let currentIndex = 0;
            let currentScale = 1.0;

            const imgEl = document.getElementById('judas-active-page');
            const wrapper = document.getElementById('judas-img-wrapper');
            const prevBtn = document.getElementById('judas-prev-btn');
            const nextBtn = document.getElementById('judas-next-btn');
            const floatPrev = document.getElementById('judas-floating-prev');
            const floatNext = document.getElementById('judas-floating-next');
            const pageInput = document.getElementById('judas-page-input');
            const totalPagesEl = document.getElementById('judas-total-pages');
            const zoomInBtn = document.getElementById('judas-zoom-in');
            const zoomOutBtn = document.getElementById('judas-zoom-out');
            const zoomFitBtn = document.getElementById('judas-zoom-fit');
            const zoomValEl = document.getElementById('judas-zoom-val');

            function applyZoom() {
                zoomValEl.textContent = `${Math.round(currentScale * 100)}%`;

                if (currentScale === 1.0) {
                    imgEl.style.maxHeight = '80vh';
                    imgEl.style.maxWidth = '100%';
                    imgEl.style.width = 'auto';
                } else {
                    imgEl.style.maxHeight = 'none';
                    imgEl.style.maxWidth = 'none';
                    imgEl.style.width = `${Math.round(currentScale * 100)}%`;
                }

                wrapper.scrollTop = 0;
            }

            function updateDisplay() {
                if (!pages || pages.length === 0) return;

                if (currentIndex < 0) currentIndex = 0;
                if (currentIndex >= totalPages) currentIndex = totalPages - 1;

                imgEl.style.opacity = '0.4';
                imgEl.src = pages[currentIndex];

                imgEl.onload = () => {
                    imgEl.style.opacity = '1';
                };

                pageInput.value = currentIndex + 1;
                totalPagesEl.textContent = totalPages;

                wrapper.scrollTop = 0;

                const isFirst = currentIndex === 0;
                const isLast = currentIndex === totalPages - 1;

                prevBtn.disabled = isFirst;
                floatPrev.disabled = isFirst;

                nextBtn.disabled = isLast;
                floatNext.disabled = isLast;

                document.querySelectorAll('.thumb-item').forEach((thumb, idx) => {
                    if (idx === currentIndex) {
                        thumb.className = 'thumb-item w-16 h-24 object-cover rounded-lg border-2 cursor-pointer transition-all duration-200 shrink-0 border-rose-500 ring-2 ring-rose-500/50 scale-105 opacity-100';
                        thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    } else {
                        thumb.className = 'thumb-item w-16 h-24 object-cover rounded-lg border-2 cursor-pointer transition-all duration-200 shrink-0 border-slate-800 opacity-60 hover:opacity-100';
                    }
                });
            }

            function goToPrev() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateDisplay();
                }
            }

            function goToNext() {
                if (currentIndex < totalPages - 1) {
                    currentIndex++;
                    updateDisplay();
                }
            }

            prevBtn.addEventListener('click', goToPrev);
            nextBtn.addEventListener('click', goToNext);
            floatPrev.addEventListener('click', goToPrev);
            floatNext.addEventListener('click', goToNext);

            zoomInBtn?.addEventListener('click', () => {
                if (currentScale < 3.0) {
                    currentScale += 0.25;
                    applyZoom();
                }
            });

            zoomOutBtn?.addEventListener('click', () => {
                if (currentScale > 0.5) {
                    currentScale -= 0.25;
                    applyZoom();
                }
            });

            zoomFitBtn?.addEventListener('click', () => {
                currentScale = 1.0;
                applyZoom();
            });

            pageInput.addEventListener('change', (e) => {
                let target = parseInt(e.target.value, 10);
                if (isNaN(target)) return;
                if (target < 1) target = 1;
                if (target > totalPages) target = totalPages;

                currentIndex = target - 1;
                updateDisplay();
            });

            document.addEventListener('keydown', (e) => {
                if (document.activeElement === pageInput) return;
                if (e.key === 'ArrowLeft') goToPrev();
                if (e.key === 'ArrowRight' || e.key === ' ') goToNext();
            });

            function attachThumbListeners() {
                document.querySelectorAll('.thumb-item').forEach(thumb => {
                    thumb.addEventListener('click', () => {
                        const idx = parseInt(thumb.getAttribute('data-index'), 10);
                        if (!isNaN(idx)) {
                            currentIndex = idx;
                            updateDisplay();
                        }
                    });
                });
            }

            attachThumbListeners();
            updateDisplay();
        });
    </script>
@endsection
