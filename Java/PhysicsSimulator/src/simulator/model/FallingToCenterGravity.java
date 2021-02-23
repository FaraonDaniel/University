package simulator.model;

import java.util.List;

public class FallingToCenterGravity implements GravityLaws{
	private final double g = 9.81;

	//Fórmula a = -g*d, la cual cambia la aceleración de los objetos de la lusta
	@Override
	public void apply(List<Body> bodies) {
		// TODO Auto-generated method stub
		for (Body body : bodies) {
			body.setAcceleration(body.getPosition().direction().scale(-g));
		}
	}
	
	public String toString() {
		return "Falling to center";
	}

}
