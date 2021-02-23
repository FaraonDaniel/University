package simulator.view;


import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.InputStream;
import java.lang.Thread.State;
import java.util.List;

import javax.swing.*;

import org.json.JSONObject;

import simulator.control.Controller;
import simulator.model.Body;
import simulator.model.SimulatorObserver;

@SuppressWarnings("serial")
public class ControlPanel extends JPanel implements SimulatorObserver, ActionListener{
	private Controller _ctrl;
	private JButton openFiles, physics, play, stop, off;
	private SpinnerModel jp1;
	private SpinnerModel jp2;
	private SpinnerModel jp3;
	private JSpinner jpSteps;
	private JSpinner jpDT;
	private JToolBar barra;
	private JSpinner jpDelay;
	private volatile Thread _thread;
	
	
	public ControlPanel (Controller cc) {
		this._ctrl = cc;
		initGUI();	
		this._ctrl.addObserver(this);
	}
	
	private void initGUI() {
		createPanel(Color.gray, 150, 50);
		Dimension panelD = new Dimension(1200,55);
		this.setPreferredSize(panelD);
		this.setLayout(new FlowLayout());
		this._thread = new Thread();
		
		barra = new JToolBar("Barra");
		barra.setOrientation(JToolBar.HORIZONTAL);
		barra.setLayout(new FlowLayout());
		
		
		this.openFiles = new JButton();
		this.physics = new JButton();
		this.play = new JButton();
		this.stop = new JButton();
		this.off = new JButton();
		JTextField steps = new JTextField("Steps");
		steps.setPreferredSize(new Dimension(45, 20));
		JTextField deltaTime = new JTextField("Delta-Time");
		deltaTime.setPreferredSize(new Dimension(70, 20));
		JTextField delay = new JTextField("Delay");
		delay.setPreferredSize(new Dimension(70, 20));
		
		//Caja para poner los steps deseados;
		this.jp1 = new SpinnerNumberModel(10000, 0, 50000, 0);
		this.jp2 = new SpinnerNumberModel(2500.0, 0.0, 50000.0, 0.0);
		this.jp3 = new SpinnerNumberModel(1000.0, 0.0, 1000.0, 1.0);
		this.jpDelay = new JSpinner(jp3);
		this.jpSteps = new JSpinner(jp1);
		this.jpDT = new JSpinner(jp2);
		
		jpSteps.setPreferredSize(new Dimension(80, 15));

		jpDT.setPreferredSize(new Dimension(80, 15));
		
		createButton(openFiles, new ImageIcon("resources/icons/open.png"), "Select file", 20, 20);
		this.openFiles.addActionListener((ActionListener) this);
	
		createButton(physics, new ImageIcon("resources/icons/physics.png"), "Select instructions", 20, 20);
		this.physics.addActionListener((ActionListener) this);
		
		createButton(play, new ImageIcon("resources/icons/run.png"), "Start Simulation", 20, 20);
		this.play.addActionListener((ActionListener) this);
		
		createButton(stop, new ImageIcon("resources/icons/stop.png"), "Stop simulation", 20, 20);
		this.stop.addActionListener((ActionListener) this);
		
		createButton(off, new ImageIcon("resources/icons/exit.png"), "Turn off", 20, 20);
		this.off.addActionListener((ActionListener) this);
		
		barra.add(openFiles);
		barra.add(Box.createHorizontalStrut(15));
		barra.add(physics);
		barra.add(Box.createHorizontalStrut(15));
		barra.add(play);
		barra.add(Box.createHorizontalStrut(15));
		barra.add(stop);
		barra.add(Box.createHorizontalStrut(15));
		barra.add(steps);
		barra.add(jpSteps);
		barra.add(Box.createHorizontalStrut(15));
		barra.add(deltaTime);
		barra.add(jpDT);
		barra.add(Box.createHorizontalStrut(15));
		barra.add(delay);
		barra.add(jpDelay);
		barra.add(Box.createHorizontalStrut(280));
		barra.add(off);
		barra.setPreferredSize(panelD);
		this.add(barra);
	}
	
	private void createButton(JButton boton, Icon imagen, String texto, int sizeX, int sizeY) {
		boton.setIcon(imagen);
		boton.setSize(sizeX, sizeY);
		boton.setToolTipText(texto);
	}
	
	private void createPanel(Color color, int x, int y) {
		 this.setBackground(color);
		 this.setPreferredSize(new Dimension(x, y));
	}
	
