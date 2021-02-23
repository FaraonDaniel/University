package simulator.control;


import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import org.json.JSONArray;
import org.json.JSONObject;
import org.json.JSONTokener;
import simulator.factories.Factory;
import simulator.model.Body;
import simulator.model.GravityLaws;
import simulator.model.PhysicsSimulator;
import simulator.model.SimulatorObserver;

public class Controller {
	private PhysicsSimulator fisicas;
	private Factory<Body> factoriaB;
	private Factory<GravityLaws> factoriaL;
	
	public Controller(PhysicsSimulator fisicas, Factory<Body> factoryBodies, Factory<GravityLaws> factoryLaws) {
		this.fisicas = fisicas;
		this.factoriaB = factoryBodies;
		this.factoriaL = factoryLaws;
	}
	
	public void loadBodies(InputStream in) {
		
			JSONObject jsonInupt = new JSONObject(new JSONTokener(in));
			JSONArray aux = jsonInupt.getJSONArray("bodies");
			
			for(int i = 0; i < aux.length(); i++) {
				JSONObject aux2 = aux.getJSONObject(i);
				fisicas.addBody(this.factoriaB.createInstance(aux2));
			}
	}
	
	public void loadBodies(Object file) {
		//file = Parser.parse(new FileReader(file));
		JSONObject jsonOb = new JSONObject();
		jsonOb = (JSONObject) file;
		JSONArray aux = jsonOb.getJSONArray("bodies");
		
		for(int i = 0; i < aux.length(); i++) {
			JSONObject aux2 = aux.getJSONObject(i);
			fisicas.addBody(this.factoriaB.createInstance(aux2));
		}
	}
	
	public void run(int steps, OutputStream out) throws IOException {
		StringBuilder resultado = new StringBuilder();
		resultado.append("{\n\"states\": [\n");
		resultado.append(this.fisicas.toString()+ ",\n");
		for(int i = 0; i < steps ; i++) {
			this.fisicas.advance();
			if(i== steps - 1){
				resultado.append(this.fisicas.toString() + "\n]\n}");
			}
			else{
				resultado.append(this.fisicas.toString()+",\n");
			}	
		}
		out.write(resultado.length());
	}
	
	public void run(int n) {
		for(int i = 0; i < n; i++) {
			this.fisicas.advance();
		}
	}
	
	public Factory<GravityLaws> getGravityLawsFactory() {
		return this.factoriaL;
	}
	
	//Hay dudas en esta...
	public void setGravityLaws(JSONObject info) {
		fisicas.setGravityLaws(this.factoriaL.createInstance(info));
	}
	public void reset() {
		this.fisicas.reset();
	}
	
	public void setDeltaTime(double dt) {
		this.fisicas.setDeltaTime(dt);
	}
		
	public void addObserver(SimulatorObserver o) {
		this.fisicas.addObserver(o);
	}
	
}
