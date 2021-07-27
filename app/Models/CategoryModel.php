<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
	protected $table                = 'categories';
	protected $primaryKey           = 'id';
	protected $useSoftDeletes       = true;

	// Dates
	protected $useTimestamps        = true;

    protected $allowedFields = [ 'title', 'description', 'status', 'type', 'slug', 'photo'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $deletedField  = 'deleted_at';
}
