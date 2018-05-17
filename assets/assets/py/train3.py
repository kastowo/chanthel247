# train3.py
import cv2, sys, numpy, os
import subprocess
import time
size = 4
fn_haar = 'haarcascade_frontalface_default.xml'
fn_dir = 'att_faces'
#status = 0

#def getN():
try:
	fn_name = sys.argv[1]
except:
	#print("You must provide a name")
	sys.exit(0)
path = os.path.join(fn_dir, fn_name)
if not os.path.isdir(path):
	os.mkdir(path)
(im_width, im_height) = (112, 92)
haar_cascade = cv2.CascadeClassifier(fn_haar)
webcam = cv2.VideoCapture(0)

pin=sorted([int(n[:n.find('.')]) for n in os.listdir(path)
	 if n[0]!='.' ]+[0])[-1] + 1

count = 0
pause = 0
count_max = 20
while count < count_max:

	rval = False
	(rval, frame) = webcam.read()
	while(not rval):
		
		status = 1
		
		#print "mandeg"
		#return 1
		sys.exit() 
		   
	height, width, channels = frame.shape
	frame = cv2.flip(frame, 1, 0)
	gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
	mini = cv2.resize(gray, (int(gray.shape[1] / size), int(gray.shape[0] / size)))
	faces = haar_cascade.detectMultiScale(mini)
	faces = sorted(faces, key=lambda x: x[3])
	if faces:
		face_i = faces[0]
		(x, y, w, h) = [v * size for v in face_i]

		face = gray[y:y + h, x:x + w]
		face_adp = cv2.adaptiveThreshold(face,255,cv2.ADAPTIVE_THRESH_MEAN_C, cv2.THRESH_BINARY,11,2)
		face_resize = cv2.resize(face_adp, (im_width, im_height))

		cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 3)
		cv2.putText(frame, fn_name, (x - 10, y - 10), cv2.FONT_HERSHEY_PLAIN,
			1,(0, 255, 0))

		#if(w * 6 < width or h * 6 < height):
		#	#print("Face too small")
		#else:
		if(w * 6 > width or h * 6 > height):
			if(pause == 0):

				#print("Saving training sample "+str(count+1)+"/"+str(count_max))

				cv2.imwrite('%s/%s.png' % (path, pin), face_resize)

				pin += 1
				count += 1

				pause = 1
				#status=2
					
	if(pause > 0):
		pause = (pause + 1) % 5
	cv2.imshow('OpenCV', frame)
	key = cv2.waitKey(10)
	if key == 27:
		break
print "ahir"		
#return status
#getN()
	#webcam.release()
	#pl = subprocess.Popen(['bash', 'startmotion.sh' ], stdout=subprocess.PIPE).communicate()[0]
	#print pl
            

