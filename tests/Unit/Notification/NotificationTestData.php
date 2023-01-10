<?php

namespace Tests\Unit\Notification;

class NotificationTestData
{
    /**
     * Return data for testing
     *
     * @return array
     */
    public static function returnTestData()
    {
        return [
            0 =>
                [
                    'vin' => 'TMBLJ7NE0J0368235',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 16368.3894921235,
                            'price_in_euro' => 16368.3894921235,
                        ],
                    'hashed_attributes' => '4d34def5348add4d5a479ea640b82405',
                ],
            1 =>
                [
                    'vin' => 'W0VBE8EC8J8048883',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 11495.450866910269,
                            'price_in_euro' => 11495.450866910269,
                        ],
                    'hashed_attributes' => '06480b37e8cb17255352fd73cf4982de',
                ],
            2 =>
                [
                    'vin' => 'TMBJJ9NP5K7039138',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21404.817028161502,
                            'price_in_euro' => 21404.817028161502,
                        ],
                    'hashed_attributes' => 'a4ff05e715e414ed73458279ba3e977e',
                ],
            3 =>
                [
                    'vin' => 'TMBJG9NE5K0082240',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 15109.282608114001,
                            'price_in_euro' => 15109.282608114001,
                        ],
                    'hashed_attributes' => 'c3b43fee16a3b28d41aef60c62dbf8b2',
                ],
            4 =>
                [
                    'vin' => 'W0VZT8EH2J1123263',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21151.629595114893,
                            'price_in_euro' => 21151.629595114893,
                        ],
                    'hashed_attributes' => '90ce328370d59cac092263c2c8e94b30',
                ],
            5 =>
                [
                    'vin' => 'W0VBE8EF4K8003001',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 10882.360154008387,
                            'price_in_euro' => 10882.360154008387,
                        ],
                    'hashed_attributes' => 'b92a3b90f59d10ecda601ebb711ee8db',
                ],
            6 =>
                [
                    'vin' => 'W0VZT8GC0J1162337',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21917.992986242243,
                            'price_in_euro' => 21917.992986242243,
                        ],
                    'hashed_attributes' => '16648109b9a7c14c79e0f663f343f5dd',
                ],
            7 =>
                [
                    'vin' => 'W0VZT6EKXK1026202',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 18392.72138705643,
                            'price_in_euro' => 18392.72138705643,
                        ],
                    'hashed_attributes' => '678be761abc96f67c68404b51680d8e2',
                ],
            8 =>
                [
                    'vin' => 'VR1J45GGUKY183991',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 30850,
                            'price_in_euro' => 30850,
                        ],
                    'hashed_attributes' => 'b57af2ac2ba43d29cf73ff86d95a3623',
                ],
            9 =>
                [
                    'vin' => 'VR3F35GGRKY041569',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 26843,
                            'price_in_euro' => 26843,
                        ],
                    'hashed_attributes' => '7e6055d1b80a24b867730f8a39b04794',
                ],
        ];
    }

    /**
     * Return data with custom country and company
     *
     * @param string $country
     * @param string $company
     * @return array
     */
    public static function returnTestDataCustomCompanyCountry(string $country, string $company)
    {
        $testData = self::returnTestData();

        foreach ($testData as $key => &$data) {
            $data['country'] = $country;
            $data['company'] = $company;
        }

        return $testData;
    }

    /**
     * Return data for testing - with duplicates
     *
     * @return array
     */
    public static function returnTestDataWithDuplicates()
    {
        return [
            0 =>
                [
                    'vin' => 'TMBLJ7NE0J0368235',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 16368.3894921235,
                            'price_in_euro' => 16368.3894921235,
                        ],
                    'hashed_attributes' => '4d34def5348add4d5a479ea640b82405',
                ],
            1 =>
                [
                    'vin' => 'W0VBE8EC8J8048883',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 11495.450866910269,
                            'price_in_euro' => 11495.450866910269,
                        ],
                    'hashed_attributes' => '06480b37e8cb17255352fd73cf4982de',
                ],
            2 =>
                [
                    'vin' => 'TMBJJ9NP5K7039138',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21404.817028161502,
                            'price_in_euro' => 21404.817028161502,
                        ],
                    'hashed_attributes' => 'a4ff05e715e414ed73458279ba3e977e',
                ],
            3 =>
                [
                    'vin' => 'TMBJG9NE5K0082240',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 15109.282608114001,
                            'price_in_euro' => 15109.282608114001,
                        ],
                    'hashed_attributes' => 'c3b43fee16a3b28d41aef60c62dbf8b2',
                ],
            4 =>
                [
                    'vin' => 'W0VZT8EH2J1123263',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21151.629595114893,
                            'price_in_euro' => 21151.629595114893,
                        ],
                    'hashed_attributes' => '90ce328370d59cac092263c2c8e94b30',
                ],
            5 =>
                [
                    'vin' => 'W0VBE8EF4K8003001',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 10882.360154008387,
                            'price_in_euro' => 10882.360154008387,
                        ],
                    'hashed_attributes' => 'b92a3b90f59d10ecda601ebb711ee8db',
                ],
            6 =>
                [
                    'vin' => 'W0VZT8GC0J1162337',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21917.992986242243,
                            'price_in_euro' => 21917.992986242243,
                        ],
                    'hashed_attributes' => '16648109b9a7c14c79e0f663f343f5dd',
                ],
            7 =>
                [
                    'vin' => 'W0VZT6EKXK1026202',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 18392.72138705643,
                            'price_in_euro' => 18392.72138705643,
                        ],
                    'hashed_attributes' => '678be761abc96f67c68404b51680d8e2',
                ],
            8 =>
                [
                    'vin' => 'VR1J45GGUKY183991',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 30850,
                            'price_in_euro' => 30850,
                        ],
                    'hashed_attributes' => 'b57af2ac2ba43d29cf73ff86d95a3623',
                ],
            9 =>
                [
                    'vin' => 'VR1J45GGUKY183991',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 26843,
                            'price_in_euro' => 26843,
                        ],
                    'hashed_attributes' => '7e6055d1b80a24b867730f8a39b04794',
                ]
        ];
    }

    /**
     * Return data for testing - with updates price values (3) for existing VIN's
     *
     * @return array
     */
    public static function returnTestDataWithUpdatesForStockUsedCars()
    {

        //Prices of 3 VIN's are changed compared to original data

        $dataArray = [
            0 =>
                [
                    'vin' => 'TMBLJ7NE0J0368235',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 18368.3894921235,
                            'price_in_euro' => 18368.3894921235,
                        ]
                ],
            1 =>
                [
                    'vin' => 'W0VBE8EC8J8048883',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 16495.450866910269,
                            'price_in_euro' => 16495.450866910269,
                        ],
                ],
            2 =>
                [
                    'vin' => 'TMBJJ9NP5K7039138',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 31404.817028161502,
                            'price_in_euro' => 31404.817028161502,
                        ],
                ],
            3 =>
                [
                    'vin' => 'TMBJG9NE5K0082240',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 15109.282608114001,
                            'price_in_euro' => 15109.282608114001,
                        ]
                ],
            4 =>
                [
                    'vin' => 'W0VZT8EH2J1123263',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21151.629595114893,
                            'price_in_euro' => 21151.629595114893,
                        ]
                ],
            5 =>
                [
                    'vin' => 'W0VBE8EF4K8003001',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 10882.360154008387,
                            'price_in_euro' => 10882.360154008387,
                        ]
                ],
            6 =>
                [
                    'vin' => 'W0VZT8GC0J1162337',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21917.992986242243,
                            'price_in_euro' => 21917.992986242243,
                        ]
                ],
            7 =>
                [
                    'vin' => 'W0VZT6EKXK1026202',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 18392.72138705643,
                            'price_in_euro' => 18392.72138705643,
                        ]
                ],
            8 =>
                [
                    'vin' => 'VR1J45GGUKY183991',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 30850,
                            'price_in_euro' => 30850,
                        ]
                ],
            9 =>
                [
                    'vin' => 'VR3F35GGRKY041569',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 26843,
                            'price_in_euro' => 26843,
                        ]
                ],
        ];

        foreach ($dataArray as &$data) {
            $hashedAttributes = md5(json_encode($data['attributes']));

            $data['hashed_attributes'] = $hashedAttributes;
        }

        return $dataArray;
    }

    /**
     * Return data for deleted testing
     *
     * @param string $country
     * @param string $company
     * @return array
     */
    public static function returnTestDataWithDeletedVinCodes()
    {
        return [
            0 =>
                [
                    'vin' => 'TMBLJ7NE0J0368235',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 16368.3894921235,
                            'price_in_euro' => 16368.3894921235,
                        ],
                    'hashed_attributes' => '4d34def5348add4d5a479ea640b82405',
                ],
            1 =>
                [
                    'vin' => 'W0VBE8EC8J8048883',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 11495.450866910269,
                            'price_in_euro' => 11495.450866910269,
                        ],
                    'hashed_attributes' => '06480b37e8cb17255352fd73cf4982de',
                ],
            2 =>
                [
                    'vin' => 'TMBJJ9NP5K7039138',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21404.817028161502,
                            'price_in_euro' => 21404.817028161502,
                        ],
                    'hashed_attributes' => 'a4ff05e715e414ed73458279ba3e977e',
                ],
            3 =>
                [
                    'vin' => 'TMBJG9NE5K0082240',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 15109.282608114001,
                            'price_in_euro' => 15109.282608114001,
                        ],
                    'hashed_attributes' => 'c3b43fee16a3b28d41aef60c62dbf8b2',
                ],
            4 =>
                [
                    'vin' => 'W0VZT8EH2J1123263',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21151.629595114893,
                            'price_in_euro' => 21151.629595114893,
                        ],
                    'hashed_attributes' => '90ce328370d59cac092263c2c8e94b30',
                ],
            5 =>
                [
                    'vin' => 'W0VBE8EF4K8003001',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 10882.360154008387,
                            'price_in_euro' => 10882.360154008387,
                        ],
                    'hashed_attributes' => 'b92a3b90f59d10ecda601ebb711ee8db',
                ],
            6 =>
                [
                    'vin' => 'W0VZT8GC0J1162337',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 21917.992986242243,
                            'price_in_euro' => 21917.992986242243,
                        ],
                    'hashed_attributes' => '16648109b9a7c14c79e0f663f343f5dd',
                ],
            7 =>
                [
                    'vin' => 'W0VZT6EKXK1026202',
                    'country' => 'SI',
                    'company' => 'Avto Triglav d.o.o.',
                    'attributes' =>
                        [
                            'b2b_price_ex_vat' => 18392.72138705643,
                            'price_in_euro' => 18392.72138705643,
                        ],
                    'hashed_attributes' => '678be761abc96f67c68404b51680d8e2',
                ]
        ];
    }

}
