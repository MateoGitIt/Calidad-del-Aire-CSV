import requests
import json
import datetime
import time
import mysql.connector


# EXTRAER DATOS CON API DE AQICN

base_url = "https://api.waqi.info/feed/"
token = "4518705f988780f67feea9461bb58eeaacb0225a"


def guaymaral_pol(lat=4.785387820178285, lng=-74.04272193712805):
    try:
        request_g = requests.get(base_url + f"geo:{lat};{lng}/?token={token}")
        time.sleep(0.2)
        aqi = request_g.json()["data"]["aqi"]
        pm25 = request_g.json()["data"]["iaqi"]["pm25"]["v"]
        pm10 = request_g.json()["data"]["iaqi"]["pm10"]["v"]
        o3 = request_g.json()["data"]["iaqi"]["o3"]["v"]
        no2 = request_g.json()["data"]["iaqi"]["no2"]["v"]
        so2 = request_g.json()["data"]["iaqi"]["so2"]["v"]
        co = request_g.json()["data"]["iaqi"]["co"]["v"]
    except Exception as e:
        print(type(e))
        print(e)
    print("Función polutos OK")
    return aqi, pm25, pm10, o3, no2, so2, co



def guaymaral_weath(lat=4.785387820178285, lng=-74.04272193712805):
    try:
        request_g = requests.get(base_url + f"geo:{lat};{lng}/?token={token}")
        time.sleep(0.2)
        temp = request_g.json()["data"]["iaqi"]["t"]["v"]
        presion = request_g.json()["data"]["iaqi"]["p"]["v"]
        humedad = request_g.json()["data"]["iaqi"]["h"]["v"]
        viento = request_g.json()["data"]["iaqi"]["w"]["v"]
        precip = request_g.json()["data"]["iaqi"]["r"]["v"]

    except Exception as e:
        print(type(e))
        print(e)
        return "N/A"
    print("Función clima OK")
    return temp, presion, humedad, viento, precip

# PONDERACIÓN
def weighing(num):
    weigh = ""
    if num <= 50:
        weigh = "Buena"
    elif num <= 100:
        weigh = "Moderada"
    elif num <= 150:
        weigh = "Peligrosa para personas sensibles"
    elif num <= 200:
        weigh = "Peligrosa"
    elif num <= 300:
        weigh = "Muy peligrosa"
    elif num <= 500:
        weigh = "Altamente tóxica"
    return weigh

# VARIABLES REASIGNADAS A STRING

ponderacion = str(weighing(guaymaral_pol()[0]))
aqi_int = int(guaymaral_pol()[0])
pm25 = str(guaymaral_pol()[1])
pm10 = str(guaymaral_pol()[2])
o3 = str(guaymaral_pol()[3])
no2 = str(guaymaral_pol()[4])
so2 = str(guaymaral_pol()[5])
co = str(guaymaral_pol()[6])

temp = str(guaymaral_weath()[0])
presion = str(guaymaral_weath()[1])
humedad = str(guaymaral_weath()[2])
viento = str(guaymaral_weath()[3])
precip = str(guaymaral_weath()[4])

cnn = mysql.connector.connect(host="localhost", user="root", passwd="1234", database="aire")

today = datetime.datetime.now()
date = today.strftime("%Y/%m/%d/%H%p")

def insertar_datos():
    cur = cnn.cursor()
    sql = f"INSERT INTO calidad (Hora, Ponderacion, PM25, PM10, O3, NO2, SO2, CO, " \
          f"Temperatura, Presion, Humedad, Viento, Precipitacion) VALUES" \
          f"('{date}', '{ponderacion}', {pm25}, {pm10}, {o3}, {no2}, {so2}, {co}, {temp}, " \
          f"{presion}, {humedad}, {viento}, {precip})"
    time.sleep(0.2)
    cur.execute(sql)
    time.sleep(0.2)
    n = cur.rowcount
    cnn.commit()
    cur.close()
    print("Conexión e insertar datos OK")
    return n

insertar_datos()
print("FIN ALCANZADO")
