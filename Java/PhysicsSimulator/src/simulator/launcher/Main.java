package simulator.launcher;

/*
 * Examples of command-line parameters:
 * 
 *  -h
 *  -i resources/examples/ex4.4body.txt -s 100
 *  -i resources/examples/ex4.4body.txt -o resources/examples/ex4.4body.out -s 100
 *  -i resources/examples/ex4.4body.txt -o resources/examples/ex4.4body.out -s 100 -gl ftcg
 *  -i resources/examples/ex4.4body.txt -o resources/examples/ex4.4body.out -s 100 -gl nlug
 *
 */

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.lang.reflect.InvocationTargetException;
import java.util.ArrayList;



import org.apache.commons.cli.CommandLine;
import org.apache.commons.cli.CommandLineParser;
import org.apache.commons.cli.DefaultParser;
import org.apache.commons.cli.HelpFormatter;
import org.apache.commons.cli.Option;
import org.apache.commons.cli.Options;
import org.apache.commons.cli.ParseException;
import org.json.JSONObject;

import simulator.control.Controller;
import simulator.factories.BasicBodyBuilder;
import simulator.factories.Builder;
import simulator.factories.BuilderBasedFactory;
import simulator.factories.Factory;
import simulator.factories.FallingToCenterGravityBuilder;
import simulator.factories.MassLossingBodyBuilder;
import simulator.factories.NewtonUniversalGravitationBuilder;
import simulator.factories.NoGravityBuilder;
import simulator.model.Body;
import simulator.model.GravityLaws;
import simulator.model.PhysicsSimulator;
import simulator.view.MainWindow;

public class Main {

	// default values for some parameters
	//
	private final static Double _dtimeDefaultValue = 2500.0;

	// some attributes to stores values corresponding to command-line parameters
	//
	private static Double _dtime = null;
	private static String _inFile = null;
	private static String _outFile = null;
	private static JSONObject _gravityLawsInfo = null;
	private static int _step = 150;
	private static String _mode = "batch";

	// factories
	private static Factory<Body> _bodyFactory;
	private static Factory<GravityLaws> _gravityLawsFactory;

	private static void init() {
		// initialize the bodies factory
		ArrayList<Builder<Body>> listaBodies = new ArrayList<>();
		listaBodies.add(new BasicBodyBuilder());
		listaBodies.add(new MassLossingBodyBuilder());

		// initialize the gravity laws factory
		//NoGravityBuilder ngb = new NoGravityBuilder();
		ArrayList<Builder<GravityLaws>> listaGravity = new ArrayList<>();
		listaGravity.add(new FallingToCenterGravityBuilder());
		listaGravity.add(new NewtonUniversalGravitationBuilder());
		listaGravity.add(new NoGravityBuilder());

		// ...
		Main._bodyFactory = new BuilderBasedFactory<Body>(listaBodies);
		Main._gravityLawsFactory = new BuilderBasedFactory<GravityLaws>(listaGravity);
	}

	private static void parseArgs(String[] args) {

		// define the valid command line options
		//
		Options cmdLineOptions = buildOptions();

		// parse the command line as provided in args
		//
		CommandLineParser parser = new DefaultParser();
		try {
			CommandLine line = parser.parse(cmdLineOptions, args);
			parseHelpOption(line, cmdLineOptions);
			parseBatchMode(line);
			parseInFileOption(line);
			parseOutFileOption(line);
			parseStepOption(line);
			parseDeltaTimeOption(line);
			parseGravityLawsOption(line);
		
			// if there are some remaining arguments, then something wrong is
			// provided in the command line!
			//
			String[] remaining = line.getArgs();
			if (remaining.length > 0) {
				String error = "Illegal arguments:";
				for (String o : remaining)
					error += (" " + o);
				throw new ParseException(error);

			}

		} catch (ParseException e) {
			System.err.println(e.getLocalizedMessage());
			System.exit(1);
		}

	}

	private static Options buildOptions() {
		Options cmdLineOptions = new Options();

		// help
		cmdLineOptions.addOption(Option.builder("h").longOpt("help")
				.desc("Print this message.").build());

		// input file
		cmdLineOptions.addOption(Option.builder("i").longOpt("input").hasArg()
				.desc("Bodies JSON input file.").build());

		// output file
		cmdLineOptions.addOption(Option.builder("o").longOpt("output").hasArg()
				.desc("Bodies JSON output file.").build());

		// steps process
		cmdLineOptions.addOption(Option.builder("s").longOpt("steps").hasArg()
				.desc("Simulation steps.").build());
		// mode process
		cmdLineOptions.addOption(Option.builder("m").longOpt("mode").hasArg()
				.desc("Execution Mode. Possible values: ’batch’\n" + 
						"(Batch mode), ’gui’ (Graphical User Interface mode). Default value: ’batch’.\n").build());
		
		// delta-time
		cmdLineOptions
				.addOption(Option
						.builder("dt")
						.longOpt("delta-time")
						.hasArg()
						.desc("A double representing actual time, in seconds, per simulation step. Default value: "
								+ _dtimeDefaultValue + ".").build());

		// gravity laws -- there is a workaround to make it work even when
		// _gravityLawsFactory is null.
		//
		String gravityLawsValues = "N/A";
		String defaultGravityLawsValue = "N/A";
		if (_gravityLawsFactory != null) {
			gravityLawsValues = "";
			for (JSONObject fe : _gravityLawsFactory.getInfo()) {
				if (gravityLawsValues.length() > 0) {
					gravityLawsValues = gravityLawsValues + ", ";
				}

				gravityLawsValues = gravityLawsValues + "'"
						+ fe.getString("type") + "' (" + fe.getString("desc")
						+ ")";
			}
			defaultGravityLawsValue = _gravityLawsFactory.getInfo().get(0)
					.getString("type");
		}
		cmdLineOptions
				.addOption(Option
						.builder("gl")
						.longOpt("gravity-laws")
						.hasArg()
						.desc("Gravity laws to be used in the simulator. Possible values: "
								+ gravityLawsValues
								+ ". Default value: '"
								+ defaultGravityLawsValue + "'.").build());

		return cmdLineOptions;
	}

