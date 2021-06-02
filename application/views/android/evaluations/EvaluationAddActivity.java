
public class EvaluationAddActivity extends AppCompatActivity {
	
	private EditText academical_evaluation_id;
				private EditText class_id;
				private EditText section_id;
				private EditText subject_id;
				private EditText kpi_id;
				private text rate;
				private text teacher_name;
				private text evaluator;
				private Button btn_add_evaluations;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_add_evaluation);
		
		academical_evaluation_id = (EditText)findViewById(R.id.academical_evaluation_id);
				class_id = (EditText)findViewById(R.id.class_id);
				section_id = (EditText)findViewById(R.id.section_id);
				subject_id = (EditText)findViewById(R.id.subject_id);
				kpi_id = (EditText)findViewById(R.id.kpi_id);
				rate = (text)findViewById(R.id.rate);
				teacher_name = (text)findViewById(R.id.teacher_name);
				evaluator = (text)findViewById(R.id.evaluator);
				btn_add_evaluations = (Button)findViewById(R.id.btn_add_evaluations);
		
		
btn_add_evaluations.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //do your code here
				final String form_academical_evaluation_id = academical_evaluation_id.getText().toString();
				final String form_class_id = class_id.getText().toString();
				final String form_section_id = section_id.getText().toString();
				final String form_subject_id = subject_id.getText().toString();
				final String form_kpi_id = kpi_id.getText().toString();
				final String form_rate = rate.getText().toString();
				final String form_teacher_name = teacher_name.getText().toString();
				final String form_evaluator = evaluator.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(EvaluationAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/evaluation/save_data", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(EvaluationAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(EvaluationAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("academical_evaluation_id", form_academical_evaluation_id);
				params.put("class_id", form_class_id);
				params.put("section_id", form_section_id);
				params.put("subject_id", form_subject_id);
				params.put("kpi_id", form_kpi_id);
				params.put("rate", form_rate);
				params.put("teacher_name", form_teacher_name);
				params.put("evaluator", form_evaluator);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		

     }

}
