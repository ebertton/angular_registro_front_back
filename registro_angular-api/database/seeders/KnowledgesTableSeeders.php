<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnowledgesTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('knowledges')->insert([
            [
                'name' => 'Git',
            ],
            [
                'name' => 'React',
            ],
            [
                'name' => 'PHP',
            ],
            [
                'name' => 'NodeJS',
            ],
            [
                'name' => 'DevOps',
            ],
            [
                'name' => 'Banco de Dados',
            ],
            [
                'name' => 'TypeScript',
            ]
        ]);
    }
}
