import requests

def get_current_weather(api_key,city):
    response = requests.get(
        'http://api.openweathermap.org/data/2.5/weather?q=' + city + '&units=metric&appid=' + api_key)
    data = response.json()
    w_dict = {
        "temp": data['main']['temp'], # temperatura Celcius
        "pressure":  data['main']['pressure'],  # cisnienie hPa
        "humidity": data['main']['humidity'],  # wilgotnosc %
        "weatherIcon": data['weather'][0]['icon'],   # ikona pogody
        "clouds": data['clouds']['all'],    # pochmurnosc %
        "wind": data['wind']['speed']    # predkosc wiatru m/s
    }
    return(w_dict)

def dict_to_string_tuple(dict):
    w_array = []
    w_array.append(('Temperatura',str(dict["temp"]) + ' °C'))
    w_array.append(('Ciśnienie', str(dict["pressure"]) + ' hPa'))
    w_array.append(('Wilgotność', str(dict["humidity"]) + '%'))
    w_array.append(('Pogoda', dict["weatherIcon"]))
    w_array.append(('Pochmurność', str(dict["clouds"]) + '%'))
    w_array.append(('Wiatr', str(dict["wind"]) + ' m/s'))
    return w_array
