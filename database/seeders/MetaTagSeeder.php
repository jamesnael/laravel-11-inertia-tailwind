<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MetaTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\MetaTag::create([
            'page_name'       => "Homepage",
            'route_slug'      => '',
            'controller_name' => 'HomeController',
            'title'           => 'Lorem ipsum dolor sit amet.',
            'description'     => 'Promoting circularity for marine plastics in ASEAN+3 through knowledge collection, dissemination, research support, and capacity building.'
        ]);
    }
}
