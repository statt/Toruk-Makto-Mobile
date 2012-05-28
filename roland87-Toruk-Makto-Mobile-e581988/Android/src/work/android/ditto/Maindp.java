package work.android.ditto;

import android.content.Intent;
import android.app.Activity;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;


public class Maindp extends Activity {
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.maindp);
		
		Handler handler = new Handler() {
			public void handleMessage(Message msg) {
				super.handleMessage(msg);
				startActivity(new Intent(Maindp.this, MainActivity.class));
				finish();
			}
		};
		handler.sendEmptyMessageDelayed(0, 1000);
	}
}