#!/bin/bashtxt

cible=$1

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

echo -e '<h1 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost network scan</h1>' >> resultats/netscan.html

echo "ICMP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost ICMP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -PE -PM -PP -sn -n "$cible"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "TCP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost TCP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    masscan --banners -p20,21-23,25,53,80,110,111,135,139,143,443,445,993,995,1723,3306,3389,5900,8080 "$cible"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "HTTP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost HTTP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    masscan --banners -p80,443,8000-8100,8443 "$cible"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "UDP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost UDP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sU -sV --version-intensity 0 -F -n "$cible"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html

echo "SCTP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Outside singlehost SCTP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sY -n --open -Pn "$cible"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/netscan.html