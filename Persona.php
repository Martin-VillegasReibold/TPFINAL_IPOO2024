<?php
class Persona{

	private $nrodoc;
	private $nombre;
	private $apellido;
	private $telefono;
	private $mensajeoperacion;


	public function __construct(){
		
		$this->nrodoc = "";
		$this->nombre = "";
		$this->apellido = "";
		$this->telefono = "";
	}

	public function cargar($nroDoc, $nombre, $apellido, $telefono){
        $this->setNrodoc($nroDoc);
        $this->setNombre($nombre);        
        $this->setApellido($apellido);
        $this->setTelefono($telefono);
    }
    
	//Getters
	public function getNrodoc(){
		return $this->nrodoc;
	}
	public function getNombre(){
		return $this->nombre ;
	}
	public function getApellido(){
		return $this->apellido ;
	}
	public function getTelefono(){
		return $this->telefono ;
	}
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

	//Setters
	public function setNrodoc($NroDNI){
		$this->nrodoc=$NroDNI;
	}
	public function setNombre($Nom){
		$this->nombre=$Nom;
	}
	public function setApellido($Ape){
		$this->apellido=$Ape;
	}
	public function setTelefono($Tel){
		$this->telefono=$Tel;
	}
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}


	/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){ 
		$base=new BaseDatos();
		$consultaPersona="Select * from persona where pnumdoc=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setNrodoc($dni);
					$this->setNombre($row2['pnombre']);
					$this->setApellido($row2['papellido']);
					$this->setTelefono($row2['ptelefono']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    
    /**
     * Trae una lista usando parametros de busqueda.
	 * Devuelve un array cuyos elementos cumplieran la condicion de la consulta.
     *
     * @param string $condicion=""
     * @return array
     */
	public function listar($condicion=""){
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from persona ";
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by papellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){				
				$arregloPersona= array();
				while($row2=$base->Registro()){
					
					$NroDoc=$row2['pnumdoc'];
					$Nombre=$row2['pnombre'];
					$Apellido=$row2['papellido'];
					$telefono=$row2['ptelefono'];
				
					$perso=new Persona();
					$perso->cargar($NroDoc,$Nombre,$Apellido,$telefono);
					array_push($arregloPersona,$perso);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloPersona;
	}	


	 /**
     * Inserta datos en la base.
	 * Devuelve verdadero si los datos se insertaron con exito, o falso en caso contrario.
     *
     * @return boolean
     */
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		
		$consultaInsertar = "INSERT INTO persona(pnumdoc, pnombre, papellido, ptelefono) 
			VALUES (".$this->getNrodoc().", '".$this->getNombre()."', '".$this->getApellido()."', '".$this->getTelefono()."')";


		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	
	/**
     * Modifica datos en la base.
	 * Devuelve verdadero si los datos se modificaron con exito, o falso en caso contrario.
     *
     * @return boolean
     */
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE persona SET papellido='".$this->getApellido()."',pnombre='".$this->getNombre()."'
                           ,ptelefono='".$this->getTelefono()."' WHERE pnumdoc=". $this->getNrodoc();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

	/**
     * Elimina datos en la base.
	 * Devuelve verdadero si los datos se eliminaron con exito, o falso en caso contrario.
     *
     * @return boolean
     */
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM persona WHERE pnumdoc=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

	/**
     * Establece como se van a mostrar los datos de la instancia de la clase.
     *
     * @return string
     */
	public function __toString(){
	    return "\nNombre: ".$this->getNombre(). "\nApellido: ".$this->getApellido()."\nDNI: ".$this->getNrodoc()."\nTelefono: ".$this->getTelefono()."\n" ;
			
	}
}
?>