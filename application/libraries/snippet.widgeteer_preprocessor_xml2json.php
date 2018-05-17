<?php
// First we require the xml2json file of course.

  require_once($modx->getOption('core_path').'components/simplx/common/xml2json.php');
  
  // xml2json simply takes a String containing XML contents as input.
  // Remember that the preprocessor always get a parameter called $dataSet
  // containing the complete dataSet recieved from the dataSourceUrl or the
  // dataSet Snippet parameter.


/*

** Config options for the xml2json Class **

public static $DEBUG;
public static $MAX_RECURSION_DEPTH_ALLOWED = 25;
public static $EMPTY_STR = '';
public static $SIMPLE_XML_ELEMENT_OBJECT_PROPERTY_FOR_ATTRIBUTES = '@attributes';
public static $SIMPLE_XML_ELEMENT_PHP_CLASS = 'SimpleXMLElement';  
public static $INCLUDE_ATTRIBUTES = true;  

*/

  $jsonContents = xml2json::transformXmlStringToJson($dataSet);
  
  // And, hopefully, we got valid json to return to the Widgeteer script.
  return $jsonContents;