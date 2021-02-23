package simulator.factories;


import org.json.JSONArray;
import org.json.JSONObject;

import simulator.misc.Vector;
import simulator.model.Body;

public class BasicBodyBuilder extends Builder<Body>{
	
	public BasicBodyBuilder() {
		
	}
	//Crea un tipo body a traves de un JSON
	public Body createInstance(JSONObject info) {
		Body result = null;
		Vector auxPos = null;
		Vector auxVel = null;
		if(info.getString("type").equals("basic")) {
			try {
				JSONObject jo2 = info.getJSONObject("data");
				auxPos = new Vector(tratarJOArray(jo2.getJSONArray("pos")));
				auxVel = new Vector(tratarJOArray(jo2.getJSONArray("vel")));
				//Queda por comprobar como hacer la aceleracion
				result = new Body(jo2.getString("id"), jo2.getDouble("mass"), auxPos, auxVel, auxPos.scale(0)); 
			}catch(IllegalArgumentException e) {
				System.out.println(e);
			}
		}
		return result;
	}
	//Extrae los valores del objeto JSON y los introduce en un array double que se retorna
	public double[] tratarJOArray(JSONArray arrayDouble) {		
		double[] result = new double[arrayDouble.length()];
		
		for(int i = 0; i < arrayDouble.length(); i++) {
			result[i] = arrayDouble.getDouble(i) ;
		}
		return result;		
	}

	@Override
	public JSONObject getBuilderInfo() {
		// TODO Auto-generated method stub
		JSONObject type = new JSONObject();
		JSONObject data = new JSONObject();
		
		type.put("type", "basic");
		
		data.put("id", "id de cuerpo");
		data.put("mass", "masa del cuerpo");
		data.put("vel", "vector velocidad");
		data.put("pos", "Vector posicion");
		type.put("data:", data);
		type.put("desc", "basic body");
		return type ;
	}
	
	
	
}
