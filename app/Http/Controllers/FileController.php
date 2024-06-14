<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use League\HTMLToMarkdown\HtmlConverter;
use PDF;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

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

    public function markdown($filename)
    {
        $directory = public_path("resultats");

        $file = $directory . '/' . $filename;

        if (file_exists($file)) {
            $htmlContent = file_get_contents($file);
            $converter = new HtmlConverter();
            $markdown = $converter->convert($htmlContent);
            $markdownFileName = pathinfo($file, PATHINFO_FILENAME) . '.md';
            return response($markdown)
                ->header('Content-Type', 'text/markdown')
                ->header('Content-Disposition', 'attachment; filename="' . $markdownFileName . '"');
        } else {
            return redirect()->route('files')->with('error', 'Fichier non trouvé.');
        }
    }

    public function PDF($filename)
    {
        $directory = public_path("resultats");

        $file = $directory . '/' . $filename;

        if (file_exists($file)) {
            $htmlContent = file_get_contents($file);
            $pdf = PDF::loadHTML($htmlContent);
            $pdfFileName = pathinfo($file, PATHINFO_FILENAME) . '.pdf';
            return $pdf->download($pdfFileName);
        } else {
            return redirect()->route('files')->with('error', 'Fichier non trouvé.');
        }
    }

    public function Word($filename)
    {
        $directory = public_path("resultats");

        $file = $directory . '/' . $filename;

        if (file_exists($file)) {
            $htmlContent = file_get_contents($file);
            $pdf = PDF::loadHTML($htmlContent);
            $pdfContent = $pdf->output();
            //Sauvegarde temporaire du PDF
            $tempDir = storage_path('app/public/temp');
            if (!Storage::exists('public/temp')) {
                Storage::makeDirectory('public/temp');
            }
            $pdfPath = $tempDir . '/temp.pdf';
            file_put_contents($pdfPath, $pdfContent);
            //Extraction du texte du pdf
            $parser = new Parser();
            $pdf = $parser->parseFile($pdfPath);
            $text = $pdf->getText();
            //Suppression du PDF temporaire
            unlink($pdfPath);
            //Création du document Word
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();
            $section->addText($text);
            $wordFileName = pathinfo($file, PATHINFO_FILENAME) . '.docx';
            $response = response()->stream(function () use ($phpWord) {
                $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
                $objWriter->save('php://output');
            }, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment;filename="' . $wordFileName . '"',
            ]);
            return $response;
        }
    }
}