# -*- coding: utf-8 -*-
import requests, json

def twilio_checker(account_sid, auth_token):
	auth = (account_sid, auth_token)
	try:
		curler_balance = requests.get("https://api.twilio.com/2010-04-01/Accounts/"+account_sid+"/Balance.json", auth=auth).text
		curler_msg = requests.get("https://api.twilio.com/2010-04-01/Accounts/" + account_sid + "/Messages.json", auth=auth).text
		info_balance = json.loads(curler_balance)
		info_msg = json.loads(curler_msg)
		for msg in info_msg["messages"]:
			if msg["direction"] == "outbound-api":
				nope = msg["from"]
				break
			elif msg["direction"] == "inbound-api":
				nope = msg["to"]
				break
		print "Currency: "+info_balance["currency"]
		print "Balance: "+info_balance["balance"]
		print "Phone number: "+nope
	except Exception as err:
		print "ERROR: Invalid credentials"

account_sid = raw_input("Account sid: ")
auth_token = raw_input("Auth token: ")
twilio_checker(account_sid, auth_token)
