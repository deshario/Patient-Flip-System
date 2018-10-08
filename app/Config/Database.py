import time
import pymysql as Connector
import json

# db = Connector.connect(host='119.59.104.18', user='psshealt_sunil', passwd='33UZJfOr', db='psshealt_sunil')
db = Connector.connect(host='localhost', user='root', passwd='', db='hospital')
cursor = db.cursor()

def create_patient(name,bed,create):
    try:
        # Prepare SQL query to INSERT a record into the database.
        # sql = "INSERT INTO patient_info(patient_name,patient_bed,patient_created)VALUES(%s,%s,%s)", (name,bed,create)
        sql = "INSERT INTO patient_info(patient_name,patient_bed,patient_created)VALUES(%s,%s,%s)"
        try:
            data = (name,bed,create)
            cursor.execute(sql,data)
            db.commit()
            print('\n Patient Registered')
        except:
            db.rollback()
            print("SQL Error")
    except Connector.Error:
        print('Connection Error')

def create_records(id,p_turn,pos):
    try:
        sql = "INSERT INTO patient_turning(P_id,latest_turned,position)VALUES(%s,%s,%s)"
        try:
            data = (id,p_turn,pos)
            cursor.execute(sql,data)
            db.commit()
            print('\n Records Created')
            last_id = cursor.lastrowid
            return last_id
        except:
            return -1
            db.rollback()
            print("SQL Error")
    except Connector.Error:
        return -1
        print('Connection Error')

def selector():
    try:
        # Execute the SQL command
        cursor.execute("SET NAMES utf8;")
        sql = "SELECT * FROM patient_info"
        sql = sql.encode('utf-8')
        try:
            cursor.execute(sql)
            db.commit()
            re = cursor.fetchall()
            for row in re:
                id = row[0]
                name = row[1]
                lastname = row[2]
                color = row[3]
                print("id=%s, Name=%s, Bed=%s, Date=%s" % (id, name, lastname, color))
        except:
            db.rollback()
            print("SQL Error")
    except:
        print("Error: unable to fetch data")

def loginPatient(pName):
    try:
        cursor.execute("SET NAMES utf8;")
        sql = "SELECT * FROM patient_info WHERE patient_name = '%s'" % (pName)
        sql = sql.encode('utf-8')
        try:
            cursor.execute(sql)
            db.commit()
            re = cursor.fetchone()
            d = {}
            d["id"] = str(re[0])
            d["name"] = str(re[1])
            d["bed"] = str(re[2])
            d["date"] = str(re[3])
            return json.dumps(d)
            # return str(re)
        except:
            db.rollback()
            return "Error"
            print("SQL Error")
    except:
        return "Error"
        print("Error: unable to fetch data")

def getPatientDetails(p_id):
    try:
        cursor.execute("SET NAMES utf8;")
        sql = "SELECT * FROM patient_info WHERE patient_id = '%d'" % (p_id)
        sql = sql.encode('utf-8')
        try:
            cursor.execute(sql)
            db.commit()
            re = cursor.fetchone()
            d = {}
            d["id"] = str(re[0])
            d["name"] = str(re[1])
            d["bed"] = str(re[2])
            d["date"] = str(re[3])
            return json.dumps(d)
            # return str(re)
        except:
            db.rollback()
            return "Error"
            print("SQL Error")
    except:
        return "Error"
        print("Error: unable to fetch data")


def getpId(pName):
    try:
        cursor.execute("SET NAMES utf8;")
        sql = "SELECT patient_id FROM patient_info WHERE patient_name = '%s'" % (pName)
        sql = sql.encode('utf-8')
        try:
            cursor.execute(sql)
            db.commit()
            re = cursor.fetchone()
            return str(re[0])
        except:
            db.rollback()
            return ""
            print("SQL Error")
    except:
        return ""
        print("Error: unable to fetch data")

def getTId(pName):
    try:
        cursor.execute("SET NAMES utf8;")
        sql = "SELECT turning_id FROM patient_turning WHERE patient_name = '%s'" % (pName)
        sql = sql.encode('utf-8')
        try:
            cursor.execute(sql)
            db.commit()
            re = cursor.fetchone()
            return str(re[0])
        except:
            db.rollback()
            return ""
            print("SQL Error")
    except:
        return ""
        print("Error: unable to fetch data")

def getLatestPosition(pId):
    try:
        cursor.execute("SET NAMES utf8;")
        sql = "SELECT patient_turning.position FROM patient_turning INNER JOIN patient_info ON patient_info.patient_id = patient_turning.patient_id WHERE patient_turning.patient_id = '%d' ORDER BY patient_turning.latest_turned DESC LIMIT 1 " %(pId)
        sql = sql.encode('utf-8')
        try:
            cursor.execute(sql)
            db.commit()
            re = cursor.fetchone()
            return str(re[0])
        except:
            db.rollback()
            return ""
            print("SQL Error")
    except:
        return ""
        print("Error: unable to fetch data")

def delete(id):
    try:
        sql = "DELETE FROM patient_info WHERE patient_id = '%d'" % (id)
        #sql = "DELETE FROM patient_info"
        cursor.execute(sql)
        db.commit()
        print("Delete Success")
    except:
        db.rollback()
        print("SQL Error")

def Is_Patient_Exists():
    status = False
    try:
        sql = "SELECT * FROM patient_turning"
        try:
            cursor.execute(sql)
            db.commit()
            if cursor.rowcount >= 1:
                status = True
            else:
                status = False
        except:
            db.rollback()
            status = False
            print("SQL Error")
    except:
        status = False
        print("Error: unable to fetch data")
    return status

def kill_connection():
    if db:
        db.close()

def test():
    print("TEST")

if __name__ == '__main__':
    # selector()
    # delete(0)
    # create_patient("deshario","BED1016",localtime)
    # create_records(18,"2017-09-15 06:00:00","2017-09-15 06:00:00")
    # p_exists = Is_Patient_Exists()
    # print("Exists :: "+str(p_exists))

    # pos = getLatestPosition(4)
    # if pos == "":
    #     print("pos  :: Empty")
    # else:
    #     print("pos :: "+str(pos))
    kill_connection()