<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
	protected $table                = 'orders';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes       = true;

	// Dates
	protected $useTimestamps        = true;

    protected $allowedFields = [ 'code', 'user_id', 'status', 'total', 'photo', 'kurir_teknisi'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $deletedField  = 'deleted_at';
}
