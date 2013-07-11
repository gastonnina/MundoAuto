<?php

/**
 * @author Gaston Nina <gastonnina@gmail.com>
 */
if (!class_exists("BDmysql")) {

    class BDmysql {
        /* variables de conexión */

        public $BaseDatos;
        public $Servidor;
        public $Usuario;
        public $Clave;
        /* identificador de conexión y consulta */
        public $Conexion_ID = 0;
        public $Consulta_ID = 0;
        /* número de error y texto error */
        public $Errno = 0;
        public $Error = "";
        public $sql;

        /* Método Constructor: Cada vez que creemos una variable
          de esta clase, se ejecutará esta función */

        public function __construct($bd = "", $host = "localhost", $user = "root", $pass = "") {
            $this->BaseDatos = $bd;
            $this->Servidor = $host;
            $this->Usuario = $user;
            $this->Clave = $pass;
        }

        public function msg_error() {
            echo $this->Error ;
            exit();
        }

        /* Conexión a la base de datos */

        public function conectar($bd = "", $host = "", $user = "", $pass = "") {
            if ($bd != "")
                $this->BaseDatos = $bd;
            if ($host != "")
                $this->Servidor = $host;
            if ($user != "")
                $this->Usuario = $user;
            if ($pass != "")
                $this->Clave = $pass;
// Conectamos al servidor
            $this->Conexion_ID = mysql_connect($this->Servidor, $this->Usuario, $this->Clave);
            if (!$this->Conexion_ID) {
                $this->Error = "Ha fallado la conexión.";
                $this->msg_error();
            }

//seleccionamos la base de datos
            if (!@mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {
                $this->Error = "Imposible abrir " . $this->BaseDatos;
                $this->msg_error();
            }

            /* Si hemos tenido éxito conectando devuelve 
              el identificador de la conexión, sino devuelve 0 */
            return $this->Conexion_ID;
        }

        /* Ejecuta un consulta */

        public function consulta($sql = "", $show = 0, $objectQueLlama = "") {
            if ($show != 0)
                echo "sql=$sql <br>";

            if ($sql == "") {
                $this->Error = "No ha especificado una consulta SQL";
                return 0;
            }
            //ejecutamos la consulta
            //	echo "Ejecuta consulta -- $sql <br />";
            //if ($sql=="SELECT table1.site_title2,table1.meta_description2,table1.meta_keywords2 FROM st_adm_siteconf AS table1") $sql="SELECT table1.site_title2,table1.meta_description2,table1.meta_keywords2 FROM st_adm_siteconfa AS table1";
            $this->Consulta_ID = mysql_query($sql, $this->Conexion_ID);
            $this->sql = $sql;
            if (!$this->Consulta_ID) {
                $this->Errno = mysql_errno();
                $this->Error = mysql_error();
            }
            if ($objectQueLlama != "") {
                if (strlen(trim($this->Error)) > 0) {
                    $id_log = $this->loglogreporting(30, "super", 1, "0", $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . ' : An error ocurred when ' . $sql . ' was execute - ' . ereg_replace("'", " ", $this->Error) . '.', "Error SQL", "0", "", "", "Espanol");
                    if ($id_log == 0) {
                        $form_cliente = WebPage::EnviaMail($title, '[HANSA] Log error', "gaston@enbolivia.com", $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . ' : An error ocurred when ' . $sql . ' was execute - ' . ereg_replace("'", " ", $this->cn->Error) . '.', ""); //mail a usuari
                    }
                    $this->showErrorMessage('An error ocurred : ' . $id_log . '.', $objectQueLlama);
                }
            }
            /* Si hemos tenido éxito en la consulta devuelve 
              el identificador de la conexión, sino devuelve 0 */
            return $this->Consulta_ID;
        }

        /**
         * Show an error message
         * @param string $message
         * @access protected
         */
        protected function showErrorMessage($message, $objectQueLlama) {
            if (strlen(trim($message)) > 0)
                echo '<br />' . $message . ' (' . $objectQueLlama . ')';
        }

        public function loglogreporting($Id_user, $user_i = "", $action, $id_registro = "", $registro = "", $typeregistro = "", $IdDataType = "", $data_type = "", $date = "", $idioma = "") { //$message="$action $item";
            global $basedatos, $host, $user, $pass, $pre;
            if ($date == "")
                $date = date("Y-n-j H:i:s");
            $ip = $_SERVER['REMOTE_ADDR'];
            $bd = new BDmysql;
            $bd->conectar("$basedatos", "$host", "$user", "$pass");
            //$sql="insert into {$pre}log (user,message,obs) VALUES ('$user_1','$message','$obs')";
            $sql = "insert into {$pre}loglog (id_user,nombre_user,accion,id_registro, registro, typeregistro,id_data_type,data_type,date,ip,idioma)
                    VALUES ('$Id_user', '$user_i', '$action', '$id_registro','$registro', '$typeregistro', '$IdDataType', '$data_type', '$date','$ip','$idioma')";
            $bd->consulta($sql);
            return $bd->id_ultimo_insert();
            //echo "<br>desde index.php".$sql;
        }

        /* Devuelve el número de campos de una consulta */

        public function numcampos() {
            return mysql_num_fields($this->Consulta_ID);
        }

        /* Devuelve el número de registros de una consulta */

        public function numregistros() {


            return mysql_num_rows($this->Consulta_ID);
        }

        /* Devuelve el ide del ultimo insert */

        public function id_ultimo_insert() {
            return mysql_insert_id($this->Conexion_ID);
        }

        /* devuelve el numero de columnas afectadas */

        public function affected_rows() {
            return mysql_affected_rows($this->Conexion_ID);
        }

        /* Devuelve el nombre de un campo de una consulta */

        function nombrecampo($numcampo) {
            return mysql_field_name($this->Consulta_ID, $numcampo);
        }

        /* Muestra los datos de una consulta */

        public function verconsulta() {
            echo "<table border=1>\n";
            // mostramos los nombres de los campos
            for ($i = 0; $i < $this->numcampos(); $i++) {
                echo "<td><b>" . $this->nombrecampo($i) . "</b></td>\n";
            }
            echo "</tr>\n";
            // mostrarmos los registros
            while ($row = mysql_fetch_row($this->Consulta_ID)) {
                echo "<tr> \n";
                for ($i = 0; $i < $this->numcampos(); $i++) {
                    echo "<td>" . $row[$i] . "</td>\n";
                }
                echo "</tr>\n";
            }
        }

        /* gaston Devuelve solo el resultado de una fila
         * estos valores pueden ser recogidos por list() si son varios asignacion directa a variable, siempre maneja posiciones si es array no variables tomar en cuenta
         */

        public function valoresFila() {
            if ($this->Error == "")
                return mysql_fetch_row($this->Consulta_ID);
            else {
                $this->Error = "$this->sql, $this->Error ";
                $this->msg_error();
                return false;
            }
        }

        public function matriz() {
            if ($this->Error == "") {
                return mysql_fetch_array($this->Consulta_ID);
            } else {
                $this->Error = "$this->sql, $this->Error ";
                $this->msg_error();
                return false;
            }
        }

        public function libera() {
            @mysql_free_result($this->Consulta_ID);
        }

        public function __destruct() {
            $this->libera();
        }

    }

    //fin de la Clse BDmysql
}
?>
