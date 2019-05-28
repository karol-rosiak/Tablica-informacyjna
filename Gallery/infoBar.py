import tkinter as tk
import scheduler

text_array = scheduler.scheduleText()
text_final = ''
for x in text_array:
    text_final += (x['text'] + ' * ')

root = tk.Tk()

root.wm_attributes('-type', 'splash') #to dodalem zeby usunelo gorny pasek z minimlaizacja itp
deli = 90        # milliseconds of delay per character
svar = tk.StringVar()
print(root.winfo_screenwidth())
labl = tk.Label(root, textvariable=svar, height=2,width=158,font=("Calibri",13)) #root.winfo_screenwidth() pobiera dlugosc ekranu

root.geometry("+300+850")


def shif():
    shif.msg = shif.msg[1:] + shif.msg[0]
    svar.set(shif.msg)
    root.after(deli, shif)

shif.msg = text_final
shif()
labl.pack()
root.attributes('-topmost', True)

root.mainloop()
