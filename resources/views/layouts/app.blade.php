<!DOCTYPE html>
<html lang="en" class="light scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ToonInput - Stress-Free Language Acquisition (Krashen Theory)')</title>
    <meta name="description" content="Acquire English naturally through animated shorts, graphic novels, web series, podcasts and comprehensible input (i+1). Zero anxiety, 100% immersion.">
    
    <!-- Google Fonts: Outfit, Plus Jakarta Sans, JetBrains Mono & Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN & Custom Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Outfit"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                            950: '#1e1b4b',
                        }
                    },
                    boxShadow: {
                        'glass': '0 20px 40px -15px rgba(15, 23, 42, 0.06), 0 0 1px 1px rgba(226, 232, 240, 0.8)',
                        'glass-hover': '0 25px 50px -12px rgba(99, 102, 241, 0.15), 0 0 1px 1px rgba(99, 102, 241, 0.2)',
                        'glow-indigo': '0 0 25px -5px rgba(99, 102, 241, 0.4)',
                        'glow-emerald': '0 0 25px -5px rgba(16, 185, 129, 0.35)',
                        'glow-amber': '0 0 25px -5px rgba(245, 158, 11, 0.35)',
                        'glow-rose': '0 0 25px -5px rgba(244, 63, 94, 0.35)',
                    }
                }
            }
        }
    </script>
    
    <style>
        :root {
            --canvas-mesh: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                           radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.06) 0px, transparent 50%),
                           radial-gradient(at 100% 100%, rgba(244, 63, 94, 0.05) 0px, transparent 50%),
                           radial-gradient(at 0% 100%, rgba(245, 158, 11, 0.05) 0px, transparent 50%),
                           #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            background-image: var(--canvas-mesh);
            background-attachment: fixed;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            letter-spacing: -0.025em;
        }

        /* Glassmorphic Utilities */
        .glass-panel {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .glass-dock {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.08);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(51, 65, 85, 0.6);
        }

        /* Gradient Text Utilities */
        .text-gradient-indigo {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-emerald {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-amber {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-rose {
            background: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { height: 8px; width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Subtle Micro-animations */
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-4px); }
        }
        .animate-float {
            animation: float-gentle 4s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.08); opacity: 0.4; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        .animate-pulse-ring {
            animation: pulse-ring 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Card Interactive Lift */
        .card-interactive {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-interactive:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 45px -12px rgba(99, 102, 241, 0.12), 0 0 1px 1px rgba(99, 102, 241, 0.15);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-indigo-600 selection:text-white">

    <!-- Top Glow Ambient Bar -->
    <div class="fixed top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-emerald-500 to-rose-500 z-50 pointer-events-none"></div>

    <!-- Header & Navigation (Floating Glass Dock) -->
    <header class="sticky top-2 z-40 px-3 sm:px-6 lg:px-8 py-2 transition-all">
        <div class="max-w-7xl mx-auto glass-dock rounded-2xl sm:rounded-full px-4 sm:px-6 py-2.5 shadow-sm">
            <div class="flex items-center justify-between gap-2 sm:gap-4">
                
                <!-- Brand Logo & Krashen i+1 Pill -->
                <a href="{{ route('catalog') }}" class="flex items-center gap-3 group focus:outline-none shrink-0">
                    <div class="relative w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 to-indigo-500 p-0.5 shadow-lg shadow-indigo-600/30 group-hover:scale-105 group-hover:shadow-indigo-600/40 transition-all duration-300 flex items-center justify-center text-white">
                        <svg class="w-5 h-5 drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-heading text-xl sm:text-2xl font-black tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors">
                                Toon<span class="text-indigo-600">Input</span>
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200/80 font-mono tracking-wider shadow-2xs">
                                i+1
                            </span>
                        </div>
                        <p class="text-[10px] text-slate-500 font-semibold tracking-tight hidden md:block">
                            Stress-Free Comprehensible Input
                        </p>
                    </div>
                </a>

                <!-- Navigation Tabs (Sleek High Contrast Pills) -->
                <nav class="hidden lg:flex items-center gap-1 bg-slate-100/90 p-1.5 rounded-full border border-slate-200/80 shadow-inner">
                    
                    <!-- Tab 1: Catalog -->
                    <a href="{{ route('catalog') }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('catalog') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                        <span>Catalog</span>
                    </a>

                    <!-- Tab 2: Tracker -->
                    <a href="{{ route('tracker') }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('tracker') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                        <span>Tracker</span>
                    </a>

                    <!-- Tab 3: Roulette -->
                    <a href="{{ route('roulette') }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('roulette') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                        <span>Roulette</span>
                    </a>

                    <!-- Tab 4: Comic Hub & Readers -->
                    <a href="{{ route('comic') }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ (request()->routeIs('comic') || request()->routeIs('comic-reader') || request()->routeIs('judas.reader') || request()->routeIs('comic.nodes')) ? 'bg-rose-600 text-white shadow-md shadow-rose-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                        <span>Comics</span>
                    </a>

                    <!-- Tab 5: Web Series -->
                    <a href="{{ route('series.index') }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ (request()->routeIs('series.index') || request()->routeIs('series.player')) ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                        <span>Series</span>
                    </a>

                    <!-- Tab 6: Podcasts -->
                    <a href="{{ route('podcasts.index') }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ (request()->routeIs('podcasts.index') || request()->routeIs('podcasts.player')) ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                        <span>Podcasts</span>
                    </a>

                    <!-- Tab 7: Theory -->
                    <a href="{{ route('theory') }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('theory') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                        <span>Theory</span>
                    </a>
                </nav>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-2">
                    <!-- Stephen Krashen Theory Quick Trigger -->
                    <button 
                        id="global-theory-btn" 
                        class="hidden sm:inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white hover:bg-indigo-50 text-indigo-700 hover:text-indigo-800 border border-indigo-200 text-xs font-extrabold transition-all duration-300 shadow-sm hover:shadow hover:scale-105 active:scale-95"
                        title="View Stephen Krashen's Comprehensible Input Theory">
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-ping"></span>
                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>SLA Theory</span>
                    </button>

                    <!-- Mobile Menu Hamburger -->
                    <button 
                        id="mobile-nav-toggle" 
                        class="lg:hidden p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition focus:outline-none"
                        aria-label="Toggle navigation menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Dropdown Navigation -->
            <div id="mobile-nav-menu" class="hidden lg:hidden pt-3 mt-3 border-t border-slate-200/80 space-y-1.5 text-xs font-bold">
                <a href="{{ route('catalog') }}" class="block px-3.5 py-2 rounded-xl {{ request()->routeIs('catalog') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">🎬 Video Catalog</a>
                <a href="{{ route('tracker') }}" class="block px-3.5 py-2 rounded-xl {{ request()->routeIs('tracker') ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">📊 Immersion Tracker</a>
                <a href="{{ route('roulette') }}" class="block px-3.5 py-2 rounded-xl {{ request()->routeIs('roulette') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">🎲 Input Roulette</a>
                <a href="{{ route('comic') }}" class="block px-3.5 py-2 rounded-xl {{ request()->routeIs('comic') ? 'bg-rose-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">📖 Comic Library</a>
                <a href="{{ route('series.index') }}" class="block px-3.5 py-2 rounded-xl {{ request()->routeIs('series.index') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">📺 Web Series</a>
                <a href="{{ route('podcasts.index') }}" class="block px-3.5 py-2 rounded-xl {{ request()->routeIs('podcasts.index') ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">🎙️ Audio Podcasts</a>
                <a href="{{ route('theory') }}" class="block px-3.5 py-2 rounded-xl {{ request()->routeIs('theory') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">💡 Krashen Theory</a>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full space-y-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-slate-200/90 glass-panel py-8 mt-16 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-[10px] font-black font-mono shadow-xs">
                    i+1
                </div>
                <p class="font-semibold text-slate-700">
                    © 2026 <span class="font-extrabold text-slate-900">ToonInput</span> • Built on Stephen Krashen's Comprehensible Input Hypothesis.
                </p>
            </div>
            <div class="flex items-center gap-4 text-slate-500 font-mono text-[11px]">
                <span class="inline-flex items-center gap-1.5 text-emerald-700 font-bold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>100% Static Client Architecture</span>
                </span>
                <span class="text-slate-300">•</span>
                <span class="text-slate-600 font-medium">Laravel • Tailwind • Vite</span>
            </div>
        </div>
    </footer>

    <!-- Global Stephen Krashen Theory Modal -->
    <div id="global-theory-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 bg-slate-950/70 backdrop-blur-md overflow-y-auto">
        <div class="relative w-full max-w-3xl bg-white border border-slate-200/90 rounded-3xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh] animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-500/30 border border-indigo-400/40 text-indigo-300 flex items-center justify-center font-black font-mono text-sm shadow-sm">
                        i+1
                    </div>
                    <div>
                        <h3 class="font-heading text-lg font-black text-white">Stephen Krashen's Comprehensible Input Theory</h3>
                        <p class="text-[11px] font-mono text-indigo-300">Second Language Acquisition (SLA) Framework</p>
                    </div>
                </div>
                <button id="close-global-theory-modal" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-full transition" title="Close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 sm:p-8 overflow-y-auto space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed bg-slate-50/50">
                <!-- Quote Banner -->
                <div class="p-5 bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200/80 rounded-2xl text-indigo-950 relative overflow-hidden shadow-xs">
                    <span class="text-xs font-mono font-extrabold text-indigo-700 uppercase tracking-wider block mb-1">Foundational Law of Acquisition:</span>
                    <blockquote class="italic text-sm sm:text-base font-semibold text-slate-900">
                        "We acquire language in only one way: when we understand messages; when we receive 'comprehensible input' in a low-anxiety environment."
                    </blockquote>
                    <p class="text-[11px] font-bold text-indigo-700 mt-2">— Dr. Stephen Krashen (University of Southern California)</p>
                </div>

                <!-- 4 Pillars Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-5 bg-white border border-slate-200/90 rounded-2xl shadow-xs space-y-2 card-interactive">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 font-mono font-black text-xs flex items-center justify-center">1</span>
                            <h4 class="text-slate-900 font-black text-xs uppercase tracking-wide">The Input Hypothesis (i+1)</h4>
                        </div>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            Language develops when the input is one step beyond your current stage (<em>i</em>), made comprehensible through rich visual context, body language, and narrative.
                        </p>
                    </div>

                    <div class="p-5 bg-white border border-slate-200/90 rounded-2xl shadow-xs space-y-2 card-interactive">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 font-mono font-black text-xs flex items-center justify-center">2</span>
                            <h4 class="text-slate-900 font-black text-xs uppercase tracking-wide">Low Affective Filter</h4>
                        </div>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            Fear of exams and stress actively block acquisition. ToonInput provides context descriptions before viewing to maintain zero stress.
                        </p>
                    </div>

                    <div class="p-5 bg-white border border-slate-200/90 rounded-2xl shadow-xs space-y-2 card-interactive">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-sky-100 text-sky-700 font-mono font-black text-xs flex items-center justify-center">3</span>
                            <h4 class="text-slate-900 font-black text-xs uppercase tracking-wide">Acquisition vs. Learning</h4>
                        </div>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            Acquisition is subconscious and natural, just like your mother tongue. Fluency emerges from meaningful input, not grammar drilling.
                        </p>
                    </div>

                    <div class="p-5 bg-white border border-slate-200/90 rounded-2xl shadow-xs space-y-2 card-interactive">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-amber-100 text-amber-700 font-mono font-black text-xs flex items-center justify-center">4</span>
                            <h4 class="text-slate-900 font-black text-xs uppercase tracking-wide">The Monitor Hypothesis</h4>
                        </div>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            Consciously learned grammar rules only serve as an editor. Comprehensible exposure builds your spontaneous internal language engine.
                        </p>
                    </div>
                </div>

                <!-- Footer Action CTA -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-slate-200">
                    <a href="{{ route('theory') }}" class="text-xs font-extrabold text-indigo-600 hover:text-indigo-800 flex items-center gap-1.5 transition">
                        <span>Read full scientific guide & interactive SLA matrix</span>
                        <span>→</span>
                    </a>
                    <button onclick="document.getElementById('close-global-theory-modal').click()" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-full text-xs shadow-md hover:shadow-lg transition">
                        Got it, Let's Acquire!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Handling Navigation & Global Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('global-theory-modal');
            const btn = document.getElementById('global-theory-btn');
            const closeBtn = document.getElementById('close-global-theory-modal');
            const mobileToggle = document.getElementById('mobile-nav-toggle');
            const mobileMenu = document.getElementById('mobile-nav-menu');

            btn?.addEventListener('click', () => modal?.classList.remove('hidden'));
            btn?.addEventListener('click', () => modal?.classList.add('flex'));
            closeBtn?.addEventListener('click', () => {
                modal?.classList.add('hidden');
                modal?.classList.remove('flex');
            });
            modal?.addEventListener('click', (e) => { 
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });

            // Mobile menu toggle
            mobileToggle?.addEventListener('click', () => {
                mobileMenu?.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
