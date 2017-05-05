<?php
require_once ('db/atos.php');
class plugins_atos_admin extends DBAtos
{
    protected $header, $template, $message;
    public static $notify = array('plugin' => 'true');
    public $getlang, $plugin, $edit, $id, $getpage, $merchandId, $secureKey, $accountType, $brands, $status;
    /**
     * constructeur
     */
    public function __construct()
    {
        if (class_exists('backend_model_message')) {
            $this->message = new backend_model_message();
        }
        // Global
        if (magixcjquery_filter_request::isGet('edit')) {
            $this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
        }
        if (magixcjquery_filter_request::isGet('action')) {
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if (magixcjquery_filter_request::isGet('tab')) {
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        // Dédié
        if (magixcjquery_filter_request::isGet('plugin')) {
            $this->plugin = magixcjquery_form_helpersforms::inputClean($_GET['plugin']);
        }
        if (magixcjquery_filter_request::isGet('id')) {
            $this->id = (integer)magixcjquery_filter_isVar::isPostNumeric($_GET['id']);
        }
        // POST
        if (magixcjquery_filter_request::isPost('merchandId')) {
            $this->merchandId = magixcjquery_form_helpersforms::inputClean($_POST['merchandId']);
        }
        if (magixcjquery_filter_request::isPost('secureKey')) {
            $this->secureKey = magixcjquery_form_helpersforms::inputClean($_POST['secureKey']);
        }
        if (magixcjquery_filter_request::isPost('accountType')) {
            $this->accountType = magixcjquery_form_helpersforms::inputClean($_POST['accountType']);
        }

        if(magixcjquery_filter_request::isPost('brands')){
            $this->brands = magixcjquery_form_helpersforms::arrayClean($_POST['brands']);
        }

        $this->header = new magixglobal_model_header();
        $this->template = new backend_controller_plugins();
    }
    /**
     * @access private
     * Installation des tables mysql du plugin
     */
    private function install_table($create)
    {
        if (parent::c_show_table() == 0) {
            $create->db_install_table('db.sql', 'request/install.tpl');
        } else {
            //$magixfire = new magixcjquery_debug_magixfire();
            //$magixfire->magixFireInfo('Les tables mysql sont installés', 'Statut des tables mysql du plugin');
            return true;
        }
    }
    /**
     * @return array
     */
    private function setItemData(){
        $data = parent::fetchData(array('context'=>'unique'));
        return array(
            'merchandId'          =>  $data['merchandId'],
            'secureKey'           =>  $data['secureKey'],
            'accountType'         =>  $data['accountType']
        );
    }

    /**
     * Assign table data
     */
    private function getItemData(){
        $data = $this->setItemData();
        $this->template->assign('getItemData', $data, true);
    }

    /**
     * @return array
     */
    private function setItems(){
        $data = parent::fetchData(array('context'=>'all'));
        return $data;
    }

    /**
     *
     */
    private function getItems(){
        $data = $this->setItems();
        $this->template->assign('getItems', $data, true);
    }

    /**
     * @param $data
     */
    private function add($data){
        parent::insert($data);
    }

    /**
     * @param $data
     */
    private function update($data){
        parent::uData($data);
    }

    /**
     * @param $data
     */
    private function save($data,$config){
        if($data['edit'] != null){
            $this->update($data);
            if($config['msg']){
                $this->message->getNotify('update',self::$notify);
            }
        }elseif($data['brands']){
            foreach($this->setItems() as $item){
                if(isset($data['brands'])){
                    if(isset($data['brands'][$item['brand']])){
                        $this->update(
                            array(
                                'brand'     =>  $item['brand'],
                                'status'    =>  1
                            )
                        );
                    }else{
                        $this->update(
                            array(
                                'brand'     =>  $item['brand'],
                                'status'    =>  0
                            )
                        );
                    }
                }
            }
            $this->message->getNotify('update',self::$notify);
        }else{
            $this->add($data);
            if($config['msg']) {
                $this->message->getNotify('add', self::$notify);
            }
        }
    }

    public function run()
    {
        if (self::install_table($this->template) == true) {
            if(isset($this->brands)){
                $this->save(
                    array(
                        'brands'                =>  $this->brands
                    ),
                    array(
                        'msg'   =>  true
                    )
                );
            }elseif(isset($this->merchandId) && isset($this->secureKey)){
                $control = parent::fetchData(array('context'=>'unique'));
                $this->save(
                    array(
                        'edit'            =>  $control['idatos'],
                        'merchandId'      =>  $this->merchandId,
                        'secureKey'       =>  $this->secureKey,
                        'accountType'     =>  $this->accountType
                    ),
                    array(
                        'msg'   =>  true
                    )
                );
            }else{
                $this->getItemData();
                $this->getItems();
                $this->template->display('list.tpl');
            }
        }
    }
    public function setConfig(){
        return array(
            'url'=> array(
                'lang'  => 'none',
                'action'=>''
            ),
            'icon'=> array(
                'type'=>'font',
                'name'=>'fa fa-credit-card-alt'
            )
        );
    }
}