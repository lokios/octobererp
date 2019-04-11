<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class ReferenceNumber extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    

    const CNAME = 'reference_numbers';
    
    public function getEntityType()
    {
        return self::CNAME;
    }
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_reference_number';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    
    
    public function getReferenceTypeOptions($activeOnly = false) {
        $options = [
            'purchases' => 'Material Receipt',
            'quotes' => 'Purchase Order',
        ];

        return $options;
    }
    
    
    public function getReferenceType(){
        $list = $this->getReferenceTypeOptions();
        return isset($list[$this->reference_type]) ? $list[$this->reference_type] : $this->reference_type;
    }
    
    
    /*
     * Calling Method
     * $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('qu');
     * 
     * if ($this->site->getReference('qu') == $data['reference_no']) {
                $this->site->updateReference('qu');
            }
     */
    
    public function getReference_BIN($field) {
        $q = $this->db->get_where('order_ref', array('ref_id' => '1'), 1);
        if ($q->num_rows() > 0) {
            $ref = $q->row();
            switch ($field) {
                case 'so':
                    $prefix = $this->Settings->sales_prefix;
                    break;
                case 'pos':
                    $prefix = isset($this->Settings->sales_prefix) ? $this->Settings->sales_prefix . '/POS' : '';
                    break;
                case 'qu':
                    $prefix = $this->Settings->quote_prefix;
                    break;
                case 'po':
                    $prefix = $this->Settings->purchase_prefix;
                    break;
                case 'to':
                    $prefix = $this->Settings->transfer_prefix;
                    break;
                case 'do':
                    $prefix = $this->Settings->delivery_prefix;
                    break;
                case 'pay':
                    $prefix = $this->Settings->payment_prefix;
                    break;
                case 'ex':
                    $prefix = $this->Settings->expense_prefix;
                    break;
                case 'in':
                    $prefix = $this->Settings->income_prefix;
                    break;
                case 're':
                    $prefix = $this->Settings->return_prefix;
                    break;
                case 'rep':
                    $prefix = $this->Settings->returnp_prefix;
                    break;
                case 'mr':
                    $prefix = $this->Settings->requisition_prefix;
                    break;
                default:
                    $prefix = '';
            }

            $ref_no = (!empty($prefix)) ? $prefix . '/' : '';

            if ($this->Settings->reference_format == 1) {
                $ref_no .= date('Y') . "/" . sprintf("%04s", $ref->{$field});
            } elseif ($this->Settings->reference_format == 2) {
                $ref_no .= date('Y') . "/" . date('m') . "/" . sprintf("%04s", $ref->{$field});
            } elseif ($this->Settings->reference_format == 3) {
                $ref_no .= sprintf("%04s", $ref->{$field});
            } else {
                $ref_no .= $this->getRandomReference();
            }

            return $ref_no;
        }
        return FALSE;
    }
    
    
    public function getRandomReference_BIN($len = 12) {
        $result = '';
        for ($i = 0; $i < $len; $i++) {
            $result .= mt_rand(0, 9);
        }

        if ($this->getSaleByReference($result)) {
            $this->getRandomReference();
        }

        return $result;
    }
    
    public function updateReference_BIN($field) {
        $q = $this->db->get_where('order_ref', array('ref_id' => '1'), 1);
        if ($q->num_rows() > 0) {
            $ref = $q->row();
            $this->db->update('order_ref', array($field => $ref->{$field} + 1), array('ref_id' => '1'));
            return TRUE;
        }
        return FALSE;
    }
    
    public function resetOrderRef_BIN()
    {
        $settings = $this->getSettings();
        if ($settings->reference_format == 1 || $settings->reference_format == 2) {
            $month = date('Y-m') . '-01';
            $year = date('Y') . '-01-01';
            if ($ref = $this->getOrderRef()) {
                $reset_ref = array('date' => $month, 'so' => 1, 'qu' => 1, 'po' => 1, 'to' => 1, 'pos' => 1, 'do' => 1, 'pay' => 1, 're' => 1, 'rep' => 1, 'ex' => 1);
                if ($settings->reference_format == 1) {
                    if (strtotime($ref->date) < strtotime($year)) {
                        $this->db->update('order_ref', $reset_ref, array('ref_id' => 1));
                        return TRUE;
                    }
                } elseif ($settings->reference_format == 2) {
                    if (strtotime($ref->date) < strtotime($month)) {
                        $this->db->update('order_ref', $reset_ref, array('ref_id' => 1));
                        return TRUE;
                    }
                }
            }
        }
        return FALSE;
    }
}
