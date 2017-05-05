<?php
class DBAtos
{
    /**
     * Vérifie si les tables du plugin sont installé
     * @access protected
     * return integer
     */
    protected function c_show_table()
    {
        $table = 'mc_plugins_atos';
        return magixglobal_model_db::layerDB()->showTable($table);
    }

    /**
     * @param $data
     * @return array
     */
    protected function fetchData($config,$data = false)
    {
        if(is_array($config)) {
            $sql = '';
            $params = false;
            if($config['context'] === 'all' || $config['context'] === 'return') {
                if($config['type'] === 'active'){
                    $sql = 'SELECT bd.*
                    FROM mc_plugins_atos_paymentmeanbrand AS bd
                    WHERE bd.status = :status';
                    $params = $data;
                }else{
                    $sql = 'SELECT bd.*
                FROM mc_plugins_atos_paymentmeanbrand AS bd';
                    $params = $data;
                }
                return $sql ? magixglobal_model_db::layerDB()->select($sql,$params) : null;
            }elseif($config['context'] === 'unique' || $config['context'] === 'last') {
                $sql = 'SELECT atos.*
                FROM mc_plugins_atos AS atos';
                $params = $data;
                return $sql ? magixglobal_model_db::layerDB()->selectOne($sql,$params): null;
            }
        }
    }
    /**
     * @param $data
     */
    protected function insert($data){
        if(is_array($data)){
            if($data['accountType']) {
                $sql = 'INSERT INTO mc_plugins_atos (merchandId,secureKey,accountType)
		        VALUE(:merchandId,:secureKey,:accountType)';
                magixglobal_model_db::layerDB()->insert($sql,
                    array(
                        ':merchandId' => $data['merchandId'],
                        ':secureKey' => $data['secureKey'],
                        ':accountType' => $data['accountType']
                    ));
            }
        }

    }

    /**
     * @param $data
     */
    protected function uData($data){
        if(is_array($data)){
            if($data['accountType']){
                $sql = 'UPDATE mc_plugins_atos
                SET merchandId=:merchandId,secureKey=:secureKey,accountType=:accountType
                WHERE idatos=:edit';
                magixglobal_model_db::layerDB()->update($sql,
                    array(
                        ':edit'	               =>  $data['edit'],
                        ':merchandId'          =>  $data['merchandId'],
                        ':secureKey'           =>  $data['secureKey'],
                        ':accountType'         =>  $data['accountType']
                    )
                );
            }elseif($data['brand']){
                $sql = 'UPDATE mc_plugins_atos_paymentmeanbrand
                SET status=:status
                WHERE brand=:brand';
                magixglobal_model_db::layerDB()->update($sql,
                    array(
                        ':brand'	        =>  $data['brand'],
                        ':status'           =>  $data['status']
                    )
                );
            }
        }
    }
}
?>