<?php /** */
class SimpleParser
{
    var $data  = array();
    var $stack = array();
    var $keys;

    function SimpleParser()
    {

    }

    function getValue( $tagsname , $idx = 0)
    {
        if( !isset( $this->data[ $tagsname ] ) ) return false;
        if( !isset( $this->data[ $tagsname ]['data'] ) ) return false;
        if( !isset( $this->data[ $tagsname ]['data'][$idx] ) ) return false;

        return $this->data[ $tagsname ]['data'][$idx];
    }

    function parse_xml( $xml_text , $bEUCKR = false )
    {
        $parser = xml_parser_create($bEUCKR ? 'ISO-8859-1' : "UTF-8");

        xml_set_object($parser, $this);
        xml_set_element_handler($parser, 'startXML', 'endXML');
        xml_set_character_data_handler($parser, 'charXML');

        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, $bEUCKR ? 'ISO-8859-1' : "UTF-8" );
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 1);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

        xml_parse(  $parser, trim( $xml_text ));
        xml_parser_free($parser);

        if( count( $this->data ) <= 0 ) return false;

        return true;
    }

    function startXML($parser, $name, $attr)
    {
        $this->stack[$name] = array();
        $keys = '';
        $total = count($this->stack)-1;
        $i=0;
        foreach ($this->stack as $key => $val)
        {
            if (count($this->stack) > 1) {
                if ($total == $i)
                    $keys .= $key;
                else
                    $keys .= $key . '|'; // The saparator
            }
            else
                $keys .= $key;

            $i++;
        }

        if (array_key_exists($keys, $this->data))    {
            $this->data[$keys][] = $attr;
        }
        else
            $this->data[$keys] = $attr;

        $this->keys = $keys;
    }

    function endXML($parser, $name)    {
        end($this->stack);
        if (key($this->stack) == $name)
            array_pop($this->stack);
    }

    function charXML($parser, $data)    {
        if (trim($data) != '')
            @$startFrom = count($this->data[$this->keys])-1; // fixes weird splitting (bug?)
        @$startFrom = $startFrom == -1 ? $startFrom = 0 : $startFrom;
        @$this->data[$this->keys]['data'][$startFrom] .= trim(str_replace("\n", '', $data));
    }
}	// HiworksRequestParser class


// 직접 호출은 가급적 사용하시지 말기 바랍니다.
// 한글일 경우 utf-8 로 변환해 주어야 사용가능합니다.


/* key_array 에 원하는 name 을 준다. 여러개일 경우 array 로 */
function getValueFromXML( $xml_str, $key_array = "" )
{
    $dom = domxml_open_mem($xml_str);

    return getValueFromXMLObject( $dom, $key_array );
}

function getValueFromXMLObject( $dom, $key_array )
{
    $result = array();

    if( is_array( $key_array ) )
    {
        foreach( $key_array as $getk )
        {
            if( strstr( $getk , ">" ) )
            {
                $tree_list = explode(">", $getk );
                $value = getValueFromXMLObjectByTree( $dom, $tree_list );
                if( !$value ) continue;
                $result[ $getk ] = $value;
            }
            else
            {
                $value = $dom->get_elements_by_tagname($getk);
                if( !$value ) continue;
                $result[ $getk ] = $value[0]->get_content();
            }
        }
    }
    else
    {
        if( $key_array == "" ) return $result;

        if( strstr( $key_array , ">" ) )
        {
            $tree_list = explode(">", $key_array );
            $value = getValueFromXMLObjectByTree( $dom, $tree_list );
            if( $value )
                $result[ $getk ] = $value;

        }
        else
        {
            $value = $dom->get_elements_by_tagname($key_array);
            if( $value )
                $result[ $key_array ] = $value[0]->get_content();
        }
    }

    return $result;

}

function getValueFromXMLObjectByTree( $xml_obj , $tree_list )
{
    $result = array();

    $current_dom = $xml_obj;
    $success_count = 0;

    foreach( $tree_list as $getk )
    {
        //echo $getk;
        $temp_dom = $current_dom->get_elements_by_tagname( $getk );
        if( !$temp_dom ) break;

        $current_dom = $temp_dom[0];
        $success_count++;
    }

    if( $success_count != count($tree_list) ) return false;

    return $current_dom->get_content();
}

