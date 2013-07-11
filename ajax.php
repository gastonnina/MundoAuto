<?php
header('Content-type: text/json');
header('Content-type: application/json');
$res=array('code'=>400,'msg'=>'aglo salio mal');
if (isset($_GET['txtFiltro'])) {
    extract($_GET);
    require ('db/conn.php');
    require ('db/conection.php');
    $q = new BDmysql;
//echo "<br>--->$basedatos, $host, $user, $pass";
    $q->conectar($basedatos, $host, $user, $pass);
    
    $sql = "SELECT * FROM ma_auto";
  
    $q->consulta($sql);
 $res['code']=200;
 $res['msg']='filtrado';
 $res['total_data']=$q->numregistros();
    while ($r = $q->matriz()) {
        $res['data'][] = array(
            'id'=>$r['id_auto'],
            'placa' => $r['auto_placa'],
            'propietario' => $r['auto_propietario'],
            'marca' => $r['auto_marca'],
            'modelo' => $r['auto_modelo'],
            'color' => $r['auto_color'],
            'obs' => $r['auto_observacion'],
                );

    }
}

 /*echo "<pre>";
  print_r($res);
  echo "</pre>"; 
  */
echo json_encode($res);


?>