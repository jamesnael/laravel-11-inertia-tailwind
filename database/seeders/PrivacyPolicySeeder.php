<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PrivacyPolicy::create([
            'title'   => 'Testing',
            'content' => "<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iste minima voluptate laborum vitae, sunt, temporibus facilis sit quo similique blanditiis veniam consectetur sint a harum quis praesentium aut laudantium esse rem nobis nulla? Sunt veniam alias in natus aliquam temporibus porro ipsam quod cumque doloribus, magnam dolore aperiam vel excepturi similique commodi quam ea voluptates recusandae rem odit molestiae perspiciatis. Blanditiis recusandae sunt quo nulla id nihil deserunt a, ipsam ratione delectus dolorum amet, expedita quaerat iure voluptas cum dicta illum nam eum vel corrupti! Repudiandae voluptas ipsam maxime dolorem a totam necessitatibus magnam mollitia deleniti dicta. Numquam, praesentium quia aliquid ipsum doloremque voluptatibus commodi dolorum doloribus? Similique hic, sit modi quaerat eaque doloribus libero doloremque impedit nostrum ullam consequatur eius magnam nemo quasi aliquam at. Commodi cupiditate, quibusdam recusandae, quae aperiam non repellendus excepturi error itaque iusto officia. Eos, mollitia exercitationem ea facere tempore eum repellendus velit sunt facilis alias deleniti temporibus ab cum aperiam, accusantium distinctio. Excepturi aspernatur iure magnam libero reprehenderit, facilis, ducimus accusantium sequi fuga earum nulla nobis! Sit magni dolore distinctio nesciunt laboriosam, velit porro alias esse sunt excepturi fugiat obcaecati dolor ipsam nobis illum nihil voluptas cupiditate accusantium officia qui sapiente culpa, nemo necessitatibus?.</p>",
        ]);
    }
}
