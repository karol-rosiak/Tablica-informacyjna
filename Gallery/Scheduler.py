import pymongo
from datetime import datetime

dbName = "tablica_informacyjna"
scheduleCol = "schedule"
scheduleTextCol = "textSchedule"

myclient = pymongo.MongoClient("mongodb://localhost:27017/")
mydb = myclient[dbName]


# typy danych - image,video,hmtl,link,webcam
def scheduleMedia():
    dblist = myclient.list_database_names()
    if dbName not in dblist:
        return []

    mycol = mydb["schedule"]
    collist = mydb.list_collection_names()
    if scheduleCol not in collist:
        return []

    dateToday = datetime.today().strftime('%Y-%m-%d')
    query = {"$and": [{"start": {"$lte": dateToday}, "end": {"$gte": dateToday}}]}
    list = []
    for item in mycol.find(query, {"_id": 0}):
        list.append(item)
    return list


def scheduleText():
    dblist = myclient.list_database_names()
    if dbName not in dblist:
        return []

    mycol = mydb["textSchedule"]
    collist = mydb.list_collection_names()
    if scheduleCol not in collist:
        return []

    dateToday = datetime.today().strftime('%Y-%m-%d')
    query = {"$and": [{"start": {"$lte": dateToday}, "end": {"$gte": dateToday}}]}

    list = []
    for item in mycol.find(query, {"_id": 0}):
        list.append(item)
    return list


for x in scheduleMedia():
    print(x["name"] + " " + x["type"] + " - " + x["duration"] + " s")

for x in scheduleText():
    print(x["text"])