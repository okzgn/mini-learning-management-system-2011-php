<?php

class MockMySQLResult {
    public $rows = [];
    public $currentIndex = 0;
    public $columnCount = 0;

    public function __construct($pdoStmt) {
        if ($pdoStmt) {
            # FETCH_BOTH permite acceder por nombre de columna ($row['names']) o índice ($row[0])
            $this->rows = $pdoStmt->fetchAll(PDO::FETCH_BOTH);
            $this->columnCount = $pdoStmt->columnCount();
        }
    }
}

class UCE_Mock_DB {
    public static $pdo = null;

    public static function getPDO() {
        if (self::$pdo === null) {
            $dbFile = __DIR__ . '/uce_database.sqlite';
            $isNew = !file_exists($dbFile);

            self::$pdo = new PDO('sqlite:' . $dbFile);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

            if ($isNew) {
                self::initSchemaAndSeed();
            }
        }
        return self::$pdo;
    }

    private static function initSchemaAndSeed() {
        $db = self::$pdo;

        # Estructura requerida por regis.php, students.php y users.php
        $db->exec("CREATE TABLE IF NOT EXISTS students (
            user TEXT PRIMARY KEY,
            pass TEXT,
            names TEXT,
            age TEXT,
            email TEXT,
            curs TEXT,
            college TEXT,
            details TEXT DEFAULT 'normal'
        );");

        # --- DATOS INICIALES ---

        # 1. Administrador (User: admin | Pass: admin123)
        $db->exec("INSERT INTO students VALUES (
            '" . sha1('admin') . "',
            '" . sha1('admin123') . "',
            'Administrador General',
            '35',
            'admin@email.com',
            'AE',
            'Facultad de Administración',
            'admin'
        );");

        # 2. Profesor (User: docente | Pass: docente123)
        $db->exec("INSERT INTO students VALUES (
            '" . sha1('docente') . "',
            '" . sha1('docente123') . "',
            'Ing. Carlos Docente',
            '42',
            'docente@email.com',
            'AA',
            'Universidad Central',
            'teacher'
        );");

        # 3. Estudiante (User: estudiante | Pass: estudiante123)
        $db->exec("INSERT INTO students VALUES (
            '" . sha1('estudiante') . "',
            '" . sha1('estudiante123') . "',
            'Joel Puyo Alumno',
            '21',
            'joel.puyo@email.com',
            'AB',
            'Colegio Central Tech',
            'normal'
        );");

        # Lista de datos para asignar a cada foto encontrada
        $alumnos = [
            ['names' => 'Andrea Morales',    'age' => '20', 'email' => 'andrea.morales@email.com',   'college' => 'Colegio 24 de Mayo'],
            ['names' => 'David Ortiz',      'age' => '21', 'email' => 'david.ortiz@email.com',     'college' => 'Colegio Mejia'],
            ['names' => 'Sofia Ramirez',    'age' => '19', 'email' => 'sofia.ramirez@email.com',   'college' => 'Colegio Manuela Cañizares'],
            ['names' => 'Gabriel Castro',   'age' => '22', 'email' => 'gabriel.castro@email.com',  'college' => 'Colegio Montufar'],
            ['names' => 'Daniel Salazar',   'age' => '21', 'email' => 'daniel.salazar@email.com',  'college' => 'Colegio Central Tecnico'],
            ['names' => 'Cristian Barragan','age' => '21', 'email' => 'cristian.barragan@email.com','college' => 'Colegio San Gabriel'],
            ['names' => 'Elena Torres',     'age' => '20', 'email' => 'elena.torres@email.com',    'college' => 'Colegio Simon Bolivar'],
            ['names' => 'Gabriela Herrera', 'age' => '22', 'email' => 'gabriela.herrera@email.com','college' => 'Colegio Benalcazar'],
            ['names' => 'Natalia Paredes',  'age' => '20', 'email' => 'natalia.paredes@email.com', 'college' => 'Colegio Fernandez Madrid'],
            ['names' => 'Fernando Flores',  'age' => '21', 'email' => 'fernando.flores@email.com', 'college' => 'Colegio Juan Pio Montufar'],
            ['names' => 'Sebastian Gomez',  'age' => '23', 'email' => 'sebastian.gomez@email.com', 'college' => 'Colegio Mejia'],
            ['names' => 'Mario Espinosa',   'age' => '20', 'email' => 'mario.espinosa@email.com',  'college' => 'Colegio San Pedro Pascual'],
            ['names' => 'Jessica Vaca',     'age' => '21', 'email' => 'jessica.vaca@email.com',    'college' => 'Colegio 24 de Mayo'],
            ['names' => 'Patricia Cardenas','age' => '22', 'email' => 'patricia.cardenas@email.com','college' => 'Colegio Manuela Cañizares']
        ];

        # Extraer el hash exacto de cada archivo en "files" (fotos de estudiantes con SHA1 ID)
        $filesDir = dirname(__DIR__) . '/base/files/';
        if (is_dir($filesDir)) {
            $archivos = scandir($filesDir);
            $index = 0;
            $passDefault = sha1('123456');

            foreach ($archivos as $archivo) {
                if (strpos($archivo, 'fotoperfil___') === 0) {
                    # Extrae el hash que está después de 'fotoperfil___' y antes del punto
                    $partes = explode('___', $archivo);
                    if (isset($partes[1])) {
                        $userHash = substr($partes[1], 0, strpos($partes[1], '.'));
                        $data = $alumnos[$index % count($alumnos)];

                        $db->exec("INSERT OR REPLACE INTO students VALUES (
                            '{$userHash}',
                            '{$passDefault}',
                            '{$data['names']}',
                            '{$data['age']}',
                            '{$data['email']}',
                            'AC',
                            '{$data['college']}',
                            'normal'
                        );");

                        $index++;
                    }
                }
            }
        }
    }
}

