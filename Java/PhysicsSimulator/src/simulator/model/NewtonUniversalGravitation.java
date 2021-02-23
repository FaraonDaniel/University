package simulator.model;

import java.util.List;

import simulator.misc.Vector;

public class NewtonUniversalGravitation implements GravityLaws {
	private final double G = 6.67E-11; 
	
	//Realiza el cambio de la aceleracion con la formula a = F/m de todos los cuerpos de la lista
	@Override
	public void apply(List<Body> bodies) {
		
		for(int i = 0; i < bodies.size(); i++) {
			Vector fuerza = new Vector(bodies.get(0).pos.dim());
			
			for (int j = 0; j < bodies.size(); j++) {
				if (j != i) {
					fuerza = calcularFuerza(bodies, fuerza, i, j);
					double inversaMasa = 1 / (bodies.get(i).getMass());
					bodies.get(i).setAcceleration(fuerza.scale(inversaMasa));
					
				}
			}
		}
	}
	// Fórmula G*M1*M2/(|p1-p2|^2)
	private Vector calcularFuerza(List<Body> bodies, Vector fuerza, int objUno, int objDos){
		Vector diff = new Vector(bodies.get(0).pos.dim());
		diff = bodies.get(objDos).getPosition().minus(bodies.get(objUno).getPosition());
		
		//double dist = diff.magnitude();
		double dist = bodies.get(objUno).getPosition().distanceTo(bodies.get(objDos).getPosition());
		
		double value = (G * bodies.get(objUno).getMass() * bodies.get(objDos).getMass()) / (dist*dist);
		fuerza = fuerza.plus(diff.direction().scale(value));
		return fuerza;
	}
	
	
	public String toString() {
		return "Newton´s gravity law";
	}

}
