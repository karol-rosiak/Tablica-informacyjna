var getJSON = function(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.responseType = 'json';
    xhr.onload = function() {
      var status = xhr.status;
      if (status === 200) {
        callback(null, xhr.response);
      } else {
        callback(status, xhr.response);
      }
    };
    xhr.send();
};

window.addEventListener("load",  function() {

  var apiStatus = document.getElementById('apiStatus');
  var apiKey = document.getElementById('apiKey').value;
  var city = document.getElementById('city').value;
  getJSON('http://api.openweathermap.org/data/2.5/weather?q='+ city + '&units=metric&appid=' + apiKey,
  function(err, data) {
    if (err !== null) {
      document.getElementById("tableWeather").style.display = "none";
      if(err === 401)
      apiStatus.innerHTML = "Status API: <font color='red'> Zły klucz API</font>";
      else if(err === 404) apiStatus.innerHTML = "Status API: <font color='red'> Błędne miasto</font>";
      else
       apiStatus.innerHTML = "Status API: <font color='red'> Nieznany błąd</font>";
    } else {
       apiStatus.innerHTML = "Status API: <font color='green'> Aktywny</font>";
        document.getElementById('temperatura').innerHTML = data['main']['temp']
        document.getElementById('cisnienie').innerHTML = data['main']['pressure']
        document.getElementById('wilgotnosc').innerHTML = data['main']['humidity']
        document.getElementById('pogoda').innerHTML = data['weather'][0]['icon']
        document.getElementById('pochmurnosc').innerHTML = data['clouds']['all']
        document.getElementById('wiatr').innerHTML = data['wind']['speed']
    }
  });
});
