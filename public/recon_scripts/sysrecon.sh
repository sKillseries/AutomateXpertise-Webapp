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

echo "[*] ARP active discovering..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">ARP scan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sn "$cible"
    echo -e '</code></pre>'
} >> resultats/sysrecon.html

nmap -sn "$cible" -oX files_to_process/sys_arp_nmap_scan.xml

echo "[*] NBT discovering..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">NBT scan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nbtscan -r "$cible"
    echo -e '</code></pre>'
} >> resultats/sysrecon.html

echo "[*] ICMP discovering..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">ICMP scan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -PE -PP -PM -sP "$cible"
    echo -e '</code></pre>'
} >> resultats/sysrecon.html

nmap -PE -PP -PM -sP "$cible" -oX files_to_process/sys_icmp_nmap_scan.xml

echo "[*] TCP Port scanning..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">TCP port scan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -Pn --script vuln -sV -p "0-65535" "$cible"
    echo -e '</code></pre>'
} >> resultats/sysrecon.html

nmap -Pn --script vuln -sV -p "0-65535" "$cible" -oX files_to_process/sys_tcp_nmap_scan.xml

echo "[*] Double Checking Port Scanning..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">masscan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    masscan -p0-65535,U:0-65535 --max-rate 100000 "$cible"
    echo -e '</code></pre>'
} >> resultats/sysrecon.html 

masscan -p0-65535,U:0-65535 --max-rate 100000 "$cible" -oX files_to_process/sys_masscan.xml