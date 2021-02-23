package simulator.factories;



import org.json.JSONObject;
import simulator.model.*;

public class FallingToCenterGravityBuilder extends Builder<GravityLaws>{

	public FallingToCenterGravity createFCG() {
		return new FallingToCenterGravity();
	}
	
	public GravityLaws createInstance(JSONObject info){
		GravityLaws result = null;
		if(info.get("type").equals("ftcg")){
			result = new FallingToCenterGravity();
		}
		return result;
	}

	@Override
	public JSONObject getBuilderInfo() {
		JSONObject type = new JSONObject();
		type.put("type", "ftcg");
		//¿Usamos el metodo toString aqui?
		type.put("desc", "Falling to center gravity");
		return type;
	}
	
}
