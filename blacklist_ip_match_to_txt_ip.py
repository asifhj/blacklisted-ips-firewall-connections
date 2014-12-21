#Read IPs from database and match with blacklisted IPs


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


	# Open database connection
	#con = MySQLdb.connect("localhost","root","root","firewall")

	# Prepare a cursor object using cursor() method
	#cur = con.cursor()
	
	#cur.execute("SELECT VERSION()")

	#ver = cur.fetchone()
	
	#print "\n\tDatabase version : %s " % ver

	#cur.execute("SELECT Source_IP, Subtype, Pri, Status_IP, COUNT( Source_IP ) AS Total_hits FROM Denied_IPS WHERE Source_IP NOT LIKE  '%10.145.238.222 date=%' GROUP BY Source_IP ORDER BY Total_hits DESC")
   	#rows = cur.fetchall()
   	#counter=0
   	#r=[]
	#gi = GeoIP.open("/usr/local/share/GeoIP/GeoIPCity.dat",GeoIP.GEOIP_STANDARD)
	
with open('blacklisted_ips_8Jul-16Jul-compact.txt', 'rb') as f:
	found=0
	
	for i,black_line in enumerate(f):
		with open('src_ip_uniq.txt', 'rb') as fr:
			for j,line in enumerate(fr):
				#print line
				offset=line.find("src=")
				count=str(line[0:offset]).strip()
				ip=str(line[offset+4:]).strip()
				blackip=str(black_line).strip()
				#print ip
				if ip==blackip:
					found+=1
					print ip+"\tInput text line count: "+str(i)+"\tBlacklist records count: "+str(j)
		#print "i: "+str(i)+"j: "+str(j)
#t1 = time.time()
print "i: "+str(i)+"j: "+str(j)
print "\n\tTotal: ",found
print "\nExecution end time: ", time.asctime()
t1 = time.time()
print "Epoch end time: ", t1
total = t1-t0
print found
print "\nTotal taken epoch time: ", total
