<?php
    require_once "./libraries/graphviz/GraphViz.php";
    class Graph {
    
        var $misc, $data;

        
        function Graph($misc, $data) {
            $this->misc = $misc;
            $this->data = $data;
        }
        
        
        function isAvailable() {
            return 1;
        }
        
        
        function dumpImage($schema, $table) {
            $edges = array();
            $nodes = array(array($schema, $table));

            // Collect all referred tables until we cannot find anymore.
            for ($i = 0; $i < count($nodes); $i++) {
                $t = $nodes[$i];
                $old = $this->data->_schema;
                $this->data->_schema = $t[0];
                $refs = $this->data->getReferredTables($t[1]);
                $this->data->_schema = $old;
                foreach ($refs as $field => $fks) {
                    foreach ($fks as $fk) {
                        $rfq = array($fk['nspname'], $fk['relname']);
                        if ($rfq[1] == "obj") continue;
                        $edge = array($rfq, $fk['attname'], $t, $field);
                        if (in_array($edge, $edges)) continue;
                        $nodes[] = $rfq;
                        $edges[] = $edge;
                    }
                }
            }
            
            // Collect outgoing refs.
            array_shift($nodes);
            array_push($nodes, array($schema, $table)); 
            for ($i = count($nodes) - 1; $i < count($nodes); $i++) {
                $t = $nodes[$i];
                $old = $this->data->_schema;
                $this->data->_schema = $t[0];
                $refs = $this->data->getRefsMap($t[1]);
                $this->data->_schema = $old;
                foreach ($refs as $field => $fk) {
                    $rfq = array($fk[0], $fk[1]);
                    if ($rfq[1] == "obj") continue;
                    $edge = array($t, $field, $rfq, $fk[1]);
                    if (in_array($edge, $edges)) continue;
                    $nodes[] = $rfq;
                    $edges[] = $edge;
                }
            }
            
            // Draw the graph.
            $graph = new Image_GraphViz();   
            $graph->addAttributes(array(
                'label'=> "Graph for $schema.table",   
                'labelloc'=>'t',   
                'fontname'=>'Helvetica',   
                'fontsize'=>8,   
                'labelfontname'=>'Helvetica',   
                'labelfontsize'=>10,   
                'orientation' => 'portrait',   
                'labeljust'=>'l',   
                'labeldistance'=>'5.0',   
                'rankdir' => 'LR',   
            ));
            foreach ($nodes as $node) {
                $name = $this->getShortNodeName($nodes, $node);
                $graph->addNode(
                    $name,
                    array(
                        'URL' => 'http://www.ru',
                        'label' => $name,
                        'shape' => 'box',
                        'style' => 'filled',
                    ) + ($node[0] == $schema && $node[1] == $table? array("fillcolor" => "magenta") : array()) 
                );
            }
            foreach ($edges as $edge) {
                $graph->addEdge(
                    array($this->getShortNodeName($nodes, $edge[0]) => $this->getShortNodeName($nodes, $edge[2])),
                    array(
                        'label' => "{$edge[1]}",
                    )
                );
            }
            
            $graph->image();   
        
//          $map = $this->data->getRefsMap("$table");
//          print_r($map);
        }
        
        function getShortNodeName($nodes, $node)
        {
            foreach ($nodes as $n) {
                if ($n[1] === $node[1] && $n[0] !== $node[0]) return "{$node[0]}.{$node[1]}";
            }
            return $node[1];
        }
    }
?>
