import requests
import json
import time
from sendsms import sendSMS as _sendSMS

url = 'http://localhost/sms/'

def sendSMS(id, phoneNo, sms):
	_sendSMS(phoneNo, sms, 1)
	requests.get(url + 'removesms.php?id=%s&pass=haha' % id);

def loop():
	print 'Checking sms...'
	r = requests.get(url + 'pendingsms.php');
	cmd = 'python sendsms.py -p %s -s %s -c 1'

	if r.status_code == 200:
		pendingSMS = r.json()
		
		count = len(pendingSMS)
		
		if count > 0:
			print 'Find %s sms' % count
			for l in pendingSMS:		
				sendSMS(l['id'], l['phoneNo'], l['sms'])
				time.sleep(3)		
		else:
			print 'No sms... wait 5sec'
			time.sleep(5)
	else:
		print 'An erroc occurs...'
		return False
	
	return True
def main():
	while loop():
		print 'Next loop!'
		
if __name__ == "__main__":
    main()