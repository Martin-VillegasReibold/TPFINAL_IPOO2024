<?php
class ResponsableV extends Persona
{
    private $numeroEmpleado;
    private $numeroLicencia;


    public function __construct()
    {
        parent::__construct();
        $this->numeroEmpleado = "";
        $this->numeroLicencia = "";
    }

    public function cargar($nroDoc, $nombre, $apellido, $telefono, $numeroEmpleado=null, $numeroLicencia=null){
        parent::cargar($nroDoc, $nombre, $apellido, $telefono);
		$this->setNumeroEmpleado($numeroEmpleado);
        $this->setNumeroLicencia($numeroLicencia);
    }

	//Getters
    public function getNumeroEmpleado()
    {
        return $this->numeroEmpleado;
    }

	public function getNumeroLicencia()
    {
        return $this->numeroLicencia;
    }

   
	//Setters
	public function setNumeroEmpleado($numeroE)
    {
        $this->numeroEmpleado = $numeroE;
    }

    public function setNumeroLicencia($numeroL)
    {
        $this->numeroLicencia = $numeroL;
    }

	/**
     * Busca en la base de datos al responsable mediante su numero de empleado.
	 * Retorna verdadero si existe, sino falso.
     *
     * @param int $numeroEmpleado
     * @return boolean
     */
    public function Buscar($numeroEmpleado){
		$base=new BaseDatos();
        $consulta="SELECT * FROM responsable WHERE rnumeroempleado=".$numeroEmpleado; 
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                if($row2=$base->Registro()){    
                    parent::Buscar($row2['rnumdoc']);
                    $this->setNumeroEmpleado($row2['rnumeroempleado']);
                    $this->setNumeroLicencia($row2['rnumerolicencia']);
                    $resp= true;
                }                
            } else {
                $this->setmensajeoperacion($base->getError());
            }
         } else {
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
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from responsable ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by rnumeroempleado ";
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new ResponsableV();
					$obj->Buscar($row2['pdocumento']); //o rnumeroempleado
					array_push($arreglo,$obj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arreglo;
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
		if(parent::insertar()){
		
			$consultaInsertar = "INSERT INTO responsable (rnumeroempleado, rnumerolicencia, rnumdoc) 
                     VALUES (" . $this->getNumeroEmpleado() . ", " . $this->getNumeroLicencia() . ", " . $this->getNrodoc() . ")";

		    if($base->Iniciar()){
		        if($base->Ejecutar($consultaInsertar)){
		            $resp=  true;
		        }	else {
		            $this->setmensajeoperacion($base->getError());
		        }
		    } else {
		        $this->setmensajeoperacion($base->getError());
		    }
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
		if(parent::modificar()){
			$consultaModifica="UPDATE responsable SET rnumerolicencia=".$this->getNumeroLicencia()." WHERE rnumeroempleado=". $this->getNumeroEmpleado(); 
			if($base->Iniciar()){
				if($base->Ejecutar($consultaModifica)){
					$resp=  true;
				}else{
					$this->setmensajeoperacion($base->getError());
						
				}
			}else{
				$this->setmensajeoperacion($base->getError());	
			}
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
				$consultaBorra="DELETE FROM responsable WHERE pdocumento=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    if(parent::eliminar()){
				        $resp=  true;
				    }
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
    public function __toString()
    {
        $info= parent::__toString();
        $info.= "Empleado: {$this->getNumeroEmpleado()}, Licencia: {$this->getNumeroLicencia()})";
        return $info;
    }
}