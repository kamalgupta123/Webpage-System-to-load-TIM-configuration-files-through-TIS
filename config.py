import MySQLdb
import sys

junction = sys.argv[1]

print(junction)

mydb = MySQLdb.connect(
  host="localhost",
  user="root",
  passwd="itspe",
  database="htms"
)

jsonString = ''

jsonString = "local_configuration= { det_zones= { "

cursor = mydb.cursor()
param="J001"
cursor.execute("SELECT SystemCodeNumber FROM utmc_detector_static WHERE SystemCodeNumber LIKE '%s'" %(junction+"%"))
detZones = cursor.fetchall()

for x in detZones:
  jsonString+=x[0]+','

length=len(jsonString)

jsonString = jsonString[0:length-1] + " }, stg_detectors= { "

cursor.execute("SELECT NumLinks,StageOrder,min_green_time,max_green_time,min_green_offpeak,max_green_offpeak,GROUP_CONCAT(DISTINCT CONCAT(DET_SCN) SEPARATOR ' ') AS DET,InterStageTime FROM utmc_traffic_signal_static INNER JOIN utmc_traffic_signal_stages ON utmc_traffic_signal_static.SignalSCN=utmc_traffic_signal_stages.SignalSCN INNER JOIN `utmc_signal_movements` ON FIND_IN_SET(`utmc_signal_movements`.`id`, REPLACE(TRIM(REPLACE(`utmc_traffic_signal_stages`.`VehicleMovements`, ';', ' ')), ' ', ',')) WHERE utmc_traffic_signal_static.SignalSCN = '%s' GROUP BY StageOrder ORDER BY StageOrder ASC" %(junction))

tabData = cursor.fetchall()

jsonString+='['+str(tabData[0][0])+']= { '

for x in tabData:
    jsonString+='['+str(x[1])+']= {{'
    y=x[6].split(';')
    for item in y:
        if item:
            jsonString+=item+','
    jsonString = jsonString[0:len(jsonString)-1] + '}},'
jsonString = jsonString[0:len(jsonString)-1] + '}}'

jsonString += ', max_stg= { peak={ '

jsonString+='['+str(tabData[0][0])+']={ '

k=''
for x in tabData:
    max=[]
    max.append(x[3])
    for j in max:
        k+=str(j)
    k+=','

jsonString+=k[0:len(k)-1]+'} },'

jsonString+=' offpeak= { '

jsonString+='['+str(tabData[0][0])+']={ '

k=''
for x in tabData:
    max=[]
    max.append(x[5])
    for j in max:
        k+=str(j)
    k+=','

jsonString+=k[0:len(k)-1]+'} } }, min_stg={ peak={ '

jsonString+='['+str(tabData[0][0])+']={ '

k=''
for x in tabData:
    min=[]
    min.append(x[2])
    for i in min:
        k+=str(i)
    k+=','

jsonString+=k[0:len(k)-1]+'} },'

jsonString+=' offpeak ={ '

jsonString+='['+str(tabData[0][0])+']={ '

k=''
for x in tabData:
    max=[]
    max.append(x[4])
    for j in max:
        k+=str(j)
    k+=','

jsonString+=k[0:len(k)-1]+'} } }, istg = {'

jsonString+='['+str(tabData[0][0])+']={ '

k=''
for x in tabData:
    max=[]
    max.append(x[7])
    for j in max:
        k+=str(j)
    k+=','

jsonString+=k[0:len(k)-1]+'} },'


cursor.execute("SELECT * FROM `tis_signal_configuration` WHERE SignalSCN = '%s'" %(junction))

configurationData = cursor.fetchall()

jsonString+='thresholds={ cumulative_threshold ={peak='

for x in configurationData:
    jsonString+=str(x[1])+', offpeak = '+str(x[2])+' }, threshold = { peak = '+str(x[3])+', offpeak ='+str(x[4])+' } }, peaks = { weekday = { peak_start = {'
    k=x[5].split(',')
    for i in k:
        jsonString+="'"+str(i)+"',"
    jsonString=jsonString[0:len(jsonString)-1]
    jsonString+='}, peak_end = {'
    t=x[6].split(',')
    for j in t:
        jsonString+="'"+str(j)+"',"
    jsonString=jsonString[0:len(jsonString)-1]
    jsonString+='}'
    jsonString+='} }, weekend = { peak_start = {'
    b=x[7].split(',')
    for a in b:
        jsonString+="'"+str(a)+"',"
    jsonString=jsonString[0:len(jsonString)-1]
    jsonString+='}'
    jsonString+=', peak_end = {'
    d=x[8].split(',')
    for c in d:
        jsonString+="'"+str(c)+"',"
    jsonString=jsonString[0:len(jsonString)-1]
    jsonString+='}'
    jsonString+='} } }'


#json pure
jsonString2 = ''
jsonString2 = "{ \"local_configuration\" : { \"det_zones\" : { "

cursor.execute("SELECT SystemCodeNumber FROM utmc_detector_static WHERE SystemCodeNumber LIKE '%s'" %(junction+"%"))
detZones2 = cursor.fetchall()
count=0

for x2 in detZones2:
  jsonString2+="\""+str(count)+"\":\""+x2[0]+'",'
  count+=1

length2=len(jsonString2)

jsonString2 = jsonString2[0:length2-1] + " }, \"stg_detectors\" : { "

