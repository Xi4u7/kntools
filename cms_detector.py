#!/usr/bin/python
# -*- coding: UTF-8 -*-

import requests, re, sys, threading, threading, time, random
from Queue import Queue
requests.packages.urllib3.disable_warnings()

wp = open("wordpress.txt", "a")
jm = open("joomla.txt","a")
dr = open("drupal.txt","a")
ps = open("prestashop.txt","a")
mg = open("magento.txt","a")
other = open("other.txt","a")

def main(url):
        timeout = 15
        header = {"User-agent":"Linux Mozilla 5/0"} # Change User-agent if you want
        wpc = open("wordpress.txt").read()
        jmc = open("joomla.txt").read()
        drc = open("drupal.txt").read()
        psc = open("prestashop.txt").read()
        mgc = open("magento.txt").read()
        otherc = open("other.txt").read()
        try:
                finaly = url
                html = requests.get(finaly, headers=header, timeout=timeout).text
                if "component" in html and "com_" in html:
                        print("\033[32;1m[+] "+finaly+" -> Joomla")
                        if finaly in jmc:
                                print(" \033[31;1m| Already Added In List")
                        else:
                                jm.write(finaly+"\n")
                                jm.close()
                                print(" | Added To List")
                elif "/wp-content/" in html:
                        print("\033[32;1m[+] "+finaly+" -> Wordpress")
                        if finaly in wpc:
                                print(" \033[31;1m| Already Added In List")
                        else:
                                wp.write(finaly+"\n")
                                wp.close()
                                print(" | Added To List")
                elif "/sites/default/" in html:
                        print("\033[32;1m[+] "+finaly+" -> Drupal")
                        if finaly in drc:
                                print(" \033[31;1m| Already Added In List")
                        else:
                                dr.write(finaly+"\n")
                                dr.close()
                                print(" | Added To List")
                elif "skin/frontend/" in html:
                        print("\033[32;1m[+] "+finaly+" -> Magento")
                        if finaly in mgc:
                                print(" \033[31;1m| Already Added In List")
                        else:
                                mg.write(finaly+"\n")
                                mg.close()
                                print(" | Added To List")
                elif "prestashop" in html:
                        print("\033[32;1m[+] "+finaly+" -> PrestaShop")
                        if finaly in psc:
                                print(" \033[31;1m| Already Added In List")
                        else:
                                ps.write(finaly+"\n")
                                ps.close()
                                print(" | Added To List")
                else:
                        print("\033[33;1m[+] "+finaly+" -> Other")
                        if finaly in otherc:
                                print(" \033[31;1m| Already Added In List")
                        else:
                                other.write(finaly+"\n")
                                other.close()
                                print(" | Added To List")
        except Exception as err:
                print("\033[34m[!] Exception Error!\033[0m")
        	
try:
	list = sys.argv[1]
except:
	print("python2.7 eval-stdin.py list.txt")
	exit()
	
try:
	asu = open(list).read().splitlines()
	jobs = Queue()
	def do_stuff(q):
		while not q.empty():
			value = q.get()
			if value.startswith("http://") or value.startswith("https://"):
				main(value)
			else:
				value2 = "http://"+value
				main(value2)
			q.task_done()
			
	for trgt in asu:
		jobs.put(trgt)
	
	for i in range(100):
		worker = threading.Thread(target=do_stuff, args=(jobs,))
		worker.start()
	jobs.join()
except KeyboardInterrupt:
	print("CTRL + C Closed")
	exit()
