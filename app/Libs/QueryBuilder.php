<?php

namespace App\Libs;

class QueryBuilder
{
    /**
     * @var string
     */
    protected string $selectString = 'SELECT * FROM';

    /**
     * @var string
     */
    protected string $whereString = '';

    /**
     * @var string
     */
    protected string $limit = 'LIMIT 100';

    /**
     * Generate SELECT string
     * selectParams = ['id', 'name', 'age', 'city']
     *
     * @param array $selectParams
     * @return $this
     */
    public function select(array $selectParams): QueryBuilder
    {
        $this->selectString = 'SELECT `' . implode('`, `', $selectParams) . '` FROM';

        return $this;
    }

    /**
     * Generates a string where of parameters
     * whereParams = [['di' => 23], ['id', '>', 100]] and ['id' => 1] and ['ia', '>', 100]
     *
     * @param array $whereParams
     * @return QueryBuilder
     */
    public function where(array $whereParams): QueryBuilder
    {
        $this->whereString = '';
        $whereString = $this->setMultipleParams($whereParams);

        $this->whereString = '' === $this->whereString ? ' WHERE' . $whereString : ' AND' . $whereString;
        return $this;
    }

    /**
     *  Set whereIn query string
     *
     * @param string $fieldName
     * @param array $values
     * @return $this
     */
    public function whereIn(string $fieldName, array $values): QueryBuilder
    {
        $this->whereString = '';
        is_int($values[0]) && $this->whereString = ' WHERE `' . $fieldName . '` IN (' . implode(',', $values) . ')';
        !is_int($values[0]) && $this->whereString = ' WHERE `' . $fieldName . '` IN ("' . implode('","', $values) . '")';

        return $this;
    }

    /**
     * Set limit items query.
     *
     * @param int $limit
     * @return QueryBuilder
     */
    public function limit(int $limit): QueryBuilder
    {
        $this->limit = 'LIMIT ' . $limit;

        return $this;
    }

    /**
     *  Return full query string.
     *
     * @param string $dbName
     * @return string
     */
    protected function getFullQuery(string $dbName): string
    {
        return $this->selectString . ' ' . $dbName . $this->whereString . ' ' . $this->limit . ';';
    }

    /**
     * Recursive writes an array of parameters to the query string
     *
     * @param array $whereParams
     * @return string
     */
    private function setMultipleParams(array $whereParams): string
    {
        // todo получился запутанным и не красивым, подумать как сделать проще
        $whereString = null;

        if (count($whereParams) - count($whereParams, COUNT_RECURSIVE)) { // если многомерный массив
            foreach ($whereParams as $name => $param) {
                is_array($param) && $result = $this->setMultipleParams($param); // если $param массив, вызываем рекурсию
                !is_array($param) && $result = $this->prepareParams([$name => $param]); //если не массив, подготамливаем параметры
                $whereString .= $whereString ? ' AND ' . $result : ' ' . $result;
            }
        } else { //если не многомерный массив
            if (is_int(end($whereParams))) { //если ключ первого значения int, то записывается как field . $operator . $value
                $result = $this->prepareParams($whereParams);
                $whereString .= $whereString ? ' AND ' . $result : ' ' . $result;
            } else { // если не int, то записывается как $field=$value
                foreach ($whereParams as $name => $val) {
                    $result = $this->prepareParams([$name => $val]);
                    $whereString .= $whereString ? ' AND ' . $result : ' ' . $result;
                }
            }
        }

        return $whereString;
    }


    /**
     * Returns a query parameter string
     *
     * @param array $param
     * @return string
     */
    private function prepareParams(array $param): string
    {
        $cntArrayParam = count($param);
        $queryString = '';

        1 === $cntArrayParam && $queryString = $this->prepareTypeParam(key($param), $param[key($param)]);
        3 === $cntArrayParam && $queryString = $this->prepareTypeParam($param[0], $param[2], $param[1]);

        return $queryString;
    }

    /**
     * Set type parameter
     *
     * @param $value
     * @param string $key
     * @param string $operator
     * @return string
     */
    private function prepareTypeParam(string $key, $value,  string $operator = '='): string
    {
        $string = '';
        is_int($value) && $string = '`' . $key . '`' . $operator . $value;
        !is_int($value) && $string = '`' . $key . '`' . $operator . '"' . $value . '"';

        return $string;
    }
}