<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            'configuration_name' => 'stripe_mode',
            'configuration_value' => 'Test',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('configurations')->insert([
            'configuration_name' => 'stripe_currency',
            'configuration_value' => 'USD',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('configurations')->insert([
            'configuration_name' => 'stripe_publishable_key',
            'configuration_value' => 'pk_test_KpEfqzfA4YdlqiGb4HPiOsTF',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('configurations')->insert([
            'configuration_name'  => 'stripe_secret_key',
            'configuration_value' => 'sk_test_htZuRrdkLDTjNGanHlkK8F1M',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('configurations')->insert([
            'configuration_name'  => 'statement_descriptor',
            'configuration_value' => 'Statement descp here',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('configurations')->insert([
            'configuration_name'  => 'description',
            'configuration_value' => 'test description stripe',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('configurations')->insert([
            'configuration_name' => 'website_name',
            'configuration_value' => 'The YP Direct',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('configurations')->insert([
            'configuration_name' => 'website_logo',
            'configuration_value' => 'logo.png',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
