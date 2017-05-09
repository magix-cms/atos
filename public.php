<?php
require_once ('db/atos.php');
require_once ('autoload.php');

class plugins_atos_public extends DBAtos
{

    protected $template, $modelSystem, $about, $brand, $amount;


    /**
     * constructeur
     */
    public function __construct()
    {
        $this->template = new frontend_controller_plugins();
        $this->modelSystem = new magixglobal_model_system();
        $this->about = new plugins_about_public();
        $cleanForms = new magixcjquery_form_helpersforms();
        // Set various params:
        if(magixcjquery_filter_request::isPost('brand')){
            $this->brand = $cleanForms->inputClean($_POST['brand']);
        }
    }
    private function acquirerResponsecode(){
        return array(
            '00'=>'transaction_success',
            '02'=>'contact_card_issuer',
            '03'=>'invalid_acceptor',
            '12'=>'invalid_transaction',
            '14'=>'invalid_card_security_code',
            '17'=>'payment_aborted',
            '24'=>'perform_is_not_compatible',
            '25'=>'transaction_not_found',
            '30'=>'format_error',
            '33'=>'payment_mean_expired',
            '34'=>'fraud_suspicion',
            '51'=>'amount_too_high',
            '54'=>'card_is_past_expiry_date',
            '94'=>'duplicated_transaction'
        );
    }
    /**
     * @param $config
     * @return array
     */
    private function setItemData($config){
        $data = parent::fetchData(array('context'=>'unique'));
        $urlwebsite = magixcjquery_html_helpersHtml::getUrl() . '/' . $config['iso'] . '/';
        return array(
            'merchandId'          =>  $data['merchandId'],
            'secureKey'           =>  $data['secureKey'],
            'accountType'         =>  $data['accountType'],
            'returnUrl'           =>  $urlwebsite.$config['returnUrl'],
            'iso'                 =>  $config['iso'],
            'brand'               =>  $config['brand'],
            'amount'              =>  $config['amount'],
            'orderId'             =>  isset($config['orderId']) ? $config['orderId'] : NULL,
            'customerId'          =>  isset($config['customerId']) ? $config['customerId'] : NULL,
            'returnContext'       =>  isset($config['returnContext']) ? $config['returnContext'] : NULL,
            'customerEmail'       =>  isset($config['customerEmail']) ? $config['customerEmail'] : NULL
        );
    }

    /**
     * @param $config
     * @return array
     */
    private function setPaymentRequest($config){
        $data = $this->setItemData($config);
        if($data != null){
            $passphrase = new Passphrase($data['secureKey']);
            $shaComposer = new AllParametersShaComposer($passphrase);
            $paymentRequest = new PaymentRequest($shaComposer);
            switch ($data['accountType']){
                case 'TEST':
                    $paymentRequest->setSipsUri(PaymentRequest::TEST);
                    break;
                case 'SIMU':
                    $paymentRequest->setSipsUri(PaymentRequest::SIMU);
                    break;
                case 'PRODUCTION':
                    $paymentRequest->setSipsUri(PaymentRequest::PRODUCTION);
                    break;
            }
            $sipsTransactionReference = magixglobal_model_cryptrsa::random_generic_ui();
            $paymentRequest->setMerchantId($data['merchandId']);
            $paymentRequest->setNormalReturnUrl($data['returnUrl']);
            $paymentRequest->setKeyVersion('2');
            $paymentRequest->setTransactionReference($sipsTransactionReference);
            $paymentRequest->setAmount(intval($data['amount']));
            $paymentRequest->setCurrency('EUR');
            $paymentRequest->setLanguage($data['iso']);
            if(isset($data['orderId'])) {
                $paymentRequest->setOrderId($data['orderId']);
            }else{
                $paymentRequest->setOrderId('0');
            }

            if(isset($data['customerId'])) {
                $paymentRequest->setCustomerId($data['customerId']);
            }else{
                $paymentRequest->setCustomerId('0');
            }

            if(isset($data['returnContext'])) {
                $paymentRequest->setReturnContext($data['returnContext']);
            }else{
                $paymentRequest->setReturnContext('0');
            }

            if(isset($data['customerEmail'])) {
                $paymentRequest->setCustomerEmail($data['customerEmail']);
            }

            $paymentRequest->setPaymentBrand($data['brand']);
            $paymentRequest->validate();
            $newData = array('Data' => $paymentRequest->toParameterString(), 'InterfaceVersion' => 'HP_2.4', 'Seal' => $paymentRequest->getShaSign(),'accountType'=>$data['accountType'],'getSipsUri'=>$paymentRequest->getSipsUri());
            return $newData;
        }
    }

