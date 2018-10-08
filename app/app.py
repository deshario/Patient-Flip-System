from collections import deque
import numpy as np
import argparse
import imutils
import cv2
import time
import sys
import datetime
import tkinter as tk
import json
from tkinter import ttk
from tkinter import *
import os
from datetime import datetime as dt
import datetime as DT

from Config.Database import create_records
from Config.Database import create_patient
from Config.Database import loginPatient
from Config.Database import getLatestPosition
from Config.Database import getpId
from Config.Database import getPatientDetails

from Config.HttpRequest import sendMsg
from Config.send_line import sendLine
from Config.HttpRequest import sendMsg
from Config.notify_staff import trig_now


# window = Tk()  # Makes main window
# window.title("New Patient")
main_width = 0
# window.resizable(0, 0)

ap = argparse.ArgumentParser()
ap.add_argument("-v", "--video", help="path to the (optional) video file")
ap.add_argument("-b", "--buffer", type=int, default=64, help="max buffer size")
args = vars(ap.parse_args())

Red_left = []
Red_right = []
Blue_left = []
Blue_right = []
counter = 0
(dX1, dY1) = (0, 0)
(dX2, dY2) = (0, 0)


p_Id = 0
p_Name = ""
p_Bed = ""
p_Time = 0

points1 = deque(maxlen=args["buffer"])
points2 = deque(maxlen=args["buffer"])

if not args.get("video", False):
    camera = cv2.VideoCapture(1)
    # C:\\Users\\Deshario\\Desktop\\Deshario\\Camera Roll\\Patient2\\VDO1.mp4
else:
    camera = cv2.VideoCapture(args["video"])


def countdown(t):
    print('\n Program will Re-Work on next ' + str(t) + ' seconds ! \n')
    while t:
        mins, secs = divmod(t, 60)
        timeformat = '{:02d}:{:02d}'.format(mins, secs)
        # print(' CountDown => '+timeformat)
        sys.stdout.write('\rCountDown => ' + timeformat)
        sys.stdout.flush()
        time.sleep(1)
        t -= 1

def Notifier(pos,_pId_):
    mid = int(_pId_)
    time.sleep(2)
    p_data = getPatientDetails(mid)
    data = json.loads(p_data)
    p_Id = data['id']
    p_Name = data['name']
    p_Bed = data['bed']
    p_Date = data['date']
    p_Pos = str(pos)
    now = DT.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    time_now = DT.datetime.now().strftime("%H:%M:%S")

    t_id = create_records(p_Id,now,pos)
    if t_id != -1:
        sendLine("\nPatient Name : " +str(p_Name)+ "\nBed : " +str(p_Bed)+ "\nPosition : " +str(pos)+ "\nTime : "+now)
        time.sleep(2)
        trig_now(t_id)
        sendMsg(p_Name, p_Bed, time_now, pos) #adruino

def compare(imagename):#'new.jpg'
    my_img = cv2.imread(imagename)
    frame = imutils.resize(my_img, width=600)
    hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)
    blue_lower = np.array([40, 70, 70], np.uint8)
    blue_upper = np.array([80, 200, 200], np.uint8)
    red_lower = np.array([0, 150, 150], np.uint8)
    red_upper = np.array([10, 255, 255], np.uint8)

    bluemask = cv2.inRange(hsv, blue_lower, blue_upper)
    redmask = cv2.inRange(hsv, red_lower, red_upper)

    reddata = cv2.countNonZero(redmask)
    bluedata = cv2.countNonZero(bluemask)

    # print(str(imagename) + " redmask :: "+str(reddata))
    # print(str(imagename) + " bluemask :: "+str(bluedata))
    # cv2.imshow("bluemask", bluemask)
    # cv2.imshow("redmask", redmask)

    if reddata>bluedata:
        return "red"
    elif bluedata>reddata:
        return "blue"
    elif reddata == bluedata:
        return "straight"

