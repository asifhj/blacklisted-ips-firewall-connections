#Read IPs from database and match with blacklisted IPs
#It get details of all Voilated IPs.

import MySQLdb
import sys
import csv
import GeoIP
import time


print "IPs from DB, to LatLon to CSV to JSON."
print "\nConnecting to DB..."

print "\nConnected to DB"

t0 = time.time()
print "\nExecution start time: ", time.asctime()
print "Epoch start time: ", t0
con='';

try:
	# Open database connection
	con = MySQLdb.connect("localhost","root","root","firewall")

	# Prepare a cursor object using cursor() method
	cur = con.cursor()
	
	cur.execute("SELECT VERSION()")

	ver = cur.fetchone()
	
	print "\n\tDatabase version : %s " % ver

	cur.execute("SELECT Source_IP, Subtype, Pri, Status_IP, COUNT( Source_IP ) AS Total_hits FROM Denied_IPS WHERE Source_IP NOT LIKE  '%10.145.238.222 date=%' GROUP BY Source_IP ORDER BY Total_hits DESC")
   	rows = cur.fetchall()
   	counter=0
   	r=[]
	gi = GeoIP.open("/usr/local/share/GeoIP/GeoIPCity.dat",GeoIP.GEOIP_STANDARD)
	
   	with open('blacklisted_ips_match_count.csv', 'wb') as f:
   		writer = csv.writer(f)
   		r=['Source_IP','Subtype','Pri','Status_IP', 'Total hits', 'country_code','country_code3','country_name','city','region','region_name','postal_code','latitude','longitude','area_code','time_zone','metro_code']
   		writer.writerow(r)
   		r=[]
   		for row in rows:
   			#with open('blacklisted_ips.txt', 'rb') as fr:
	   		#	for i,line in enumerate(fr):
	   				
	   				#if line.strip()==row[0].strip:
	   					print row[0]

		   				r.append(row[0])
			   			r.append(row[1])
			   			r.append(row[2])
			   			r.append(row[3])
			   			r.append(row[4])
						gir = gi.record_by_addr(row[0])
						counter+=1
						if gir != None:
							r.append(gir['country_code'])
							r.append(gir['country_code3'])
							r.append(gir['country_name'])
							r.append(str(gir['city']))
							r.append(gir['region'])
							r.append(gir['region_name'])
							r.append(gir['postal_code'])
							r.append(gir['latitude'])
							r.append(gir['longitude'])
							r.append(gir['area_code'])
							r.append(gir['time_zone'])
							r.append(gir['metro_code'])
							#print str(gir)
						else:
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
							r.append("NA")
				   			
				   		writer.writerow(r)
				   		r=[]
	   			
	   			#if(counter==3):
	   			#	exit()

except MySQLdb.Error, e:
  
	print "\n\tError %d: %s" % (e.args[0],e.args[1])
	sys.exit(1)
	
finally:    
		
	if con:    
		con.close()
		print "\nDB disconnected."



t1 = time.time()
print "\n\tTotal rows: ",counter
print "\nExecution end time: ", time.asctime()
print "Epoch end time: ", t1
total = t1-t0
print "\nTotal taken epoch time: ", total
