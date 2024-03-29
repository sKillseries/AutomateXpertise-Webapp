<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public function showFiles()
    {
        $directory = public_path("resultats");

        $items = File::allFiles($directory);

        return view('result.index', ['items' => $items]);
    }

    public function viewFile($filename)
    {
        $directory = public_path("resultats");

        $file = $directory . '/' . $filename;

        if (file_exists($file) && is_file($file)) {
            $content = file_get_contents($file);
            return view('result.view', compact('filename', 'content'));
        } else {
            return redirect()->route('files')->with('error', 'Fichier non trouvé.');
        }
    }

    public function download($filename)
    {
        $directory = public_path("resultats");

        $file = $directory . '/' . $filename;

        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect()->route('files')->with('error', 'Fichier non trouvé.');
        }
    }
}