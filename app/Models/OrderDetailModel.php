<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailModel extends Model
{
	protected $table                = 'order_details';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes       = true;

	// Dates
	protected $useTimestamps        = true;

    protected $allowedFields = [ 'order_id', 'product_id', 'quantity', 'price', 'type', 'category_id', 'datetime'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'datetime'];
    protected $deletedField  = 'deleted_at';
}
