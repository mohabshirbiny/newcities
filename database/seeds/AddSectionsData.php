<?php

use App\SectionData;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Foreach_;

class AddSectionsData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            [
                'ar' => '',
                'en' => 'Tenders',
            ],
            [
                'ar' => '',
                'en' => 'Offers',
            ],
            [
                'ar' => '',
                'en' => 'Jobs',
            ],
            [
                'ar' => '',
                'en' => 'News',
            ],
            [
                'ar' => '',
                'en' => 'Developers',
            ],
            [
                'ar' => '',
                'en' => 'Contractors',
            ],
            [
                'ar' => '',
                'en' => 'Vendors',
            ],
            [
                'ar' => '',
                'en' => 'Events',
            ],
            [
                'ar' => '',
                'en' => 'Services',
            ],
            [
                'ar' => '',
                'en' => 'Cities',
            ],
        ];

        foreach ($titles as $key => $value) {
            SectionData::create([
                'title'      => serialize($value),
                'icon'     => '',
                'gallery'  => '',
            ]);
        }
        
    }
}
