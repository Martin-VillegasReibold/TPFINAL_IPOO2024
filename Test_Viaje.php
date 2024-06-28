<?php
include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Empresa.php';
include_once 'Viaje.php';
include_once 'BaseDatos.php';

while (true) {

echo "\nElegir operacion
Empresa:
    1->Cargar
    2->Modificar
    3->Eliminar
Viaje:
    4->Cargar
    5->Modificar
    6->Eliminar
    7->Ver informacion
Pasajero:
    8->Agregar
    9->Modificar
    10->Eliminar
Finalizar:
    11->Salir\n";

$opcion = readline("Comando: ");

    switch ($opcion) {
        case '1':
            cargarInformacionEmpresa();
            break;
        case '2':
            modificarInformacionEmpresa();
            break;
        case '3':
            eliminarInformacionEmpresa();
            break;
        case '4':
            cargarInformacionViaje();
            break;
        case '5':
            modificarInformacionViaje();
            break;
        case '6':
            eliminarInformacionViaje();
            break;
        case '7':
            verDatosViaje();
            break;
        case '8':
            agregarPasajero();
            break;
        case '9':
            modificarPasajero();
            break;
        case '10':
            eliminarPasajero();
            break;
        case '11':
            echo "Fin de la ejecucion.\n";
            exit;
        default:
            echo "Seleccione una opción válida.\n";
            break;
    }
}


function cargarInformacionEmpresa() {
    $idEmpresa = readline("Ingrese el id de la empresa: ");
    $nombreEmpresa = readline("Ingrese el nombre de la empresa: ");
    $direccionEmpresa = readline("Ingrese la dirección de la empresa: ");
    $empresa = new Empresa();
    $empresa->cargar($idEmpresa, $nombreEmpresa, $direccionEmpresa);

    if($empresa->Buscar(($idEmpresa))){
        echo "La Id ingresada ya se encuentra en la base de datos.";
        return;
    } else {
        $empresa->insertar();
        echo "Empresa agregada.";
    }
    
    
}

function modificarInformacionEmpresa() {
    echo "Ingrese el id de la empresa que desea modificar:\n";
    $id = trim(fgets(STDIN));
    $empresa = new Empresa();
    if(!$empresa->Buscar($id)){
        echo "La empresa no ha sido encontrada\n";
        return;
    }

    echo "Qué información desea modificar de la empresa?\n";
    echo "1->El nombre\n";
    echo "2->La dirección\n";
    echo "3->Todos los datos\n";
    $eleccion = trim(fgets(STDIN));
    modificarEmpresa($empresa, $eleccion);
}

function eliminarInformacionEmpresa() {
    echo "Ingrese el Id de la empresa que desea eliminar:\n";
    $id = trim(fgets(STDIN));
    $empresa = new Empresa();
    if($empresa->Buscar($id)) {
        $empresa->eliminar();
        echo "La empresa ha sido eliminada correctamente.\n";
    } else {
        echo "No se encontró la empresa que se buscaba.\n";
    }
}

function modificarEmpresa($empresa, $eleccion) {
    switch ($eleccion) {
        case '1':
            echo "Nombre actual de la empresa: " . $empresa->getNombre() . "\n";
            $empresa->setNombre(readline("Nuevo nombre: "));
            break;
        case '2':
            echo "Dirección actual de la empresa: " . $empresa->getDireccion() . "\n";
            $empresa->setDireccion(readline("Nueva dirección: "));
            break;
        case '3':
            $empresa->setNombre(readline("Nuevo nombre: "));
            $empresa->setDireccion(readline("Nueva dirección: "));
            break;
        default:
            echo "Seleccione una opción válida.\n";
            return;
    }
    $empresa->modificar();
}


function cargarInformacionViaje() {
    $empresa = new Empresa();
    echo "Ingrese el ID de la empresa:\n";
    $id= trim(fgets(STDIN));
    if (!$empresa->Buscar($id)) {
        echo "No se encontró una empresa con el ID dado.\n";
        return;
    } else {
        echo "La empresa es ".$empresa->getNombre()."\n";
    }

    echo "Completar informacion del encargado/responsable del viaje:\n";

    $nroDocResponsableV = readline("Numero de Documento: ");
    $nombreResponsableV = readline("Nombre: ");
    $apellidoResponsableV  = readline("Apellido: ");
    $telefonoResponsableV = readline("Telefono: ");
    $numEmpleado = readline("Numero de empleado: ");
    $numLicencia = readline("Numero de licencia: ");
    $nuevoResponsable = new ResponsableV();
    $nuevoResponsable->cargar($nroDocResponsableV, $nombreResponsableV, $apellidoResponsableV, $telefonoResponsableV, $numEmpleado, $numLicencia);
    if($nuevoResponsable->Buscar($numEmpleado)){
        echo "Esta persona ya ha sido cargada\n";
        return;
    } else {
        $nuevoResponsable->insertar();
    }
    echo "Informacion del nuevo viaje\n";
    $codigo = readline("Codigo(Id): ");
    $destino = readline("Destino: ");
    $maxPasajeros = readline("Cantidad maxima de pasajeros: ");
    $costoDelViaje = readline("Costo: ");

    $viaje = new Viaje();
    $viaje->cargar($codigo, $destino, $maxPasajeros, $nuevoResponsable, $costoDelViaje, $empresa);

    if($viaje->Buscar(($codigo))){
        echo "La Id ingresada ya se encuentra en la base de datos.";
        return;
    } else {
        $viaje->insertar();
        echo "Viaje agregado.";
    }





}

