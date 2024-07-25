<?
trait Model
{
    use Database;

    // protected $table = 'users';

    protected $limit = 10;
    protected $offset = 0;
    protected $order_by_column = "id";
    protected $order_by = "desc";

    public function findAll()
    {
        $query = "select * from $this->table order by $this->order_by_column $this->order_by limit $this->limit offset $this->offset ";

        //передаем выполнение запроса в Database.php
        return $this->query($query);
    }

    public function where($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $this->table where ";
        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ' && ';
        }
        foreach ($keys_not as $key) {
            $query .= $key . ' != :' . $key . ' && ';
        }

        $query = trim($query, " && ");

        $query .= " order by $this->order_by_column $this->order_by limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);
        //передаем выполнение запроса в Database.php
        return $this->query($query, $data);
    }


    public function firest($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $this->table where ";
        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ' && ';
        }
        foreach ($keys_not as $key) {
            $query .= $key . ' != :' . $key . ' && ';
        }

        $query = trim($query, " && ");

        $query .= " $this->order_by limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);
        //передаем выполнение запроса в Database.php
        $result = $this->query($query, $data);
        if ($result)
            return $result[0];
        return false;
    }

    public function insert($data)
    {
        //если столбец не разрешен в моделе, то он будет удален из запроса
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumn)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);

        $query = "insert into $this->table (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ") ";
        $result = $this->query($query, $data);

        return false;
    }

    public function update($id, $data = [], $id_column = 'id')
    {

        //если столбец не разрешен в моделе, то он будет удален из запроса
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumn)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);
        $query = "update $this->table set ";

        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ' , ';
        }
        $query = trim($query, " , ");

        $query .= " where $id_column = :$id_column";
        $data[$id_column] = $id;
        //передаем выполнение запроса в Database.php
        $this->query($query, $data);
        // echo $query;
        return false;
    }

    public function delite($id, $id_column = 'id')
    {
        $data[$id_column] = $id;
        $query = "delete from $this->table where $id_column = :$id_column";

        // echo $query;
        $query = trim($query, " && ");
        //передаем выполнение запроса в Database.php
        $this->query($query, $data);


        return false;
    }
}
