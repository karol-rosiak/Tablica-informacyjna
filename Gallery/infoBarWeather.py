import tkinter as tk
import time
import weather
from PIL import Image,ImageTk

def tick():
    time_string = time.strftime("%H:%M:%S")
    clock.config(text=time_string)
    clock.after(200, tick)

def display_weather(current_info):
    if current_info < len(weather_info):
        weather_condition_label.config(text=weather_info[current_info][0])
        if weather_info[current_info][0] != "Pogoda":
            weather_condition_info.config(image='')
            weather_condition_info.config(text=weather_info[current_info][1])
        else:
            im = Image.open('icon/' + weather_info[current_info][1] + '.png')
            im = im.resize((20, 20), Image.ANTIALIAS)
            ph = ImageTk.PhotoImage(im)
            weather_condition_info.config(image=ph)
            weather_condition_info.image = ph

        weather_condition_label.after(2000, display_weather,current_info+1)
    else:
        current_info = 0
        weather_condition_label.config(text=weather_info[current_info][0])
        weather_condition_info.config(text=weather_info[current_info][1])
        weather_condition_label.after(2000, display_weather,current_info+1)

def update_weather():

    current_w = weather.get_current_weather('a874452b76f1cc6022316d344c4ac034','Poznan')
    weather_info = weather.dict_to_string_tuple(current_w)
    weather_condition_info.after(1800000)
root = tk.Tk()
root.wm_attributes('-type', 'splash') #to dodalem zeby usunelo gorny pasek z minimlaizacja itp
root.geometry("100x100")
root.resizable(0, 0) #Don't allow resizing in the x or y direction
root.geometry("+0+800")

frame = tk.Frame(root, width=150, height=150) #size of the info square
frame.pack()

current_w = weather.get_current_weather('a874452b76f1cc6022316d344c4ac034','Poznan')
weather_info = weather.dict_to_string_tuple(current_w)
current_info = 0

weather_condition_label = tk.Label(frame, text="Cloudiness:",font=("Calibri",10))
weather_condition_label.pack()

weather_condition_info = tk.Label(frame, text="55%",font=("Calibri",10))
weather_condition_info.pack()
display_weather(current_info)

line_break = tk.Label(frame, text="",font=("Calibri",10))
line_break.pack()

clock = tk.Label(frame, text="00:00:00",font=("Calibri",13,"bold"))
clock.pack()
tick()

root.attributes('-topmost', True)

root.mainloop()
