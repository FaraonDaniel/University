package tp.p3.Objects;

import java.io.BufferedWriter;
import java.io.IOException;

import tp.p3.ControllerAndManager.Game;

public abstract class Zombie extends ActiveGameObject{

		public Zombie(Game game, int resistencia, String comportamiento, int ciclos, int maxCiclos, double frecuencia, int daño) {
			super(game, resistencia, comportamiento, 0, maxCiclos, frecuencia, daño);			
		}
		
		public abstract String dibujarElemento();
		
		public abstract int getResistencia();
		
		public abstract void setPosicionLista(int pos);
		
		public abstract int getPosicionLista();

		public abstract double getFrecuencia();

		public abstract void setFrecuencia(int frecuencia);

		public abstract void setResistencia(int resistencia);

		public abstract int getDannio();

		public abstract double getVelocidad();

		public abstract Game getGame();

		public abstract int getY();

		public abstract void setY(int y);

		public abstract int getX();

		public abstract void setX(int x);
		
		public abstract int getCiclos();

		public abstract void setCiclos();
		
		public abstract boolean zombieMuerto();
		
		public abstract int getMaxCiclos();
		

		public void store(BufferedWriter buff) throws IOException {
			buff.write(this.getNombre() + ":" + this.resistencia + ":" + this.x + ":" + this.y + ":" + this.ciclos % this.maxCiclos);
		}
		
		public void setCiclos(int i) {
			this.ciclos = i;
		}
		
}
