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
		
		$params = &JComponentHelper::getParams('com_proveedor');
		//~ $params =JComponentHelper::getParams('com_proveedor');
        echo ' ******************************************************************************';
        echo JPATH_ROOT;
        echo ' ******************************************************************************';
        
        echo '<pre>';
        print_r($files);
        echo '</pre>';
        echo '<pre>';
        echo ' ******************************************************************************';
        print_r($params);
        echo '</pre>';
		//~ $donwloader = new FOFDownload();
		//~ $xmlSource = $donwloader->getFromURL($files[0]);
        $formxml = simplexml_load_file($files[0]);
		$rootAttributes = $formxml->children();
		
		//~ $xml1 = JForm::getInstance('config', $files[0]);
		      //~ 
        //~ $campos = $xml1->getFieldset(); 
		//~ foreach ($fieldsets as $fieldset) {
        //~ echo '<h1>' . $fieldset->name . '</h1>';
        //~ $fields = $form11->getFieldset($fieldset->name);
        //~ foreach ($fields as $field) {
            //~ echo $field->label;
            //~ echo $field->input;
        //~ }
		//~ }
        echo '<pre>';
        echo ' ********************* XML *********************************************************';
        print_r($rootAttributes);
        //~ print_r($nuevoxml);
        echo '</pre>';
       
       
       
       
       
       
        
        //~ $params['version'] = $this->com_proveedor;
        //~ $this->setParams( $params );
//~ 
        //~ $db    = JFactory::getDBO();
        //~ $query = $db->getQuery(true);
        //~ $query
            //~ ->update('#__update_sites')
            //~ ->set("`enabled`='1'")
            //~ ->where("`name`='ImproveMyCity'");
        //~ $db->setQuery($query);
        //~ $db->execute();
        //~ 
        return true;        
    }
    
    /*
     * establece valores de los parámetros en la fila del componente de la tabla de extensión
     */
    public function setParams($param_array) {
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
                ' WHERE name = "com_proveedor' );
                $db->query();
        }
    }

}
