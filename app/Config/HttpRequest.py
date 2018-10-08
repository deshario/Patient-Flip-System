import sys
if sys.version_info[0] == 3:
    from urllib.request import urlopen # Python3
else:
    from urllib import urlopen # Python2

def sendMsg(pName,pBed,pTurned,pPos):
    pName = "Name : "+str(pName)
    pBed = "Bed No : "+str(pBed)
    pTurned = "Turned : "+str(pTurned)
    pPos = "Position :: "+str(pPos)
    my_url = "http://172.20.10.7/"+str(pName)+"/"+str(pBed)+"/"+str(pTurned)+"/"+str(pPos)
    urlopen(my_url)
    with urlopen(my_url) as url:
        data = url.read()
        # print(data)

# sendMsg("name","bed","turned1","123")