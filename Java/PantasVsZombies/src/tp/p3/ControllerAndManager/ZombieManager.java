package tp.p3.ControllerAndManager;
import java.util.*;

import tp.p3.Objects.Zombie;
import tp.p3.Objects.ZombieCaracubo;
import tp.p3.Objects.ZombieDeportista;
import tp.p3.Objects.ZombieNormal;

public class ZombieManager {
	private int restantes;
	Random rand;
	
	//Constructor
	public ZombieManager(int numero, Random rand) {
		this.restantes = numero;
		this.rand=rand;
	}

	public void setZombiesPartida(int x) {
		this.restantes = x;
	}
	public boolean quedanZombies(){
		return restantes>0;
	}
	public int getRestantes() {
		return restantes;
	}

	public void setRestantes() {
		this.restantes -= 1;
	}
	
	public Zombie tipoDeZombieAdded(Game game) {
		Zombie zombieDevuelto = null;		
		switch (rand.nextInt(3)) {
		case 0:
			zombieDevuelto = new ZombieNormal(game, 5, "Come y anda normal", 0, 2, 0, 1);
			break;
		case 1:
			zombieDevuelto = new ZombieDeportista(game, 2, "Come y anda deprisa", 0, 1, 0, 1);
			break;
		case 2: 
			zombieDevuelto = new ZombieCaracubo(game, 8, "Come y anda muy lento", 0, 4, 0, 1);
			break;
		}		
		return zombieDevuelto;
	}

	public boolean isZombieAdded(double frec, long seed) {
		double resultado = 0;
		boolean anniadido = false;
		if(restantes > 0) {
			resultado = rand.nextDouble();
			if(resultado <= frec)
			anniadido = true;
		}
		return anniadido;
	}

}

