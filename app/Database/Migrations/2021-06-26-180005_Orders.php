<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Orders extends Migration
{
	public function up()
	{
		// Membuat kolom/field untuk tabel orders
		$this->forge->addField([
			'id'			=> [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'code'			=> [
				'type'           => 'VARCHAR',
				'constraint'     => '191',
				'null'        	 => false
			],
			'user_id'      => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => false
			],
			'total'			=> [
				'type'           => 'DECIMAL',
				'constraint'     => '12,2',
				'null'           => false,
				'default' 		 => 0.00
			],
			'status'      => [
				'type'           => 'ENUM',
				'constraint'     => ['order', 'paid', 'on progress', 'receive', 'completed', 'rejected'],
				'default'        => 'order'
			],
			'kurir_teknisi'      => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => true
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

		// Membuat foreign key
		$this->forge->addForeignKey('user_id', 'users', 'id', 'cascade', 'cascade');

		// Membuat tabel orders
		$this->forge->createTable('orders', TRUE);
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		// menghapus tabel orders
		$this->db->disableForeignKeyChecks();
		$this->forge->dropTable('orders');
		$this->db->enableForeignKeyChecks();
	}
}
