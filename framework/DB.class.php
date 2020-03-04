<?php
class DB {

    private $db = null;

    public function __construct() {
        $this->db = new mysqli(Config::get('host'), Config::get('login'), Config::get('senha'), Config::get('banco'));
        if (mysqli_connect_errno()) {
            die('[db] Não foi possivel se conectar ao banco de dados');
        }
        $this->db->query("SET NAMES 'utf8', lc_time_names = 'pt_BR'");
    }

    public function query($sql, $fetch = 'assoc') {
        $i = 0;
        $retorno = array();
        if (!$res = $this->db->query($sql)) {
            die("[query] Erro: [{$this->db->error}]");
        } else {
            while ($val = $res->fetch_assoc()) {
                $retorno[] = $val;
            }
        }
        $res->free();
        return $retorno;
    }

    public function select($tabela, $array = [], $where = null, $outro = null, $fetch = 'assoc') {
        $retorno = array();
        $where = ($where !== null) ? " WHERE {$where} " : '';
        $outro = ($outro !== null) ? " {$outro} " : '';
        $campo = null;
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $c => $v) {
                $campo .= $campo != null ? ', ' : '';
                if (is_numeric($c)) {
                    $campo .= $v;
                } else {
                    $campo .= $c . ' AS ' . $v;
                }
            }
        } else {
            $campo = '*';
        }

        if (!$res = $this->db->query("SELECT {$campo} FROM {$tabela} {$where} {$outro}")) {
            die("[select] Erro: [{$this->db->error}] \"SELECT {$campo} FROM {$tabela} {$where} {$outro}\"");
        } else {
            while ($val = $res->fetch_assoc()) {
                $retorno[] = $val;
            }
        }
        $res->free();
        return $retorno;
    }

    public function insert($tabela, $array) {
        try {
            if (!is_array($array) || count($array) == 0) {
                throw new Exception("[update] Erro: array vazio");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
        ksort($array);
        $campoNome = implode(', ', array_keys($array));
        $campoValor = implode('\', \'', $array);
        try {
            if (!$res = $this->db->query("INSERT INTO {$tabela} ($campoNome) VALUES ('{$campoValor}')")) {
                throw new Exception("[insert] Erro: [{$this->db->error}]");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
        return $res;
    }

    public function update($tabela, $array, $where, $limit = null) {
        $limit = (is_numeric($limit) && $limit != null) ? " LIMIT {$limit} " : '';
        if (!is_array($array) || count($array) == 0) {
            throw new Exception("[update] Erro: array vazio");
        }
        ksort($array);
        $campos = null;
        foreach ($array as $chave => $valor) {
            $campos .= "{$chave}= '{$valor}',";
        }
        $campos = rtrim($campos, ',');
        if (!$res = $this->db->query("UPDATE {$tabela} SET $campos WHERE {$where} {$limit}")) {
            throw new Exception("[update] Erro: [{$this->db->error}]");
        }
        return $res;
    }

    public function delete($tabela, $where, $limit = null) {
        $where = ($where !== null) ? " WHERE {$where} " : '';
        $limit = (is_numeric($limit) && $limit != null) ? " LIMIT {$limit} " : '';
        if (!$res = $this->db->query("DELETE FROM {$tabela} WHERE {$where} {$limit}")) {
            throw new Exception("[delete] Erro: [{$this->db->error}]");
        }
        return $res;
    }

    public function getId($tabela, $campoID, $where = null) {
        $where = ($where !== null) ? " WHERE {$where} " : '';
        $res = $this->db->query("SELECT {$campoID} FROM {$tabela} {$where} ORDER BY {$campoID} DESC LIMIT 1");
        if ($val = $res->fetch_assoc()) {
            return ++$val[$campoID];
        } else {
            return 1;
        }
    }

    public function getTotal($tabela, $where = null) {
        $where = ($where !== null) ? " WHERE {$where} " : '';
        $res = $this->db->query("SELECT * FROM {$tabela} {$where}");
        return $res->num_rows;
    }

    public function truncate($tabela) {
        return $this->db->query("TRUNCATE TABLE {$tabela}");
    }

}