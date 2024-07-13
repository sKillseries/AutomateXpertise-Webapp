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
        $messages = '';

        if (!empty($selectedScripts)) {
            foreach ($selectedScripts as $selectedScript) {
                // Message avant l'exécution du script
                $messages .= "Exécution du script $selectedScript en cours...\n";

                // Exécution du script sélectionné en fonction de son extension
                $extension = pathinfo($selectedScript, PATHINFO_EXTENSION);

                if ($extension === 'py') {
                    shell_exec('python3 ' . $this->reconscriptsDirectory . '/' . $selectedScript . ' ' . $cible . ' ' . $cibleArgument1 . ' ' . $cibleArgument2);
                } elseif ($extension === 'sh') {
                    shell_exec('bash ' . $this->reconscriptsDirectory . '/' . $selectedScript . ' ' . $cible . ' ' . $cibleArgument1 . ' ' . $cibleArgument2);
                } else {
                    $messages .= "Unsupported file extension for $selectedScript\n";
                    continue;
                }

                // Message après l'exécution du script
                $messages .= "Fin exécution du script $selectedScript.\n";
            }

            // Message d'invitation à l'utiliser à consulter les résultats
            $messages .= "Vous pouvez consulter le résultat de la reconnaissance dans la section Résultats";
        }

        return view('recon.index', [
            'messages' => $messages,
            'scriptFiles' => File::files($this->reconscriptsDirectory), //Réactualiser la liste des scripts
        ]);
    }
}