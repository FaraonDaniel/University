package simulator.factories;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONObject;

public class BuilderBasedFactory<T> implements Factory<T>{
	private List<Builder<T>> lista;
	
	public BuilderBasedFactory(List<Builder<T>> builders) {
		this.lista= builders;
	}
	
	@Override
	public T createInstance(JSONObject info) {
		T result=null;
		for (Builder<T> builder : lista) {
			try {
			result = builder.createInstance(info);
			}catch(Exception e) {System.out.println(e);}
			
			if (result!=null) {break;}
		}
		return result;
	}

	@Override
	public List<JSONObject> getInfo() {
		List<JSONObject> lis = new ArrayList<JSONObject>();
		for (Builder<T> builder : lista) {
			//error al inicializar la lista.
			lis.add(builder.getBuilderInfo());
		}
		
		return lis;
	}

}
