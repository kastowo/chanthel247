from flask import Flask
from flask_restful import reqparse, abort, Api, Resource
import subprocess

app = Flask(__name__)
api = Api(app)

class Test(Resource):
    def get(self, nama):
        subprocess.call(['python', 'train.py', nama])
        # return nama
        return "success"
api.add_resource(Test, '/test/<nama>')


if __name__ == '__main__':
    # app.run(debug=True)
    app.run(host='192.168.2.69', port=8181, debug=True)
