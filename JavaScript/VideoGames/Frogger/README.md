Daniel Candil Vizcaíno
Mario Sánchez de Paz    

Mecánicas implementadas: 
    Moviento de la rana: PlayerFrogger, realiza las acciones de avance y retroceso de la rana, además de comprobar si colosiona con el agua o los troncos.
    Coches: Car, asigna una velocidad, carril y sentido determinados a cada objeto coche. Tambié comprueba si la rana colisiona con alguno de ellos, y en tal caso, la elimina.
    Troncos: Trunk, realiza las mismas acciones que los coches, solo que siendo del tipo SURFACE (ls rana puede permanecer encima).
    Tortugas: turtle, similar a los troncos.
    Agua: Water, que representa otra zona donde la rana muere si colisionan.
    Condiciones de finalización: winGame() y loseGame(), que se llaman cuando la rana alcanza el césped final, o muere en el intento.
    Animación de muerte: cada vez que la rana muere, se muestra por pantalla una calavera.
    Spawner: se introduce por defecto un array con los coches/troncos y tortugas ya definidos. 