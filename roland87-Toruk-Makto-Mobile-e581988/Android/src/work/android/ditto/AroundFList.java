package work.android.ditto;

import java.util.ArrayList;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

public class AroundFList extends Activity{
    ArrayList<FriendItem2> arItem;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.aroundflist);
        arItem = new ArrayList<FriendItem2>();
        FriendItem2 friendItem;
        friendItem = new FriendItem2(R.drawable.ic_launcher, "최윤섭");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "챠챠챠");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "쵸쵸쵸");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "키키키");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "최윤섭");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "챠챠챠");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "쵸쵸쵸");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "키키키");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "최윤섭");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "챠챠챠");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "쵸쵸쵸");	 arItem.add(friendItem);
        friendItem = new FriendItem2(R.drawable.ic_launcher, "키키키");	 arItem.add(friendItem);

        FListAdapter2 fListAdapter = new FListAdapter2(this, R.layout.around_row, arItem);
        ListView FriendList;
        FriendList =(ListView) findViewById(R.id.flist);
        FriendList.setAdapter(fListAdapter);
    }
    public boolean onCreateOptionsMenu(Menu menu) {
    	super.onCreateOptionsMenu(menu);
    	MenuItem item=menu.add(0,1,0,"새로고침");
    	return true;
    }
    public boolean onOptionsItemSelected(MenuItem item) {
    	switch (item.getItemId()) {
	    	case 1:
    		Intent intent = new Intent(AroundFList.this, AroundFList.class);
    		startActivity(intent);
	    	return true;
    	}
    	return false;
    }
}


class FriendItem2{
	int 	Img;
	String 	Name;

	FriendItem2(int img, String name){
		Img = img;
		Name = name;
	}
}

class FListAdapter2 extends BaseAdapter{
	Context maincon;
	LayoutInflater Inflater;
	ArrayList<FriendItem2> arSrc;
	int layout;
	
	public FListAdapter2(Context context, int alayout, ArrayList<FriendItem2> aarSrc){
		maincon = context;
		Inflater = (LayoutInflater) context.getSystemService(
				Context.LAYOUT_INFLATER_SERVICE);
		arSrc = aarSrc;
		layout = alayout;
	}
	
	public int getCount(){
		return arSrc.size();
	}
	
	public String getItem(int position){
		return arSrc.get(position).Name;
	}
	
	public long getItemId(int position){
		return position;
	}
	
	public View getView(int position, View convertView, ViewGroup parent){
		if (convertView == null ){
			convertView = Inflater.inflate(layout, parent, false);
		}

		ImageView img = (ImageView)convertView.findViewById(R.id.around_row_image);
		img.setImageResource(arSrc.get(position).Img);

		TextView name = (TextView) convertView.findViewById(R.id.around_row_name);
		name.setText(arSrc.get(position).Name);
		

		Button btn = (Button) convertView.findViewById(R.id.around_row_select);

		return convertView;
	}

	
	
}