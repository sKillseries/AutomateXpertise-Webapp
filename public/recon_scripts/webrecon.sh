#!/bin/bash

url=$1
fqdn=$(echo $url | sed 's#^https://www\.\(.*\)/$#\1#')

if [ ! -d "resultats" ];then
    mkdir resultats
fi
if [ ! -d "files_to_process" ];then
    mkdir files_to_process
fi
if [ ! -d "resultats/webrecon.html" ];then
    touch resultats/webrecon.html
fi
if [ ! -f "resultats/webalive.txt" ];then
    touch resultats/webalive.txt
fi
if [ ! -f "resultats/webfinal.txt" ];then
    touch resultats/webfinal.txt
fi
if [ ! -f "resultats/webassets" ];then
    touch resultats/webassets.txt
fi
if [ ! -f "resultats/web_potential_takeovers.txt" ];then
    touch resultats/web_potential_takeovers.txt
fi

afficher_tabulation() {
    tabulation="    "
    echo -e "${tabulation}${1}" >> resultats/webrecon.html
}

echo "[+] HTTP response headers checking..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Curl Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    curl --location --head "$url"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

curl --location --head "$url" 2>&1 | jq -R -s -c 'split("\n") | {results: .}' files_to_process/web_curl.xml

echo "[+] Site crawling..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">hakrawler Result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    echo "$url" | hakrawler -d 10
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

echo "$url" | hakrawler -d 10 | jq -R -s -c '{urls: split("\n")}' > files_to_process/web_hakrawler.json

echo "[+] Harvesting subdomains with assetfinder..."
assetfinder "$fqdn" >> resultats/webassets.txt
sort -u resultats/webassets.txt >> resultats/webfinal.txt
rm resultats/webassets.txt

echo "[+] Double checking for subdomains with amass..."
amass enum -d "$fqdn" >> resultats/webf.txt
sort -u resultats/webf.txt >> resultats/webfinal.txt
rm resultats/webf.txt

echo "[+] dnsrecon enumeration and zone transfer..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">dnsrecon result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    dnsrecon -a -d "$url"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

dnsrecon -a -d "$url" | jq -R -s -c 'split("\n") | map(split(",") | {key: .[0], value: .[1]})' > files_to_process/web_dnsrecon.json

echo "[+] Probing for alive domains..."
sort -u resultats/webfinal.txt | httprobe -s -p https:443 | sed 's/https\?:\/\///' | tr -d ':443' >> resultats/weba.txt
sort -u resultats/weba.txt >> resultats/webalive.txt
sort -u resultats/weba.txt | jq -R -s -c 'split("\n") | {urls: .}' > files_to_process/webalive.json
rm resultats/weba.txt
rm resultats/webfinal.txt
 
echo "[+] Checking for possible subdomain takeover..." 
subjack -w resultats/webalive.txt -t 100 -timeout 30 -ssl -c ~/go/src/github.com/haccer/subjack/fingerprints.json -v 3 -o resultats/web_potential_takeovers.txt
subjack -w resultats/webalive.txt -t 100 -timeout 30 -ssl -c ~/go/src/github.com/haccer/subjack/fingerprints.json -v 3 -o - | jq -R -s -c 'split("\n") | {subdomains: .}' > files_to_process/web_subjack.json
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">potential subdomain takeover</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    cat resultats/web_potential_takeovers.txt
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html
rm resultats/webalive.txt
rm resultats/web_potential_takeovers.txt
 
echo "[+] Scanning for open ports..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">nmap web alive result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nmap -iL resultats/webalive.txt
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

nmap -iL resultats/webalive.txt -oX files_to_process/web_nmap_scan.xml

echo "[+] WAF checking..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Wafw00f result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    wafw00f "$url"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

wafw00f "$url" | jq '.' > files_to_process/web_wafw00f.json

echo "[+] Double WAF checking..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">Whatwaf result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    whatwaf -u "$url"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

whatwaf -u "$url" 2>&1 | jq -R -s -c 'split("\n") | {results: .}' > files_to_process/web_whatwaf.json

echo "[+] CMS identification checking..."
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">droopescan result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    droopescan scan -u "$url"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

droopescan scan -u "$url" | jq '.' > files_to_process/web_droopescan.json

echo "[+] vulnerability scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">nikto vulnerability scanning result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    nikto -h "$url"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

nikto -h "$url" -o - | jq '.' > files_to_process/web_nikto.json

echo "[+] double checking vulnerability scanning"
{
    echo -e '<h2 class="font-semibold text-xl text-gray-800 dark:text-white">wapiti vulnerability scanning result</h2>'
    echo -e '<pre class="bg-gray-100 dark:bg-gray-900 shadow-md">'
    afficher_tabulation '<code class="text-sm text-gray-700 bg-gray-100 dark:text-white dark:bg-gray-900 p-4 block">'
    wapiti -u "$url"
    afficher_tabulation '</code>'
    echo -e '</pre>'
} >> resultats/webrecon.html

wapiti -u "$url" -f xml -o files_to_process/wapiti.xml