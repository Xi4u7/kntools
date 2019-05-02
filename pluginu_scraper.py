# -*- coding: utf-8 -*-
import requests, re, sys

a = 0
total = 0
def main(plugin, kntl):
	result = open(plugin+".txt","a")
	global a
	global total
	while(a < int(kntl)):
		a = a + 1
		print("[+] Scraping Page {}").format(a)
		headers = {"User-agent":"Mozilla 5/0 Linux"}
		try:
			text = requests.get("http://pluginu.com/"+plugin+"/"+str(a), headers=headers, timeout=10).text
			list = re.findall('<p style="margin-bottom: 20px">(.*?)</p></a>', text)
			for i in list:
				total = total + 1
				print(" | "+str(i))
				result.write(i+'\n')
		except Exception as err:
			print("[-] "+str(err))
		print("[*] Total Web Scrapped "+str(total))

try:
	plug = sys.argv[1]
	page = sys.argv[2]
except:
	print("python2.7 pluginu_scraper.py [plugins name] [page]\nNOTE : If you enter 100 page tools this will be scraping page 1 - 100")
	exit()
main(plug,page)
