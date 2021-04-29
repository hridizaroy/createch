#!/usr/bin/python

# Import modules for CGI handling
import cgi, cgitb
import os
import sys
import math
from datetime import datetime
import MySQLdb

#cgitb.enable()

# Create instance of FieldStorage
post = cgi.FieldStorage()

print("Content-Type: text/html\n")

host = 'localhost'
user = 'hridizaroy'
password = 'Rinik123'
db = 'accountsantidote'
mysqli = MySQLdb.connect(host, user, password, db)

#User details
email = post.getvalue('email')

lat = float(post.getvalue('lat'))
long = float(post.getvalue('long'))

radius = float(post.getvalue('radius'))

#Coordinates in radians
lat_rad = lat*math.pi/180
long_rad = long*math.pi/180

police = bool(post.getvalue('police'))

q = post.getvalue('q')


"""
Haversine formula (to calculate distance between 2 points given their latitude and longitude):
a = sin²(Δφ/2) + cos φ1 ⋅ cos φ2 ⋅ sin²(Δλ/2)
c = 2 ⋅ atan2( √a, √(1−a) )
d = R ⋅ c
where	φ is latitude, λ is longitude, R is earth’s radius;
note that angles need to be in radians to pass to trig functions
"""


def dist(latitude, longitude):
    global lat_rad, long_rad

    latitude = latitude*math.pi/180
    longitude = longitude*math.pi/180

    R = 6.371*(10**6) #Radius of Earth in metres
    a = math.sin( (latitude - lat_rad)/2 )*math.sin( (latitude - lat_rad)/2 ) + math.cos(lat_rad)*math.cos(latitude)*math.sin( (longitude - long_rad)/2 )*math.sin( (longitude - long_rad)/2 )
    c = 2*math.atan2( math.sqrt(a), math.sqrt(1-a) ) #Returns angle from x and y coordinate values
    d = R*c #Distance between the 2 points

    return d

#Getting users within radius
setLocation = mysqli.cursor()
getUsers = mysqli.cursor()

if police:
    setLocation.execute(f"UPDATE police SET latitude = {lat}, longitude = {long} WHERE email = '{email}'")
    getUsers.execute(f"SELECT * FROM civilians")
else:
    setLocation.execute(f"UPDATE civilians SET latitude = {lat}, longitude = {long} WHERE email = '{email}'")
    getUsers.execute(f"SELECT * FROM police")

users = []

rows = getUsers.fetchall()

if(len(rows) != 0):
    if police:
        for row in rows:
            if (dist(row[11], row[10]) <= radius):
                user = row[3]
                users.append(f"'{user}'")

        arr = '(' + ','.join(users) + ')'

        today = datetime.today().strftime('%Y-%m-%d')

        prods = mysqli.cursor()
        prods.execute(f"SELECT * FROM prods WHERE email in {arr} AND expiry >= '{today}' AND (descript LIKE '%{q}%' OR title LIKE '%{q}%')")
    else:
        for row in rows:
            if (dist(row[14], row[15]) <= radius):
                user = row[3]
                users.append(f"'{user}'")

        arr = '(' + ','.join(users) + ')'

        today = datetime.today().strftime('%Y-%m-%d')

        prods = mysqli.cursor()
        prods.execute(f"SELECT * FROM reqs WHERE email in {arr} AND expiry >= '{today}' AND (descript LIKE '%{q}%' OR title LIKE '%{q}%')")

    rows = prods.fetchall()

    if(len(rows) != 0):
        for row in rows:
            print("<div class = 'prod card'>")
            print("<div class='card-body'>")

            if(row[1] == 1):
                type = "Product"
                print(
                    "<img class='card-image' src='images/services-icon-3.svg' alt='alternative'>")
            else:
                type = "Service"
                print(
                    "<img class='card-image' src='images/services-icon-1.svg' alt='alternative'>")

            print("<h4>" + row[2] + "</h4>")
            print("<p>Description: " + row[3] + "</p>")
            print("<p>Type: " + type + "</p>")
            print("<p>Expires on: " + str(row[4]) + "</p>")
            print("<p class = 'user'>" + row[5] + "</p>")
            print("</div></div><br>")
else:
    print("<p>No results for the search</p>")
