@extends('layouts.app')

@section('title', 'Interactive Comic - Scene 2 - ToonInput')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Toolbar -->
        <div class="glass-panel p-4.5 sm:p-6 rounded-3xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-extrabold font-mono shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Interactive Story • Node 2 of 3</span>
                </span>
                <h1 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 mt-1">Scene 2: The Secret Key</h1>
            </div>
            
            <!-- Node Progress Step Dots -->
            <div class="flex items-center gap-2">
                <a href="{{ route('comic.nodes', ['node' => 1]) }}" class="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-mono font-black flex items-center justify-center text-xs shadow-md shadow-emerald-600/30">✓</a>
                <span class="w-10 h-10 rounded-2xl bg-amber-500 text-white font-mono font-black flex items-center justify-center text-xs shadow-md shadow-amber-500/30">2</span>
                <a href="{{ route('comic.nodes', ['node' => 3]) }}" class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-mono font-bold flex items-center justify-center text-xs border border-slate-200 transition">3</a>
            </div>
        </div>

        <!-- Comic Panel Card -->
        <div class="glass-panel rounded-3xl overflow-hidden p-6 sm:p-8 space-y-6">
            
            <!-- Artwork with Speech Bubble -->
            <div class="relative aspect-video w-full rounded-2xl overflow-hidden bg-slate-950 border border-slate-800 flex items-center justify-center shadow-2xl">
                <img 
                    src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1200&q=80" 
                    alt="Comic Scene 2" 
                    class="w-full h-full object-cover opacity-90 hover:scale-105 transition-transform duration-700"
                />

                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                <!-- Speech Bubble -->
                <div class="absolute top-6 right-6 max-w-md bg-amber-300 text-slate-950 p-4 sm:p-5 rounded-3xl rounded-tr-none shadow-2xl border-2 border-amber-500 space-y-1 animate-float">
                    <span class="text-[10px] font-mono font-black text-amber-950 uppercase tracking-wider block">Mia exclaims:</span>
                    <p class="font-heading text-sm sm:text-base font-black leading-snug">"Hold on! We need the glowing golden key first. It's hiding behind the bookshelf!"</p>
                </div>
            </div>

            <!-- Context Hint -->
            <div class="bg-slate-50/80 border-l-4 border-amber-500 border-t border-r border-b border-slate-200/80 p-5 rounded-r-2xl space-y-1.5 shadow-2xs">
                <div class="flex items-center gap-2 text-xs font-mono font-black text-amber-800">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Context Clue (i+1 Comprehension):</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                    The expression <em>"glowing golden key"</em> is paired immediately with the shiny object held in the frame, solidifying meaning without rote memorization.
                </p>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                <a href="{{ route('comic.nodes', ['node' => 1]) }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    ← Scene 1
                </a>

                <a href="{{ route('comic.nodes', ['node' => 3]) }}" class="px-7 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs shadow-lg shadow-amber-500/30 hover:scale-105 transition-all flex items-center gap-2">
                    <span>Next Scene (Node 3)</span>
                    <span class="text-sm">→</span>
                </a>
            </div>

        </div>

    </div>
@endsection