function modificarInformacionViaje() {
    while (true) {
        echo "\nModificar:
        1->Destino del viaje
        2->Maximo de pasajeros del viaje
        3->Responsable del viaje
        4->Costos del viaje
        5->Empresa
        6->Volver\n";

        $opcion = readline("Ingrese la modificacion deseada: ");
        $viaje = new Viaje();

        echo "Ingrese el id del viaje:\n";
        $id = trim(fgets(STDIN));
        
        if(!$viaje->Buscar($id)){
            echo "El viaje no ha sido encontrado\n";
            return;
        }

        switch ($opcion) {
            case '1':
                echo "Destino actual del viaje: " . $viaje->getDestino() . "\n";
                $viaje->setDestino(readline("Ingrese el destino del viaje: "));
                $viaje->modificar();
                break;
            case '2':
                echo "Cantidad maxima de pasajeros actual del viaje: " . $viaje->getMaxPasajeros() . "\n";
                $viaje->setMaxPasajeros(readline("Nueva cantidad maxima de pasajeros del viaje: "));
                $viaje->modificar();
                break;
            case '3':
                echo "Información a modificar del responsable del viaje:
                1->El número de licencia
                2->El nombre
                3->El apellido
                4->Todos los datos\n";
                $opcion = trim(fgets(STDIN));
                modificarResponsableViaje($viaje, $opcion);
                break;
            case '4':
                echo "Costo actual del viaje: " . $viaje->getCosto() . "\n";
                $viaje->setCosto(readline("Nuevo costo del viaje: "));
                $viaje->modificar();
                break;
            case '5':
                echo "Empresa actual:\n";
                
                $Empresa = $viaje->getObjEmpresa();
                $EmpresaA = new Empresa();
                $EmpresaA -> Buscar($Empresa);
                echo $EmpresaA;
                echo "Ingrese el Id de la nueva empresa:";
                $eleccion = trim(fgets(STDIN));
                if($EmpresaA -> Buscar($eleccion)){
                    $viaje -> setObjEmpresa($eleccion);
                    $viaje -> modificar();
                } else {
                    echo "La empresa no se encuentra en la base de datos.";
                }
                
                break;
            case '6':
                return;
            default:
                echo "Seleccione una opción válida.\n";
                break;
        }
    }
}

function modificarResponsableViaje($viaje, $opcion) {
    $responsable = $viaje->getObjResponsable();
    $responsableV = new ResponsableV();
    $responsableV -> Buscar($responsable);
    
    switch ($opcion) {
        case '1':
            echo "Numero de licencia actual del responsable del viaje: " . $responsableV ->getNumeroLicencia() . "\n";
            $responsableV->setNumeroLicencia(readline("Nuevo numero de licencia del responsable del viaje: "));
            break;
        case '2':
            echo "Nombre actual del responsable del viaje: " . $responsableV->getNombre() . "\n";
            $responsableV->setNombre(readline("Nuevo nombre del responsable del viaje: "));
            break;
        case '3':
            echo "Apellido actual del responsable del viaje: " . $responsableV->getApellido() . "\n";
            $responsableV->setApellido(readline("Nuevo apellido del responsable del viaje: "));
            break;
        case '4':
            $responsableV->setNumLicencia(readline("Nuevo numero de licencia del responsable del viaje: "));
            $responsableV->setNombre(readline("Nuevo nombre del responsable del viaje: "));
            $responsableV->setApellido(readline("Nuevo apellido del responsable del viaje: "));
            break;
        default:
            echo "Seleccione una opción válida.\n";
            return;
    }
    $responsableV->modificar();
}



function eliminarInformacionViaje() {
    echo "Ingrese el Id del viaje que desea eliminar:\n";
    $id = trim(fgets(STDIN));
    $viaje = new Viaje();
    if($viaje->Buscar($id)) {
        $viaje->eliminar();
        echo "El viaje ha sido eliminado correctamente.\n";
    } else {
        echo "No se encontró el viaje que se buscaba.\n";
    }
}

