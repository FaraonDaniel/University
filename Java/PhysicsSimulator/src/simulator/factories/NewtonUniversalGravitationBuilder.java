package simulator.factories;


import org.json.JSONObject;
import simulator.model.GravityLaws;
import simulator.model.NewtonUniversalGravitation;

public class NewtonUniversalGravitationBuilder extends Builder<GravityLaws>{
	
	public NewtonUniversalGravitation createNWG() {
		return new NewtonUniversalGravitation();
	}

	@Override
	//Convierte un Json en un tipo NewtonUniversalGravitation
	public NewtonUniversalGravitation createInstance(JSONObject info) {
		
		NewtonUniversalGravitation result = null;
		if(info.get("type").equals("nlug")){
			result = new NewtonUniversalGravitation();
		}
		return result;
	}

	@Override
	public JSONObject getBuilderInfo() {
		JSONObject type = new JSONObject();
		//JSONObject data = new JSONObject();
		
		type.put("type", "nlug");
		//¿Usamos el metodo toString aqui?
		type.put("desc", "Newton´s gravity law");
		return type;
	}

}
