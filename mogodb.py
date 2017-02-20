#/usr/bin/python
#coding:gbk
import sys
import pymongo
from netaddr import  IPNetwork
import threading
import pdb
from Queue import Queue
global queue
def conn(addr):
        try:
            conn1 = pymongo.MongoClient(str(addr),27017,socketTimeoutMS=3000)
            dbname = conn1.database_names()
            for n in dbname:
                print "IP:  %s  Success  DB: %s" %  (str(addr),n)
            conn1.close()
        except:
            pass
class MultiThread(threading.Thread):
        def __init__(self):
                threading.Thread.__init__(self)
        def run(self):
                while not queue.empty():
                        ip = queue.get()
                        conn(ip)
def ips(str1):
    print "[*]Start run mongodbscan..."
    print "[*]Wait..."
    for ip in IPNetwork(str1):
        queue.put(ip)
        for i in range(30):
            c = MultiThread()
            c.start()
if __name__ == "__main__":

    commands=sys.argv[1:]
    args="".join(commands)
    if len(args) < 1:
    else:
        ips(args)