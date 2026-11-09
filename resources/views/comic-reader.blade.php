@extends('layouts.app')

@section('title', 'Shadowhunters: City of Bones - Web Comic Reader')

@section('content')
    <!-- PDF.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <div class="max-w-6xl mx-auto space-y-5">
        
        <!-- Navigation Hub & Comic Switcher Bar -->
        <div class="glass-panel p-3.5 px-6 rounded-2xl flex items-center justify-between gap-3">
            <a href="{{ route('comic') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-600 hover:text-indigo-600 transition-colors">
                <span>← Back to Comic Library</span>
            </a>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400 hidden sm:inline font-mono">Switch Title:</span>
                <a href="{{ route('judas.reader', ['chapter' => 1]) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-100/90 hover:bg-rose-50 hover:text-rose-600 text-slate-700 text-xs font-extrabold transition-all border border-slate-200 flex items-center gap-1.5 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>Judas (CBR)</span>
                </a>
            </div>
        </div>

        <!-- Sticky Immersive Reader Control Header -->
        <div class="sticky top-20 z-30 bg-slate-900/95 backdrop-blur-xl border border-slate-800 p-4 sm:p-5 rounded-3xl shadow-2xl flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Comic Title & Volume -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-600/20 border border-indigo-500/40 text-indigo-400 flex items-center justify-center font-black font-mono text-xs shadow-sm shrink-0">
                    PDF
                </div>
                <div>
                    <h1 class="font-heading text-lg sm:text-xl font-black text-white leading-tight">Shadowhunters: City of Bones</h1>
                    <p class="text-[11px] font-mono text-slate-400 font-semibold">Volume 1 • 219 Pages Graphic Novel</p>
                </div>
            </div>

            <!-- Reader Controls Toolbar -->
            <div class="flex flex-wrap items-center justify-center gap-2 bg-slate-950/90 p-2 rounded-2xl border border-slate-800/90 shadow-inner">
                
                <!-- Previous Button -->
                <button 
                    id="prev-page" 
                    class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-indigo-600 text-white font-extrabold text-xs transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-slate-800 flex items-center gap-1 shadow-sm">
                    <span>← Prev</span>
                </button>

                <!-- Page Direct Jump Input -->
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 rounded-xl border border-slate-800 text-xs font-mono text-slate-300">
                    <span>Page</span>
                    <input 
                        type="number" 
                        id="page-jump-input" 
                        min="1" 
                        value="1" 
                        class="w-14 bg-slate-950 border border-slate-700 text-center font-extrabold text-amber-400 rounded-lg py-0.5 focus:outline-none focus:border-indigo-500" 
                    />
                    <span>of <strong id="page-count" class="text-white">--</strong></span>
                </div>

                <!-- Next Button -->
                <button 
                    id="next-page" 
                    class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold text-xs transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-indigo-600 flex items-center gap-1 shadow-sm">
                    <span>Next →</span>
                </button>

                <!-- Zoom Mode Selectors -->
                <div class="flex items-center gap-1 pl-2 border-l border-slate-800">
                    <button id="zoom-out" class="px-2.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition" title="Zoom Out">-</button>
                    <button id="zoom-fit" class="px-2.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition font-mono" title="Fit to Screen">Fit</button>
                    <button id="zoom-in" class="px-2.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition" title="Zoom In">+</button>
                </div>

            </div>
        </div>

        <!-- Canvas Container Card (Dark Cinema Studio View) -->
        <div id="canvas-container" class="relative bg-slate-950 border border-slate-800/90 rounded-3xl p-3 sm:p-6 flex flex-col items-center justify-center min-h-[70vh] shadow-2xl overflow-hidden group">
            
            <!-- Loading Indicator -->
            <div id="pdf-loading" class="absolute inset-0 z-20 bg-slate-950/95 backdrop-blur-md flex flex-col items-center justify-center space-y-4">
                <div class="w-12 h-12 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                <div class="text-center space-y-1">
                    <p class="text-sm font-heading font-black text-white">Loading Graphic Novel PDF...</p>
                    <p class="text-xs font-mono text-indigo-400 animate-pulse">Rendering high-res comic panels</p>
                </div>
            </div>

            <!-- Hover Arrow Overlays (Left / Right) -->
            <button 
                id="floating-prev" 
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-slate-900/90 hover:bg-indigo-600 text-white font-extrabold flex items-center justify-center border border-slate-700 shadow-2xl opacity-0 group-hover:opacity-100 transition-all duration-300 disabled:hidden">
                ←
            </button>
            
            <button 
                id="floating-next" 
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-slate-900/90 hover:bg-indigo-600 text-white font-extrabold flex items-center justify-center border border-slate-700 shadow-2xl opacity-0 group-hover:opacity-100 transition-all duration-300 disabled:hidden">
                →
            </button>

            <!-- HTML5 PDF.js Responsive Canvas -->
            <div class="w-full flex items-center justify-center overflow-auto rounded-2xl border border-slate-800/80 bg-slate-900/80 p-2">
                <canvas id="pdf-canvas" class="rounded-xl shadow-2xl max-w-full h-auto transition-opacity duration-200 block"></canvas>
            </div>

        </div>

    </div>

    <!-- PDF.js Engine Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const url = '/comics/volumen1.pdf';

            // Configure PDF.js CDN worker
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            let pdfDoc = null;
            let pageNum = 1;
            let pageRendering = false;
            let pageNumPending = null;
            let currentScale = 1.0;
            let isAutoFit = true;

            const canvas = document.getElementById('pdf-canvas');
            const ctx = canvas.getContext('2d');
            const pageCountEl = document.getElementById('page-count');
            const pageJumpInput = document.getElementById('page-jump-input');
            const prevBtn = document.getElementById('prev-page');
            const nextBtn = document.getElementById('next-page');
            const floatPrev = document.getElementById('floating-prev');
            const floatNext = document.getElementById('floating-next');
            const loadingEl = document.getElementById('pdf-loading');
            const container = document.getElementById('canvas-container');

            const zoomInBtn = document.getElementById('zoom-in');
            const zoomOutBtn = document.getElementById('zoom-out');
            const zoomFitBtn = document.getElementById('zoom-fit');

            function renderPage(num) {
                pageRendering = true;

                pdfDoc.getPage(num).then(page => {
                    const unscaledViewport = page.getViewport({ scale: 1.0 });

                    if (isAutoFit) {
                        const availableWidth = container.clientWidth - 48;
                        const availableHeight = window.innerHeight * 0.75;
                        const scaleW = availableWidth / unscaledViewport.width;
                        const scaleH = availableHeight / unscaledViewport.height;
                        currentScale = Math.min(scaleW, scaleH, 1.8);
                        if (currentScale < 0.5) currentScale = 0.5;
                    }

                    const viewport = page.getViewport({ scale: currentScale });
                    const outputScale = window.devicePixelRatio || 1;

                    canvas.width = Math.floor(viewport.width * outputScale);
                    canvas.height = Math.floor(viewport.height * outputScale);
                    canvas.style.width = Math.floor(viewport.width) + "px";
                    canvas.style.height = Math.floor(viewport.height) + "px";

                    const transform = outputScale !== 1 
                        ? [outputScale, 0, 0, outputScale, 0, 0] 
                        : null;

                    const renderContext = {
                        canvasContext: ctx,
                        transform: transform,
                        viewport: viewport
                    };

                    const renderTask = page.render(renderContext);

                    renderTask.promise.then(() => {
                        pageRendering = false;
                        if (pageNumPending !== null) {
                            renderPage(pageNumPending);
                            pageNumPending = null;
                        }
                    });
                });

                // Update UI state
                pageJumpInput.value = num;
                prevBtn.disabled = (num <= 1);
                nextBtn.disabled = (num >= pdfDoc.numPages);
                floatPrev.disabled = (num <= 1);
                floatNext.disabled = (num >= pdfDoc.numPages);
            }

            function queueRenderPage(num) {
                if (pageRendering) {
                    pageNumPending = num;
                } else {
                    renderPage(num);
                }
            }

            function onPrevPage() {
                if (pageNum <= 1) return;
                pageNum--;
                queueRenderPage(pageNum);
            }

            function onNextPage() {
                if (pageNum >= pdfDoc.numPages) return;
                pageNum++;
                queueRenderPage(pageNum);
            }

            prevBtn?.addEventListener('click', onPrevPage);
            nextBtn?.addEventListener('click', onNextPage);
            floatPrev?.addEventListener('click', onPrevPage);
            floatNext?.addEventListener('click', onNextPage);

            // Direct page jump input
            pageJumpInput?.addEventListener('change', (e) => {
                let target = parseInt(e.target.value, 10);
                if (isNaN(target) || target < 1) target = 1;
                if (target > pdfDoc.numPages) target = pdfDoc.numPages;

                pageNum = target;
                queueRenderPage(pageNum);
            });

            // Zoom Handlers
            zoomInBtn?.addEventListener('click', () => {
                isAutoFit = false;
                currentScale += 0.25;
                queueRenderPage(pageNum);
            });

            zoomOutBtn?.addEventListener('click', () => {
                isAutoFit = false;
                if (currentScale > 0.4) {
                    currentScale -= 0.25;
                    queueRenderPage(pageNum);
                }
            });

            zoomFitBtn?.addEventListener('click', () => {
                isAutoFit = true;
                queueRenderPage(pageNum);
            });

            // Keyboard Shortcuts
            document.addEventListener('keydown', (e) => {
                if (document.activeElement === pageJumpInput) return;
                if (e.key === 'ArrowLeft') onPrevPage();
                if (e.key === 'ArrowRight' || e.key === ' ') onNextPage();
            });

            // Window Resize Auto-Fit
            window.addEventListener('resize', () => {
                if (isAutoFit && pdfDoc) {
                    queueRenderPage(pageNum);
                }
            });

            // Load PDF File
            pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
                pdfDoc = pdfDoc_;
                pageCountEl.textContent = pdfDoc.numPages;
                pageJumpInput.max = pdfDoc.numPages;
                loadingEl.classList.add('hidden');

                renderPage(pageNum);
            }).catch(err => {
                console.error('PDF loading error:', err);
                loadingEl.innerHTML = `
                    <div class="p-6 bg-slate-900 border border-rose-800 rounded-2xl text-center space-y-2 max-w-md">
                        <p class="text-rose-400 font-extrabold text-sm">Failed to load public/comics/volumen1.pdf</p>
                        <p class="text-xs text-slate-400 font-mono">${err.message}</p>
                    </div>
                `;
            });
        });
    </script>
@endsection
