package work.android.ditto;

import org.apache.http.client.HttpClient;
import org.apache.http.impl.client.DefaultHttpClient;

public class ApiAdapter {
	static String ApiLoc = "http://localhost/Api/";
	
	static public void Register(){
		String url = ApiLoc + "register.php";
		HttpClient client = new DefaultHttpClient();
		
		HttpPost post = new HttpPost(url);
		List<NameValuePair>
	}
	
	static public void Login(){
		
	}
	
	static public void GetFriendList(){
	
	}
	
	static public void GetReceivingMaum(){
		
	}
}
