# import socket programming library
import socket
import pyautogui
from _thread import *
import threading

print_lock = threading.Lock()

def threaded(c):
    pic = pyautogui.screenshot()
    pic.save('Screenshot.png')

    print_lock.release()

    c.close()


def Main():
    host = "127.0.0.1"

    port = 65432
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.bind((host, port))
    print("socket binded to post", port)

    s.listen(5)
    print("socket is listening")

    while True:

        c, addr = s.accept()

        print_lock.acquire()
        print('Connected to :', addr[0], ':', addr[1])

        start_new_thread(threaded, (c,))
    s.close()


if __name__ == '__main__':
    Main()
