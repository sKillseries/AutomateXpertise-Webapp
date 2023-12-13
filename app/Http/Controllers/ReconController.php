<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReconController extends Controller
{
    private $reconscriptsDirectory;

    public function __construct()
    {
        // Initialisation du chemin vers le répertoire des scripts dans le répertoire public
        $this->reconscriptsDirectory = public_path('recon_scripts');
    }

    public function index()
    {
        // Recherche des fichiers de scripts dans le répertoire
        $scriptFiles = File::files($this->reconscriptsDirectory);

        return view('recon.index', [
            'scriptFiles' => $scriptFiles,
        ]);
    }

    public function executeScript(Request $request)
    {
        $selectedScripts = $request->input('selected_scripts');
        $cible = $request->input('cible');
        $cibleArgument1 = $request->input('cible_argument_1');
        $cibleArgument2 = $request->input('cible_argument_2');
        $output = '';

        if (!empty($selectedScripts)) {
            foreach ($selectedScripts as $selectedScript) {
                // Exécution du script sélectionné en fonction de son extension
                $extension = pathinfo($selectedScript, PATHINFO_EXTENSION);

                if ($extension === 'py') {
                    $output .= shell_exec('python3 ' . $this->reconscriptsDirectory . '/' . $selectedScript . ' ' . $cible . ' ' . $cibleArgument1 . ' ' . $cibleArgument2);
                } elseif ($extension === 'sh') {
                    $output .= shell_exec('bash ' . $this->reconscriptsDirectory . '/' . $selectedScript . ' ' . $cible . ' ' . $cibleArgument1 . ' ' . $cibleArgument2);
                } else {
                    $output .= "Unsupported file extension for $selectedScript";
                }
            }
        }

        return view('recon.index', [
            'output' => $output,
            'scriptFiles' => File::files($this->reconscriptsDirectory), //Réactualiser la liste des scripts
        ]);
    }
}