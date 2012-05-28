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
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.PopupWindow;
import android.widget.TextView;
import android.widget.Toast;
import android.view.MenuItem;

public class FriendList extends Activity{
    ArrayList<FriendItem> arItem;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.friendlist);
        arItem = new ArrayList<FriendItem>();
        FriendItem friendItem;
        friendItem = new FriendItem(R.drawable.ic_launcher, "최윤섭", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "챠챠챠", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "쵸쵸쵸", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "키키키", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "최윤섭", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "챠챠챠", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "쵸쵸쵸", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "키키키", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "최윤섭", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "챠챠챠", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "쵸쵸쵸", "안녕?");	 arItem.add(friendItem);
        friendItem = new FriendItem(R.drawable.ic_launcher, "키키키", "안녕?");	 arItem.add(friendItem);

        FListAdapter fListAdapter = new FListAdapter(this, R.layout.maum_row, arItem);
        ListView FriendList;
        FriendList =(ListView) findViewById(R.id.flist);
        FriendList.setAdapter(fListAdapter);
    }
    public boolean onCreateOptionsMenu(Menu menu) {
    	super.onCreateOptionsMenu(menu);
    	MenuItem item=menu.add(0,1,0,"편집하기");
    	menu.add(0,2,0,"주변검색");
    	menu.add(0,3,0,"홍보하기");
    	return true;
    }
    public boolean onOptionsItemSelected(MenuItem item) {
    	switch (item.getItemId()) {
	    	case 1:
    		Intent intent = new Intent(FriendList.this, EditFList.class);
    		startActivity(intent);
	    	return true;
	    	case 2:
    		Intent intent2 = new Intent(FriendList.this, AroundFList.class);
    		startActivity(intent2);
	    	return true;
	    	case 3:
	    	AlertDialog.Builder builder = new AlertDialog.Builder(this);
	    	builder.setTitle("Promotion");
	    	builder.setMessage("홍보해 임마");
	    	builder.setNeutralButton("close", new DialogInterface.OnClickListener() {
	    		public void onClick(DialogInterface dialog, int which) {
	    		}
	    		
	    		
	    	});
	    	builder.show();
	    	return true;
    	}
    	return false;
    }
}


class FriendItem{
	int 	Img;
	String 	Name;
	String 	Message;

	FriendItem(int img, String name, String message){
		Img = img;
		Name = name;
		Message = message;
	}
}

class FListAdapter extends BaseAdapter{
	Context maincon;
	LayoutInflater Inflater;
	ArrayList<FriendItem> arSrc;
	int layout;
	
	public FListAdapter(Context context, int alayout, ArrayList<FriendItem> aarSrc){
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

		ImageView img = (ImageView)convertView.findViewById(R.id.maum_row_image);
		img.setImageResource(arSrc.get(position).Img);

		TextView name = (TextView) convertView.findViewById(R.id.maum_row_name);
		name.setText(arSrc.get(position).Name);
		
		TextView status = (TextView) convertView.findViewById(R.id.maum_row_maum);
		if(arSrc.get(position).Message != null )
			status.setText(arSrc.get(position).Message);
		else
			status.setVisibility(View.GONE);

		return convertView;
	}
	
	
}