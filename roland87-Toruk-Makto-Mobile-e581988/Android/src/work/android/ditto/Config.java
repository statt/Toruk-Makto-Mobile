package work.android.ditto;

import java.util.ArrayList;

import work.android.ditto.CfgItem.Type;

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
import android.widget.ToggleButton;

public class Config extends Activity{
    ArrayList<CfgItem> arItem;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.config);
        arItem = new ArrayList<CfgItem>();
        CfgItem cfgItem;
        cfgItem = new CfgItem("버전정보","0.0.9");		arItem.add(cfgItem);
        cfgItem = new CfgItem("도움말");				arItem.add(cfgItem);
        cfgItem = new CfgItem(R.drawable.refresh, "주소록 동기화");		arItem.add(cfgItem);
        cfgItem = new CfgItem("위치 검색 허용", true);	arItem.add(cfgItem);
        cfgItem = new CfgItem("프로그램 잠금 사용", true);	arItem.add(cfgItem);
        cfgItem = new CfgItem("잠금암호 변경");			arItem.add(cfgItem);
        cfgItem = new CfgItem("아이템");				arItem.add(cfgItem);
        CfgListAdapter cfgListAdapter = new CfgListAdapter(this, R.layout.config_row, arItem);
        ListView CfgList;
        CfgList =(ListView) findViewById(R.id.cfglist);
        CfgList.setAdapter(cfgListAdapter);
    }
}


class CfgItem{
	public enum Type{
		USE_TEXT(0), USE_ICON(1), USE_TOGGLE(2), USE_STATUS(4);
		
		private final int t;
		Type(int t){this.t=t;}
		public int getValue(){return t;}
	}
	
	int 	Icon;
	String 	Title;
	String 	Status;
	Boolean Toggle;
	Type 	type;

	CfgItem(String title){
		Title = title;
		type = Type.USE_TEXT;
	}
	
	CfgItem(int icon, String title){
		Icon = icon;
		Title = title;
		type = Type.USE_ICON;
	}

	CfgItem(String title, Boolean toggle){
		Title = title;
		Toggle = toggle;
		type = Type.USE_TOGGLE;
	}
	
	CfgItem(String title, String status){
		Title = title;
		Status = status;
		type = Type.USE_STATUS;
	}
}

class CfgListAdapter extends BaseAdapter{
	Context maincon;
	LayoutInflater Inflater;
	ArrayList<CfgItem> arSrc;
	int layout;
	
	public CfgListAdapter(Context context, int alayout, ArrayList<CfgItem> aarSrc){
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
		return arSrc.get(position).Title;
	}
	
	public long getItemId(int position){
		return position;
	}
	
	public View getView(int position, View convertView, ViewGroup parent){
		if (convertView == null){
			convertView = Inflater.inflate(layout, parent, false);
		}
		
		ImageView img = (ImageView)convertView.findViewById(R.id.cfg_row_icon);
		if(arSrc.get(position).type == Type.USE_ICON)
			img.setImageResource(arSrc.get(position).Icon);
		else
			img.setVisibility(View.GONE);

		TextView title = (TextView) convertView.findViewById(R.id.cfg_row_text);
		title.setText(arSrc.get(position).Title);
		
		TextView status = (TextView) convertView.findViewById(R.id.cfg_row_status);
		if(arSrc.get(position).type == Type.USE_STATUS)
			status.setText(arSrc.get(position).Status);
		else
			status.setVisibility(View.GONE);
		
		ToggleButton toggle = (ToggleButton) convertView.findViewById(R.id.cfg_row_toggleBtn);
		if(arSrc.get(position).type == Type.USE_TOGGLE)
			toggle.setChecked(arSrc.get(position).Toggle);
		else
			toggle.setVisibility(View.GONE);
		
		return convertView;
	}
}