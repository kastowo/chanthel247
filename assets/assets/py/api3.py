from flask import Flask
from flask_restful import reqparse, abort, Api, Resource
import subprocess
import time
import os
app = Flask(__name__)
api = Api(app)


class Test(Resource):
    def get(self, nama , key):
    	if key == "123":
            
            #pl = subprocess.Popen(['bash', 'stopmotion.sh' ], stdout=subprocess.PIPE).communicate()[0]
            #print "motion has been " +pl
            #x = subprocess.Popen(['python', 'train3.py', nama], stdout=subprocess.PIPE).communicate()[0]
            #subprocess.call(['python', 'train3.py', nama])
            #time.sleep(0.1)
            #while str(x) == "mandeg\n":
			#	time.sleep(0.1)
            x = subprocess.Popen(['/usr/bin/python', '/var/www/html/setopbox3/assets/py/train.py', nama], stdout=subprocess.PIPE).communicate()[0]
            print "status " + str(x)
            
            #st = subprocess.Popen(['bash', 'startmotion.sh' ], stdout=subprocess.PIPE).communicate()[0]
            #return "success " + str(x) + str(st)
            
    	else:
            # print "not authorized"
            return "not authorized"
        
            # return nama
            # return "success"
api.add_resource(Test, '/test/<nama>/<key>')


if __name__ == '__main__':
    app.run(debug=True)
    #app.run(host='192.168.2.69', port=8282, debug=True)
