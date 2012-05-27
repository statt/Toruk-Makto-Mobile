package work.android.ditto;
import android.app.TabActivity;
import android.content.Intent;
import android.os.Bundle;
import android.widget.TabHost;
public class MainActivity extends TabActivity{

    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        final TabHost tabHost = getTabHost();
        tabHost.addTab(tabHost.newTabSpec("tab1")
                .setIndicator("친구목록", getResources().getDrawable(R.drawable.user2))
                .setContent(new Intent(this, FriendList.class)
                .addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP)));	// 클릭할때 마다 리플레쉬

        tabHost.addTab(tabHost.newTabSpec("tab2")
                .setIndicator("받은마음", getResources().getDrawable(R.drawable.maum2))
                .setContent(new Intent(this, ReceivingMaum.class)
                .addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP)));

        tabHost.addTab(tabHost.newTabSpec("tab3")
                .setIndicator("보낸마음", getResources().getDrawable(R.drawable.maum1))
                .setContent(new Intent(this, SendingMaum.class)
                .addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP)));
         
        tabHost.addTab(tabHost.newTabSpec("tab4")
                .setIndicator("설정", getResources().getDrawable(R.drawable.config))
                .setContent(new Intent(this, Config.class)
                .addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP)));
        
//        TextView MyText = new TextView(this);
//        MyText.setText("test");
//        setContentView(MyText);
    }
}