def work():
    start = dt.now()
    global counter
    while True:
        seconds = (dt.now() - start).total_seconds()
        sec = '{0:.1g}'.format(seconds)
        pi_time = float(sec)
        a_time = int(pi_time)

        (grabbed, frame) = camera.read()
        if args.get("video") and not grabbed:
            break
        frame = imutils.resize(frame, width=600)
        hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)

        blue_lower = np.array([40, 70, 70], np.uint8)
        blue_upper = np.array([80, 200, 200], np.uint8)
        red_lower = np.array([0, 150, 150], np.uint8)
        red_upper = np.array([10, 255, 255], np.uint8)

        redmask = cv2.inRange(hsv, red_lower, red_upper)
        redmask = cv2.erode(redmask, None, iterations=2)
        redmask = cv2.dilate(redmask, None, iterations=2)
        bluemask = cv2.inRange(hsv, blue_lower, blue_upper)
        bluemask = cv2.erode(bluemask, None, iterations=2)
        bluemask = cv2.dilate(bluemask, None, iterations=2)

        counters1 = cv2.findContours(redmask.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)[-2]
        counters2 = cv2.findContours(bluemask.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)[-2]
        center1 = None
        center2 = None

        ############################## Hand 1 ###############################################

        if len(counters1) > 0:
            c = max(counters1, key=cv2.contourArea)
            ((x, y), radius) = cv2.minEnclosingCircle(c)
            M = cv2.moments(c)
            center1 = (int(M["m10"] / M["m00"]), int(M["m01"] / M["m00"]))
            if radius > 10:
                cv2.circle(frame, (int(x), int(y)), int(radius), (0, 255, 255), 2)

        points1.appendleft(center1)

        for i in np.arange(1, len(points1)):
            if points1[i - 1] is None or points1[i] is None:
                continue
            if counter >= 10 and i == 1 and points1[-10] is not None:
                dX1 = points1[-10][0] - points1[i][0]
                dY1 = points1[-10][1] - points1[i][1]
                (dirX, dirY) = ("", "")

                if np.abs(dX1) > 20:
                    dirX = "East" if np.sign(dX1) == 1 else "West"
                if np.abs(dY1) > 20:
                    dirY = "North" if np.sign(dY1) == 1 else "South"
                if dirX != "" and dirY != "":
                    Ldirection = "{}-{}".format(dirY, dirX)
                else:
                    Ldirection = dirX if dirX != "" else dirY

                if Ldirection == "East" or Ldirection == "North-East" or Ldirection == "South-East":
                    Red_left.insert(counter, "L")

                if Ldirection == "West" or Ldirection == "North-West" or Ldirection == "South-West":
                    Red_right.insert(counter, "R")

                cv2.putText(frame, Ldirection, (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 0, 255), 2)
                cv2.putText(frame, "X: {}, Y: {}".format(dX1, dY1), (10, frame.shape[0] - 10), cv2.FONT_HERSHEY_DUPLEX,
                            0.6, (0, 0, 255), 2)

        for i in range(1, len(points1)):
            if points1[i - 1] is None or points1[i] is None:
                continue
            thickness = int(np.sqrt(args["buffer"] / float(i + 1)) * 2.5)
            cv2.line(frame, points1[i - 1], points1[i], (227, 240, 255), thickness)

            ######################################## Hand 2 #################################################################

        if len(counters2) > 0:
            c = max(counters2, key=cv2.contourArea)
            ((x, y), radius) = cv2.minEnclosingCircle(c)
            M = cv2.moments(c)
            center2 = (int(M["m10"] / M["m00"]), int(M["m01"] / M["m00"]))
            if radius > 10:
                cv2.circle(frame, (int(x), int(y)), int(radius), (0, 255, 255), 2)

        points2.appendleft(center2)

        for i in np.arange(1, len(points2)):
            if points2[i - 1] is None or points2[i] is None:
                continue
            if counter >= 10 and i == 1 and points2[-10] is not None:
                dX2 = points2[-10][0] - points2[i][0]
                dY2 = points2[-10][1] - points2[i][1]
                (dirX, dirY) = ("", "")

                if np.abs(dX2) > 20:
                    dirX = "East" if np.sign(dX2) == 1 else "West"
                if np.abs(dY2) > 20:
                    dirY = "North" if np.sign(dY2) == 1 else "South"
                if dirX != "" and dirY != "":
                    Rdirection = "{}-{}".format(dirY, dirX)
                else:
                    Rdirection = dirX if dirX != "" else dirY

                    if Rdirection == "East" or Rdirection == "North-East" or Rdirection == "South-East":
                        Blue_left.insert(counter, "L")

                    if Rdirection == "West" or Rdirection == "North-West" or Rdirection == "South-West":
                        Blue_right.insert(counter, "R")

                cv2.putText(frame, Rdirection, (450, 30), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (130, 255, 255), 2)
                cv2.putText(frame, "X: {}, Y: {}".format(dX2, dY2), (450, frame.shape[0] - 10), cv2.FONT_HERSHEY_DUPLEX,
                            0.6, (130, 255, 255), 2)

        for i in range(1, len(points2)):
            if points2[i - 1] is None or points2[i] is None:
                continue
            thickness = int(np.sqrt(args["buffer"] / float(i + 1)) * 2.5)
            cv2.line(frame, points2[i - 1], points2[i], (0, 255, 0), thickness)

        ##############################################################################################################

        cv2.imshow("Patient Monitoring System", frame)
        # cv2.imshow("redmask", redmask)
        # cv2.imshow("bluemask", bluemask)
        key = cv2.waitKey(1) & 0xFF
        counter += 1

        if counter == 5: #default image
            cv2.imwrite("old.jpg", frame)

        if key == ord("q"):
            break

            ##############################################################################################################
            #                           Check Turning Position Here                                                      #
            ##############################################################################################################

        if key == ord("p"):
            resetTime()

        if a_time > int(p_Time):
            start = dt.now()
            if os.path.exists("new.jpg") and os.path.exists("old.jpg"):
                os.remove("old.jpg")
                os.rename("new.jpg","old.jpg")
                cv2.imwrite("new.jpg", frame)
                older = compare("old.jpg")
                newer = compare("new.jpg")
                if newer == "blue" and older == "blue": # blue = ขวา || right
                    # print(" Same Right")
                    pos = "No Movement"
                elif newer == "red" and older == "red":
                    # print("red same1")
                    pos = "No Movement"
                elif newer == "straight" and older == "straight":
                    # print("straight same1")
                    pos = "No Movement"
                else:
                    pos = newer

                Notifier(pos,p_Id)

            elif os.path.exists("old.jpg") and not os.path.exists("new.jpg"):
                cv2.imwrite("new.jpg", frame)
                older = compare("old.jpg")
                newer = compare("new.jpg")
                if newer == "blue" and older == "blue":
                    # print("blue same2")
                    pos = "No Movement"
                elif newer == "red" and older == "red":
                    # print("red same2")
                    pos = "No Movement"
                elif newer == "straight" and older == "straight":
                    # print("straight same2")
                    pos = "No Movement"
                else:
                    pos = newer
                    print("newer2" + str(pos))

                Notifier(pos, p_Id)

            #######################################  Checking Ends Here ##################################################

