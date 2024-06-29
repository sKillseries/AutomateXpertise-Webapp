<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyseController extends Controller
{
    //
    public function showAnalyses()
    {
        // Todo
        // Afficher bouton 'lancement analyse'
        // Afficher lien pour télécharger le fichier d'import bdd pour la base de connaissance
        // Afficher KPI
        // Afficher la manière d'exploité la vulnérabilité et affcher le moyen de mitigation avec export de ces rapports au format markdown, etc
        return view('analyse.index');
    }

    public function launchAnalyses()
    {
        $directory = public_path("files_to_process");

        $file = $directory . '/' . $filename;
        // Todo
        // If file start by nmap launch nmap python script
        // Elif file start by masscan launch massscan python script
        // Else afficher message d'erreur 'aucun fichier à analyser'
        return view('analyse.index');
    }
}
