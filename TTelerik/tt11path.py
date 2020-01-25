# -*- coding: utf-8 -*-
import requests, threading, sys, time, itertools
from enum import Enum
from Queue import Queue
requests.packages.urllib3.disable_warnings()

list = ["/DesktopModules/Admin/RadEditorProvider/DialogHandler.aspx","/app_master/telerik.web.ui.dialoghandler.aspx","/Providers/HtmlEditorProviders/Telerik/Telerik.Web.UI.DialogHandler.aspx","/common/admin/Jobs2/Telerik.Web.UI.DialogHandler.aspx","/dashboard/UserControl/CMS/Page/Telerik.Web.UI.DialogHandler.aspx","/DesktopModules/News/Telerik.Web.UI.DialogHandler.aspx","/desktopmodules/telerikwebui/radeditorprovider/telerik.web.ui.dialoghandler.aspx","/DesktopModules/dnnWerk.RadEditorProvider/DialogHandler.aspx","/DesktopModules/TNComments/Telerik.Web.UI.DialogHandler.aspx","/DesktopModules/YA.Controls/AngularMain/Telerik.Web.UI.DialogHandler.aspx","/DesktopModules/Base/EditControls/Telerik.Web.UI.DialogHandler.aspx"]

class Sequence(Enum):
    """Enumeration of spinner sequence

    Ref: https://stackoverflow.com/questions/2685435/cooler-ascii-spinners
    """

    BASIC = ['-', '/', '|', '\\']
    TRIANGLE = ['◢', '◣', '◤', '◥']

    def describe(self):
        return self.name, self.value

    @classmethod
    def default_sequence(cls):
        return Sequence.BASIC


class Spinner():
    """A shell spinner
    """

    def __init__(self, message="", interval=0.25, sequence="BASIC", offset=1):
        self.stop_running = threading.Event()
        self.spin_thread = threading.Thread(target=self.init_spin)
        self.interval = interval  # speed rotation
        self.message = message  # spinner text
        self.offset = offset  # number of space to pad on the left
        self.spinner_cycle = itertools.cycle(self.set_spinner_seq(sequence))

    def set_spinner_seq(self, sequence):
        seq_list = [name for name, members in Sequence.__members__.items()]
        if sequence.upper() in seq_list:
            seq = Sequence[sequence.upper()].value
        else:
            seq = Sequence.default_sequence().value
        return seq

    def start(self):
        self.spin_thread.start()

    def stop(self):
        self.stop_running.set()
        self.spin_thread.join()
        # make sure to clear the line in case printing something shorter after
        sys.stdout.write("\033[K")

    def init_spin(self):
        while not self.stop_running.is_set():
            if not self.message:
                cur_mess = next(self.spinner_cycle)
            else:
                cur_mess = "{} {}".format(next(self.spinner_cycle),
                                          self.message)
            cur_mess = cur_mess.rjust(len(cur_mess) + self.offset, ' ')
            sys.stdout.write(cur_mess)
            sys.stdout.flush()
            time.sleep(self.interval)
            sys.stdout.write('\b' * len(cur_mess))

def test(asu):
	print("\r"+asu)
	time.sleep(2)
	
def check(url):
	try:
		for path in list:
			source = requests.get(url+path, verify=False, timeout=10, headers={"User-agent":"Linux Mozilla"}).text
			if "Loading the dialog" in source:
				found = url+path
				save = open("found_telerik.txt","a")
				save.write(found+"\n")
				save.close()
				print("\033[32;1m"+found+"\033[0m")
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
	messa = 'Please wait, jobs is running ...'
	speed = 0.1
	seq = 'TRIANGLE'
	off = 2
	spinner2 = Spinner(messa, speed, seq, off)
	spinner2.start()
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
	spinner2.stop()
except KeyboardInterrupt:
	print("CTRL + C Closed")
	exit()
