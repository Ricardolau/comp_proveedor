<?php

/**
 * Establecemos valores de parametros en tabla extension
 * @version 0.1b
 */
class com_proveedorInstallerScript {
	/*
     * Todo lo que aquí sucede después de la instalación / actualización / desinstalación 
     */
    public function postflight( $type, $parent ) {
        // always create or update version parameter
       //~ jimport('joomla.application.component.controller');
		$path_componente = JPATH_ROOT.'/administrator/components/com_proveedor';
		// Carga el fichero config de proveedor
        $files = JFolder::files( $path_componente , "config.xml" , false ,true); 
		
		
        echo ' ********************JPATH ROOT *********************************************************';
        echo '<pre>';
        echo JPATH_ROOT; // Es la ruta de la instalación... 
        echo $path_componente; // Es la ruta de componente... 
        echo '</pre>';
        echo ' *******************************  FILES  ***********************************************';
        echo '<pre>';
        print_r($files); // $files es la ruta del fichero config.xml
        echo '</pre>';
        $formxml = simplexml_load_file($files[0]); 
		$rootAttributes = $formxml->children(); // Genera objecto SimpleXMLElement , contiene parametros por defecto
		/** Creamos un bucle para recorra todos los grupos de parametros del fichero */
		foreach($rootAttributes->fieldset as $fieldset)
		{
			/* Necesito identificar si el grupo parametros es de permisos, ya que estos no se ponen en parametros*/
			$Nombregrupo =$fieldset->attributes(); // Obtenemos el nombre grupo de parametro si tienes.. 
			echo 'Nombre de grupo permisos:'.$Nombregrupo[name].'<br>';
			echo ' ********************* XML *********************************************************<br>';
			echo '<pre>';
			print_r($fieldset); // $files es la ruta del fichero config.xml
			echo '</pre>';
			echo ' ********************* For Set Params *********************************************************<br>';
			
			/* Si el Nombregrupo es igual permissions no lo metemos como parametro */
			if ($Nombregrupo <>'permissions') {
				echo '<pre>';
				$parametros = array(); // Creo array donde voy añadir parametros y valor defecto
				foreach($fieldset->field as $child)
				{
				echo '******** child ************<br>';
				$atributos=$child->attributes();
				$name= $atributos[name];
				$default = $atributos['default'];
				$parametros[strval($name)]=strval($default) ;
				echo $name.':'.$default.'<br>';
				echo '******** fin child ************<br>';
				}
				echo '</pre>';
				$this->setParams($parametros);// Enviamos el array con los parametros a funcion setParams
			}
		} 
		return true;        
    }
    
    /*
     * establece valores de los parámetros en la fila del componente de la tabla de extensión
     */
    public function setParams($param_array) {
		echo ' ******* Estes el array parametros que añadimos a tabla extensions **********<br>';
        echo '<pre>';
        print_r($param_array);
        echo '</pre>';
              
        if ( count($param_array) > 0 ) {
            // read the existing component value(s)
            $db = JFactory::getDbo();
            $db->setQuery('SELECT params FROM #__extensions WHERE name = "com_proveedor"');
            $params = json_decode( $db->loadResult(), true );
            // add the new variable(s) to the existing one(s)
            foreach ( $param_array as $name => $value ) {
                $params[ (string) $name ] = (string) $value;
            }
            // store the combined new and existing values back as a JSON string
            $paramsString = json_encode( $params );
            
            $db->setQuery('UPDATE #__extensions SET params = ' .
                $db->quote( $paramsString ) .
                ' WHERE name = "com_proveedor"' );
                $db->query();
        }
    }
    

}
