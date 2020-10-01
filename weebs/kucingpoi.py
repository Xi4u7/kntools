# -*- coding: utf-8 -*-
import requests, re
linkpoi = raw_input('linkpoi.cc: ')
s = requests.session()
req1 = s.get(linkpoi).text
get1 = re.findall('<a href="(.*?)" class="btn btn-primary btn-block redirect" rel="nofollow">Menuju Link</a></center>', req1)[0]
req2 = s.get(get1).text
formpost = re.findall('<form method="POST" action="(.*?)"', req2)[0]
_token = re.findall('<input name="_token" type="hidden" value="(.*?)">', req2)[0]
data = {'_token': _token, 'x-token': '', 'v-token': ''}
req3 = s.post(formpost, data=data).text
formpost = re.findall('<form method="POST" action="(.*?)"', req3)[0]
_token = re.findall('<input name="_token" type="hidden" value="(.*?)">', req2)[0]
data2 = {'_token': _token, 'x-token': ''}
req4 = s.post(formpost, data=data2, allow_redirects=False)
url = req4.headers["Location"]

text = requests.get(url)
get_zippy_url = re.findall('"text": "(.*?)/file.html"', text.text)[0]
get_unicode = re.findall("\"\+\((.*?)%1000", text.text)[0]
omg_class = 2
a = 1
b = a + 1
c = b + 1
d = omg_class * 2
title = re.findall('5\/5\)\+"\/(.*?)";', text.text)[0]
asu = get_zippy_url.replace("/v/","/d/")+"/"+str(int(get_unicode)%1000 + a + b + c + d + 5/5)+"/"+title
print asu
