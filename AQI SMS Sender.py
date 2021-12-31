import requests
import json
import logging
import datetime
import time
from twilio.rest import Client

class Day:
    def __init__(self, date, location, aqi, weighing):
        self.date = date
        self.location = location
        self.aqi = aqi
        self.weighing = weighing

    def __repr__(self):
        rep = "" + str(self.date) + ": " + self.location + " - " + str(self.aqi) + " - " + self.weighing + ""
        return rep

# Find the AQI of an station with geolocation

base_url = "https://api.waqi.info/feed/"
token = "your key"

def guaymaral_aqi(lat=4.785387820178285, lng=-74.04272193712805):

    try:
        request_g = requests.get(base_url + f"geo:{lat};{lng}/?token={token}")
        time.sleep(1)
        g_aqi = request_g.json()["data"]["aqi"]
    except requests.exceptions.ConnectionError:
        print("Connection was not established correctly...")
        exit()
    return g_aqi

def suba_aqi(lat=4.762463492486517, lng=-74.09331115701266):

    try:
        request_s = requests.get(base_url + f"geo:{lat};{lng}/?token={token}")
        s_aqi = request_s.json()["data"]["aqi"]
    except requests.exceptions.ConnectionError:
        print("Connection was not establish correctly...")
        exit()
    return s_aqi

today = datetime.date.today()
date = today.strftime("%b/%d/%Y")

def define_weighing(num):
    weigh = ""
    if num <= 50:
        weigh = "Good air quality"
    elif num <= 100:
        weigh = "Moderate air quality"
    elif num <= 150:
        weigh = "Risky air quality for sensitive people"
    elif num <= 200:
        weigh = "Dangerous air quality"
    elif num <= 300:
        weigh = "Very dangerous air quality"
    elif num <= 500:
        weigh = "Highly toxic air quality"
    return weigh

def guaymaral_instance():
    guaymaral_loc = Day(date, "Guaymaral", guaymaral_aqi(), define_weighing(guaymaral_aqi()))
    return guaymaral_loc

def suba_instance():
    suba_loc = Day(date, "Suba", suba_aqi(), define_weighing(suba_aqi()))
    return suba_loc

def send_sms(auth='your auth key', sid="your sid key"):
    formatted_text = f"\n{suba_instance()}\n{guaymaral_instance()}"
    client = Client(sid, auth)
    message = client.messages.create(
                                  messaging_service_sid='messaging service sid',
                                  body=formatted_text,
                                  to='phone number'
                              )
    return message

# Remember the to phone number must be authenticated in Twilio´s console page

print(suba_instance())
print(guaymaral_instance())
send_sms()
