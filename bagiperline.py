output = "output"
bagiper = 3000
delim = 1
listf = open("domain-names.txt").read()
abc = 0
for i in listf.splitlines():
	name = output+"_"+str(delim)+".txt"
	wr = open(name, "a")
	if abc == int(bagiper):
		print(name+" | "+str(abc))
		abc = 0
		delim = delim + 1
	else:
		abc = abc + 1
		wr.write(i+"\n")
	wr.close()
