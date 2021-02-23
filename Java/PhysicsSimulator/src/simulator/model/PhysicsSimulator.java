package simulator.model;

import java.util.ArrayList;
import java.util.List;

public class PhysicsSimulator {
	private double tiempoReal;
	private double tiempoActual;
	private GravityLaws leyes;
	private List<Body> lista;
	private List<SimulatorObserver> observadores;
	
	public PhysicsSimulator(double tiempoReal, GravityLaws leyes) {
		this.tiempoReal = tiempoReal;
		this.leyes = leyes;
		this.tiempoActual = 0.0;
		this.lista = new ArrayList<Body>();
		this.observadores = new ArrayList<SimulatorObserver>();
	}
	
	//Aplica un paso de simulación
	public void advance() {
		leyes.apply(this.lista);
		for(Body i: this.lista) {
			i.move(tiempoReal);
		}
		this.tiempoActual += this.tiempoReal;
		for (SimulatorObserver iterator : this.observadores) {
			iterator.onAdvance(this.lista, this.tiempoReal);
		}
	}
	
	//Añade un cuerpo a la lista
	public void addBody(Body b) {
		for(Body i: this.lista) {
			if(i.id.equals(b.id)) {
				throw new IllegalArgumentException("ID´s iguales");
			}
		}
		lista.add(b);
		for (SimulatorObserver iterator : this.observadores) {
			iterator.onBodyAdded(this.lista, b);
		}
		
	}
	
	public void reset() {
		this.tiempoReal = 0.0;
		this.lista.clear();
		for (SimulatorObserver iterator : this.observadores) {
			iterator.onReset(lista, tiempoReal, tiempoActual, this.leyes.toString());
		}
	}
	
	public void setDeltaTime(double dt) {
		try {
			this.tiempoReal = dt;
		}
		catch(IllegalArgumentException e) {
			System.out.println(e);
		}
		for (SimulatorObserver iterator : this.observadores) {
			iterator.onDeltaTimeChanged(dt);
		}
	}
	
	public void addObserver(SimulatorObserver o) {
		this.observadores.add(o);
		this.observadores.get(this.observadores.size()-1).onRegister(this.lista, this.tiempoReal, this.tiempoActual, this.leyes.toString());
	}
	
	public void setGravityLaws(GravityLaws gravityLaw) {
		try{
			this.leyes = gravityLaw;
		}catch(IllegalArgumentException e) {
			System.out.println(e);
		}
		for (SimulatorObserver iterator : this.observadores) {
			iterator.onGravityLawChanged(this.leyes.toString());
		}
	}
	
	public String toString() {
		return "{ \"time\": " + this.tiempoActual + ", \"bodies\": " + this.lista.toString() + " }";
	}

	
}
