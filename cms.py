# -*- coding: utf-8 -*-

import sys, requests, re, time, os
from ConfigParser import ConfigParser
from Queue import Queue
from threading import Thread

try:
	os.mkdir("cms")
except:
	pass

""" Configure Headers """
header = {"User-agent":"Linux Mozilla 7.0"}
pid_restore = ".cmsscanner.session"


class Worker(Thread):
	def __init__(self, tasks):
		Thread.__init__(self)
		self.tasks = tasks
		self.daemon = True
		self.start()

	def run(self):
		while True:
			func, args, kargs = self.tasks.get()
			try: func(*args, **kargs)
			except Exception, e: print e
			self.tasks.task_done()

class ThreadPool:
	def __init__(self, num_threads):
		self.tasks = Queue(num_threads)
		for _ in range(num_threads): Worker(self.tasks)

	def add_task(self, func, *args, **kargs):
		self.tasks.put((func, args, kargs))

	def wait_completion(self):
		self.tasks.join()

def printf(text):
	''.join([str(item) for item in text])
	print(text + '\n'),

def main(url):
	try:
		s = requests.Session()
		req = s.get(url, headers=header, timeout=8)
		html = req.text
		if "=eyJ" in str(req.headers) or "XSRF-TOKEN" in str(req.headers):
			nama = "Laravel"
			w = open("cms/"+nama+".txt","a")
			r = open("cms/"+nama+".txt").read()
			if url in r:
				printf(url+" -> \033[31;1m"+nama+"\033[0m")
			else:
				printf(url+" -> \033[32;1m"+nama+"\033[0m")
				w.write(url+"\n")
			w.close()
		elif "/wp-content/" in html:
			nama = "Wordpress"
			w = open("cms/"+nama+".txt","a")
			r = open("cms/"+nama+".txt").read()
			if url in r:
				printf(url+" -> \033[31;1m"+nama+"\033[0m")
			else:
				printf(url+" -> \033[32;1m"+nama+"\033[0m")
				w.write(url+"\n")
			w.close()
		elif "component" in html and "com_" in html:
			nama = "Joomla"
			w = open("cms/"+nama+".txt","a")
			r = open("cms/"+nama+".txt").read()
			if url in r:
				printf(url+" -> \033[31;1m"+nama+"\033[0m")
			else:
				printf(url+" -> \033[32;1m"+nama+"\033[0m")
				w.write(url+"\n")
			w.close()
		elif "/sites/default/" in html:
			nama = "Drupal"
			w = open("cms/"+nama+".txt","a")
			r = open("cms/"+nama+".txt").read()
			if url in r:
				printf(url+" -> \033[31;1m"+nama+"\033[0m")
			else:
				printf(url+" -> \033[32;1m"+nama+"\033[0m")
				w.write(url+"\n")
			w.close()
		elif "skin/frontend/" in html:
			nama = "Magento"
			w = open("cms/"+nama+".txt","a")
			r = open("cms/"+nama+".txt").read()
			if url in r:
				printf(url+" -> \033[31;1m"+nama+"\033[0m")
			else:
				printf(url+" -> \033[32;1m"+nama+"\033[0m")
				w.write(url+"\n")
			w.close()
		elif "prestashop" in html:
			nama = "PrestaShop"
			w = open("cms/"+nama+".txt","a")
			r = open("cms/"+nama+".txt").read()
			if url in r:
				printf(url+" -> \033[31;1m"+nama+"\033[0m")
			else:
				printf(url+" -> \033[32;1m"+nama+"\033[0m")
				w.write(url+"\n")
			w.close()
		else:
			nama = "Other"
			w = open("cms/"+nama+".txt","a")
			r = open("cms/"+nama+".txt").read()
			if url in r:
				printf(url+" -> \033[31;1m"+nama+"\033[0m")
			else:
				printf(url+" -> \033[33;1m"+nama+"\033[0m")
				w.write(url+"\n")
			w.close()
	except:
		w = open("cms/EXCEPTION_SITES.txt","a")
		w.write(url + '\n')
		w.close()
		pass

if __name__ == '__main__':
	try:
		readcfg = ConfigParser()
		readcfg.read(pid_restore)
		lists = readcfg.get('DB', 'FILES')
		numthread = readcfg.get('DB', 'THREAD')
		sessi = readcfg.get('DB', 'SESSION')
		printf("log session bot found! restore session")
		printf('''Using Configuration :\n\tFILES='''+lists+'''\n\tTHREAD='''+numthread+'''\n\tSESSION='''+sessi)
		tanya = raw_input("Want to contineu session ? [Y/n] ")
		if "Y" in tanya or "y" in tanya:
			lerr = open(lists).read().split(sessi)[1]
			readsplit = lerr.splitlines()
		else:
			kntl # Send Error Biar Lanjut Ke Wxception :v
	except:
		try:
			lists = sys.argv[1]
			numthread = sys.argv[2]
			readsplit = open(lists).read().splitlines()
		except:
			try:
				lists = raw_input("websitelist ? ")
				numthread = raw_input("threads ? ")
				readsplit = open(lists).read().splitlines()
			except:
				printf("\nCheck our lists and try again!")
				exit()

	pool = ThreadPool(int(numthread))
	for url in readsplit:
		jagases = url
		if "://" in url:
			url = url
		else:
			url = "http://"+url
		try:
			pool.add_task(main, url)
		except KeyboardInterrupt:
			session = open(pid_restore, 'w')
			cfgsession = "[DB]\nFILES="+lists+"\nTHREAD="+str(numthread)+"\nSESSION="+jagases+"\n"
			session.write(cfgsession)
			session.close()
			printf("CTRL+C Detect, Session saved")
			exit()
	pool.wait_completion()
	try:
		os.remove(pid_restore)
	except:
		pass
