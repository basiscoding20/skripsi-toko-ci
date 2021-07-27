<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categories extends Migration
{
	public function up()
	{
		// Membuat kolom/field untuk tabel categories
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
			'status'      => [
				'type'           => 'ENUM',
				'constraint'     => ['active', 'inactive'],
				'default'        => 'active'
			],
			'type'      => [
				'type'           => 'ENUM',
				'constraint'     => ['product', 'service'],
				'default'        => 'product'
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

		// Membuat tabel categories
		$this->forge->createTable('categories', TRUE);
	}

	public function down()
	{
		// menghapus tabel categories
		$this->forge->dropTable('categories');
	}
}
