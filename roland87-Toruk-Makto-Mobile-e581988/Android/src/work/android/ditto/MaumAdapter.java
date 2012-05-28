package work.android.ditto;

import java.util.ArrayList;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;


public class MaumAdapter extends BaseAdapter{
	Context maincon;
	LayoutInflater Inflater;
	ArrayList<MaumItem> arSrc;
	int layout;
	
	public MaumAdapter(Context context, int alayout, ArrayList<MaumItem> aarSrc){
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
		if(arSrc.get(position).Maum != null)
			status.setText(arSrc.get(position).Maum);
		else
			status.setVisibility(View.GONE);
		
		return convertView;
	}
}