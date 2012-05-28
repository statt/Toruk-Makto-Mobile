package work.android.ditto;

import java.util.ArrayList;
import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

public class FriendList extends Activity{
    ArrayList<FriendItem> arItem;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.friendlist);
        arItem = new ArrayList<FriendItem>();
        FriendItem friendItem;
        friendItem = new FriendItem(R.drawable.ic_launcher, "최윤섭", "안녕?");	 arItem.add(friendItem);

        FListAdapter fListAdapter = new FListAdapter(this, R.layout.maum_row, arItem);
        ListView FriendList;
        FriendList =(ListView) findViewById(R.id.flist);
        FriendList.setAdapter(fListAdapter);
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
		if (convertView == null){
			convertView = Inflater.inflate(layout, parent, false);
		}
		
		ImageView img = (ImageView)convertView.findViewById(R.id.maum_row_image);
		img.setImageResource(arSrc.get(position).Img);

		TextView name = (TextView) convertView.findViewById(R.id.maum_row_name);
		name.setText(arSrc.get(position).Name);
		
		TextView status = (TextView) convertView.findViewById(R.id.maum_row_maum);
		if(arSrc.get(position).Message != null)
			status.setText(arSrc.get(position).Message);
		else
			status.setVisibility(View.GONE);
		
		return convertView;
	}
}