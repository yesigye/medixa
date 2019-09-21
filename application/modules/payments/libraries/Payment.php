<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require __DIR__ . '/vendor/autoload.php';

use Omnipay\Omnipay;

class Payment
{
    protected $gateway;

	public function __construct()
	{
        /*
         Test buyer details
        
         First name:      test
         Last name:       buyer
         email address:   ignatiusyesigye-buyer@gmail.com
         password:        testbuyer123
         Phone number:    4088191359
         Card number:     4032038577747763 
         Card type:       VISA
         Expiration Date: 02/2021
 
        */

        $this->gateway = Omnipay::create('PayPal_Express');
        $this->gateway->setTestMode(true);
        $this->gateway->setLogoImageUrl('');
        $this->gateway->setBrandName('');
        $this->gateway->setUsername('ignatiusyesigye-facilitator_api1.gmail.com');
        $this->gateway->setPassword('3KE6TFZSHQHRQW3N');
        $this->gateway->setSignature('Ay2OfeDYL8uedFQvgkZeSwX8Y.FZAsa85Xc27QGYJIttyrxaTGc6985o');
    }
    
	/**
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * @param	$var
     * 
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
    }

    public function send()
    {
        // var_dump($this->gateway->getDefaultParameters());
        
        try {
            // Send purchase request
            $response = $this->gateway->authorize(
                [
                    'amount' => '3.00',
                                'taxAmount' => '1.00',
            'shippingAmount' => '1.00',
            'handlingAmount' => '1.00',
                    'currency' => 'USD',
                    'returnUrl' => 'http://medic.test/payments/test/okay',
                    'cancelUrl' => 'http://medic.test/payments/test/fail'
                ]
            )->send();

            // Process response
            if ($response->isSuccessful()) {
                
                // Payment was successful
                print_r($response);

            } elseif ($response->isRedirect()) {
                
                // Redirect to offsite payment gateway
                $response->redirect();

            } else {

                // Payment failed
                echo $response->getMessage();
            }
        } catch (Exception $e) {
            log_message('error', 'internal error processing payment TOKEN. '.$e->getMessage());
        }
    }

    public function done()
    {
        /*
         TODO:
         - Check with DB that this is not a double payment
         */
        try {
            // Send purchase request
            $response = $this->gateway->completeAuthorize(
                [
                    'amount' => '3.00',
                                'taxAmount' => '1.00',
            'shippingAmount' => '1.00',
            'handlingAmount' => '1.00',
                    'currency' => 'USD',
                ]
            )->send();

            if ($response->isSuccessful()) {
                // Return payment infomation
                $info = $this->gateway->fetchCheckout()->send();

                header_remove();
                header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
                header('Content-Type: application/json');
                echo json_encode($response->getData());

            } elseif ($response->isRedirect()) {
                // Redirect to offsite payment gateway
                $response->redirect();
            } else {
                // Payment failed
                echo $response->getMessage();
            }
        } catch (Exception $e) {
            log_message('error', 'internal error processing payment TOKEN. '.$e->getMessage());
        }
    }
}