cursor.execute("SELECT NumLinks,StageOrder,min_green_time,max_green_time,min_green_offpeak,max_green_offpeak,GROUP_CONCAT(DISTINCT CONCAT(DET_SCN) SEPARATOR ' ') AS DET,InterStageTime FROM utmc_traffic_signal_static INNER JOIN utmc_traffic_signal_stages ON utmc_traffic_signal_static.SignalSCN=utmc_traffic_signal_stages.SignalSCN INNER JOIN `utmc_signal_movements` ON FIND_IN_SET(`utmc_signal_movements`.`id`, REPLACE(TRIM(REPLACE(`utmc_traffic_signal_stages`.`VehicleMovements`, ';', ' ')), ' ', ',')) WHERE utmc_traffic_signal_static.SignalSCN = '%s' GROUP BY StageOrder ORDER BY StageOrder ASC" %(junction))

tabData2 = cursor.fetchall()

jsonString2+='"'+str(tabData2[0][0])+'" : { '

count1=0
for x2 in tabData:
    jsonString2+='"'+str(x2[1])+'": {'
    y2=x2[6].split(';')
    for item2 in y2:
        if item2:
            jsonString2+="\""+str(count1)+"\":\""+item2+'",'
            count1+=1
    jsonString2 = jsonString2[0:len(jsonString2)-1] + '},'
jsonString2 = jsonString2[0:len(jsonString2)-1] + '}}'

jsonString2 += ', \"max_stg\": { \"peak\":{ '

jsonString2+='"'+str(tabData2[0][0])+'":{ '

k2=''
count2=0;
for x2 in tabData2:
    max2=[]
    max2.append(x2[3])
    for j2 in max2:
        k2+="\""+str(count2)+"\":\""+str(j2)
        count2+=1
    k2+='",'

jsonString2+=k2[0:len(k2)-1]+'} },'

jsonString2+=' \"offpeak\" : { '

jsonString2+='"'+str(tabData2[0][0])+'":{ '

k2=''
count3=0;
for x2 in tabData2:
    max2=[]
    max2.append(x2[5])
    for j2 in max2:
        k2+="\""+str(count3)+"\":\""+str(j2)
        count3+=1
    k2+='",'

jsonString2+=k2[0:len(k2)-1]+'} } }, "min_stg":{ "peak":{ '

jsonString2+='"'+str(tabData2[0][0])+'":{ '

k2=''
count4=0;
for x2 in tabData2:
    min2=[]
    min2.append(x2[2])
    for i2 in min2:
        k2+="\""+str(count4)+"\":\""+str(i2)
        count4+=1
    k2+='",'

jsonString2+=k2[0:len(k2)-1]+'} },'

jsonString2+=' "offpeak" : { '

jsonString2+='"'+str(tabData2[0][0])+'":{ '

k2=''
count5=0;
for x2 in tabData2:
    max2=[]
    max2.append(x2[4])
    for j2 in max2:
        k2+="\""+str(count5)+"\":\""+str(j2)
        count5+=1
    k2+='",'

jsonString2+=k2[0:len(k2)-1]+'} } }, "istg" : {'

jsonString2+='"'+str(tabData2[0][0])+'":{ '

k2=''
count6=0;
for x2 in tabData2:
    max2=[]
    max2.append(x2[7])
    for j2 in max2:
        k2+="\""+str(count6)+"\":\""+str(j2)
        count6+=1
    k2+='",'

jsonString2+=k2[0:len(k2)-1]+'} },'


cursor.execute("SELECT * FROM `tis_signal_configuration` WHERE SignalSCN = '%s'" %(junction))

configurationData2 = cursor.fetchall()

jsonString2+='"thresholds":{ "cumulative_threshold" :{"peak":'

for x2 in configurationData2:
    jsonString2+="\""+str(x2[1])+'\", \"offpeak\" : "'+str(x2[2])+'" }, "threshold" : { "peak" : "'+str(x2[3])+'", "offpeak" :"'+str(x2[4])+'" } }, "peaks" : { "weekday" : { "peak_start" : {'
    k2=x2[5].split(',')
    cou=0
    for i2 in k2:
        jsonString2+="\""+str(cou)+"\":\""+str(i2)+"\","
        cou+=1
    jsonString2=jsonString2[0:len(jsonString2)-1]
    jsonString2+='}, "peak_end" : {'
    t2=x2[6].split(',')
    cou1=0
    for j2 in t2:
        jsonString2+="\""+str(cou1)+"\":\""+str(j2)+"\","
        cou1+=1
    jsonString2=jsonString2[0:len(jsonString2)-1]
    jsonString2+='}'
    jsonString2+='} }, "weekend" : { "peak_start" : {'
    b2=x2[7].split(',')
    cou2=0
    for a2 in b2:
        jsonString2+="\""+str(cou2)+"\":\""+str(a2)+"\","
        cou2+=1
    jsonString2=jsonString2[0:len(jsonString2)-1]
    jsonString2+='}'
    jsonString2+=', "peak_end" : {'
    d2=x2[8].split(',')
    cou3=0
    for c2 in d2:
        jsonString2+="\""+str(cou3)+"\":\""+str(c2)+"\","
        cou3+=1
    jsonString2=jsonString2[0:len(jsonString2)-1]
    jsonString2+='}'
    jsonString2+='} } }'


print(jsonString2) 

text_file = open("configuration.lua", "w")
n = text_file.write(jsonString)
text_file.close()


    

