<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJenisPengajuanToPenjualanAssets extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penjualan_assets', [
            'jenis_pengajuan' => [
                'type' => 'ENUM',
                'constraint' => ['penjualan', 'penghentian'],
                'default' => 'penjualan',
            ],
            'alasan_penghentian' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_pengajuan' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penjualan_assets', ['jenis_pengajuan', 'alasan_penghentian', 'tanggal_pengajuan']);
    }
}
