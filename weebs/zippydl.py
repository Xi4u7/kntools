import requests, re

url = "https://www120.zippyshare.com/v/MD5ghqGj/file.html"
text = requests.get(url)
get_zippy_url = re.findall('"text": "(.*?)/file.html"', text.text)[0]
get_unicode = re.findall("\"\+\((.*?)%1000", text.text)[0]
omg_class = 2
a = 1
b = a + 1
c = b + 1
d = omg_class * 2
asu = get_zippy_url.replace("/v/","/d/")+"/"+str(int(get_unicode)%1000 + a + b + c + d + 5/5)+"/Otakudesu_SAO.AWU--21_720p.mp4"
print(asu)