	private static void parseHelpOption(CommandLine line, Options cmdLineOptions) {
		if (line.hasOption("h")) {
			HelpFormatter formatter = new HelpFormatter();
			formatter.printHelp(Main.class.getCanonicalName(), cmdLineOptions,
					true);
			System.exit(0);
		}
	}

	private static void parseInFileOption(CommandLine line)
			throws ParseException {
		_inFile = line.getOptionValue("i");
		if (_inFile == null && !_mode.equalsIgnoreCase("gui")){
			throw new ParseException("An input file of bodies is required");
		}
	}

	private static void parseOutFileOption(CommandLine line)
			throws ParseException {
		_outFile = line.getOptionValue("o");
		if (_outFile == null) {
			System.out.println("La salida se pone por defecto la consola");

		}
	}

	private static void parseStepOption(CommandLine line) throws ParseException {

		String valor = line.getOptionValue("s");
		if (valor != null) {
			try {
				_step = Integer.parseInt(valor);

			} catch (NumberFormatException e) {
				System.out.println("Error al leer el step. El valor es" + _step
						+ " por defecto");
			}
		} else {
			System.out.println("El valor del step es" + _step + "por defecto");
		}
	}

	private static void parseDeltaTimeOption(CommandLine line)
			throws ParseException {
		String dt = line.getOptionValue("dt", _dtimeDefaultValue.toString());
		try {
			_dtime = Double.parseDouble(dt);
			assert (_dtime > 0);
		} catch (Exception e) {
			throw new ParseException("Invalid delta-time value: " + dt);
		}
	}

	private static void parseGravityLawsOption(CommandLine line) throws ParseException {
		if (_gravityLawsFactory == null)
			return;

		String gl = line.getOptionValue("gl");
		if (gl != null) {
			for (JSONObject fe : _gravityLawsFactory.getInfo()) {
				if (gl.equals(fe.getString("type"))) {
					_gravityLawsInfo = fe;
					break;
				}
			}
			if (_gravityLawsInfo == null) {
				throw new ParseException("Invalid gravity laws: " + gl);
			}
		} else {
			_gravityLawsInfo = _gravityLawsFactory.getInfo().get(0);
		}
	}
	
	
	private static void parseBatchMode(CommandLine line) throws ParseException{
		String gl = line.getOptionValue("m");
		if(gl != null && gl.equals("gui")) {
			_mode = gl;
		}
		
	}
	
	private static void start(String[] args) throws Exception {
		parseArgs(args);
		if(_mode.equals("gui"))
			startGUIMode();
		else
			startBatchMode();
	}

	private static void startBatchMode() throws Exception {
		GravityLaws gravity = Main._gravityLawsFactory.createInstance(_gravityLawsInfo);
		PhysicsSimulator simulator = new PhysicsSimulator(_dtime, gravity);
		Controller control = new Controller(simulator, Main._bodyFactory, Main._gravityLawsFactory);
		InputStream in = new FileInputStream(new File(_inFile));
		control.loadBodies(in);

		if (_outFile == null) {
			control.run(_step, System.out);
		} else {
			control.run(_step, new FileOutputStream(new File(_outFile)));
		}
	}

	

	private static void startGUIMode() throws InvocationTargetException, InterruptedException {
		GravityLaws gravity = Main._gravityLawsFactory.createInstance(_gravityLawsInfo);
		PhysicsSimulator simulator = new PhysicsSimulator(_dtime, gravity);
		Controller control = new Controller(simulator, Main._bodyFactory, Main._gravityLawsFactory);
		
		MainWindow window = new MainWindow(control);	
		if(_inFile != null) {
			try {
				control.reset();
				control.loadBodies(new FileInputStream(new File(_inFile)));
			} catch (FileNotFoundException e) {
				e.printStackTrace();
			}
		}
	}

	public static void main(String[] args) {
		try {
			init();
			start(args);
		} catch (Exception e) {
			System.err.println("Something went wrong ...");
			System.err.println();
			e.printStackTrace();
		}
	}
}
