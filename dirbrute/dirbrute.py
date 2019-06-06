#!/usr/bin/python
# -*- coding: utf-8 -*-

import requests, threading, sys
from Queue import Queue
sys.stderr.write("\x1b[2J\x1b[H")

try:
	out = sys.argv[4]
except:
	out = "Found_Result.txt"
save = open(out, "a")
try:
	thread = sys.argv[3]
except:
	thread = 8
try:
	path = sys.argv[2]
	list = sys.argv[1]
except:
	print("No Args!! Command:\n	# args 1 = list site\n	# args 2 = list path\n	# args 3 = Set Thread\n	# Set Output Name\n\n	Example Command:\n	- python2.7 dirbrute.py sites.txt path.txt\n	- python2.7 dirbrute.py sites.txt path.txt 8 output.txt")
	exit()

def main(url, path):
	try:
		header = {"User-agent":"Linux Mozilla 5/0"}
		request = requests.get(url+path, headers=header)
		if request.status_code == 200:
			print("\033[32;1m[200] "+url+path+"\033[0m")
			save.write(url+path+"\n")
		else:
			print("\033[31;1m["+request.status_code+"] "+url+path+"\033[0m")
	except:
		print("\033[33;1m[BAD] "+url+path+"\033[0m")

asu = open(list).read().splitlines()
path = open(path).read().splitlines()
jobs = Queue()

def do_stuff(q):
	global sampe
	global list
	while not q.empty():
		value = q.get()
		for get in path:
			main(value, get)
		q.task_done()

for trgt in asu:
	if trgt.startswith("http://") or trgt.startswith("https://"):
		final = trgt
	else:
		final = "http://"+trgt
	jobs.put(final)
for i in range(int(thread)):
	worker = threading.Thread(target=do_stuff, args=(jobs,))
	worker.start()
jobs.join()