function verDatosViaje() {
    echo "Ingrese el Id del viaje:\n";
    $id = trim(fgets(STDIN));
    $viaje = new Viaje();
    if($viaje->Buscar($id)) {
        $pasajero = new Pasajero();
        $viaje -> setPasajerosArray($pasajero -> listar('idviaje ='.$id));
        //echo getStringArray();
       
        echo $viaje;
    } else {
        echo "No se encontró el viaje que se buscaba.\n";
    }
}


function agregarPasajero() {
    $viaje = new Viaje();
    echo "Ingrese el id del viaje:\n";
    $id = trim(fgets(STDIN));

    if ($viaje->Buscar($id)) {
        //echo $viaje;
        $pasajero = new Pasajero();
        $viaje -> setPasajerosArray($pasajero -> listar('idviaje ='.$id));

        if (!$viaje->hayPasajesDisponibles()) {
            echo "No hay pasajes disponibles\n";
            return;
        } else {
            $numDocPasajero = readline("Ingrese el numero de documento del pasajero: ");
            $nombrePasajero = readline("Ingrese el Nombre del pasajero: ");
            $apellidoPasajero = readline("Ingrese el apellido del pasajero: ");
            $telefonoPasajero = readline("Ingrese el telefono del pasajero: ");
            $numAsiento = readline("Ingrese el numero de asiento: ");
            $numTicket = readline("Ingrese el numero de ticket: ");

            if (empty($numDocPasajero) || empty($nombrePasajero) || empty($apellidoPasajero) || empty($telefonoPasajero) || empty($numAsiento) || empty($numTicket)) {
                echo "Todos los campos son obligatorios.\n";
                return;
            }

            $nuevoPasajero = new Pasajero();
            $nuevoPasajero->cargar($numDocPasajero, $nombrePasajero, $apellidoPasajero, $telefonoPasajero, null, $numAsiento, $numTicket, $viaje);

            if ($nuevoPasajero->Buscar($numDocPasajero)) {
                echo "Este pasajero ya ha sido cargado\n";
                return;
            } else {
                if ($nuevoPasajero->insertar()) {
                    echo "Pasajero agregado exitosamente.\n";
                } else {
                    echo "Error al insertar el pasajero: " . $nuevoPasajero->getmensajeoperacion() . "\n";
                }
            }
        }
    } else {
        echo "No se encontró el viaje que se buscaba.\n";
    }
}


function modificarPasajero() {
    echo "Ingrese el documento del pasajero que desea modificar:\n";
    $id = trim(fgets(STDIN));
    $pasajero = new Pasajero();
    if (!$pasajero->Buscar($id)) {
        echo "El pasajero no ha podido ser encontrado\n";
        return;
    }

    echo "Qué información desea modificar del pasajero?
    1->El nombre
    2->El apellido
    3->El telefono
    4->Todos los datos\n";
    $eleccion = trim(fgets(STDIN));
    switch ($eleccion) {
        case '1':
            echo "Nombre actual del pasajero: " . $pasajero->getNombre() . "\n";
            $pasajero->setNombre(readline("Ingrese el nuevo nombre del pasajero: "));
            break;
        case '2':
            echo "Apellido actual del pasajero: " . $pasajero->getApellido() . "\n";
            $pasajero->setApellido(readline("Ingrese el nuevo apellido del pasajero: "));
            break;
        case '3':
            echo "Telefono actual del pasajero: " . $pasajero->getTelefono() . "\n";
            $pasajero->setTelefono(readline("Ingrese el nuevo telefono del pasajero: "));
            break;
        case '4':
            $pasajero->setNombre(readline("Nuevo nombre del pasajero: "));
            $pasajero->setApellido(readline("Nuevo apellido del pasajero: "));
            $pasajero->setTelefono(readline("Nuevo telefono del pasajero: "));
            break;
        default:
            echo "Seleccione una opción válida.\n";
            return;
    }
    if ($pasajero->modificar()) {
        echo "Pasajero modificado exitosamente.\n";
    } else {
        echo "Error al modificar el pasajero: " . $pasajero->getmensajeoperacion() . "\n";
    }
}

function eliminarPasajero() {
    echo "Ingrese el documento del pasajero que desea eliminar:\n";
    $id = trim(fgets(STDIN));
    $pasajero = new Pasajero();
    if ($pasajero->Buscar($id)) {
        $pasajero->eliminar();
        echo "El pasajero ha sido eliminado correctamente.\n";
    } else {
        echo "No se encontró el pasajero que se buscaba.\n";
    }
}




?>