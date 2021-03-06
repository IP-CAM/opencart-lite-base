<?php   namespace Model\Total;

use Engine\Model;

class Reward {
    use Model;
	public function getTotal(&$total_data, &$total) {
		if (isset($this->session->data['reward'])) {
			$this->load->language('total/reward');
			
			$points = $this->customer->getRewardPoints();
			
			if ($this->session->data['reward'] <= $points) {
				$discount_total = 0;
				
				$points_total = 0;
				
				foreach ($this->cart->getProducts() as $product) {
					if ($product['points']) {
						$points_total += $product['points'];
					}
				}	
				
				$points = min($points, $points_total);
		
				foreach ($this->cart->getProducts() as $product) {
					$discount = 0;
					
					if ($product['points']) {
						$discount = $product['total'] * ($this->session->data['reward'] / $points_total);

					}
					
					$discount_total += $discount;
				}
			
				$total_data[] = array(
					'code'       => 'reward',
        			'title'      => sprintf($this->language->get('text_reward'), $this->session->data['reward']),
	    			'text'       => $this->currency->format(-$discount_total),
        			'value'      => -$discount_total,
					'sort_order' => $this->config->get('reward_sort_order')
      			);

				$total -= $discount_total;
			} 
		}
	}
	
	public function confirm($order_info, $order_total) {
		$this->load->language('total/reward');
		
		$points = 0;
		
		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');
		
		if ($start && $end) {  
			$points = substr($order_total['title'], $start, $end - $start);
		}	
		
		if ($points) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$order_info['customer_id'] . "', description = " . $this->db->quote(sprintf($this->language->get('text_order_id'), (int)$order_info['order_id'])) . ", points = '" . (float)-$points . "', date_added = NOW()");
		}
	}		
}
?>