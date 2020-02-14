# -*- coding: utf-8 -*-
import requests, re, sys, threading, json
from Queue import Queue
from itertools import cycle

# Report Setting
reports = True
user = "Diky_AR"

# Save Total Results
live = 0
proxy = ""

def printf(text):
	print(text+"\n"),
	
def getid(user, id):
	for i in id:
		username = i["message"]["from"]["username"]
		if username == user:
			sendto = i["message"]["from"]["id"]
			break
	return sendto

def sendmsg(user, msg):
	token = "1058213924:AAHHlYEJKzpA49UC7u4oBomVjEZO2Y2MLAA"
	resup = requests.get("https://api.telegram.org/bot"+token+"/getUpdates").text
	jsres = json.loads(resup)["ok"]
	if jsres == True:
		id = json.loads(resup)["result"]
		sendto = getid(user, id)
		data = {"chat_id": sendto, "text": msg}
		sendmsg = requests.get("https://api.telegram.org/bot"+token+"/sendMessage", data=data).text
		res = json.loads(sendmsg)["ok"]
		if res == True:
			return "Report sent to @"+user
		elif res == False:
			debug = json.loads(sendmsg)["description"]
			return "Can't send report to @"+user+" - "+debug

def hackertarget(ip):
	global live
	total = 0
	global proxy_cycle
	global proxy
	try:
		text = requests.get("http://api.hackertarget.com/reverseiplookup/?q="+ip, headers={"User-agent":"Linuz Mozilla 5/0"}, proxies=proxy, timeout=8).text
		if "error check your search parameter" in text:
			pass
		elif "API count exceeded - Increase Quota with Membership" in text:
			soc = next(proxy_cycle)
			proxy = {"http":str(soc),"https":str(soc)}
			hackertarget(ip)
		else:
			dom = text.splitlines()
			for i in dom:
				ini = i
				w = open(result, "a")
				f = open(result).read()
				if ini in f:
					continue
				else:
					total = int(total) + 1
					live = int(live) + 1
					w.write(i+"\n")
					w.close()
	except Exception as err:
		# print(str(err))
		printf("PROXY DIE")
		soc = next(proxy_cycle)
		proxy = {"http":str(soc),"https":str(soc)}
		pass
	printf(ip+" - \033[32;1m"+str(total)+"\033[0m")

try:
	mmc = sys.argv[1]
	result = sys.argv[2]
	aburame = open(sys.argv[3]).read()
	hyuga = aburame.splitlines()
	proxy_cycle = cycle(hyuga)
	thre = sys.argv[4]
except:
	print("pythob rev3rseip.py list.txt output.txt proxy.txt thread")
	exit()

jobs = Queue()
def do_stuff(q):
	while not q.empty():
		i = q.get()
		hackertarget(i)
		q.task_done()

for i in open(mmc).read().splitlines():
	if i.startswith("http://"):
		y = i.split("http://")[1]
	elif i.startswith("https://"):
		y = i.split("https://")[1]
	else:
		y = i
	if "/" in y:
		final = y.split("/")[0]
	else:
		final = y
	jobs.put(final)

for i in range(int(thre)):
	worker = threading.Thread(target=do_stuff, args=(jobs,))
	worker.start()
jobs.join()
text = """
  ReverseIP Reports - AndroXgh0sT
___________________________________

TOTAL REVERSED : %s
___________________________________

androxghost1337@gmail.com - Diky AR
""" %(str(live))
if reports == True:
	sendmsg(user, text)