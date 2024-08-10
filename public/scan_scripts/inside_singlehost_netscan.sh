#!/bin/bash

cible=$1

if [ ! -d "resultats" ];then
    mkdir resultats
fi
if [ ! -d "resultats/netscan.html" ];then
    touch resultats/netscan.html
fi

echo -e '<h1 class="font-semibold text-xl text-gray-800 dark:text-white">Inside singlehost network scan</h1>' >> resultats/netscan.html

echo "[*] ARP active scanning..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">ARP scan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sn "$cible"
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "ICMP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Inside singlehost ICMP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -PE -PM -PP -sn -vvv -n "$cible"
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "TCP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Inside singlehost TCP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sV -sC -O -p- -n -Pn "$cible" -oX files_to_process/nmap_netscan_inside_tcp_port_scan.xml
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "SCTP Port Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Inside singlehost SCTP Port Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -p- -sY -sV -sC -n "$cible" -oX files_to_process/nmap_netscan_inside_sctp_scan.xml
    echo -e '</code></pre>'
} >> resultats/netscan.html

echo "DHCP Scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">DHCP Scanning Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap --script broadcast-dhcp-discover
    echo -e '</code></pre>'
} >> resultats/netscan.html