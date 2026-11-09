@extends('layouts.app')

@section('title', 'Comprehensible Input Theory - Stephen Krashen - ToonInput')

@section('content')
    <div class="max-w-6xl mx-auto space-y-12 pb-16">
        
        <!-- Header Banner & Hero Image (Editorial Glass Studio Canvas) -->
        <div class="glass-panel rounded-3xl p-6 sm:p-10 shadow-sm space-y-6 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                <div class="lg:col-span-7 space-y-4">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-extrabold font-mono shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        <span>Second Language Acquisition (SLA) Linguistic Framework</span>
                    </span>

                    <h1 class="font-heading text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        Stephen Krashen's <br/>
                        <span class="text-gradient-indigo">Comprehensible Input Theory</span>
                    </h1>

                    <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-medium">
                        Explore the foundational scientific framework behind natural, stress-free language acquisition. Learn how human brains acquire language through meaningful messages, subconscious processing, and optimal psychological conditions.
                    </p>

                    <!-- Quick Navigation Anchor Pills -->
                    <div class="flex flex-wrap gap-2 pt-2">
                        <a href="#acquisition-vs-learning" class="px-3 py-1.5 rounded-xl bg-slate-100/90 hover:bg-indigo-600 text-slate-700 hover:text-white text-xs font-extrabold transition border border-slate-200 shadow-2xs">1. Acquisition vs Learning</a>
                        <a href="#input-definition" class="px-3 py-1.5 rounded-xl bg-slate-100/90 hover:bg-indigo-600 text-slate-700 hover:text-white text-xs font-extrabold transition border border-slate-200 shadow-2xs">2. The i+1 Formula</a>
                        <a href="#positive-aspects" class="px-3 py-1.5 rounded-xl bg-slate-100/90 hover:bg-indigo-600 text-slate-700 hover:text-white text-xs font-extrabold transition border border-slate-200 shadow-2xs">3. Key Advantages</a>
                        <a href="#limitations" class="px-3 py-1.5 rounded-xl bg-slate-100/90 hover:bg-indigo-600 text-slate-700 hover:text-white text-xs font-extrabold transition border border-slate-200 shadow-2xs">4. Academic Critiques</a>
                        <a href="#affective-filter" class="px-3 py-1.5 rounded-xl bg-slate-100/90 hover:bg-indigo-600 text-slate-700 hover:text-white text-xs font-extrabold transition border border-slate-200 shadow-2xs">5. Affective Filter</a>
                    </div>
                </div>

                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-full max-w-sm rounded-3xl overflow-hidden border border-slate-200 shadow-lg group">
                        <img 
                            src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=800&q=80" 
                            alt="Reading and Language Acquisition" 
                            class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-center">
                            <span class="text-[11px] font-mono font-bold text-white bg-slate-900/90 px-3.5 py-1.5 rounded-full border border-slate-700 backdrop-blur-md shadow-sm">
                                "We acquire language when we understand messages."
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 1: ACQUISITION VS LEARNING -->
        <section id="acquisition-vs-learning" class="glass-panel rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-6">
                <div>
                    <span class="text-xs font-mono font-extrabold text-indigo-600 uppercase tracking-wider block">Part 1</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900">Language Acquisition vs. Language Learning</h2>
                </div>
                <div class="px-3.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-extrabold font-mono border border-indigo-200 w-max shadow-2xs">
                    Subconscious vs. Conscious
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-4 text-slate-700 text-xs sm:text-sm leading-relaxed font-medium">
                    <p>
                        In Stephen Krashen's theoretical framework, human beings possess two distinct systems for developing second language competence: <strong class="text-slate-900 font-extrabold">Acquisition</strong> and <strong class="text-slate-900 font-extrabold">Learning</strong>.
                    </p>
                    <div class="p-4 bg-slate-50/90 rounded-2xl border border-slate-200 space-y-1.5 shadow-2xs">
                        <h4 class="font-black text-xs uppercase tracking-wider text-indigo-700">The Acquisition Process:</h4>
                        <p class="text-xs text-slate-600">
                            Similar to how children acquire their first native language, acquisition happens <em>subconsciously</em> when focusing on meaning, visual context, and narrative comprehension without explicit grammar study.
                        </p>
                    </div>
                    <div class="p-4 bg-slate-50/90 rounded-2xl border border-slate-200 space-y-1.5 shadow-2xs">
                        <h4 class="font-black text-xs uppercase tracking-wider text-rose-700">The Learning Process:</h4>
                        <p class="text-xs text-slate-600">
                            Learning is a <em>conscious</em>, analytical process involving explicit grammar memorization, syntax rules, error correction, and formal classroom testing.
                        </p>
                    </div>
                </div>

                <!-- Interactive Comparison Toggle Matrix -->
                <div class="bg-slate-950 text-white rounded-3xl p-6 shadow-2xl border border-slate-800 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-heading font-black text-base text-indigo-400">Interactive Comparison Matrix</h3>
                        <span class="text-[11px] font-mono text-slate-400">Click tabs to switch</span>
                    </div>

                    <!-- Mode Selector Buttons -->
                    <div class="grid grid-cols-2 gap-2 bg-slate-900 p-1.5 rounded-2xl border border-slate-800">
                        <button id="btn-mode-acq" class="py-2 px-4 rounded-xl text-xs font-extrabold transition-all bg-indigo-600 text-white shadow-md shadow-indigo-600/30">
                            Subconscious Acquisition
                        </button>
                        <button id="btn-mode-learn" class="py-2 px-4 rounded-xl text-xs font-extrabold transition-all text-slate-400 hover:text-white">
                            Conscious Learning
                        </button>
                    </div>

                    <!-- Dynamic Card Content -->
                    <div id="matrix-display-box" class="space-y-3 bg-slate-900/60 p-5 rounded-2xl border border-slate-800">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: DEFINITION OF INPUT (i+1) -->
        <section id="input-definition" class="glass-panel rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-6">
                <div>
                    <span class="text-xs font-mono font-extrabold text-indigo-600 uppercase tracking-wider block">Part 2</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900">Definition of Input as a Linguistic Theory</h2>
                </div>
                <div class="px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-200 w-max font-mono shadow-2xs">
                    Formula: i + 1
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-6 space-y-4 text-slate-700 text-xs sm:text-sm leading-relaxed font-medium">
                    <h3 class="font-heading text-xl font-black text-slate-900">How Language Enters the Brain</h3>
                    <p>
                        According to Krashen's Input Hypothesis, humans acquire language in only one way: by receiving <strong class="text-slate-900 font-extrabold">Comprehensible Input</strong>. Input becomes comprehensible when the listener or reader understands the overall message, supported by visual illustrations, gestures, real-world context, and prior knowledge.
                    </p>
                    <div class="p-4 bg-indigo-50/80 rounded-2xl border border-indigo-200 text-indigo-950 space-y-2 shadow-2xs">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-indigo-600 text-white font-mono font-black text-xs flex items-center justify-center shadow-xs">i+1</span>
                            <h4 class="font-black text-xs uppercase tracking-wider text-indigo-900 font-mono">The i+1 Formula:</h4>
                        </div>
                        <p class="text-xs text-indigo-950 leading-relaxed font-medium">
                            Where <strong>'i'</strong> represents your current linguistic stage, and <strong>'+1'</strong> represents the next immediate level of language structure that is slightly beyond your level, made clear through contextual visual anchors.
                        </p>
                    </div>
                </div>

                <!-- Interactive i+1 Comprehensibility Simulator -->
                <div class="lg:col-span-6 bg-slate-950 text-white rounded-3xl p-6 shadow-2xl border border-slate-800 space-y-6">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-heading font-black text-base text-emerald-400">Interactive i+1 Simulator</h3>
                            <span id="sim-level-badge" class="text-xs font-mono font-extrabold px-2.5 py-0.5 rounded-md bg-emerald-950 text-emerald-400 border border-emerald-800">
                                i + 1 (Optimal Zone)
                            </span>
                        </div>
                        <p class="text-xs text-slate-400">Drag the slider to test different input difficulty zones:</p>
                    </div>

                    <!-- Slider Control -->
                    <div class="space-y-2">
                        <input 
                            type="range" 
                            id="i-plus-slider" 
                            min="0" 
                            max="100" 
                            value="50" 
                            class="w-full h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-500" 
                        />
                        <div class="flex justify-between text-[10px] font-mono text-slate-400 font-bold">
                            <span>0% (i+0 Too Easy)</span>
                            <span class="text-emerald-400 font-extrabold">50% (i+1 Sweet Spot)</span>
                            <span>100% (i+10 Noise)</span>
                        </div>
                    </div>

                    <!-- Simulator Live Display Result Box -->
                    <div id="sim-display-box" class="p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-3">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3: POSITIVE ASPECTS OF APPLICATION -->
        <section id="positive-aspects" class="glass-panel rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-6">
                <div>
                    <span class="text-xs font-mono font-extrabold text-indigo-600 uppercase tracking-wider block">Part 3</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900">Key Advantages & Benefits</h2>
                </div>
                <div class="px-3.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-extrabold font-mono border border-blue-200 w-max shadow-2xs">
                    Strengths
                </div>
            </div>

            <!-- Benefits Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="p-6 bg-slate-50/90 rounded-3xl border border-slate-200/90 space-y-3 hover:shadow-md transition card-interactive">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 font-black text-sm flex items-center justify-center font-mono shadow-2xs">
                        01
                    </div>
                    <h3 class="font-heading text-lg font-black text-slate-900">Reduced Anxiety & Stress</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                        By prioritizing receptive understanding over forced early speech production, learners experience significantly lower performance anxiety, fostering higher engagement.
                    </p>
                </div>

                <div class="p-6 bg-slate-50/90 rounded-3xl border border-slate-200/90 space-y-3 hover:shadow-md transition card-interactive">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 font-black text-sm flex items-center justify-center font-mono shadow-2xs">
                        02
                    </div>
                    <h3 class="font-heading text-lg font-black text-slate-900">Natural Intuitive Fluency</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                        Acquired language is stored in deep implicit memory, allowing native-like spontaneous output without the cognitive bottleneck of translating grammar rules in real time.
                    </p>
                </div>

                <div class="p-6 bg-slate-50/90 rounded-3xl border border-slate-200/90 space-y-3 hover:shadow-md transition card-interactive">
                    <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-700 font-black text-sm flex items-center justify-center font-mono shadow-2xs">
                        03
                    </div>
                    <h3 class="font-heading text-lg font-black text-slate-900">High Long-Term Retention</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                        Contextualized visual reading (such as graphic novels and animated shorts) creates rich multimodal neural connections, anchoring vocabulary far better than isolated flashcards.
                    </p>
                </div>

            </div>
        </section>

        <!-- SECTION 4: NEGATIVE ASPECTS AND LIMITATIONS -->
        <section id="limitations" class="glass-panel rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-6">
                <div>
                    <span class="text-xs font-mono font-extrabold text-indigo-600 uppercase tracking-wider block">Part 4</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900">Academic Critiques & Limitations</h2>
                </div>
                <div class="px-3.5 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold font-mono border border-amber-200 w-max shadow-2xs">
                    Linguistic Debate
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 font-medium max-w-3xl">
                While revolutionary, Krashen's theory has faced scrutiny from second language acquisition researchers (such as Merrill Swain and Michael Long). Click each point below to expand the analysis:
            </p>

            <!-- Expandable Limitation Accordion -->
            <div class="space-y-3 max-w-4xl">
                
                <!-- Item 1 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                    <button class="accordion-header w-full p-4 bg-slate-50/90 hover:bg-slate-100 text-left flex items-center justify-between font-heading font-black text-sm text-slate-900 transition">
                        <span>1. Difficulty in Operationalizing 'i+1'</span>
                        <span class="accordion-icon text-indigo-600 font-mono font-bold text-base">+</span>
                    </button>
                    <div class="accordion-content p-4 bg-white text-xs text-slate-600 leading-relaxed font-medium hidden border-t border-slate-100">
                        Critics point out that 'i+1' is vague and difficult to quantify empirically. What constitutes '+1' varies widely between individual learners, making it challenging for educators to precisely calibrate input difficulty in mixed-level classrooms.
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                    <button class="accordion-header w-full p-4 bg-slate-50/90 hover:bg-slate-100 text-left flex items-center justify-between font-heading font-black text-sm text-slate-900 transition">
                        <span>2. Neglect of Output (Swain's Output Hypothesis)</span>
                        <span class="accordion-icon text-indigo-600 font-mono font-bold text-base">+</span>
                    </button>
                    <div class="accordion-content p-4 bg-white text-xs text-slate-600 leading-relaxed font-medium hidden border-t border-slate-100">
                        Linguist Merrill Swain argued that input alone is insufficient for high-level accuracy. Producing output (speaking and writing) forces learners to process language syntactically rather than just semantically, noticing gaps in their own production.
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                    <button class="accordion-header w-full p-4 bg-slate-50/90 hover:bg-slate-100 text-left flex items-center justify-between font-heading font-black text-sm text-slate-900 transition">
                        <span>3. Fossilization & Delayed Grammatical Precision</span>
                        <span class="accordion-icon text-indigo-600 font-mono font-bold text-base">+</span>
                    </button>
                    <div class="accordion-content p-4 bg-white text-xs text-slate-600 leading-relaxed font-medium hidden border-t border-slate-100">
                        Relying exclusively on implicit comprehension can lead to grammatical fossilization, where a learner understands everything and communicates effectively, but continues making systematic grammatical errors without explicit feedback.
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION 5: PSYCHOLOGICAL VARIABLES (AFFECTIVE FILTER) -->
        <section id="affective-filter" class="glass-panel rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-6">
                <div>
                    <span class="text-xs font-mono font-extrabold text-indigo-600 uppercase tracking-wider block">Part 5</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900">Psychological Variables: The Affective Filter</h2>
                </div>
                <div class="px-3.5 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-extrabold font-mono border border-rose-200 w-max shadow-2xs">
                    Mental Gateway
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <div class="lg:col-span-6 space-y-4 text-slate-700 text-xs sm:text-sm leading-relaxed font-medium">
                    <h3 class="font-heading text-xl font-black text-slate-900">The Emotional Screen in the Brain</h3>
                    <p>
                        The <strong class="text-slate-900 font-extrabold">Affective Filter Hypothesis</strong> posits that emotional and psychological variables act as an invisible mental barrier that can either allow or block input from reaching the Language Acquisition Device (LAD) in the brain.
                    </p>
                    
                    <div class="space-y-2">
                        <div class="p-3 bg-slate-50/90 rounded-xl border border-slate-200 flex items-center gap-3 shadow-2xs">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 shrink-0"></span>
                            <div class="text-xs">
                                <strong class="text-slate-900">Motivation:</strong> High intrinsic interest opens the filter.
                            </div>
                        </div>

                        <div class="p-3 bg-slate-50/90 rounded-xl border border-slate-200 flex items-center gap-3 shadow-2xs">
                            <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0"></span>
                            <div class="text-xs">
                                <strong class="text-slate-900">Self-Confidence:</strong> Strong self-esteem enhances intake.
                            </div>
                        </div>

                        <div class="p-3 bg-slate-50/90 rounded-xl border border-slate-200 flex items-center gap-3 shadow-2xs">
                            <span class="w-3 h-3 rounded-full bg-rose-500 shrink-0"></span>
                            <div class="text-xs">
                                <strong class="text-slate-900">Anxiety:</strong> High anxiety raises a wall, blocking acquisition.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interactive Affective Filter Gateway Simulator -->
                <div class="lg:col-span-6 bg-slate-950 text-white rounded-3xl p-6 shadow-2xl border border-slate-800 space-y-6">
                    <div class="space-y-1">
                        <h3 class="font-heading font-black text-base text-rose-400">Interactive Affective Filter Gateway</h3>
                        <p class="text-xs text-slate-400">Adjust emotional variables to test input absorption into the brain:</p>
                    </div>

                    <!-- Sliders -->
                    <div class="space-y-4 text-xs font-mono">
                        <!-- Anxiety Slider -->
                        <div class="space-y-1">
                            <div class="flex justify-between">
                                <span class="text-rose-400 font-bold">Anxiety Level:</span>
                                <span id="anxiety-val" class="font-bold">Low (20%)</span>
                            </div>
                            <input type="range" id="anxiety-slider" min="0" max="100" value="20" class="w-full h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-rose-500" />
                        </div>

                        <!-- Motivation Slider -->
                        <div class="space-y-1">
                            <div class="flex justify-between">
                                <span class="text-emerald-400 font-bold">Motivation Level:</span>
                                <span id="motivation-val" class="font-bold font-mono">High (80%)</span>
                            </div>
                            <input type="range" id="motivation-slider" min="0" max="100" value="80" class="w-full h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-emerald-500" />
                        </div>
                    </div>

                    <!-- Visual Brain Absorption Meter -->
                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 space-y-3 text-center">
                        <span class="text-[11px] font-mono text-slate-400 uppercase tracking-wider block">Input Absorbed by Language Acquisition Device (LAD):</span>
                        <div class="w-full bg-slate-800 h-6 rounded-full overflow-hidden p-1 border border-slate-700 shadow-inner">
                            <div id="filter-bar" class="h-full bg-gradient-to-r from-emerald-500 to-indigo-500 rounded-full transition-all duration-300 w-[80%]"></div>
                        </div>
                        <p id="filter-status-text" class="text-xs font-mono font-extrabold text-emerald-400">
                            Filter Status: OPEN (90% Language Absorbed Effortlessly)
                        </p>
                    </div>

                </div>

            </div>
        </section>

    </div>

    <!-- Script handling all interactive theory components -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- 1. Acquisition vs Learning Interactive Matrix ---
            const btnAcq = document.getElementById('btn-mode-acq');
            const btnLearn = document.getElementById('btn-mode-learn');
            const matrixBox = document.getElementById('matrix-display-box');

            const acqData = [
                { title: 'Cognitive Process', desc: 'Subconscious assimilation of structures through context and reading.' },
                { title: 'Primary Focus', desc: 'Focus on MEANING, story, and communicative intent.' },
                { title: 'Error Sensitivity', desc: 'Errors are natural developmental steps; no explicit corrections.' },
                { title: 'Long-term Result', desc: 'Spontaneous, native-like intuition and automatic speech output.' }
            ];

            const learnData = [
                { title: 'Cognitive Process', desc: 'Conscious memorization of explicit rules and syntax diagrams.' },
                { title: 'Primary Focus', desc: 'Focus on FORM, grammatical correctness, and sentence structure.' },
                { title: 'Error Sensitivity', desc: 'Errors are corrected immediately to prevent bad habits.' },
                { title: 'Long-term Result', desc: 'Conscious monitoring and translation before speaking.' }
            ];

            function renderMatrix(isAcquisition) {
                const data = isAcquisition ? acqData : learnData;
                matrixBox.innerHTML = data.map(item => `
                    <div class="space-y-0.5">
                        <span class="text-[10px] font-mono font-extrabold uppercase tracking-wider ${isAcquisition ? 'text-indigo-400' : 'text-rose-400'}">${item.title}</span>
                        <p class="text-xs font-medium text-slate-200 leading-snug">${item.desc}</p>
                    </div>
                `).join('');

                if (isAcquisition) {
                    btnAcq.className = 'py-2 px-4 rounded-xl text-xs font-extrabold transition-all bg-indigo-600 text-white shadow-md shadow-indigo-600/30';
                    btnLearn.className = 'py-2 px-4 rounded-xl text-xs font-extrabold transition-all text-slate-400 hover:text-white';
                } else {
                    btnLearn.className = 'py-2 px-4 rounded-xl text-xs font-extrabold transition-all bg-rose-600 text-white shadow-md shadow-rose-600/30';
                    btnAcq.className = 'py-2 px-4 rounded-xl text-xs font-extrabold transition-all text-slate-400 hover:text-white';
                }
            }

            btnAcq?.addEventListener('click', () => renderMatrix(true));
            btnLearn?.addEventListener('click', () => renderMatrix(false));
            renderMatrix(true);


            // --- 2. Interactive i+1 Simulator ---
            const iSlider = document.getElementById('i-plus-slider');
            const simBadge = document.getElementById('sim-level-badge');
            const simBox = document.getElementById('sim-display-box');

            function updateSimulator() {
                const val = parseInt(iSlider.value, 10);
                let badgeText = '';
                let resultHTML = '';

                if (val < 35) {
                    badgeText = 'i + 0 (Too Easy)';
                    simBadge.className = 'text-xs font-mono font-extrabold px-2.5 py-0.5 rounded-md bg-slate-800 text-slate-300 border border-slate-700';
                    resultHTML = `
                        <p class="text-xs text-slate-300 font-extrabold">Boredom Zone:</p>
                        <p class="text-xs text-slate-400 leading-normal">The material contains no new vocabulary or structures. The brain experiences zero cognitive acquisition challenge.</p>
                    `;
                } else if (val <= 65) {
                    badgeText = 'i + 1 (Optimal Zone)';
                    simBadge.className = 'text-xs font-mono font-extrabold px-2.5 py-0.5 rounded-md bg-emerald-950 text-emerald-400 border border-emerald-800';
                    resultHTML = `
                        <p class="text-xs text-emerald-400 font-extrabold">Optimal Acquisition Zone (80-85% Comprehension):</p>
                        <p class="text-xs text-slate-200 leading-normal font-medium">The reader understands the story context while effortlessly absorbing 15-20% new vocabulary through visual clues!</p>
                    `;
                } else {
                    badgeText = 'i + 10 (Incomprehensible Noise)';
                    simBadge.className = 'text-xs font-mono font-extrabold px-2.5 py-0.5 rounded-md bg-rose-950 text-rose-400 border border-rose-800';
                    resultHTML = `
                        <p class="text-xs text-rose-400 font-extrabold">Frustration Zone:</p>
                        <p class="text-xs text-slate-400 leading-normal">The material is overwhelming. Without contextual understanding, the brain treats the input as meaningless noise.</p>
                    `;
                }

                simBadge.textContent = badgeText;
                simBox.innerHTML = resultHTML;
            }

            iSlider?.addEventListener('input', updateSimulator);
            updateSimulator();


            // --- 3. Accordion Handler ---
            document.querySelectorAll('.accordion-header').forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling;
                    const icon = header.querySelector('.accordion-icon');
                    
                    const isOpen = !content.classList.contains('hidden');
                    
                    // Close all
                    document.querySelectorAll('.accordion-content').forEach(c => c.classList.add('hidden'));
                    document.querySelectorAll('.accordion-icon').forEach(i => i.textContent = '+');

                    if (!isOpen) {
                        content.classList.remove('hidden');
                        icon.textContent = '−';
                    }
                });
            });


            // --- 4. Affective Filter Simulator ---
            const anxietySlider = document.getElementById('anxiety-slider');
            const motivationSlider = document.getElementById('motivation-slider');
            const anxietyVal = document.getElementById('anxiety-val');
            const motivationVal = document.getElementById('motivation-val');
            const filterBar = document.getElementById('filter-bar');
            const filterStatusText = document.getElementById('filter-status-text');

            function updateFilter() {
                const anx = parseInt(anxietySlider.value, 10);
                const mot = parseInt(motivationSlider.value, 10);

                anxietyVal.textContent = anx > 50 ? `High (${anx}%)` : `Low (${anx}%)`;
                motivationVal.textContent = mot > 50 ? `High (${mot}%)` : `Low (${mot}%)`;

                // Calculate absorption percentage
                let absorption = Math.max(5, Math.min(100, (mot * 0.7) - (anx * 0.5) + 30));
                absorption = Math.round(absorption);

                filterBar.style.width = `${absorption}%`;

                if (absorption >= 70) {
                    filterBar.className = 'h-full bg-gradient-to-r from-emerald-500 to-indigo-500 rounded-full transition-all duration-300 shadow-sm';
                    filterStatusText.className = 'text-xs font-mono font-extrabold text-emerald-400';
                    filterStatusText.textContent = `Filter Status: OPEN (${absorption}% Language Absorbed Effortlessly)`;
                } else if (absorption >= 40) {
                    filterBar.className = 'h-full bg-gradient-to-r from-amber-500 to-indigo-500 rounded-full transition-all duration-300 shadow-sm';
                    filterStatusText.className = 'text-xs font-mono font-extrabold text-amber-400';
                    filterStatusText.textContent = `Filter Status: PARTIAL (${absorption}% Language Reaching LAD)`;
                } else {
                    filterBar.className = 'h-full bg-rose-600 rounded-full transition-all duration-300 shadow-sm';
                    filterStatusText.className = 'text-xs font-mono font-extrabold text-rose-400';
                    filterStatusText.textContent = `Filter Status: BLOCKED (${absorption}% Input Filtered Out)`;
                }
            }

            anxietySlider?.addEventListener('input', updateFilter);
            motivationSlider?.addEventListener('input', updateFilter);
            updateFilter();
        });
    </script>
@endsection
