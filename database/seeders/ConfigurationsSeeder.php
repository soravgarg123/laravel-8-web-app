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
            'configuration_value' => 'Test'
        ]);

        DB::table('configurations')->insert([
            'configuration_name' => 'stripe_currency',
            'configuration_value' => 'USD'
        ]);

        DB::table('configurations')->insert([
            'configuration_name' => 'stripe_publishable_key',
            'configuration_value' => 'pk_test_KpEfqzfA4YdlqiGb4HPiOsTF'
        ]);

        DB::table('configurations')->insert([
            'configuration_name'  => 'stripe_secret_key',
            'configuration_value' => 'sk_test_htZuRrdkLDTjNGanHlkK8F1M'
        ]);

        DB::table('configurations')->insert([
            'configuration_name'  => 'statement_descriptor',
            'configuration_value' => 'Statement descp here'
        ]);

        DB::table('configurations')->insert([
            'configuration_name'  => 'description',
            'configuration_value' => 'test description stripe'
        ]);

        DB::table('configurations')->insert([
            'configuration_name' => 'website_name',
            'configuration_value' => 'The YP Direct'
        ]);

        DB::table('configurations')->insert([
            'configuration_name' => 'website_logo',
            'configuration_value' => 'logo.png'
        ]);
    }
}