    /**
     * @param $config
     * @return array
     */
    public function getPaymentRequest($config){
        return $this->setPaymentRequest($config);
    }
    /**
     * @return array
     */
    private function setPaymentBrand(){
        $data = parent::fetchData(array('context'=>'all','type'=>'active'),array(':status' => 1));
        return $data;
    }

    /**
     * Get items payment mean brand
     */
    public function getPaymentBrand(){
        $data = $this->setPaymentBrand();
        $this->template->assign('getPaymentBrand', $data, true);
    }

    /**
     * @param $data
     * @return array
     */
    private function setPaymentResponse($data){
        $paymentResponse = new PaymentResponse($_REQUEST);
        $passphrase = new Passphrase($data['secureKey']);
        $shaComposer = new AllParametersShaComposer($passphrase);
        $acquirerResponsecode = $this->acquirerResponsecode();
        if($paymentResponse->isValid($shaComposer) && $paymentResponse->isSuccessful()) {
            return array(
                'response'              => 'true',
                'responseCode'          => $paymentResponse->getParam('responseCode'),
                'acquirerResponsecode'  => $acquirerResponsecode[$paymentResponse->getParam('responseCode')],
                'orderId'               => $paymentResponse->getParam('orderId'),
                'customerId'            => $paymentResponse->getParam('customerId'),
                'customerEmail'         => $paymentResponse->getParam('customerEmail'),
                'returnContext'         => $paymentResponse->getParam('returnContext'),
                'transactionReference'  => $paymentResponse->getParam('transactionReference'),
                'paymentMeanBrand'      => $paymentResponse->getParam('paymentMeanBrand'),
                'getAmount'             => number_format(($paymentResponse->getAmount() / 100), 2, '.', ''),
                'currencyCode'          => SipsCurrency::convertSipsCurrencyCodeToCurrency($paymentResponse->getParam('currencyCode'))
            );
        }else {
            // perform logic when the validation fails
            /*print number_format(($paymentResponse->getAmount() / 100), 2, '.', '');
            print '<pre>';
            print_r($paymentResponse).'<br />';
            print '</pre><br />';*/
            return array(
                'response'              => 'false',
                'responseCode'          => $paymentResponse->getParam('responseCode'),
                'acquirerResponsecode'  => $acquirerResponsecode[$paymentResponse->getParam('responseCode')],
                'orderId'               => $paymentResponse->getParam('orderId'),
                'customerId'            => NULL,
                'customerEmail'         => $paymentResponse->getParam('customerEmail'),
                'returnContext'         => $paymentResponse->getParam('returnContext'),
                'transactionReference'  => $paymentResponse->getParam('transactionReference'),
                'paymentMeanBrand'      => NULL,
                'getAmount'             => number_format(($paymentResponse->getAmount() / 100), 2, '.', ''),
                'currencyCode'          => SipsCurrency::convertSipsCurrencyCodeToCurrency($paymentResponse->getParam('currencyCode'))
            );
        }
    }

    /**
     * @param $data
     * @return array
     */
    public function getPaymentResponse($data){
        return $this->setPaymentResponse($data);
    }
    /**
     * test account with uniq page (test only)
     */
    private function testAccount($config){
        $setData = parent::fetchData(array('context'=>'unique'));
        if($setData['accountType'] === 'TEST'){
            if(isset($this->brand)){
                $data = $this->getPaymentRequest($config);
                $this->template->assign('getItemData', $data, true);
            }else{
                if(isset($_POST['Encode'])){
                    $data = $this->getPaymentResponse($setData);
                    $this->template->assign('getPaymentResponse', $data, true);
                }else{
                    $this->getPaymentBrand();
                }
            }
            $this->template->display('index.tpl');
        }
    }

    /**
     * @param $config
     * @return array
     */
    public function fetchData($config){
        return parent::fetchData($config);
    }

    /**
     *
     */
    public function run(){
        $this->testAccount(array(
            'returnUrl'           =>  'atos',
            'iso'                 =>  frontend_model_template::current_Language(),
            'brand'               =>  $this->brand,
            'amount'              =>  '1000',
            'orderId'             =>  'ds5f4f45sf456d4',
            'customerId'          =>  '4',
            'customerEmail'       =>  'test@mail.com',
            'returnContext'       =>  '10'
        ));
    }
}
?>