	public void actionPerformed(ActionEvent e) {
		if(e.getSource() == this.openFiles) {
			JFileChooser jfile = new JFileChooser("resources/examples/");
			int result = jfile.showOpenDialog(new JFrame());
			InputStream targetStream = null;
			if(result == JFileChooser.APPROVE_OPTION) {
				try {
					targetStream = new FileInputStream(jfile.getSelectedFile().getAbsoluteFile());
				} 
				catch (FileNotFoundException e1) {
					e1.printStackTrace();
				}
				this._ctrl.reset();
				this._ctrl.loadBodies(targetStream);
			}
			else if (result == JFileChooser.CANCEL_OPTION) {
				jfile.setVisible(false);
			}
		}

		
		
		
		
		else if(e.getSource() == this.physics) {
			this.setLayout(null);
			JFrame ops = new JFrame("Gravity Laws Selector");
			JPanel panel = new JPanel();
			JComboBox<String> opsGL = new JComboBox<String>();
			JButton yes = new JButton("Ok");
			JButton no = new JButton("Cancel");
			JLabel mensaje = new JLabel("Select gravity law to be used:\n");
			
			
			opsGL.add(mensaje);
			
			List<JSONObject> aux = this._ctrl.getGravityLawsFactory().getInfo();
			for (JSONObject it : aux) {
				opsGL.addItem(it.getString("desc"));
			}
			
			
			ops.setLayout(new BorderLayout());
			ops.setSize(500, 400);
			panel.setSize(500, 300);
			opsGL.setSize(100, 50);
			panel.add(mensaje, BorderLayout.PAGE_START);
			panel.add(opsGL, BorderLayout.CENTER);
			panel.add(yes, BorderLayout.PAGE_END);
			panel.add(no, BorderLayout.PAGE_END);
			ops.add(panel);
			ops.setVisible(true);
			yes.addActionListener(new ActionListener() {
	            public void actionPerformed(ActionEvent e) {
	            	for(int i = 0; i < aux.size(); i++) {	            		
	            		if(aux.get(i).getString("desc").equals((String)opsGL.getSelectedItem())) {
	            			_ctrl.setGravityLaws(aux.get(i));
	            		}
	            	}
	            	ops.setVisible(false);
	            	ops.dispose();
	            }
	        });
			no.addActionListener(new ActionListener() {
	            public void actionPerformed(ActionEvent e) {
	            	ops.setVisible(false);
	            	ops.dispose();
	            }
	        });
			
		}
		
		else if(e.getSource() == this.play) {
			this.openFiles.setEnabled(false);
			this.physics.setEnabled(false);
			this.off.setEnabled(false);
			this.play.setEnabled(false);
			Thread hilo =  new Thread(new Runnable() {
			
				public void run() {
					run_sim((int)jpSteps.getValue(), (double)jpDelay.getValue());
                	openFiles.setEnabled(true);
        			physics.setEnabled(true);
        			off.setEnabled(true);
        			play.setEnabled(true);
        			_thread = null;					
				}
			
			});
     
			double num = (double)jp2.getValue();
			_ctrl.setDeltaTime(num);
			this._thread = hilo;
			this._thread.start();
						
		}
		
		else if(e.getSource() == this.stop) {
			this.openFiles.setEnabled(true);
			this.physics.setEnabled(true);
			this.off.setEnabled(true);
			play.setEnabled(true);
			if(_thread != null){
				_thread.interrupt();
			}
			
		}
		else if(e.getSource() == this.off) {
			JFrame confirmar = new JFrame();
			JPanel aux = new JPanel();
			aux.setSize(400, 200);
			JButton yes = new JButton("Si");
			JButton no = new JButton("No");
			JLabel mensaje = new JLabel ("¿Desea salir?");
			confirmar.setSize(400, 100);
			aux.add(yes);
			aux.add(no);
			confirmar.add(mensaje, BorderLayout.PAGE_START);
			confirmar.add(aux, BorderLayout.CENTER);
			confirmar.setVisible(true);
			
			yes.addActionListener(new ActionListener() {
	            public void actionPerformed(ActionEvent e) {
	               System.exit(0);
	            }
	        });
			no.addActionListener(new ActionListener() {
	            public void actionPerformed(ActionEvent e) {
	              confirmar.setVisible(false);
	            }
	        });
		}
	}
	

	public void run_sim(int n, double delay) {
		Thread currentThread = Thread.currentThread();
		while ( n>0 && (!currentThread.isInterrupted())) {
			try {
				_ctrl.run(1);
				currentThread.sleep((long)delay);
			} 
			//Mensaje de error al parar la aplicación (current thread stopped).
			catch (Exception e) {
				currentThread.interrupt();
				SwingUtilities.invokeLater(new Runnable() {
					public void run() {
						JOptionPane.showMessageDialog(null, e);
					}
				});
				return;
			}
			n--;
		}
		currentThread = null;
	}

	public void onRegister(List<Body> bodies, double time, double dt, String gLawsDesc) {	
	}
	@Override
	public void onReset(List<Body> bodies, double time, double dt, String gLawsDesc) {
	}
	@Override
	public void onBodyAdded(List<Body> bodies, Body b) {
	}
	@Override
	public void onAdvance(List<Body> bodies, double time) {
	}
	@Override
	public void onDeltaTimeChanged(double dt) {
		this.jpDT.setValue(dt);
	}
	@Override
	public void onGravityLawChanged(String gLawsDesc) {
	}
}
