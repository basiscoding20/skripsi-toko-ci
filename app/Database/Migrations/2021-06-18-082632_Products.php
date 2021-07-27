<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
	public function up()
	{
		// Membuat kolom/field untuk tabel products
		$this->forge->addField([
			'id'			=> [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'title'			=> [
				'type'           => 'VARCHAR',
				'constraint'     => '191',
				'null'        	 => true
			],
			'description'	=> [
				'type'           => 'TEXT',
				'null'           => true
			],
			'price'			=> [
				'type'           => 'DECIMAL',
				'constraint'     => '12,2',
				'null'           => false,
				'default' 		 => 0.00
			],
			'price_sale'			=> [
				'type'           => 'DECIMAL',
				'constraint'     => '12,2',
				'null'           => false,
				'default' 		 => 0.00
			],
			'quantity'			=> [
				'type'           => 'DECIMAL',
				'constraint'     => '7,0',
				'null'           => false,
				'default' 		 => 0
			],
			'status'      => [
				'type'           => 'ENUM',
				'constraint'     => ['published', 'draft'],
				'default'        => 'draft'
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
			'slug'			=> [
				'type'           => 'VARCHAR',
				'constraint'     => '191',
				'null'        	 => false,
				'unique'		 => true
			],
			'photo'			=> [
				'type'           => 'VARCHAR',
				'constraint'     => '191',
				'null'        	 => true
			],
			'seller_id'      => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => false
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
		$this->forge->addForeignKey('category_id', 'categories', 'id', 'cascade', 'cascade');
		$this->forge->addForeignKey('seller_id', 'users', 'id', 'cascade', 'cascade');

		// Membuat tabel products
		$this->forge->createTable('products', TRUE);
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		// menghapus tabel products
		$this->db->disableForeignKeyChecks();
		$this->forge->dropTable('products');
		$this->db->enableForeignKeyChecks();
	}
}
