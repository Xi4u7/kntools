#!/usr/bin/python
# -*- coding: UTF-8 -*-

import requests, urlparse, sys

wp = open("wordpress.txt", "a")
jm = open("joomla.txt","a")
dr = open("drupal.txt","a")
ps = open("prestashop.txt","a")
other = open("other.txt","a")

def main(url):
        timeout = 15
        header = {"User-agent":"Linux Mozilla 5/0"} # Change User-agent if you want
        wpc = open("wordpress.txt").read()
        jmc = open("joomla.txt").read()
        drc = open("drupal.txt").read()
        psc = open("prestashop.txt").read()
        otherc = open("other.txt").read()
        try:
                finaly = url
                html = requests.get(finaly, headers=header, timeout=timeout).text
                if "component" in html and "com_" in html:
                        print("[+] "+finaly+" -> Joomla")
                        if finaly in jmc:
                                print(" | Already Added In List")
                        else:
                                jm.write(finaly+"\n")
                                print(" | Added To List")
                elif "/wp-content/" in html:
                        print("[+] "+finaly+" -> Wordpress")
                        if finaly in wpc:
                                print(" | Already Added In List")
                        else:
                                wp.write(finaly+"\n")
                                print(" | Added To List")
                elif "/sites/default/" in html:
                        print("[+] "+finaly+" -> Drupal")
                        if finaly in drc:
                                print(" | Already Added In List")
                        else:
                                dr.write(finaly+"\n")
                                print(" | Added To List")
                elif "prestashop" in html:
                        print("[+] "+finaly+" -> PrestaShop")
                        if finaly in psc:
                                print(" | Already Added In List")
                        else:
                                ps.write(finaly+"\n")
                                print(" | Added To List")
                else:
                        print("[+] "+finaly+" -> Other")
                        if finaly in otherc:
                                print(" | Already Added In List")
                        else:
                                other.write(finaly+"\n")
                                print(" | Added To List")
        except Exception as err:
                print("[!] Exception Error!")

list = raw_input("[?] List Of Website : ")
ab = open(list,"r")
for i in ab:
        asu = i.replace("\n","")
        if asu.startswith("http://") or asu.startswith("https://"):
        	main(asu)
        else:
        	gas = "http://" + asu
        	main(gas)
