@extends('layouts.app')

@section('title', 'Graphic Novels & Comic Readers - ToonInput')

@section('content')
    <div class="max-w-6xl mx-auto space-y-10">
        
        <!-- Header Banner (Editorial Glass Canvas) -->
        <div class="glass-panel rounded-3xl p-6 sm:p-10 shadow-sm space-y-4 relative overflow-hidden">
            <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-800 text-xs font-extrabold font-mono shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span>
                <span>Visual Immersion • Graphic Novels & Readers</span>
            </div>
            
            <h1 class="font-heading text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Comic Library & <span class="text-gradient-rose">Web Readers</span>
            </h1>
            
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-medium max-w-2xl">
                Absorb rich narrative structures and colloquial dialogues through beautifully rendered graphic novels. Visual cues anchor comprehension directly into your subconscious.
            </p>
        </div>

        <!-- Featured Comic Collection Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Comic Card 1: Shadowhunters -->
            <div class="glass-panel rounded-3xl overflow-hidden card-interactive flex flex-col justify-between group border-indigo-200/60">
                <div class="p-6 sm:p-8 space-y-5">
                    
                    <!-- Badges -->
                    <div class="flex items-center justify-between gap-2">
                        <span class="px-3 py-1 rounded-xl text-xs font-mono font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200 shadow-2xs">
                            Format: PDF
                        </span>
                        <span class="px-3 py-1 rounded-xl text-xs font-mono font-black bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                            219 Pages
                        </span>
                    </div>

                    <!-- Title & Authors -->
                    <div class="space-y-1.5">
                        <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors">
                            Shadowhunters: City of Bones
                        </h2>
                        <p class="text-xs font-semibold text-slate-500">
                            <span class="text-slate-900 font-extrabold">Creators:</span> Cassandra Clare (Script) & Cassandra Jean (Art)
                        </p>
                    </div>

                    <!-- Genre Pills -->
                    <div class="flex flex-wrap gap-1.5">
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-200 font-mono">Urban Fantasy</span>
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-200 font-mono">Action</span>
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-200 font-mono">Graphic Novel</span>
                    </div>

                    <!-- Description -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        A graphic novel adaptation of the Shadowhunters saga. Follow Clary Fray as she discovers subterranean demons, runes, and secret warriors across New York City.
                    </p>

                </div>

                <!-- Footer Action Button -->
                <div class="p-6 pt-0">
                    <a 
                        href="{{ route('comic-reader') }}" 
                        class="w-full py-3.5 px-6 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs shadow-lg shadow-indigo-600/30 transition-all duration-200 flex items-center justify-center gap-2 group-hover:scale-[1.01]">
                        <span>Open PDF Reader (Shadowhunters)</span>
                        <span class="text-sm">→</span>
                    </a>
                </div>
            </div>

            <!-- Comic Card 2: Judas -->
            <div class="glass-panel rounded-3xl overflow-hidden card-interactive flex flex-col justify-between group border-rose-200/60">
                <div class="p-6 sm:p-8 space-y-5">
                    
                    <!-- Badges -->
                    <div class="flex items-center justify-between gap-2">
                        <span class="px-3 py-1 rounded-xl text-xs font-mono font-extrabold bg-rose-50 text-rose-700 border border-rose-200 shadow-2xs">
                            Format: JPG
                        </span>
                        <span class="px-3 py-1 rounded-xl text-xs font-mono font-black bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                            4 Chapters (120 Pages)
                        </span>
                    </div>

                    <!-- Title & Authors -->
                    <div class="space-y-1.5">
                        <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 group-hover:text-rose-600 transition-colors">
                            Judas
                        </h2>
                        <p class="text-xs font-semibold text-slate-500">
                            <span class="text-slate-900 font-extrabold">Creators:</span> Jeff Loveness (Script) & Jakub Rebelka (Art)
                        </p>
                    </div>

                    <!-- Genre Pills -->
                    <div class="flex flex-wrap gap-1.5">
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-200 font-mono">Dark Fantasy</span>
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-200 font-mono">Mythology</span>
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-200 font-mono">Award Nominated</span>
                    </div>

                    <!-- Description -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        A tragic mythological exploration of Judas Iscariot's journey through the Underworld. Acclaimed visual storytelling with breathtaking illustration and deep emotional prose.
                    </p>

                </div>

                <!-- Footer Action Button -->
                <div class="p-6 pt-0">
                    <a 
                        href="{{ route('judas.reader', ['chapter' => 1]) }}" 
                        class="w-full py-3.5 px-6 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-lg shadow-rose-600/30 transition-all duration-200 flex items-center justify-center gap-2 group-hover:scale-[1.01]">
                        <span>Open Reader (Judas)</span>
                        <span class="text-sm">→</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Extra Section: Interactive Node Stories -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm border border-slate-200/90 relative overflow-hidden">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-0.5 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-800 border border-indigo-200 uppercase tracking-wider font-mono">
                        Guided Immersion Mode
                    </span>
                    <span class="text-xs font-mono text-indigo-600 font-bold">Scene Nodes 1 - 3</span>
                </div>
                <h3 class="font-heading text-xl font-black text-slate-900">
                    Interactive Context Comic (Guided Walkthrough)
                </h3>
                <p class="text-xs text-slate-600 font-medium max-w-xl">
                    Experience interactive scenes with embedded speech bubbles and pedagogical Krashen hints to deduce vocabulary naturally.
                </p>
            </div>

            <a 
                href="{{ route('comic.nodes', ['node' => 1]) }}" 
                class="px-6 py-3.5 rounded-2xl bg-slate-900 hover:bg-indigo-600 text-white font-extrabold text-xs transition-all whitespace-nowrap shadow-md hover:shadow-lg flex items-center gap-2 group">
                <span>Launch Node Scenes</span>
                <span class="group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

    </div>
@endsection
