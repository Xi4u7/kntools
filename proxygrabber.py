# -*- coding: utf-8 -*-
import requests, threading, os
from Queue import Queue

def cek(sock, type):
		if type == "sock4":
			try:
				proxy = {"https":sock}
				x = requests.get("https://api.ipify.org/", proxies=proxy, timeout=10).text
				if x:
					print(sock+" - Worked - "+x)
					k = open("socks4_work.txt","a")
					k.write(sock+"\n")
					k.close()
			except:
				print(sock+" - Dead")
		elif type == "https":
			try:
				proxy = {"https":sock}
				x = requests.get("https://api.ipify.org/", proxies=proxy, timeout=10).text
				if x:
					print(sock+" - Worked - "+x)
					k = open("https_work.txt","a")
					k.write(sock+"\n")
					k.close()
			except:
				print(sock+" - Dead")
		else:
			try:
				proxy = {"https":sock}
				x = requests.get("https://api.ipify.org/", proxies=proxy, timeout=10).text
				if x:
					print(sock+" - Worked - "+x)
					k = open("socks5_work.txt","a")
					k.write(sock+"\n")
					k.close()
			except:
				print(sock+" - Dead")

def https(tanya):
	s4 = requests.get("https://api.proxyscrape.com/?request=getproxies&proxytype=https&timeout=5000&country=all").text
	t = 0
	for i in s4.splitlines():
		t = t + 1
		f = open("https.txt","a")
		f.write("https://"+i+"\n")
		f.close()
	print("Sukses Grab "+str(t)+" httls")
	if tanya == "y" or tanya == "Y":
		list = open("https.txt").read()
		jobs = Queue()
		def do_stuff(q):
		        while not q.empty():
		                i = q.get()
		                cek(i, "https")
		                q.task_done()
		
		for trgt in list.splitlines():
			jobs.put(trgt)

		for i in range(100): # Default 50 Thread Ganti Aja Kalau Mau
		        worker = threading.Thread(target=do_stuff, args=(jobs,))
		        worker.start()
		jobs.join()
		os.remove("https.txt")

def sock4(tanya):
	s4 = requests.get("https://api.proxyscrape.com/?request=getproxies&proxytype=socks4&timeout=5000&country=all", headers={"User-agent":"linux jgggdg"}).text
	t = 0
	for i in s4.splitlines():
		t = t + 1
		f = open("socks4.txt","a")
		f.write("socks4://"+i+"\n")
		f.close()
	print("Sukses Grab "+str(t)+" socks4")
	if tanya == "y" or tanya == "Y":
		list = open("socks4.txt").read()
		jobs = Queue()
		def do_stuff(q):
		        while not q.empty():
		                i = q.get()
		                cek(i, "sock4")
		                q.task_done()
		
		for trgt in list.splitlines():
			jobs.put(trgt)

		for i in range(100): # Default 50 Thread Ganti Aja Kalau Mau
		        worker = threading.Thread(target=do_stuff, args=(jobs,))
		        worker.start()
		jobs.join()
		os.remove("socks4.txt")

def sock5(tanya):
	s5 = requests.get("https://api.proxyscrape.com/?request=getproxies&proxytype=socks5&timeout=5000&country=all").text
	t = 0
	for i in s5.splitlines():
		t = t + 1
		f = open("socks5.txt","a")
		f.write("socks5://"+i+"\n")
		f.close()
	print("Sukses Grab "+str(t)+" socks4")
	if tanya == "y" or tanya == "Y":
		list = open("socks5.txt").read()
		jobs = Queue()
		def do_stuff(q):
		        while not q.empty():
		                i = q.get()
		                cek(i, "sock5")
		                q.task_done()
		
		for trgt in list.splitlines():
			jobs.put(trgt)

		for i in range(100): # Default 50 Thread Ganti Aja Kalau Mau
		        worker = threading.Thread(target=do_stuff, args=(jobs,))
		        worker.start()
		jobs.join()
		os.remove("socks5.txt")

print("	[1] SOCKS4\n	[2] SOCKS5\n	[3] HTTPS\n	[4] Get All Proxy")
ty = raw_input("	> ")
if ty == "1" or ty == 1:
	autocek = raw_input("	use auto check ? [Y/n] ")
	if autocek == "y" or autocek == "Y":
		sock4("y")
	else:
		sock4("y")
elif ty == "2" or ty == 2:
	autocek = raw_input("	use auto check ? [Y/n] ")
	if autocek == "y" or autocek == "Y":
		sock5("y")
	else:
		sock5("y")
elif ty == "3" or ty == 3:
	autocek = raw_input("	use auto check ? [Y/n] ")
	if autocek == "y" or autocek == "Y":
		https("y")
	else:
		https("gak")
elif ty == "4" or ty == 4:
	autocek = raw_input("	use auto check ? [Y/n] ")
	if autocek == "y" or autocek == "Y":
		sock4("y")
		sock5("y")
		https("y")
	else:
		sock4("gak")
		sock5("gak")
		https("gak")
else:
	print("Wrong number!")
