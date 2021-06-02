
public class EvaluationListActivity extends AppCompatActivity {
	
	static String[][] Items;
    private GoogleApiClient client;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_list_evaluation);
		
		RequestQueue request_queue = Volley.newRequestQueue(EvaluationListActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/evaluation/view", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								 Items = new String[JsonArray.length()][8];
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									Items[i][0] = json_object.getString("academical_evaluation_id");
				Items[i][1] = json_object.getString("class_id");
				Items[i][2] = json_object.getString("section_id");
				Items[i][3] = json_object.getString("subject_id");
				Items[i][4] = json_object.getString("kpi_id");
				Items[i][5] = json_object.getString("rate");
				Items[i][6] = json_object.getString("teacher_name");
				Items[i][7] = json_object.getString("evaluator");
				
			
								}
								
								EvaluationAdapter evaluationAdapter;
                    			evaluationAdapter = new EvaluationAdapter(EvaluationListActivity.this,Items);
                    			evaluation_listView.setAdapter(evaluationAdapter);
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							    Toast.makeText(EvaluationListActivity, "Error in Json", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(EvaluationListActivity, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);
		
		
		
 evaluation_listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent i = new Intent(EvaluationListActivity.this, EvaluationView.class);
                i.putExtra("evaluation_id", Items[position][0]);
                startActivity(i);
            }
        });
		
		

        
    }

}
