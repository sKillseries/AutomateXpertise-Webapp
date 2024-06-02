#!/bin/bash

cible=$1
cidr=$2

if [ ! -d "resultats" ];then
    mkdir resultats
fi
if [ ! -d "resultats/netscan.html" ];then
    touch resultats/netscan.html
fi

afficher_tabulation() {
    tabulation="    "
    echo -e "${tabulation}${1}" >> resultats/netscan.html
}

echo -e '<h1 class="font-semibold text-xl text-gray-800 dark:text-white">Inside multihosts network scan</h1>' >> resultats/netscan.html

echo "ICMP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Inside multihosts ICMP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -PE -PM -PP -sn -vvv -n "$cible"/"$cidr"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "TCP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Inside multihosts TCP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sV -sC -O -n -Pn -p- -oA fullfastscan "$cible"/"$cidr"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "HTTP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Inside multihosts HTTP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    masscan --banners -p80,443,8000-8100,8443 "$cible"/"$cidr"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "UDP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Inside multihosts UDP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sU -sV --version-intensity 0 -n "$cible"/"$cidr"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "SCTP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Inside multihosts SCTP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -p- -sY -sV -sC -F -n -oA SCTAllScan "$cible"/"$cidr"
    fficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "DHCP Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">DHCP multihosts Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap --script broadcast-dhcp-discover
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html