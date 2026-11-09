<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JudasComicController;

// Catálogo Estático
Route::get('/', function () {
    return view('catalog');
})->name('catalog');

Route::get('/catalog', function () {
    return view('catalog');
});

// Input Tracker (LocalStorage)
Route::get('/tracker', function () {
    return view('tracker');
})->name('tracker');

// La Ruleta del Input (YouTube API)
Route::get('/roulette', function () {
    return view('roulette');
})->name('roulette');

// Hub Principal de Cómics & Lectores
Route::get('/comic', function () {
    return view('comic.hub');
})->name('comic');

// Theory: Stephen Krashen's Comprehensible Input Hypothesis
Route::get('/theory', function () {
    return view('theory');
})->name('theory');

// Web Series Platform (Netflix / Crunchyroll Style Streaming)
Route::get('/web-series', function () {
    return view('series-index');
})->name('series.index');

Route::get('/web-series/{id}', function ($id) {
    return view('series-player', ['seriesId' => $id]);
})->name('series.player');

// Podcasts Platform (Spotify Audio Streaming Style)
Route::get('/podcasts', function () {
    return view('podcasts-index');
})->name('podcasts.index');

Route::get('/podcasts/{id}', function ($id) {
    return view('podcasts-player', ['podcastId' => $id]);
})->name('podcasts.player');

// Cómic Interactivo por Nodos (Escenas Estáticas 1-3)
Route::get('/comic/node/{node?}', function ($node = 1) {
    $nodeNum = (int)$node;
    if ($nodeNum < 1 || $nodeNum > 3) {
        $nodeNum = 1;
    }
    return view("comic.node-{$nodeNum}", ['currentNode' => $nodeNum]);
})->name('comic.nodes');

// Visor PDF de Cómic (Shadowhunters: City of Bones)
Route::get('/reader', function () {
    return view('comic-reader');
})->name('comic-reader');

Route::get('/comic-reader', function () {
    return view('comic-reader');
});

// Visor CBR de Cómic (.cbr: "Judas")
Route::get('/judas/{chapter?}', [JudasComicController::class, 'show'])->name('judas.reader');
Route::get('/api/judas/{chapter}', [JudasComicController::class, 'getChapterApi'])->name('judas.api');
