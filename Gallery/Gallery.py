import cv2
import time as t
import imgkit
import scheduler

file = 'C:\\Users\\Karol\\Desktop\\screen\\'


def video(filename):
    cap = cv2.VideoCapture(file+filename)

    while (cap.isOpened()):
        ret, frame = cap.read()
        print(ret)
        if ret:
            cv2.imshow('Gallery', frame)
            if cv2.waitKey(33) == 27:
                exit()
                break
        else:
            break
    cap.release()

def img(filename,time):
    cv2.imshow('Gallery', cv2.imread(file+filename))
    if cv2.waitKey(33) == ord('q'):
        exit()
    t.sleep(int(time))

def u(filename,time):
    imgkit.from_url(filename, file+"out.jpg")
    cv2.imshow('Gallery', cv2.imread(file + filename))
    if cv2.waitKey(33) == ord('q'):
        exit()
    t.sleep(int(time))

i = 0
cv2.namedWindow('Gallery', cv2.WND_PROP_FULLSCREEN)
cv2.setWindowProperty('Gallery', cv2.WND_PROP_FULLSCREEN, cv2.WINDOW_FULLSCREEN)

l=scheduler.scheduleMedia()
print(l)
while True:
    for x in l:
        if x["type"] == 'image':
            img(x["name"], x["duration"])
        if x["type"] == 'video':
            video(x["name"])
        if x["type"] == 'url':
            u(x["name"], x["duration"])
