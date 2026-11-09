<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class JudasComicController extends Controller
{
    /**
     * Map of chapters 1..4 to their exact CBR filenames in public/comic/judas/
     */
    protected $chapterFiles = [
        1 => 'Judas 01 (of 04) (2017) (digital) (Son of Ultron-Empire).cbr',
        2 => 'Judas 02 (of 04) (2018) (digital) (Son of Ultron-Empire).cbr',
        3 => 'Judas 03 (of 04) (2018) (digital) (Son of Ultron-Empire).cbr',
        4 => 'Judas 04 (of 04) (2018) (digital) (Son of Ultron-Empire).cbr',
    ];

    /**
     * Display the Judas Interactive Comic Reader
     */
    public function show($chapter = 1)
    {
        $chapterNum = (int)$chapter;
        if (!isset($this->chapterFiles[$chapterNum])) {
            $chapterNum = 1;
        }

        $pages = $this->extractAndGetPages($chapterNum);

        return view('judas-reader', [
            'chapterTitle'   => 'Judas',
            'currentChapter' => $chapterNum,
            'totalChapters'  => count($this->chapterFiles),
            'chapterMap'     => $this->chapterFiles,
            'pages'          => $pages,
            'totalPages'     => count($pages),
        ]);
    }

    /**
     * API Endpoint for dynamic chapter switching via AJAX
     */
    public function getChapterApi($chapter = 1)
    {
        $chapterNum = (int)$chapter;
        if (!isset($this->chapterFiles[$chapterNum])) {
            $chapterNum = 1;
        }

        $pages = $this->extractAndGetPages($chapterNum);

        return response()->json([
            'chapter'    => $chapterNum,
            'totalPages' => count($pages),
            'pages'      => $pages,
        ]);
    }

    /**
     * Extract CBR archive to public cache and return ordered image URLs
     */
    protected function extractAndGetPages($chapterNum)
    {
        $fileName = $this->chapterFiles[$chapterNum];
        $cbrPath  = public_path("comics_files/judas/{$fileName}");
        $cacheDir = public_path("cache/judas/chapter_{$chapterNum}");

        if (!File::exists($cacheDir) || count(File::files($cacheDir)) === 0) {
            File::makeDirectory($cacheDir, 0755, true, true);
            $this->extractCbrFile($cbrPath, $cacheDir);
        }

        $files = File::files($cacheDir);
        $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        $fileNames = [];
        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, $imageExtensions)) {
                $fileNames[] = $file->getFilename();
            }
        }

        // Natural sort (Judas 001-000.jpg, Judas 001-001.jpg, etc.)
        natsort($fileNames);
        $fileNames = array_values($fileNames);

        $imageUrls = [];
        foreach ($fileNames as $name) {
            $imageUrls[] = asset("cache/judas/chapter_{$chapterNum}/{$name}");
        }

        return $imageUrls;
    }

    /**
     * System extractor for CBR (RAR) files using tar (built into Windows/Linux libarchive)
     */
    protected function extractCbrFile($cbrPath, $destDir)
    {
        if (!File::exists($cbrPath)) {
            return;
        }

        $escapedCbr  = escapeshellarg($cbrPath);
        $escapedDest = escapeshellarg($destDir);

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $cmd = "tar -xf {$escapedCbr} -C {$escapedDest}";
            @exec($cmd);
        } else {
            $cmd = "unrar x -o+ {$escapedCbr} {$escapedDest}/";
            @exec($cmd);
        }

        // Flatten subdirectories if any
        $subDirs = File::directories($destDir);
        foreach ($subDirs as $sub) {
            $subFiles = File::allFiles($sub);
            foreach ($subFiles as $f) {
                File::move($f->getPathname(), $destDir . '/' . $f->getFilename());
            }
            File::deleteDirectory($sub);
        }
    }
}