if (!function_exists('mysql_connect')) {

    function mysql_connect($host = null, $user = null, $pass = null) {
        try {
            UCE_Mock_DB::getPDO();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function mysql_select_db($database_name, $link = null) {
        return true;
    }

    function mysql_query($query, $link = null) {
        $pdo = UCE_Mock_DB::getPDO();
        $trimmed = trim($query);

        if (preg_match('/^(use\s+|create\s+database|create\s+uce)/i', $trimmed)) {
            return true;
        }

        # Si busca un usuario por texto plano que no es sha1 (longitud distinta a 40 hex), le aplica sha1 automáticamente
        if (preg_match("/where\s*\(?user='([^']+)'\)?/i", $query, $matches)) {
            $userParam = $matches[1];
            if (strlen($userParam) != 40) {
                $query = str_replace("user='{$userParam}'", "(user='{$userParam}' OR user='" . sha1($userParam) . "')", $query);
            }
        }

        $stmt = $pdo->query($query);
        if ($stmt === false) {
            return false;
        }

        if (preg_match('/^(select|show|describe|pragma)/i', $trimmed)) {
            return new MockMySQLResult($stmt);
        }

        return true;
    }

    /*
    function mysql_fetch_object($result) {
        if ($result instanceof MockMySQLResult && isset($result->rows[$result->currentIndex])) {
            $row = $result->rows[$result->currentIndex];
            $result->currentIndex++;
            return (object)$row;
        }

        # SI NO ENCONTRÓ AL USUARIO, RETORNA UN PERFIL GENÉRICO PARA EVITAR LOS WARNINGS
        if ($result instanceof MockMySQLResult && count($result->rows) === 0) {
            return (object)[
                'user'    => 'desconocido',
                'names'   => 'Estudiante No Registrado',
                'college' => 'Sin registrar',
                'age'     => 'N/A',
                'email'   => 'sin-email@email.com',
                'curs'    => 'AD',
                'details' => 'normal'
            ];
        }

        return false;
    }
    */

    function mysql_fetch_object($result) {
        if ($result instanceof MockMySQLResult && isset($result->rows[$result->currentIndex])) {
            $row = $result->rows[$result->currentIndex];
            $result->currentIndex++;
            return (object)$row;
        }
        return false;
    }

    function mysql_fetch_array($result, $result_type = null) {
        if ($result instanceof MockMySQLResult && isset($result->rows[$result->currentIndex])) {
            $row = $result->rows[$result->currentIndex];
            $result->currentIndex++;
            return $row;
        }
        return false;
    }
}

?>
