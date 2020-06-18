# -*- coding: utf-8 -*-

import requests, re

page = 0
while True:
	page = page + 1
	text = requests.get("https://domain-status.com/archives/2020-2-11/org/registered/"+str(page)).text
	regex = re.findall('<li><a href="https://domain-status.com/www/(.*?)">', text)
	if regex:
		for i in regex:
			print("\033[32;1m-\033[0m "+i)
			save = open("relusts.txt","a")
			save.write(i+'\n')
			save.close()
	else:
		print("kelar")
		break
