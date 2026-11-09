@extends('layouts.app')

@section('title', 'Interactive Comic - Scene 3 - ToonInput')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Toolbar -->
        <div class="glass-panel p-4.5 sm:p-6 rounded-3xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-extrabold font-mono shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Interactive Story • Node 3 of 3 (Climax)</span>
                </span>
                <h1 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 mt-1">Scene 3: The Magic Discovery</h1>
            </div>
            
            <!-- Node Progress Step Dots -->
            <div class="flex items-center gap-2">
                <a href="{{ route('comic.nodes', ['node' => 1]) }}" class="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-mono font-black flex items-center justify-center text-xs shadow-md shadow-emerald-600/30">✓</a>
                <a href="{{ route('comic.nodes', ['node' => 2]) }}" class="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-mono font-black flex items-center justify-center text-xs shadow-md shadow-emerald-600/30">✓</a>
                <span class="w-10 h-10 rounded-2xl bg-indigo-600 text-white font-mono font-black flex items-center justify-center text-xs shadow-md shadow-indigo-600/30">3</span>
            </div>
        </div>

        <!-- Comic Panel Card -->
        <div class="glass-panel rounded-3xl overflow-hidden p-6 sm:p-8 space-y-6">
            
            <!-- Artwork with Speech Bubble -->
            <div class="relative aspect-video w-full rounded-2xl overflow-hidden bg-slate-950 border border-slate-800 flex items-center justify-center shadow-2xl">
                <img 
                    src="https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=1200&q=80" 
                    alt="Comic Scene 3" 
                    class="w-full h-full object-cover opacity-90 hover:scale-105 transition-transform duration-700"
                />

                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                <!-- Speech Bubble -->
                <div class="absolute bottom-6 left-6 max-w-md bg-indigo-600/95 backdrop-blur-md text-white p-4 sm:p-5 rounded-3xl rounded-bl-none shadow-2xl border-2 border-indigo-400 space-y-1 animate-float">
                    <span class="text-[10px] font-mono font-black text-amber-300 uppercase tracking-wider block">Together in awe:</span>
                    <p class="font-heading text-sm sm:text-base font-black leading-snug">"Wow! It opened! Look at all these floating starlight maps!"</p>
                </div>
            </div>

            <!-- Context Hint -->
            <div class="bg-slate-50/80 border-l-4 border-emerald-500 border-t border-r border-b border-slate-200/80 p-5 rounded-r-2xl space-y-1.5 shadow-2xs">
                <div class="flex items-center gap-2 text-xs font-mono font-black text-emerald-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Context Clue (Zero Affective Filter):</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                    Reaching the story climax lowers anxiety to zero. The words <em>"floating starlight maps"</em> are acquired naturally through visual awe and story engagement.
                </p>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                <a href="{{ route('comic.nodes', ['node' => 2]) }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    ← Scene 2
                </a>

                <a href="{{ route('comic') }}" class="px-7 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-lg shadow-emerald-600/30 hover:scale-105 transition-all flex items-center gap-2">
                    <span>Complete Story • Return to Hub</span>
                    <span>✓</span>
                </a>
            </div>

        </div>

    </div>
@endsection
