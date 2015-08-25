<?php
/**
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Migrations;

use Phinx\Db\Table as BaseTable;

class Table extends BaseTable
{

    /**
     * Primary key for this table.
     * Can either be a string or an array in case of composite
     * primary key.
     *
     * @var string|array
     */
    protected $primaryKey;

    /**
     * Add a primary key to a database table.
     *
     * @param string|array $columns Table Column(s)
     * @return Table
     */
    public function addPrimaryKey($columns)
    {
        $this->primaryKey = $columns;
        return $this;
    }

    /**
     * You can pass `autoIncrement` as an option and it will be converted
     * to the correct option for phinx to create the column with an
     * auto increment attribute
     *
     * {@inheritdoc}
     */
    public function addColumn($columnName, $type = null, $options = array())
    {
        if (isset($options['autoIncrement']) && $options['autoIncrement'] === true) {
            $options['identity'] = true;
            unset($options['autoIncrement']);
        }

        return parent::addColumn($columnName, $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        if ((!isset($this->options['id']) || $this->options['id'] === false) && !empty($this->primaryKey)) {
            $this->options['primary_key'] = $this->primaryKey;
        }
        parent::create();
    }
}