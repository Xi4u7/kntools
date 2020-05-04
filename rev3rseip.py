# -*- coding: utf-8 -*-
import requests, re, sys, threading, json
from Queue import Queue
from itertools import cycle

# Save Total Results
live = 0
proxy = ""

# Mod print biar ga amburadul pas return output thread :v
def printf(text):
        print(text+"\n"),

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
