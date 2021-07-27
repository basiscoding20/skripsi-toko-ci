<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
	protected $table                = 'products';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes       = true;

	// Dates
	protected $useTimestamps        = true;

    protected $allowedFields = [ 'title', 'description', 'price', 'price_sale', 'quantity', 'status', 'type', 'category_id', 'slug', 'photo', 'seller_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $deletedField  = 'deleted_at';
}
