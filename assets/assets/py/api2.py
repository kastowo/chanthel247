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
            # print key
    	    #subprocess.call(['sudo', 'service', 'motion', 'stop'])
            #time.sleep(9)
            #subprocess.call(['python', 'train.py', nama])
            #pl = subprocess.Popen(['bash', '-x', 'cek.sh'], stdout=subprocess.PIPE).communicate()[0]
            #return pl
            pl = subprocess.Popen(['bash', 'stopmotion.sh' ], stdout=subprocess.PIPE).communicate()[0]
            #pl = os.system('bash stopmotion.sh')
            print "motion has been " +pl
            cap = subprocess.Popen(['python', 'train5.py', nama], stdout=subprocess.PIPE).communicate()[0]
            print "camera status " +cap[0:4]+" ahir"
            time.sleep(1) 
            while cap[0:4] == 'fail':
                #subprocess.call(['sudo', 'kill', pl])
                #pl = subprocess.Popen(['pgrep', '-x', 'motion'], stdout=subprocess.PIPE).communicate()[0]
                #os.system('sudo kill'+pl )
                cap = subprocess.Popen(['python', 'train5.py', nama], stdout=subprocess.PIPE).communicate()[0]
                print "kamera mati "+cap[0:5]+" ahir" 
                
            	time.sleep(1)    				
            #subprocess.call(['python', 'train3.py', nama])
            subprocess.Popen(['bash', 'startmotion.sh' ], stdout=subprocess.PIPE).communicate()[0]
            return "success"
            
                
				
    	else:
            # print "not authorized"
            return "not authorized"
        
            # return nama
            # return "success"
api.add_resource(Test, '/test/<nama>/<key>')


if __name__ == '__main__':
    app.run(debug=True)
    #app.run(host='192.168.2.69', port=8181, debug=True)
