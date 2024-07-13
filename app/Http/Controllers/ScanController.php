<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ScanController extends Controller
{
    private $scanscriptsDirectory;

    public function __construct()
    {
        // Initialisation du chemin vers le répertoire des scripts dans le répertoire public
        $this->scanscriptsDirectory = public_path('scan_scripts');
    }

    public function index()
    {
        // Recherche des fichiers de scripts dans le répertoire
        $scriptFiles = File::files($this->scanscriptsDirectory);

        return view('scan.index', [
            'scriptFiles' => $scriptFiles,
        ]);
    }

    public function executeScript(Request $request)
    {
        $selectedScripts = $request->input('selected_scripts');
        $cible = $request->input('cible');
        $cibleArguments = $request->input('cible_arguments');
        $messages = '';

        if (!empty($selectedScripts)) {
            foreach ($selectedScripts as $selectedScript) {
                // Message avant l'exécution du script
                $messages .= "Exécution du script $selectedScript en cours...\n";

                // Exécution du script sélectionné en fonction de son extension
                $extension = pathinfo($selectedScript, PATHINFO_EXTENSION);

                if ($extension === 'py') {
                    shell_exec('python3 ' . $this->scanscriptsDirectory . '/' . $selectedScript . ' ' . $cible . ' ' . $cibleArguments);
                } elseif ($extension === 'sh') {
                    shell_exec('bash ' . $this->scanscriptsDirectory . '/' . $selectedScript . ' ' . $cible . ' ' . $cibleArguments);
                } else {
                    $messages .= "Unsupported file extension for $selectedScript\n";
                    continue;
                }

                // Message après l'exécution du script
                $messages .= "Fin exécution du script $selectedScript.\n";
           }

           // Message d'invitation à l'utiliser à consulter les résultats
           $messages .= "Vous pouvez consulter le résultat du scanning dans la section Résultats";
        }

        return view('scan.index', [
            'messages' => $messages,
            'scriptFiles' => File::files($this->scanscriptsDirectory), //Réactualise la liste des scripts
        ]);
    }
}