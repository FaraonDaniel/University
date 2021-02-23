package simulator.factories;


import org.json.JSONObject;


public abstract class Builder<T>{
	
	public abstract T createInstance(JSONObject info);

	public abstract JSONObject getBuilderInfo();
	
}
