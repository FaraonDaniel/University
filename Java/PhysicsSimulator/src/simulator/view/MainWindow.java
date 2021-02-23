




package simulator.view;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;

import javax.swing.BorderFactory;
import javax.swing.BoxLayout;
import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.TitledBorder;

import simulator.control.Controller;

@SuppressWarnings("serial")
public class MainWindow extends JFrame {
	// ...
	Controller _ctrl;
	ControlPanel panelControl;
	BodiesTable tablaDeCuerpos;
	Viewer vista;
	StatusBar estado;

	public MainWindow(Controller ctrl) {
		super("Physics Simulator");
		_ctrl = ctrl;
		this.panelControl = new ControlPanel(ctrl);
		this.tablaDeCuerpos = new BodiesTable(ctrl);
		this.vista = new Viewer(ctrl);
		this.estado = new StatusBar(ctrl);
		initGUI();
	}

	private void initGUI() {
		JFrame jf = this;
		jf.setLayout(new BorderLayout());
		jf.setSize(1200, 1000);
		JPanel mainPanel = new JPanel(new BorderLayout());
	
		mainPanel.add(this.panelControl, BorderLayout.PAGE_START);
		JPanel cuerposYvista = new JPanel();
		cuerposYvista.setLayout(new BoxLayout(cuerposYvista, BoxLayout.Y_AXIS));
		
		tablaDeCuerpos.setPreferredSize(new Dimension(1000, 100));
		
		vista.setPreferredSize(new Dimension(900, 660));
		vista.setBorder(BorderFactory.createTitledBorder(BorderFactory.createLineBorder(Color.black, 2), "Viewer",
				TitledBorder.LEFT, TitledBorder.TOP));
		
		
		
		
		mainPanel.add(this.estado,BorderLayout.SOUTH);
		mainPanel.add(panelControl,BorderLayout.NORTH);
		
		cuerposYvista.add(tablaDeCuerpos);
		cuerposYvista.add(vista);
		mainPanel.add(cuerposYvista, BorderLayout.CENTER);
		
		jf.add(mainPanel);
		jf.setVisible(true);
		this.setDefaultCloseOperation(DO_NOTHING_ON_CLOSE);		
	}
	// other private/protected methods
	// ...
}
