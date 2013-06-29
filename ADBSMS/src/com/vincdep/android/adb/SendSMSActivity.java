package com.vincdep.android.adb;

import android.app.Activity;
import android.os.Bundle;
import android.telephony.SmsManager;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
 
public class SendSMSActivity extends Activity {
 
	Button buttonSend;
	EditText textPhoneNo;
	EditText textSMS;
 
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);

		buttonSend = (Button) findViewById(R.id.buttonSend);
		textPhoneNo = (EditText) findViewById(R.id.editTextPhoneNo);
		textSMS = (EditText) findViewById(R.id.editTextSMS);
		
		buttonSend.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				String phoneNo = textPhoneNo.getText().toString();
				String sms = textSMS.getText().toString();
			
				sendSMS(phoneNo, sms);
			}
		});
		
		Bundle extras = this.getIntent().getExtras();
		if (extras != null) {
			if(extras.containsKey ("phoneno")) {
				String phoneNo =  extras.getString("phoneno");
				String sms = extras.containsKey ("sms") ? extras.getString("sms") : "<no body>";
				int count = extras.containsKey ("count") ? Integer.parseInt(extras.getString("count")) : 1;
				
				this.sendSMS(phoneNo, sms, count);
			}
		}
	}
	
	public void sendSMS(String phoneNo, String sms) {
		this.sendSMS(phoneNo, sms, 1);
	}
	
	public void sendSMS(String phoneNo, String sms, int count) {
		try {		
			Log.d("SMS", "[" + phoneNo + "] " + sms);
			
			SmsManager smsManager = SmsManager.getDefault();
			
			for(int i=0; i < count; i++) {
				String body = sms.replace("{i}", String.valueOf(i+1)).replace("{index}", String.valueOf(i+1))
					.replace("{c}", String.valueOf(count)).replace("{count}", String.valueOf(count));
				
				smsManager.sendTextMessage(phoneNo, null, body, null, null);
			}
			
			Toast.makeText(getApplicationContext(), "SMS Sent!", Toast.LENGTH_LONG).show();
		} catch (Exception e) {
			Toast.makeText(getApplicationContext(), "SMS failed, please try again later!", Toast.LENGTH_LONG).show();
			e.printStackTrace();
		}
		this.finish();
	}
}