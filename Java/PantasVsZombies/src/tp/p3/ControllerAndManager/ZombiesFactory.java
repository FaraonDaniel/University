package tp.p3.ControllerAndManager;

import tp.p3.Objects.*;

public class ZombiesFactory {
	private static final Zombie ZombieNormal = new ZombieNormal(null, 5, "Anda y come normal", 0, 2, 0, 1);
	private static final Zombie ZombieCaracubo = new ZombieCaracubo(null, 8, "Anda y come lento", 0, 4, 0, 1);
	private static final Zombie ZombieDeportista = new ZombieDeportista(null, 2, "Anda y come rapido", 0, 1, 0, 1);
	
	/*private static Zombie[] availableZombies = {
			new ZombieNormal(null, 5, "Anda y come normal", 0, 2, 0, 1),
			new ZombieCaracubo(null, 8, "Anda y come lento", 0, 4, 0, 1),
			new ZombieDeportista(null, 2, "Anda y come rapido", 0, 1, 0, 1)	
	};*/
	
	public ZombiesFactory(Game game) {}
		
		
	public static Zombie getZombie(String zombieName){
		Zombie resultado = null;
		if(zombieName.equals("ZOMBIENORMAL") || zombieName.equals("Z"))
			resultado = new ZombieNormal(null, 5, "Anda y come normal", 0, 2, 0, 1);
		else if(zombieName.equals("ZOMBIECARACUBO") || zombieName.equals("W"))
			resultado = new ZombieCaracubo(null, 8, "Anda y come lento", 0, 4, 0, 1);
		else if(zombieName.equals("ZOMBIEDEPORTISTA") || zombieName.equals("X"))
			resultado =  new ZombieDeportista(null, 2, "Anda y come rapido", 0, 1, 0, 1);
		return resultado;
	}
	
	
	public static String listOfAvilableZombies() {
		String lista = "";
		lista += "[Z]ombie comun: Speed: "  + ZombieNormal.getVelocidad() + " Harm: " + ZombieNormal.getDannio() + " Life: " + ZombieNormal.getResistencia() + "\n";
		lista += "[Z]ombie deportista:  Speed: " + ZombieDeportista.getVelocidad() + " Harm: " + ZombieDeportista.getDannio() + " Life: " + ZombieDeportista.getResistencia() + "\n";
		lista += "[Z]mbie caracubo: Speed: " + ZombieCaracubo.getVelocidad() + " Harm: " + ZombieCaracubo.getDannio() + " Life: " + ZombieCaracubo.getResistencia() + "\n";
			
		return lista;
	}
}


