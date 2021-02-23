package simulator.factories;

import org.json.JSONObject;
import simulator.model.GravityLaws;
import simulator.model.NoGravity;

public class NoGravityBuilder extends Builder<GravityLaws>{

	public NoGravity createNG() {
		return new NoGravity();
	}

	@Override
	public GravityLaws createInstance(JSONObject info) {
		
		NoGravity result = null;
		if(info.get("type").equals("ng")){
			result = new NoGravity();
		}
		return result;
	}

	@Override
	public JSONObject getBuilderInfo() {
		JSONObject type = new JSONObject();
		//JSONObject data = new JSONObject();
		
		type.put("type", "ng");
		//¿Usamos el metodo toString aqui?
		type.put("desc", "No gravity law");
		return type;
	}
}
