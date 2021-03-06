<?php  namespace Controller\Checkout;

use Engine\Controller;
use Engine\iController;

class Billing implements iController {
    use Controller;

	public function index() {

        $this->language->load('checkout/checkout');

        $this->data['text_your_details'] = $this->language->get('text_your_details');
        $this->data['text_your_address'] = $this->language->get('text_your_address');

        $this->data['entry_firstname'] = $this->language->get('entry_firstname');
        $this->data['entry_lastname'] = $this->language->get('entry_lastname');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_telephone'] = $this->language->get('entry_telephone');
        $this->data['entry_address'] = $this->language->get('entry_address');
        $this->data['entry_postcode'] = $this->language->get('entry_postcode');
        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_country'] = $this->language->get('entry_country');
        $this->data['entry_zone'] = $this->language->get('entry_zone');

        $this->load->model('account/address');

        $this->data['address_id'] = $this->customer->getAddressId();
        $this->data['address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
        $this->data['firstname'] = $this->customer->getFirstName();
        $this->data['lastname'] = $this->customer->getLastName();
        $this->data['email'] = $this->customer->getEmail();
        $this->data['telephone'] = $this->customer->getTelephone();

        $this->load->model('localisation/country');

        $this->data['countries'] = $this->model_localisation_country->getCountries();

        $this->data['button_continue'] = $this->language->get('button_continue');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/billing.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/billing.tpl';
		} else {
			$this->template = 'default/template/checkout/billing.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
				
		$this->response->setOutput($this->render());
  	}
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}

    public function validate() {
        $this->language->load('checkout/checkout');

        $json = array();

        // Validate if customer is logged in.
        if (!$this->customer->isLogged()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }

        // Validate if shipping is required. If not the customer should not have reached this page.
        if (!$this->cart->hasShipping()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }

        // Validate minimum quantity requirments.
        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $json['redirect'] = $this->url->link('checkout/cart');

                break;
            }
        }


        if (!$json) {

                $this->load->model('account/address');

                if (empty($this->request->post['address_id'])) {
                    $json['error']['warning'] = $this->language->get('error_address');
                }

                if (!$json) {
                    $this->session->data['address_id'] = $this->request->post['address_id'];

                    // Default Shipping Address
                    $this->load->model('account/address');

                    $address_info = $this->model_account_address->getAddress($this->request->post['address_id']);

                    if ($address_info) {
                        $this->session->data['country_id'] = $address_info['country_id'];
                        $this->session->data['zone_id'] = $address_info['zone_id'];
                        $this->session->data['postcode'] = $address_info['postcode'];
                    } else {
                        unset($this->session->data['country_id']);
                        unset($this->session->data['zone_id']);
                        unset($this->session->data['postcode']);
                    }

                    unset($this->session->data['shipping_method']);
                    unset($this->session->data['shipping_methods']);
                    unset($this->session->data['payment_method']);
                    unset($this->session->data['payment_methods']);
                }


        }

        $this->response->setOutput(json_encode($json));
    }

}
?>