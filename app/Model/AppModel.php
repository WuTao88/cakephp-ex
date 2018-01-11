<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    public function createMany($data){
        $ca_sql="INSERT INTO ".$this->useTable;
        $ca_sql_arr=array();
        $keys=array();
        foreach($data as $k=>$v){
            if(empty($keys)){
                $a_keys = array_keys($v);
                foreach($a_keys as $kv){
                    $keys[]="`".$kv."`";
                }
            }
            $ca_sql_arr[]="(".implode(",", $v).")";
        }
        if(!empty($ca_sql_arr)){
            $sql=$ca_sql." (".implode(",", $keys).")  VALUES".implode(",", $ca_sql_arr);
            $this->query($sql);
        }
    }

    public function query($sql) {
        $sindex = stripos($sql,"select");
        if($sindex ===0){
            $this->beforeFind(null);
        }
        $params = func_get_args();
        $db = $this->getDataSource();
        $results= call_user_func_array(array(&$db, 'query'), $params);
        return $this->afterFind($results);
    }

    public function beforeFind($queryData) {
        $this->useDbConfig="readonly";
        return true;
    }

    public function afterFind($results, $primary = false) {
        $this->useDbConfig="default";
        return $results;
    }

    public function beforeSave($options = array()) {
        $this->useDbConfig="default";
        return true;
    }

    public function beforeDelete($cascade = true) {
        $this->useDbConfig="default";
        return true;
    }
}
