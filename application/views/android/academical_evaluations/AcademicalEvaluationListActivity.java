
public class AcademicalEvaluationListActivity extends AppCompatActivity {
	
	static String[][] Items;
    private GoogleApiClient client;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_list_academical_evaluation);
		
		RequestQueue request_queue = Volley.newRequestQueue(AcademicalEvaluationListActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/academical_evaluation/view", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								 Items = new String[JsonArray.length()][2];
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									Items[i][0] = json_object.getString("academical_evaluation_title");
				Items[i][1] = json_object.getString("academical_evaluation_date");
				
			
								}
								
								AcademicalEvaluationAdapter academicalevaluationAdapter;
                    			academicalevaluationAdapter = new AcademicalEvaluationAdapter(AcademicalEvaluationListActivity.this,Items);
                    			academical_evaluation_listView.setAdapter(academicalevaluationAdapter);
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							    Toast.makeText(AcademicalEvaluationListActivity, "Error in Json", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(AcademicalEvaluationListActivity, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);
		
		
		
 academical_evaluation_listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent i = new Intent(AcademicalEvaluationListActivity.this, AcademicalEvaluationView.class);
                i.putExtra("academical_evaluation_id", Items[position][0]);
                startActivity(i);
            }
        });
		
		

        
    }

}
