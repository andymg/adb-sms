import time, sys, subprocess
import getopt

def usage():
	print 'Send sms:'
	print '  -p --phone    the phone number'
	print '  -s --sms      body message'
	print '  -c --count    count'
	print ''
	print 'Template:'
	print '  {i}, {index}  current index'
	print '  {c}, {count}  count'
	print ''
	
def sendSMS(phoneNo, sms, count):
	print "[%s](x%s) %s" % (phoneNo, count, sms)
	
	cmd = 'adb shell am start -a android.intent.action.MAIN -c android.intent.category.LAUNCHER'
	cmd = cmd + ' -e phoneno %s'
	cmd = cmd + ' -e sms "%s"'
	cmd = cmd + ' -e count %s'
	cmd = cmd + ' -n com.vincdep.android.adb/com.vincdep.android.adb.SendSMSActivity' 
	cmd = cmd % (phoneNo, sms, count)

	process = subprocess.Popen(cmd, stdout=subprocess.PIPE, shell=True)
	
	return True
	
def checkPhoneNumber(phoneNo):
	return len(phoneNo) > 0
	
def main(argv):
	try:                                
		opts, args = getopt.getopt(argv, "hp:s:c:", ["help", "phone=", "sms=", "count="]) 
	except getopt.GetoptError:           
		usage()                          
		sys.exit(2)   

	phoneNo = ''
	sms = '<no body>'
	count = 1

	for opt, arg in opts:                
		if opt in ("-h", "--help"):      
			usage()                     
			sys.exit()                  
		if opt in ("-p", "--phone"):      
			phoneNo = arg             
		elif opt in ("-s", "--sms"): 
			sms = arg   			
		elif opt in ("-c", "--count"): 
			count = arg   
	
	if checkPhoneNumber(phoneNo):
		sendSMS(phoneNo, sms, count)
	else:
		usage()

if __name__ == "__main__":
    main(sys.argv[1:])