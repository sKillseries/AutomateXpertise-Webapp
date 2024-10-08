#!/bin/bash

cible=$1

if [ ! -d "resultats" ];then
    mkdir resultats
fi
if [ ! -d "files_to_process" ];then
    mkdir files_to_process
fi
if [ ! -d "resultats/sysrecon.html" ];then
    touch resultats/sysrecon.html
fi

echo "[*] TCP Port scanning..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">TCP port scan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -Pn -sV -p "0-65535" "$cible" -oX files_to_process/nmap_sysrecon_tcp_scan.xml
    echo -e '</code></pre>'
} >> resultats/sysrecon.html