#!/bin/bash

cible=$1

if [ ! -d "resultats" ];then
    mkdir resultats
fi
if [ ! -d "resultats/netscan.html" ];then
    touch resultats/netscan.html
fi

echo -e '<h1 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost network scan</h1>' >> resultats/netscan.html

echo "ICMP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost ICMP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -PE -PM -PP -sn -n "$cible"
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "TCP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost TCP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -Pn -sV -p- "$cible" -oX files_to_process/nmap_outside_singlehost_netscan.xml
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "SCTP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost SCTP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sY -n --open -Pn "$cible"
    echo -e '</code></pre>'
} >> resultats/netscan.html