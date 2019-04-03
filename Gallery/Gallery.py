import cv2
import glob

image_list = []
for filename in glob.glob('C:\\Users\\Nico\\Desktop\\WP/*.jpg'):
    im = cv2.imread(filename)
    image_list.append(im)
i = 0
while True:
        cv2.imshow('Gallery', image_list[i])
        cv2.waitKey(10000)
        i += 1
        if image_list.__len__() == i:
            i = 0

