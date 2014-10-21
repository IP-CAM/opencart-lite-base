<?php  namespace Controller\Checkout;

use Engine\Controller;
use Engine\iController;

class Guest_address implements iController {
    use Controller;

	public function index() {

        $this->language->load('checkout/checkout');

        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['text_none'] = $this->language->get('text_none');

        $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $this->data['entry_firstname'] = $this->language->get('entry_firstname');
        $this->data['entry_lastname'] = $this->language->get('entry_lastname');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_telephone'] = $this->language->get('entry_telephone');
        $this->data['entry_address'] = $this->language->get('entry_address');
        $this->data['entry_postcode'] = $this->language->get('entry_postcode');
        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_country'] = $this->language->get('entry_country');
        $this->data['entry_zone'] = $this->language->get('entry_zone');

        $this->load->model('account/customer_group');

        $this->data['customer_groups'] = array();

        if (is_array($this->config->get('config_customer_group_display'))) {
            $customer_groups = $this->model_account_customer_group->getCustomerGroups();

            foreach ($customer_groups as $customer_group) {
                if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                    $this->data['customer_groups'][] = $customer_group;
                }
            }
        }

        if (isset($this->session->data['guest']['billing']['customer_group_id'])) {
            $this->data['customer_group_id'] = $this->session->data['guest']['billing']['customer_group_id'];
        } else {
            $this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
        }

        if (isset($this->session->data['guest']['billing']['firstname'])) {
            $this->data['firstname'] = $this->session->data['guest']['billing']['firstname'];
        } else {
            $this->data['firstname'] = '';
        }

        if (isset($this->session->data['guest']['billing']['lastname'])) {
            $this->data['lastname'] = $this->session->data['guest']['billing']['lastname'];
        } else {
            $this->data['lastname'] = '';
        }

        if (isset($this->session->data['guest']['billing']['email'])) {
            $this->data['email'] = $this->session->data['guest']['billing']['email'];
        } else {
            $this->data['email'] = '';
        }

        if (isset($this->session->data['guest']['billing']['address'])) {
            $this->data['address'] = $this->session->data['guest']['billing']['address'];
        } else {
            $this->data['address'] = '';
        }

        if (isset($this->session->data['guest']['billing']['city'])) {
            $this->data['city'] = $this->session->data['guest']['billing']['city'];
        } else {
            $this->data['city'] = '';
        }

        if (isset($this->session->data['guest']['billing']['telephone'])) {
            $this->data['telephone'] = $this->session->data['guest']['billing']['telephone'];
        } else {
            $this->data['telephone'] = '';
        }

        if (isset($this->session->data['guest']['billing']['postcode'])) {
            $this->data['postcode'] = $this->session->data['guest']['billing']['postcode'];
        } else {
            $this->data['postcode'] = '';
        }

        if (isset($this->session->data['guest']['billing']['shipping_country_id'])) {
            $this->data['country_id'] = $this->session->data['guest']['billing']['shipping_country_id'];
        } else {
            $this->data['country_id'] = $this->config->get('config_country_id');
        }

        if (isset($this->session->data['guest']['billing']['shipping_zone_id'])) {
            $this->data['zone_id'] = $this->session->data['guest']['billing']['shipping_zone_id'];
        } else {
            $this->data['zone_id'] = '';
        }

        $this->load->model('localisation/country');

        $this->data['countries'] = $this->model_localisation_country->getCountries();

        $this->data['shipping_required'] = $this->cart->hasShipping();

        $this->data['button_continue'] = $this->language->get('button_continue');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/guest_address.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/guest_address.tpl';
		} else {
			$this->template = 'default/template/checkout/guest_address.tpl';
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

    public function validate() {
        $this->language->load('checkout/checkout');

        $json = array();

        // Validate if customer is logged in.
        if ($this->customer->isLogged()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }

        // Check if guest checkout is avaliable.
        if (!$this->config->get('config_guest_checkout') || $this->config->get('config_customer_price') || $this->cart->hasDownload()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
        }

        if (!$json) {

            // Customer Group
            $this->load->model('account/customer_group');

            if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                $customer_group_id = $this->request->post['customer_group_id'];
            } else {
                $customer_group_id = $this->config->get('config_customer_group_id');
            }

            //$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

            if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
                $json['error']['firstname'] = $this->language->get('error_firstname');
            }

            if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
                $json['error']['lastname'] = $this->language->get('error_lastname');
            }

            if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
                $json['error']['email'] = $this->language->get('error_email');
            }

            if ((utf8_strlen($this->request->post['address']) < 3) || (utf8_strlen($this->request->post['address']) > 128)) {
                $json['error']['address'] = $this->language->get('error_address');
            }

            if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
                $json['error']['city'] = $this->language->get('error_city');
            }

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
                $json['error']['postcode'] = $this->language->get('error_postcode');
            }

            if ($this->request->post['country_id'] == '') {
                $json['error']['country'] = $this->language->get('error_country');
            }

            if ($this->request->post['zone_id'] == '') {
                $json['error']['zone'] = $this->language->get('error_zone');
            }
        }

        if (!$json) {
            $this->session->data['guest']['billing']['customer_group_id'] = $customer_group_id;
            $this->session->data['guest']['billing']['firstname'] = trim($this->request->post['firstname']);
            $this->session->data['guest']['billing']['lastname'] = trim($this->request->post['lastname']);
            $this->session->data['guest']['billing']['email'] = $this->request->post['email'];
            $this->session->data['guest']['billing']['address'] = $this->request->post['address'];
            $this->session->data['guest']['billing']['telephone'] = trim($this->request->post['telephone']);
            $this->session->data['guest']['billing']['postcode'] = $this->request->post['postcode'];
            $this->session->data['guest']['billing']['city'] = $this->request->post['city'];
            $this->session->data['guest']['billing']['country_id'] = $this->request->post['country_id'];
            $this->session->data['guest']['billing']['zone_id'] = $this->request->post['zone_id'];

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info) {
                $this->session->data['guest']['billing']['country'] = $country_info['name'];
                $this->session->data['guest']['billing']['iso_code_2'] = $country_info['iso_code_2'];
                $this->session->data['guest']['billing']['iso_code_3'] = $country_info['iso_code_3'];
                $this->session->data['guest']['billing']['address_format'] = $country_info['address_format'];
            } else {
                $this->session->data['guest']['billing']['country'] = '';
                $this->session->data['guest']['billing']['iso_code_2'] = '';
                $this->session->data['guest']['billing']['iso_code_3'] = '';
                $this->session->data['guest']['billing']['address_format'] = '';
            }

            $this->load->model('localisation/zone');

            $zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);

            if ($zone_info) {
                $this->session->data['guest']['billing']['zone'] = $zone_info['name'];
                $this->session->data['guest']['billing']['zone_code'] = $zone_info['code'];
            } else {
                $this->session->data['guest']['billing']['zone'] = '';
                $this->session->data['guest']['billing']['zone_code'] = '';
            }

            $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
            $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
            $this->session->data['shipping_postcode'] = $this->request->post['postcode'];

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
        }

        $this->response->setOutput(json_encode($json));
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
}
?>