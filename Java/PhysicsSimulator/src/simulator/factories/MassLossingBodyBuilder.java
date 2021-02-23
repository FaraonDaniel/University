package simulator.factories;

import org.json.JSONArray;
import org.json.JSONObject;

import simulator.misc.Vector;
import simulator.model.*;

public class MassLossingBodyBuilder extends Builder<Body>{
	
	public MassLossingBodyBuilder() {
		
	}
	//Crea un tipo MassLoosingBody a traves de un objeto JSON
	public MassLossingBody createInstance(JSONObject info){
		MassLossingBody result = null;
		
		if(info.get("type").equals("mlb")){
			try {
				JSONObject jo2 = info.getJSONObject("data");
				Vector auxPos = new Vector(tratarJOArray(jo2.getJSONArray("pos")));
				Vector auxVel = new Vector(tratarJOArray(jo2.getJSONArray("vel")));;
				//Revisar para hacer la aceleracion.
				result = new MassLossingBody(jo2.getString("id"), jo2.getDouble("mass"), auxPos, auxVel, 
						auxPos.scale(0), jo2.getDouble("factor"), jo2.getDouble("freq"), 0.0);
			}
			catch(IllegalArgumentException e) {
				System.out.println(e);
			}
		}
		return result;
	}
	
	//Extrae los valores del objeto JSON y los introduce en un array double que se retorna
	public double[] tratarJOArray(JSONArray arrayDouble) {		
		double[] result = new double[arrayDouble.length()];
		
		for(int i = 0; i < arrayDouble.length(); i++) {
			result[i] = arrayDouble.getDouble(i);
		}
		return result;		
	}
	
	public JSONObject getBuilderInfo(){
		JSONObject type = new JSONObject();
		JSONObject data = new JSONObject();
		
		type.put("type", "mlb");
		data.put("id", "id de cuerpo");
		data.put("mass", "masa del cuerpo");
		data.put("vel", "vector velocidad");
		data.put("pos", "Vector posicion");
		data.put("freq", "frecuencia de perdida de masa");
		data.put("factor", "factor de frecuencia");
		type.put("data:", data);
		type.put("desc", "Mass losing body");
		
		return type;
	}

}
