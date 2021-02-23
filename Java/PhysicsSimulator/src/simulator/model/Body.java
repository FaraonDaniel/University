package simulator.model;

import simulator.misc.Vector;

public class Body {
	

	protected String id;
	protected Double mass;
	protected Vector pos;
	protected Vector vel;
	protected Vector acc;
	
	public Body() {
		super();
		// TODO Auto-generated constructor stub
	}
	
	public Body(String id, Double mass, Vector pos, Vector vel, Vector acc) {
		super();
		this.id = id;
		this.mass = mass;
		this.pos = pos;
		this.vel = vel;
		this.acc = acc;
	}

	//devuelve el identificador del cuerpo.
	public String getId(){
		return this.id;
	}
	
	//devuelve una copia del vector de velocidad.
	public Vector getVelocity(){
		Vector copy = new Vector(this.vel);
		return copy;
	} 
	
	//devuelve una copia del vector de aceleración.
	public Vector getAcceleration(){
		Vector copy = new Vector(this.acc);
		return copy;
	}
	
	
	//devuelve una copia del vector de posición.
	public Vector getPosition(){
		Vector copy = new Vector(this.pos);
		return copy;
	}
	
	//devuelve la masa del cuerpo.
	public double getMass(){
		return this.mass;
	}
	
	//hace una copia de v y se la asigna al vector de velocidad.
	void setVelocity(Vector v){
		Vector copy = new Vector(v);
		this.vel=copy;
	}
	
	//hace una copia de a y se la asigna al vector de aceleración.
	void setAcceleration(Vector a){
		Vector copy = new Vector(a);
		this.acc=copy;
	}
	
	//hace una copia de p y se la asigna al vector de posición.
	void setPosition(Vector p){
		Vector copy = new Vector(p);
		this.pos=copy;
	}
	
	// mueve el cuerpo durante t segundos
	void move(double t){
		this.pos = this.pos.plus(this.vel.scale(t).plus(this.acc.scale((0.5*t*t))));
		this.vel= this.vel.plus(this.acc.scale(t));
	}
	
	//devuelve un string con la información del cuerpo en formato JSON: { ”id”: id, ”mass”: m, ”pos”: ~p, ”vel”: ~v, ”acc”: ~a }
	public String toString(){
		return " { \"id\": \"" + this.id + "\", \"mass\": " + this.mass.toString() +
				", \"pos\": " + this.pos.toString() + ", \"vel\": " + this.vel.toString() + 
				", \"acc\": " + this.acc.toString() + " }";
	}
}
