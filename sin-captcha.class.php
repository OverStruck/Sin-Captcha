<?php
/**
 * SinCaptcha class
 *
 * Sin Captcha provee una manera fácil de crear un sistema parecido a los captcha.
 * Sin Captcha genera X números al azar, selecciona uno como respuesta, también al azar
 * Y genera los botones necesarios para poner en la forma de sumisión.
 *
 * @author Juanix <info@juanix.net>
 * @copyright 2013 Juanix.net
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class SinCaptcha {
	/**
	 * @var private array el HTML de los botones soportados
	 */
	private $btn_templates = array(
		'button' => '<button type="submit" class="[class]" value="[val]" name="[name]">[val]</button>', 
		'submit' => '<input type="submit" class="[class]" value="[val]" name="sin-[name]">'
	);
	
	/**
	 * Constructor
	 * @param array $config la configuracion del captcha
	 */
	public function __construct($config = array()) {
		
		//la configuracion por defecto
		$default_config = array(
			'max_num' => 99,				//maximo numbero
			'min_num' => 1,					//minimo numero
			'numb_of_btns' => 4,			//numero de botones
			'btn_type' => 'button',			//tipo de boton (<buton> o <input>)
			'btn_name' => 'sin-captcha',	//nombre del boton (name=)
			'btn_class' => ''				//clase del boton (class=)
		);
		
		//si el user especifica alguna configuracion
		//esta sobre-escribira la config por defecto
		$config = array_merge($default_config, $config);
		
		//asigna configuracion a variables locales
		foreach ($config as $key => $value) {
			$this->$key = $value;
		}
	}
	
	/**
	 * Genera los datos necesarios para la verificacion
	 *
	 * @return array La respuesta correcta y el HTML de los botones
	 */
	public function generate() {
		$answer = ''; //respuesta
		while (empty($answer)) {
			$number = rand(1, $this -> numb_of_btns);
			$numbers = $this -> getRandomNums();
            $answer = $numbers[$number];
		}
		return array('answer' => $answer, 'buttons' => $this -> populateBtns($numbers));

	}

	/**
	 * Genera el HTML de los botones
	 *
	 * @param int array $numbers los numeros generados unicos
	 * @return string $btns el HTML de los botones
	 */
	private function populateBtns($numbers) {
		$btn_template = $this -> btn_templates[$this -> btn_type];
		$btns = '';
		for ($i = 0; $i < $this -> numb_of_btns; $i++) {
			$btns .= preg_replace('/\[val\]/', $numbers[$i], $btn_template);
		}
		$btns = preg_replace('/\[class\]/', $this -> btn_class, $btns);
		$btns = preg_replace('/\[name\]/', $this -> btn_name, $btns);
		return $btns;
	}

	/**
	 * Genera X numeros al azar
	 *
	 * @return int array $randoms Los numeros generados
	 */
	private function getRandomNums() {
		$randoms = array();
		while (count($randoms) < $this -> numb_of_btns) {
			$random = rand($this -> min_num, $this -> max_num);
			if (!in_array($random, $randoms)) {
                array_push($randoms, $random);
			}
		}
		return $randoms;
	}

}
?>