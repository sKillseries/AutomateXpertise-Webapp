<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vulnerability;

class AnalyseController extends Controller
{
    private $analysescriptsDirectory;

    protected $severityCounts;

    public function __construct()
    {
        // Initialisation du chemin vers le répertoire du script d'analyse
        $this->analysescriptsDirectory = public_path('analyse_scripts');

        //Compter les occurences de chaque sévérité dans la table
        $severityCounts = Vulnerability::select('severity')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('severity')
            ->pluck('count', 'severity');
    }
    public function showAnalyses()
    {
        // Todo
        // Afficher lien pour télécharger le fichier d'import bdd pour la base de connaissance
        // Afficher KPI
        // Afficher la manière d'exploité la vulnérabilité et affcher le moyen de mitigation avec export de ces rapports au format markdown, etc
        return view('analyse.index', [
            'severityCounts' => $this->severityCounts
        ]);
    }

    public function launchAnalyses()
    {
        $directory = public_path("files_to_process");
        $messages = "";

        $file = glob($directory . '/*');
        // Todo
        // If file start by nmap launch nmap python script
        if (!empty($file)) {
            shell_exec('source ~/.bashrc && python3 ' . $this->analysescriptsDirectory . '/analyse_vulnerabilities.py');
            $messages .= "Analyse des fichiers en cours...\n";
        } else {
            $messages .= "Aucun fichier à analyser.\n";
        }
        // Else afficher message d'erreur 'aucun fichier à analyser'
        return view('analyse.index', [
            'messages' => $messages,
            'severityCounts' => $this->severityCounts
        ]);
    }
}
