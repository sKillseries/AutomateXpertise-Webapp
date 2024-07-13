#!/bin/bash

cible=$1
cidr=$2

if [ ! -d "resultats" ];then
    mkdir resultats
fi
if [ ! -d "resultats/netscan.html" ];then
    touch resultats/netscan.html
fi

echo -e '<h1 class="font-semibold text-xl text-gray-800 dark:text-white">Outside multihosts network scan</h1>' >> resultats/netscan.html

echo "ICMP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside multihosts ICMP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -PE -PM -PP -sn -n "$cible"/"$cidr"
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "TCP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside multihosts TCP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    masscan --banners -p 20,21-23,25,53,80,110,111,135,139,143,443,445,993,995,1723,3306,3389,5900,8080 "$cible"/"$cidr"
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "HTTP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside multihosts HTTP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    masscan --banners -p 80,443,8000-8100,8443 "$cible"/"$cidr"
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "UDP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside multihosts UDP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sU -sV --version-intensity 0 -F -n "$cible"/"$cidr"
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "SCTP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside multihosts SCTP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sY -n --open -Pn "$cible"/"$cidr"
    echo -e '</code></pre>'
} >> resultats/netscan.html