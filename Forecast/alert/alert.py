
import json
import pymysql
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt

# get the forecast id from the command args or file or whatever
forecast_id = 1

#conn = pymysql.connect(host='vd745c7.stern.nyu.edu', port=3306, user='admin', passwd='Sba5rtb!', db='alert')
conn = pymysql.connect(host='localhost', port=3306, user='root', passwd='wesvefaj', db='alert')

cur = conn.cursor(pymysql.cursors.DictCursor)
cur.execute("select * from forecasts")
forecasts = cur.fetchall()
i = 0

# loop through all forecasts in the system
for forecast in forecasts:
    i = i + 1
    print "Forecast #" , i
    
    # get the forecast from the sql row
    expected_points = json.loads( forecast["points"] )

    # load forecast into a pandas data frame   
    df_expected = pd.DataFrame(expected_points)

    # get the actual sales for this product
    sql = "select * from sales where product_id = 1;"
    cur.execute(sql)
    df_actual = pd.DataFrame(cur.fetchall())

    # bin expected dates by week

    # bin atual dates by week

    # merge forecast with actuals based on week bin

    # merge forecast and actual frames into combined data frame
    cdf = pd.merge( df_expected, df_actual, left_on = "index", \
                    right_on = "sales_id" )

    # filter rows where date is before forecast's last_alert_date
    
    # select just the rows that are outside of allowed range
    alert_df = cdf[(cdf['observed_value'] > cdf['max']) | \
                   (cdf['observed_value'] < cdf['min'])]

    over_under = ""
    # loop through data frame and compare each actual with range
    for index, row in alert_df.iterrows():
        if ( row["observed_value"] > row["max"] ):
            over_under = "over"
        else:
            over_under = "under"

        # insert into alerts table
        sql = "INSERT INTO alert.alerts (forecast_id,week,observation_date," \
               + "hilo,min,max,observed_value) VALUES ('" + str(forecast_id) \
               + "','week',str_to_date('" + "01-01-2015" + "','%m-%d-%Y'),'"  \
               + over_under + "'," + str(row["min"]) + "," \
               + str(row["max"]) + "," + str(row['observed_value']) + ");"
        
        cur.execute(sql)    
        print sql
        
    # update forecast's last_alert_date to now
    sql = "UPDATE alert.forecasts SET last_alert_date = str_to_date('11-01-2015','%m-%d-%Y') WHERE id = 3;"
    cur.execute(sql)

# commit to db
sql = "COMMIT;"
cur = conn.cursor()
cur.execute(sql)
        
        
# close the connection
cur.close()
conn.close()

