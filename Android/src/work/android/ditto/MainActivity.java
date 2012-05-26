package work.android.ditto;

import android.app.Activity;
import android.os.Bundle;

public class MainActivity extends Activity {
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        //Button btn = (Button)findViewById(R.id.button1);
//        btn.setOnClickListener(new Button.OnClickListener(){
//			public void onClick(View arg0) {
//				String str = new String("토스트 맛있는 토스트~");
//				Toast.makeText(MainActivity.this, str, Toast.LENGTH_SHORT).show();
//			}
//        });
        
//        TextView MyText = new TextView(this);
//        MyText.setText("test");
//        setContentView(MyText);
    }
}