def clear():
    os.system('cls')

def Reg():
    global p_Id
    global p_Time
    clear()
    clear()
    print("\n   ========================")
    print("        Register Patient ")
    print("   =======================")
    _pName = input("\n  Patient Name :: ")
    _pBed = input("\n  Patient Bed :: ")
    _pTime = input("\n  Patient Time in Minutes :: ")
    val = parse_int(_pTime)
    if val != None:
        p_Time = minToSec(val)
        now = DT.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        time_now = DT.datetime.now().strftime("%H:%M:%S")
        create_patient(_pName,_pBed,now)
        time.sleep(1)
        p_Id = getpId(_pName)
        # print("\n p_Id :: "+str(p_Id))
        work()
    else:
        print("\n  Invalid Time")
        time.sleep(2)
        Reg()

def login():
    global p_Time
    global p_Id
    global p_Name
    global p_Bed
    clear()
    print("\n   ========================")
    print("        Login Patient ")
    print("   =======================")
    inp = input("\n  Patient Name :: ")
    pName = str(inp)
    inp = input("\n  Set Time in Minutes :: ")
    val = parse_int(inp)
    if val != None:
        p_Time = minToSec(val)
    else:
        print("Invalid Time")
        time.sleep(2)
        login()
    status1 = loginPatient(pName)
    if status1 == "None":
        print("\n Login Fail ! Please Try Again.")
        time.sleep(2)
        login()
    else:
        print("\n Login Success")
        print("\n  Time Set to :: " + str(val) + " minutes.")
        # print(" status :: "+str(status1))
        data = json.loads(status1)
        p_Id = data['id']
        p_Name = data['name']
        p_Bed = data['bed']
        work()

def parse_int(s):
    try:
        res = int(eval(str(s)))
        if type(res) == int:
            return res
    except:
        return

def mainMeu():
    clear()
    print("\n   =========================================")
    print("           Patient Monitoring System ")
    print("   =========================================")
    print("\n    1. Login Patient")
    print("\n    2. Register Patient")
    print("\n    3. Exit")
    print("\n   =========================================")
    Choice = input("\n  Choose Option :: ")
    val = parse_int(Choice)
    if val != None:
        if val > 0 and val < 4:
            if val == 1:
                login()
            elif val == 2:
                Reg()
            else:
                sys.exit()
        else:
            print("Invalid Choice")
            mainMeu()
    else:
        print("Invalid Choice")
        mainMeu()

def minToSec(min):
    sec = min*60
    return sec

def SecToMin(sec):
    min = sec / 60
    return round(min)

def resetTime():
    global p_Time
    clear()
    print("\n   ================")
    print("      Reset Time ")
    print("   ================")
    print("\n  Current SetTime is :: "+str(SecToMin(p_Time)) + " minutes.")
    new_time = input("\n  New Time in Minutes :: ")
    val = parse_int(new_time)
    if val != None:
        p_Time = minToSec(val)

        print("\n  New Time Set to :: "+str(val)+" minutes.")
    else:
        print("Invalid Time")
        resetTime()

clear()

if __name__ == "__main__":
    mainMeu()
    # work()
    # resetTime()
    # print("sec :: "+str(SecToMin(7652)))
    # print("min :: "+str(minToSec(83)))

camera.release()
cv2.destroyAllWindows()
