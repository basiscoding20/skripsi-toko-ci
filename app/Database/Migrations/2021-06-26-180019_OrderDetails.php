<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderDetails extends Migration
{
	public function up()
	{
		// Membuat kolom/field untuk tabel order_details
		$this->forge->addField([
			'id'			=> [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'order_id'      => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => false
			],
			'product_id'      => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => false
			],
			'quantity'			=> [
				'type'           => 'DECIMAL',
				'constraint'     => '7,0',
				'null'           => false,
				'default' 		 => 0
			],
			'price'			=> [
				'type'           => 'DECIMAL',
				'constraint'     => '12,2',
				'null'           => false,
				'default' 		 => 0.00
			],
			'type'      => [
				'type'           => 'ENUM',
				'constraint'     => ['product', 'service'],
				'default'        => 'product'
			],
			'category_id'      => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => false
			],
			'datetime'			=> [
				'type'           => 'DATETIME',
				'null'        	 => true,
			],
			'created_at DATETIME default current_timestamp',
			'updated_at'			=> [
				'type'           => 'DATETIME',
				'null'        	 => true,
				'on update'      => 'current_timestamp',
			],
			'deleted_at'			=> [
				'type'           => 'DATETIME',
				'null'        	 => true
			],
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat foreign key
		$this->forge->addForeignKey('order_id', 'orders', 'id', 'cascade', 'cascade');
		$this->forge->addForeignKey('product_id', 'products', 'id', 'cascade', 'cascade');
		$this->forge->addForeignKey('category_id', 'categories', 'id', 'cascade', 'cascade');

		// Membuat tabel order_details
		$this->forge->createTable('order_details', TRUE);
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		// menghapus tabel order_details
		$this->db->disableForeignKeyChecks();
		$this->forge->dropTable('order_details');
		$this->db->enableForeignKeyChecks();
	}
}
