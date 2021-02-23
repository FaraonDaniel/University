package tp.p3.Objects;

import tp.p3.ControllerAndManager.Game;

public abstract class PasiveGameObject extends GameObject{

	public PasiveGameObject(Game game, int maxCiclos, String comportamiento) {
		super(game, maxCiclos, comportamiento);
	}
}