function getElementsFromXML( $xml_str, $key_array )
{
    $result = array();
    $dom = domxml_open_mem($xml_str);

    $value = $dom->get_elements_by_tagname($key_array);

    if( $value ) $result = $value;

    return $result;
}

function getElementsFromXMLByTree( $xml_str, $tree_list )
{
    $result = array();

    $current_dom = $xml_obj;
    $success_count = 0;

    foreach( $tree_list as $getk )
    {
        //echo $getk;
        $temp_dom = $current_dom->get_elements_by_tagname( $getk );
        if( !$temp_dom ) break;

        $current_dom = $temp_dom[0];
        $success_count++;

        if( $success_count == count($tree_list) )
            $current_dom = $temp_dom;
    }

    if( $success_count != count($tree_list) ) return false;

    return $current_dom;
}

function getOneNodeFromXMLObject( $node_dom )
{
    $result = array();
    $child = $node_dom->first_child();

    while( $child )
    {
        if( $child->tagname() == "groupEntries" )
        {

        }
        else if( $child->tagname() == "nodes" )
        {
            $result[ "nodes" ] = getNodeFromXMLObject( $child );
        }
        else
        {
            $result[ $child->tagname() ] = $child->get_content();
        }

        $child = $child->next_sibiling();
    }

    return $result;


}

function getNodeFromXMLObject( $nodes_dom )
{
    //print_r($nodes_dom);
    //return "111";

    $xpath = xpath_new_context($nodes_dom);
    $xpresult = xpath_eval( $xpath, "/organizationInformation/nodes/node/nodeId" );

    //print_r($xpresult);
    //return;

    foreach( $xpresult->nodeset as $node )
    {
        printf("%s", $node->get_content() );
    }


    print_r($xpresult->nodeset);
    return;


    $children = $dConvsNodeSet->nodeset[0]-> child_nodes();


    $result = array();
    $child = $nodes_dom->first_child();

    print_r( $child->get_content() );

    while( $child )
    {
        //$result[] = getOneNodeFromXMLObject( $child );
        print_r( $child->get_content() );

        if( $child->node_name() == "DomComment" )
            $child = $child->next_sibiling();
    }

    return $result;

}

function xml2array($contents, $bEUCKR = false )
{
    $xml_values = array();
    $parser = xml_parser_create('');
    if(!$parser) return array();

    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, $bEUCKR ? 'ISO-8859-1' : "UTF-8" );
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);

    xml_parser_free($parser);

    if (!$xml_values) return array();

    $xml_array = array();
    $last_tag_ar =& $xml_array;
    $parents = array();
    $last_counter_in_tag = array(1=>0);

    foreach ($xml_values as $data)
    {
        switch($data['type'])
        {
        case 'open':
            $last_counter_in_tag[$data['level']+1] = 0;
            $new_tag = array('name' => $data['tag']);
            if(isset($data['attributes']))
                $new_tag['attributes'] = $data['attributes'];
            if(isset($data['value']) && trim($data['value']))
                $new_tag['value'] = trim($data['value']);
            $last_tag_ar[$last_counter_in_tag[$data['level']]] = $new_tag;
            $parents[$data['level']] =& $last_tag_ar;
            $last_tag_ar =& $last_tag_ar[$last_counter_in_tag[$data['level']]++];
            break;
        case 'complete':
            $new_tag = array('name' => $data['tag']);
            if(isset($data['attributes']))
                $new_tag['attributes'] = $data['attributes'];
            if(isset($data['value']) && trim($data['value']))
                $new_tag['value'] = trim($data['value']);

            $last_count = count($last_tag_ar)-1;
            $last_tag_ar[$last_counter_in_tag[$data['level']]++] = $new_tag;
            break;
        case 'close':
            $last_tag_ar =& $parents[$data['level']];
            break;
        default:
            break;
        };
    }
    return $xml_array;
}
?>
