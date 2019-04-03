import cv2
import glob
import time
image_list = []
for filename in glob.glob('C:\\Users\\Nico\\Desktop\\WP/*.jpg'):
    im = cv2.imread(filename)
    image_list.append(im)
i = 0
cv2.namedWindow('Gallery', cv2.WND_PROP_FULLSCREEN)
cv2.setWindowProperty('Gallery', cv2.WND_PROP_FULLSCREEN, cv2.WINDOW_FULLSCREEN)
while True:
        cv2.imshow('Gallery', image_list[i])
        time.sleep(3)
        i += 1
        if image_list.__len__() == i:
            i = 0
        if cv2.waitKey(33) == ord('q'):
            exit()

