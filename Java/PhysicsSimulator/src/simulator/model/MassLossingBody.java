
package simulator.model;

import simulator.misc.Vector;

public class MassLossingBody extends Body{
	
	//un número (double) entre 0 y 1 que representa el factor de pérdida de masa.
	private double lossFactor;
	
	/*un número positivo (double) que indica el intervalo de tiempo
	(en segundos) después del cual el objeto pierde masa.*/
	private double lossFrequency;
	private double c = 0.0;
	
	public MassLossingBody(){
		super();
	}
	
	public MassLossingBody(String id, Double mass, Vector pos, Vector vel, Vector acc, double lossFactor, double lossFrequency, double c) {
		super(id, mass, pos, vel, acc);
		this.lossFactor = lossFactor;
		this.lossFrequency = lossFrequency;
		this.c = c;
	}
	
	//Modifica la posicion y la velocidad del cuerpo, y la masa se reduce si lleva x tiempo acumulado
	void move(double t){
		this.pos = this.pos.plus(this.vel.scale(t).plus(this.acc.scale(t*t*(0.5))));
		this.vel= this.vel.plus(this.acc.scale(t));
		this.c+=t;
		if(this.c >= this.lossFrequency ){
			this.c=0;
			this.mass = this.mass*(1-this.lossFactor);
		}
	}
}
