package work.android.ditto;

import java.util.ArrayList;
import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

public class EditFList extends Activity{
    ArrayList<FriendItem3> arItem;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.editflist);
        arItem = new ArrayList<FriendItem3>();
        FriendItem3 friendItem;
        friendItem = new FriendItem3(R.drawable.ic_launcher, "최윤섭");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "챠챠챠");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "쵸쵸쵸");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "키키키");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "최윤섭");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "챠챠챠");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "쵸쵸쵸");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "키키키");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "최윤섭");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "챠챠챠");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "쵸쵸쵸");	 arItem.add(friendItem);
        friendItem = new FriendItem3(R.drawable.ic_launcher, "키키키");	 arItem.add(friendItem);

        FListAdapter3 fListAdapter = new FListAdapter3(this, R.layout.edit_row, arItem);
        ListView FriendList;
        FriendList =(ListView) findViewById(R.id.flist);
        FriendList.setAdapter(fListAdapter);
    }
}


class FriendItem3{
	int 	Img;
	String 	Name;

	FriendItem3(int img, String name){
		Img = img;
		Name = name;
	}
}

class FListAdapter3 extends BaseAdapter{
	Context maincon;
	LayoutInflater Inflater;
	ArrayList<FriendItem3> arSrc;
	int layout;
	
	public FListAdapter3(Context context, int alayout, ArrayList<FriendItem3> aarSrc){
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

		ImageView img = (ImageView)convertView.findViewById(R.id.edit_row_image);
		img.setImageResource(arSrc.get(position).Img);

		TextView name = (TextView) convertView.findViewById(R.id.edit_row_name);
		name.setText(arSrc.get(position).Name);
		

		Button btn = (Button) convertView.findViewById(R.id.edit_row_select);

		return convertView;
	}

	
	
}