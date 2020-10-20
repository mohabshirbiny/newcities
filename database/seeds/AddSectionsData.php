<?php

use App\SectionData;
use Illuminate\Database\Seeder;

class AddSectionsData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            'Tender' =>[
                    'title'=>[
                        'ar' => '',
                        'en' => 'Tenders'
                        ]
                ],
            'Offer' => ['title'=>[
                    'ar' => '',
                    'en' => 'Offers']
                ],
            'Job' => ['title'=>[
                    'ar' => '',
                    'en' => 'Jobs']
                ],
            'New' => ['title'=>[
                    'ar' => '',
                    'en' => 'News']
                ],
            'Developer' => ['title'=>[
                    'ar' => '',
                    'en' => 'Developers']
                ],
            'Contractor' => ['title'=>[
                    'ar' => '',
                    'en' => 'Contractors']
                ],
            'Vendor' => ['title'=>[
                    'ar' => '',
                    'en' => 'Vendors']
                ],
            'Event' => ['title'=>[
                    'ar' => '',
                    'en' => 'Events']
                ],
            'Service' => ['title'=>[
                    'ar' => '',
                    'en' => 'Services']
                ],
            'City' => ['title'=>[
                    'ar' => '',
                    'en' => 'Cities']
                ],
            'Help' => ['title'=>[
                    'ar' => '',
                    'en' => 'Help']
                ],
            'About_us' => ['title'=>[
                    'ar' => '',
                    'en' => 'About us']
                ],
        ];

        foreach ($models as $key => $value) {
            if (!SectionData::where('model',$key)->first()) {

                SectionData::updateOrCreate([
                        'title'      => serialize($value['title']),
                        'icon'     => '',
                        'gallery'  => '',
                        'model'  => $key,
                    ]);
            }
        }
        
    }
}
