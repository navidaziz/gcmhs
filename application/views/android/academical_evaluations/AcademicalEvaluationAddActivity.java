
public class AcademicalEvaluationAddActivity extends AppCompatActivity {
	
	private text academical_evaluation_title;
				private text academical_evaluation_date;
				private Button btn_add_academical_evaluations;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_add_academical_evaluation);
		
		academical_evaluation_title = (text)findViewById(R.id.academical_evaluation_title);
				academical_evaluation_date = (text)findViewById(R.id.academical_evaluation_date);
				btn_add_academical_evaluations = (Button)findViewById(R.id.btn_add_academical_evaluations);
		
		
btn_add_academical_evaluations.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //do your code here
				final String form_academical_evaluation_title = academical_evaluation_title.getText().toString();
				final String form_academical_evaluation_date = academical_evaluation_date.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(AcademicalEvaluationAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/academical_evaluation/save_data", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(AcademicalEvaluationAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(AcademicalEvaluationAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("academical_evaluation_title", form_academical_evaluation_title);
				params.put("academical_evaluation_date", form_academical_evaluation_date);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		

     }

}
