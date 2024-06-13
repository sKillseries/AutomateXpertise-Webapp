#!/bin/bash

cible=$1
cidr=$2

if [ ! -d "resultats" ];then
    mkdir resultats
fi
if [ ! -d "resultats/hostdiscovering.html" ];then
    touch resultats/hostdiscovering.html
fi

echo "Active Host Discovering"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Active Host Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sn "$cible"/"$cidr"
    echo -e '</code></pre>'
} >> resultats/hostdiscovering.html

echo "Active Host Discovering double checking"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Active host double checking Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nbtscan -r "$cible"/"$cidr"
    echo -e '</code></pre>'
} >> resultats/hostdiscovering.html