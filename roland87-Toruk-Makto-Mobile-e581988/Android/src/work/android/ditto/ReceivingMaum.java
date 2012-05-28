package work.android.ditto;

import java.util.ArrayList;
import android.app.Activity;
import android.os.Bundle;
import android.widget.ListView;

public class ReceivingMaum extends Activity{
	ArrayList<MaumItem> arItem;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.receivingmaum);
        arItem = new ArrayList<MaumItem>();
        MaumItem maumItem;
        maumItem = new MaumItem(R.drawable.ic_launcher, "최윤섭", "안녕?");	 arItem.add(maumItem);

        MaumAdapter maumAdapter = new MaumAdapter(this, R.layout.maum_row, arItem);
        ListView MaumList;
        MaumList =(ListView) findViewById(R.id.rcvmaumlist);
        MaumList.setAdapter(maumAdapter);
    }
}
