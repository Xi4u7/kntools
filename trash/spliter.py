# _*_ coding: utf-8 _*_
import sys

text = open(sys.argv[1]).read()
for i in text.splitlines():
	try:
		asu = i.split(',')
		f = asu.replace('"','')
		print(str(asu))
	except:
		continue
