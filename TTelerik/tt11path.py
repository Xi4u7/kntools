# -*- coding: utf-8 -*-
import requests, threading, sys, time, itertools
from Queue import Queue
requests.packages.urllib3.disable_warnings()

pler = ["/DesktopModules/Admin/RadEditorProvider/DialogHandler.aspx","/app_master/telerik.web.ui.dialoghandler.aspx","/Providers/HtmlEditorProviders/Telerik/Telerik.Web.UI.DialogHandler.aspx","/common/admin/Jobs2/Telerik.Web.UI.DialogHandler.aspx","/dashboard/UserControl/CMS/Page/Telerik.Web.UI.DialogHandler.aspx","/DesktopModules/News/Telerik.Web.UI.DialogHandler.aspx","/desktopmodules/telerikwebui/radeditorprovider/telerik.web.ui.dialoghandler.aspx","/DesktopModules/dnnWerk.RadEditorProvider/DialogHandler.aspx","/DesktopModules/TNComments/Telerik.Web.UI.DialogHandler.aspx","/DesktopModules/YA.Controls/AngularMain/Telerik.Web.UI.DialogHandler.aspx","/DesktopModules/Base/EditControls/Telerik.Web.UI.DialogHandler.aspx"]

class Spinner(object):
    spinner_cycle = itertools.cycle(['-', '/', '|', '\\'])

    def __init__(self):
        self.stop_running = threading.Event()
        self.spin_thread = threading.Thread(target=self.init_spin)

    def start(self):
        self.spin_thread.start()

    def stop(self):
        self.stop_running.set()
        self.spin_thread.join()

    def init_spin(self):
        while not self.stop_running.is_set():
            sys.stdout.write("\r["+self.spinner_cycle.next()+"] Please wait, jobs is running ...")
            sys.stdout.flush()
            time.sleep(0.25)
            sys.stdout.write('\b')

def test(asu):
	print("\r"+asu)
	time.sleep(2)
	
def check(url):
	try:
		for path in pler:
			source = requests.get(url+path, verify=False, timeout=10, headers={"User-agent":"Linux Mozilla"}).text
			if "Loading the dialog" in source:
				found = url+path
				save = open("found_telerik.txt","a")
				save.write(found+"\n")
				save.close()
				print("\b" * 50 + "\033[32;1m"+found+"\033[0m")
				break
	except:
		pass

try:
	list = open(sys.argv[1]).read()
	thre = sys.argv[2]
except:
	print("python scanner.py list.txt threads")
	exit()

try:
	spinner = Spinner()
	spinner.start()
	asu = list.splitlines()
	jobs = Queue()
	def do_stuff(q):
		while not q.empty():
			value = q.get()
			if value.startswith("http://") or value.startswith("https://"):
				check(value)
			else:
				value2 = "http://"+value
				check(value2)
			q.task_done()
	
	for trgt in asu:
		jobs.put(trgt)
	for i in range(int(thre)):
		worker = threading.Thread(target=do_stuff, args=(jobs,))
		worker.start()
	jobs.join()
	spinner.stop()
except KeyboardInterrupt:
	print("CTRL + C Closed")
	exit()
