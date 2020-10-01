# -*- coding: utf-8 -*-
import requests, re
s = requests.session()
req1 = s.get("https://linkpoi.cc/it8zl").text
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
print req4.headers["Location"]
print data2
