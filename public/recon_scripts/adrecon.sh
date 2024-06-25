#!/bin/bash

cible=$1
mask=$2
range=$3

if [ ! -d "resultats" ];then
    mkdir resultats
fi
if [ ! -d "files_to_process" ];then
    mkdir files_to_process
fi
if [ ! -d "resultats/adrecon.html" ];then
    touch resultats/adrecon.html
fi

echo "[*] DHCP Checking..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">DHCP Check result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap --script broadcast-dhcp-discover
    echo -e '</code></pre>'
} >> resultats/adrecon.html

nmap --script broadcast-dhcp-discover -oX files_to_process/ad_dhcp_nmap_scan.xml

echo "[*] DNS checking..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">DNS Check result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap --script dns-srv-enum --script-args dns-srv-enum.domain="$cible"
    echo -e '</code></pre>'
} >> resultats/adrecon.html

nmap --script dns-srv-enum --script-args dns-srv-enum.domain="$cible" -oX files_to_process/ad_dns_check_nmap_scan.xml

echo "[*] Disvovering DNS nameservers..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">DNS Discover result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -v -sV -p 53 "$cible"/"$mask"
    echo -e '</code></pre>'
    echo -e '</br>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -v -sV -sU -p 53 "$cible"/"$mask"
    echo -e '</code></pre>'
} >> resultats/adrecon.html

nmap -v -sV -p 53 "$cible"/"$mask" -oX files_to_process/ad_dns_discover_nmap_scan1.xml
nmap -v -sV -sU -p 53 "$cible"/"$mask" -oX files_to_process/ad_dns_discover_nmap_scan2.xml

echo "[*] Reverse lookups PTR"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">PTR result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    dnsrecon -r "$range" -n "$cible"
    echo -e '</code></pre>'
} >> resultats/adrecon.html

dnsrecon -r "$range" -n "$cible" -x files_to_process/ad_ptr_dnsrecon.xml

echo "[*] nbt-ns scanning..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">nbt scan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nbtscan -r "$cible"/"$mask"
    echo -e '</code></pre>'
    echo -e '</br>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmblookup -A "$cible"
    echo -e '</code></pre>'
} >> resultats/adrecon.html

echo "[*] Port scanning..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Port Scan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -sS -n --open -p 88,389 "$cible"
    echo -e '</code></pre>'
} >> resultats/adrecon.html

nmap -sS -n --open -p 88,389 "$cible" -oX files_to_process/ad_port_nmap_scan.xml

echo "[*] ldap checking..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">ldap check result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    impacket-ntlmrelayx -t "ldap://'$cible'" --dump-adcs --dump-laps --dump-gmsa
    echo -e '</code></pre>'
    echo -e '</br>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    windapsearch --dc "$cible" --module users
    echo -e '</code></pre>'
    echo -e '</br>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    windapsearch --dc "$cible" --module metadata
    echo -e '</code></pre>'
} >> resultats/adrecon.html

windapsearch --dc "$cible" --module users -o files_to_process/ad_ldap_windapsearch_users.tsv
windapsearch --dc "$cible" --module metadata -o 2>&1 files_to_process/ad_ldap_windapsearch_metadata.tsv

echo "[*] Looking for exposed rpc services..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">exposed rpc services result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    impacket-rpcdump -port 135 "$cible"
    echo -e '</code></pre>'
    echo -e '</br>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    impacket-rpcdump -port 593 "$cible"
    echo -e '</code></pre>'
} >> resultats/adrecon.html

echo "[*] enum4linux checking..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">enum4linux result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md"><code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    enum4linux -A "$cible"
    echo -e '</code></pre>'
} >> resultats/adrecon.html