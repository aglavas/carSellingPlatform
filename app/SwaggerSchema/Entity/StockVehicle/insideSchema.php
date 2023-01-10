<?php

/**
 * @OA\Schema(
 *     schema="InsideVehicleStoreRequestSchema",
 *     description="Vehicle store request Schema for vehicles coming from Inside. Request schema is simplified and uses only one language (German). Additional fields (the ones that aren't in standard Inside feed) are: Availability,B2bPriceExVat,BodyColorCode,BodyColorText,ConsumptionTotal,ConsumptionTotal,CountryOrigin,CurrencyIso,AdditionalProperties,URLmarketplace,VatDeductible.",
 *     @OA\Property(
 *         property="de",
 *         type="object",
 *         @OA\Property(
 *             property="AccountId",
 *             type="integer",
 *             description="Id of the company owning vehicle from Inside",
 *             example="702"
 *         ),
 *         @OA\Property(
 *             property="Availability",
 *             type="string",
 *             description="Availability date of the vehicle",
 *             example="03/07/2022"
 *         ),
 *         @OA\Property(
 *             property="B2bPriceExVat",
 *             type="numeric",
 *             description="B2B price",
 *             example="43434.23"
 *         ),
 *         @OA\Property(
 *             property="BodyColorCode",
 *             type="string",
 *             description="Color code of vehicle",
 *             example="9197"
 *         ),
 *         @OA\Property(
 *             property="BodyColorText",
 *             type="string",
 *             description="Color description of vehicle",
 *             example="obsidian black metallic"
 *         ),
 *         @OA\Property(
 *             property="BodyTypeText",
 *             type="string",
 *             description="Body type of the vehicle",
 *             example="Kombi"
 *         ),
 *         @OA\Property(
 *             property="CarNumber",
 *             type="string",
 *             description="SKU number of vehicle",
 *             example="51007186/02"
 *         ),
 *         @OA\Property(
 *             property="Ccm",
 *             type="integer",
 *             description="Engine ccm info",
 *             example="1331"
 *         ),
 *         @OA\Property(
 *             property="CertificationCode",
 *             type="string",
 *             description="Certification code",
 *             example="1KA607"
 *         ),
 *         @OA\Property(
 *             property="ChassisCode",
 *             type="string",
 *             description="Chassis code of the vehicle (VIN)",
 *             example="U5YH5F1AGLL003829"
 *         ),
 *         @OA\Property(
 *             property="Co2Emission",
 *             type="integer",
 *             description="Co2 emission value of vehicle",
 *             example="32"
 *         ),
 *         @OA\Property(
 *             property="Comments",
 *             type="string",
 *             description="Comments about the vehicle",
 *             example="Herzlich willkommen bei der Emil Frey AG - Ihrem Autohaus in Zürich. Ihr Interesse an unserem Fahrzeug freut uns sehr..."
 *         ),
 *         @OA\Property(
 *             property="ConditionTypeText",
 *             type="string",
 *             description="Condition of the vehicle. Determines if vehicle is used or new.",
 *             example="Used"
 *         ),
 *         @OA\Property(
 *             property="ConsumptionCity",
 *             type="numeric",
 *             description="Fuel consumption in city.",
 *             example="7.6"
 *         ),
 *         @OA\Property(
 *             property="ConsumptionLand",
 *             type="numeric",
 *             description="Fuel consumption outside of city.",
 *             example="6.6"
 *         ),
 *         @OA\Property(
 *             property="ConsumptionRatingText",
 *             type="string",
 *             description="Fuel consumption rating.",
 *             example="A"
 *         ),
 *         @OA\Property(
 *             property="ConsumptionTotal",
 *             type="numeric",
 *             description="Total fuel consumption.",
 *             example="7.1"
 *         ),
 *         @OA\Property(
 *             property="CountryOrigin",
 *             type="string",
 *             description="Vehicle origin.",
 *             example="DE"
 *         ),
 *         @OA\Property(
 *             property="CurrencyIso",
 *             type="string",
 *             description="Price currency.",
 *             example="EUR"
 *         ),
 *         @OA\Property(
 *             property="Cylinders",
 *             type="integer",
 *             description="Numer of cylinders in engine.",
 *             example="4"
 *         ),
 *         @OA\Property(
 *             property="Documents",
 *             type="array",
 *             description="Links to car documents.",
 *             @OA\Items(
 *             ),
 *             example={"www.pathtodoc1.com", "www.pathtodoc2.com"}
 *         ),
 *         @OA\Property(
 *             property="Doors",
 *             type="integer",
 *             description="Numer of doors of the vehicle.",
 *             example="4"
 *         ),
 *         @OA\Property(
 *             property="DriveTypeText",
 *             type="string",
 *             description="Drive type of the vehicle.",
 *             example="Front-wheel"
 *         ),
 *         @OA\Property(
 *             property="Equipment",
 *             type="object",
 *             @OA\Property(
 *                 property="AutoIDatEquipment",
 *                 type="object",
 *                 @OA\Property(
 *                     property="OptionalEquipment",
 *                     type="array",
 *                     @OA\Items(
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="StandardEquipment",
 *                     type="array",
 *                     @OA\Items(
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="StandardItems",
 *                     type="array",
 *                     @OA\Items(
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="StandardPackages",
 *                     type="array",
 *                     @OA\Items(
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="OptionalItems",
 *                     type="array",
 *                     @OA\Items(
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="OptionalPackages",
 *                     type="array",
 *                     @OA\Items(
 *                     ),
 *                 ),
 *             ),
 *             @OA\Property(
 *                 property="SearchableEquipment",
 *                 type="array",
 *                 @OA\Items(
 *                 ),
 *             ),
 *             description="Vehicle equipment info",
 *             example={"AutoIDatEquipment":{"OptionalEquipment":{"Metallic-/ Pearl-Lackierung","Glasschiebedach elektrisch"},"StandardEquipment":{"Müdigkeitserkennung","Klimaanlage automatisch","Ambientebeleuchtung","Wärmepumpe","Fernlichtassistent","Lenkradheizung","Bremsassistent BA","Leichtmetallfelgen 17\","Keine Gewähr auf die Angaben der Serienausstattungen","Aussenspiegelgehäuse schwarz","LED-Scheinwerfer","Spurhalteassistent LKA","Details siehe gültige Preisliste des Importeurs","230 V Steckdose hinten","Garantie 7 Jahre/ 150'000 km","Schaltwippen am Lenkrad","Servolenkung elektrisch","Automatisch abblendbarer Innenspiegel","On-Board Lader","HSA Berganfahrassistent","Sitzheizung vorne","Rücksitzbank geteilt abklappbar 60/40","Privacy-Verglasung","DAB+ Digital Audio Broadcast","Aussenspiegel elektrisch einklappbar","Isofix-Kindersitzbefestigung hinten","Park-Distanz-Sensor hinten","Reifendruck-Sensoren TPMS","Licht- und Regensensor","Nebelscheinwerfer vorne","Apple Car Play/ Android Auto","Vordersitze höhenverstellbar","Smart-Key","LED Tagfahrlicht","Deaktivierung Beifahrerairbag","Türgriffe aussen verchromt","Lederlenkrad mit Lederschaltknauf","Bluetooth und Sprachsteuerung","TCS Elektronische Traktionskontrolle","USB-Anschluss","Kopfairbag vorne und hinten","ESP Elektronisches Stabilitätsprogramm","Elektrische Fensterheber vorne + hinten","Sitzbezüge in Stoff/ Leder","Aussenspiegel elektrisch verstellbar/ heizbar","Airbag Fahrer und Beifahrerseite","Zentralverriegelung mit Fernbedienung","Adaptiver Tempomat ACC","LED Rückleuchten","Notbrems-Assistent","Navigationssystem mit Rückfahrkamera","ABS/ EBD","Dachreling","Seitenairbags vorne"},"StandardItems":{"Müdigkeitserkennung","Klimaanlage automatisch","Ambientebeleuchtung","Wärmepumpe","Fernlichtassistent","Lenkradheizung","Bremsassistent BA","Leichtmetallfelgen 17\","Keine Gewähr auf die Angaben der Serienausstattungen","Aussenspiegelgehäuse schwarz","LED-Scheinwerfer","Spurhalteassistent LKA","Details siehe gültige Preisliste des Importeurs","230 V Steckdose hinten","Garantie 7 Jahre/ 150'000 km","Schaltwippen am Lenkrad","Servolenkung elektrisch","Automatisch abblendbarer Innenspiegel","On-Board Lader","HSA Berganfahrassistent","Sitzheizung vorne","Rücksitzbank geteilt abklappbar 60/40","Privacy-Verglasung","DAB+ Digital Audio Broadcast","Aussenspiegel elektrisch einklappbar","Isofix-Kindersitzbefestigung hinten","Park-Distanz-Sensor hinten","Reifendruck-Sensoren TPMS","Licht- und Regensensor","Nebelscheinwerfer vorne","Apple Car Play/ Android Auto","Vordersitze höhenverstellbar","Smart-Key","LED Tagfahrlicht","Deaktivierung Beifahrerairbag","Türgriffe aussen verchromt","Lederlenkrad mit Lederschaltknauf","Bluetooth und Sprachsteuerung","TCS Elektronische Traktionskontrolle","USB-Anschluss","Kopfairbag vorne und hinten","ESP Elektronisches Stabilitätsprogramm","Elektrische Fensterheber vorne + hinten","Sitzbezüge in Stoff/ Leder","Aussenspiegel elektrisch verstellbar/ heizbar","Airbag Fahrer und Beifahrerseite","Zentralverriegelung mit Fernbedienung","Adaptiver Tempomat ACC","LED Rückleuchten","Notbrems-Assistent","Navigationssystem mit Rückfahrkamera","ABS/ EBD","Dachreling","Seitenairbags vorne"},"StandardPackages":{},"OptionalItems":{"Metallic-/ Pearl-Lackierung","Glasschiebedach elektrisch"},"OptionalPackages":{{"PackageName":"Pack Style","PackageItems":{"Rückfahr-Querverkehrswarner","Fahrersitz mit Memory","Sitzbezüge in Leder","Details siehe Preisliste","Park-Distanz-Sensor vorne","Wireless Charging für mobile Geräte","JBL Hi-Fi System","Fahrersitz elektrisch verstellbar mit Lendenwirbelstütze","Totwinkel-Assistent","Sitzheizung hinten","Aktive Sitzbelüftung vorn"}}}},"SearchableEquipment":{"1","5","6","7","9","10","15","181","188","219"}}
 *         ),
 *         @OA\Property(
 *             property="FirstRegMonth",
 *             type="integer",
 *             description="Month of first registration.",
 *             example="4"
 *         ),
 *         @OA\Property(
 *             property="FirstRegYear",
 *             type="integer",
 *             description="Year of first registration.",
 *             example="2021"
 *         ),
 *         @OA\Property(
 *             property="FuelTypeText",
 *             type="string",
 *             description="Fuel type.",
 *             example="Gasoline"
 *         ),
 *         @OA\Property(
 *             property="HasWarranty",
 *             type="boolean",
 *             description="Has warranty flag.",
 *             example="true"
 *         ),
 *         @OA\Property(
 *             property="Hp",
 *             type="numeric",
 *             description="Horse power of the engine.",
 *             example="204.0"
 *         ),
 *         @OA\Property(
 *             property="Id",
 *             type="integer",
 *             description="Id of vehicle from Inside database.",
 *             example="37"
 *         ),
 *         @OA\Property(
 *             property="Images",
 *             type="object",
 *             @OA\Property(
 *                 property="S",
 *                 type="array",
 *                 @OA\Items(
 *                 ),
 *             ),
 *             @OA\Property(
 *                 property="M",
 *                 type="array",
 *                 @OA\Items(
 *                 ),
 *             ),
 *             @OA\Property(
 *                 property="L",
 *                 type="array",
 *                 @OA\Items(
 *                 ),
 *             ),
 *             @OA\Property(
 *                 property="XL",
 *                 type="array",
 *                 @OA\Items(
 *                 ),
 *             ),
 *             @OA\Property(
 *                 property="Original",
 *                 type="array",
 *                 @OA\Items(
 *                 ),
 *             ),
 *             description="Vehicle Images",
 *             example={"S":{"https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/d0332a2e-57a3-4f74-a12c-345fa8bb497b_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/1fe067b6-cc4f-4419-bb51-611c43399066_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/da231a84-7966-4a2c-a134-f60150629a02_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/6ed7cc57-4b41-41a4-9573-bb454d781229_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/0899415a-1c72-4f99-ba1a-79c7d14b601a_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/26141823-ed17-47ba-888e-9c5264239057_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/77ed9cb8-7f02-42c4-b94c-33e13b3874bf_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/f371736a-ed9e-4eec-a86c-5bb312a980ee_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/b9bcff16-b6ea-4446-bf26-798045ac51c7_95.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/7b723304-c410-486e-958c-b548ac45c7ea_95.jpg"},"M":{"https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/d0332a2e-57a3-4f74-a12c-345fa8bb497b_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/1fe067b6-cc4f-4419-bb51-611c43399066_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/da231a84-7966-4a2c-a134-f60150629a02_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/6ed7cc57-4b41-41a4-9573-bb454d781229_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/0899415a-1c72-4f99-ba1a-79c7d14b601a_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/26141823-ed17-47ba-888e-9c5264239057_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/77ed9cb8-7f02-42c4-b94c-33e13b3874bf_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/f371736a-ed9e-4eec-a86c-5bb312a980ee_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/b9bcff16-b6ea-4446-bf26-798045ac51c7_300.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/7b723304-c410-486e-958c-b548ac45c7ea_300.jpg"},"L":{"https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/d0332a2e-57a3-4f74-a12c-345fa8bb497b_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/1fe067b6-cc4f-4419-bb51-611c43399066_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/da231a84-7966-4a2c-a134-f60150629a02_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/6ed7cc57-4b41-41a4-9573-bb454d781229_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/0899415a-1c72-4f99-ba1a-79c7d14b601a_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/26141823-ed17-47ba-888e-9c5264239057_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/77ed9cb8-7f02-42c4-b94c-33e13b3874bf_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/f371736a-ed9e-4eec-a86c-5bb312a980ee_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/b9bcff16-b6ea-4446-bf26-798045ac51c7_640.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/7b723304-c410-486e-958c-b548ac45c7ea_640.jpg"},"XL":{"https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/d0332a2e-57a3-4f74-a12c-345fa8bb497b_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/1fe067b6-cc4f-4419-bb51-611c43399066_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/da231a84-7966-4a2c-a134-f60150629a02_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/6ed7cc57-4b41-41a4-9573-bb454d781229_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/0899415a-1c72-4f99-ba1a-79c7d14b601a_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/26141823-ed17-47ba-888e-9c5264239057_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/77ed9cb8-7f02-42c4-b94c-33e13b3874bf_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/f371736a-ed9e-4eec-a86c-5bb312a980ee_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/b9bcff16-b6ea-4446-bf26-798045ac51c7_1024.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/7b723304-c410-486e-958c-b548ac45c7ea_1024.jpg"},"Original":{"https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/d0332a2e-57a3-4f74-a12c-345fa8bb497b.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/1fe067b6-cc4f-4419-bb51-611c43399066.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/da231a84-7966-4a2c-a134-f60150629a02.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/6ed7cc57-4b41-41a4-9573-bb454d781229.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/0899415a-1c72-4f99-ba1a-79c7d14b601a.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/26141823-ed17-47ba-888e-9c5264239057.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/77ed9cb8-7f02-42c4-b94c-33e13b3874bf.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/f371736a-ed9e-4eec-a86c-5bb312a980ee.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/b9bcff16-b6ea-4446-bf26-798045ac51c7.jpg","https://stage1-vp-ch.emilfreydigital.hr/vp_files/stock_images/80362/7b723304-c410-486e-958c-b548ac45c7ea.jpg"}}
 *         ),
 *         @OA\Property(
 *             property="Km",
 *             type="integer",
 *             description="Mileage of a vehicle (in km).",
 *             example="2000"
 *         ),
 *         @OA\Property(
 *             property="MakeText",
 *             type="string",
 *             description="Vehicle brand.",
 *             example="Kia"
 *         ),
 *         @OA\Property(
 *             property="ModelGroupText",
 *             type="string",
 *             description="Vehicle model group.",
 *             example="E-CLASS"
 *         ),
 *         @OA\Property(
 *             property="ModelText",
 *             type="string",
 *             description="Vehicle model.",
 *             example="e-Niro Style"
 *         ),
 *         @OA\Property(
 *             property="ModelTypeText",
 *             type="string",
 *             description="Vehicle model type.",
 *             example="e-Niro Style"
 *         ),
 *         @OA\Property(
 *             property="PollutionNormTypeText",
 *             type="string",
 *             description="Vehicle pollution norm data.",
 *             example="Euro 5"
 *         ),
 *          @OA\Property(
 *             property="Price",
 *             type="numeric",
 *             description="Vehicle price.",
 *             example="49900.0"
 *         ),
 *         @OA\Property(
 *             property="PriceHistory",
 *             type="array",
 *             @OA\Items(
 *             ),
 *             description="Vehicle price history over time.",
 *             example="[49900.0, 39900.0]"
 *         ),
 *         @OA\Property(
 *             property="PriceNew",
 *             type="numeric",
 *             description="Vehicle price if new.",
 *             example="53700.0"
 *         ),
 *         @OA\Property(
 *             property="Properties",
 *             type="array",
 *             @OA\Items(
 *             ),
 *             description="Vehicle properties.",
 *             example={"prop1", "prop2"}
 *         ),
 *         @OA\Property(
 *             property="AdditionalProperties",
 *             type="array",
 *             @OA\Items(
 *             ),
 *             description="Vehicle additional properties.",
 *             example={"prop1", "prop2"}
 *         ),
 *         @OA\Property(
 *             property="Seats",
 *             type="integer",
 *             description="Number of seats in the vehicle.",
 *             example="5"
 *         ),
 *         @OA\Property(
 *             property="SegmentationId",
 *             type="integer",
 *             description="Segmentation id.",
 *             example="5"
 *         ),
 *         @OA\Property(
 *             property="Seller",
 *             type="object",
 *             @OA\Property(
 *                 property="Id",
 *                 type="integer",
 *                 example="600"
 *             ),
 *             @OA\Property(
 *                 property="Name",
 *                 type="string",
 *                 example="Emil Frey Zürich Altstetten"
 *             ),
 *             @OA\Property(
 *                 property="Street",
 *                 type="string",
 *                 example="Badenerstrasse 600"
 *             ),
 *             @OA\Property(
 *                 property="Zip",
 *                 type="string",
 *                 example="8048"
 *             ),
 *             @OA\Property(
 *                 property="City",
 *                 type="string",
 *                 example="Zürich"
 *             ),
 *             @OA\Property(
 *                 property="AdditionalInfo",
 *                 type="string",
 *                 example=""
 *             ),
 *             @OA\Property(
 *                 property="Phone",
 *                 type="string",
 *                 example="+41 44 495 23 11"
 *             ),
 *             @OA\Property(
 *                 property="Mobile",
 *                 type="string",
 *                 example="+41 44 495 23 11"
 *             ),
 *             @OA\Property(
 *                 property="Email",
 *                 type="string",
 *                 example="autohaus@emilfrey.ch"
 *             ),
 *             @OA\Property(
 *                 property="Url",
 *                 type="string",
 *                 example="http://www.emilfrey.ch/zuerich"
 *             ),
 *             description="Vehicle Images",
 *             example={"Id":600,"Name":"Emil Frey Zürich Altstetten ","Street":"Badenerstrasse 600","Zip":"8048","City":"Zürich","AdditionalInfo":"","Phone":"+41 44 495 23 11","Mobile":"+41 44 495 23 11","Email":"autohaus@emilfrey.ch","Url":"http://www.emilfrey.ch/zuerich"}
 *         ),
 *         @OA\Property(
 *             property="Teaser",
 *             type="string",
 *             description="Vehicle teaser.",
 *             example="Eintauschprämie + Fr. 1'000.-"
 *         ),
 *         @OA\Property(
 *             property="TransmissionTypeText",
 *             type="string",
 *             description="Transmission type. A or M. 1 or 0",
 *             example="A"
 *         ),
 *         @OA\Property(
 *             property="URLmarketplace",
 *             type="string",
 *             description="External vehicle marketplace URL",
 *             example="www.urltocar.com"
 *         ),
 *         @OA\Property(
 *             property="VatDeductible",
 *             type="boolean",
 *             description="Vat deductible flag",
 *             example="true"
 *         ),
 *         @OA\Property(
 *             property="VehicleType",
 *             type="string",
 *             description="Vehicle type of a vehicle. Passenger, LCV, Truck",
 *             example="Passenger"
 *         ),
 *         @OA\Property(
 *             property="Videos",
 *             type="array",
 *             description="Links to car videos.",
 *             @OA\Items(
 *                  type="string"
 *             ),
 *             example={"www.pathtovideo1.com", "www.pathtovideo2.com"}
 *         ),
 *         @OA\Property(
 *             property="WarrantyDescription",
 *             type="string",
 *             description="Warranty description of a vehicle",
 *             example="MAX 250 €"
 *         ),
 *         @OA\Property(
 *             property="Weight",
 *             type="integer",
 *             description="Weight of a vehicle",
 *             example="1866"
 *         ),
 *     ),
 *     required={"ChassisCode", "CountryOrigin", "MakeText", "ModelText", "ModelTypeText", "Ccm", "Hp", "FuelTypeText", "TransmissionTypeText", "Km", "FirstRegMonth", "FirstRegYear", "BodyColorText", "Co2Emission", "B2bPriceExVat", "VatDeductible", "Seller", "CurrencyIso", "ConditionTypeText", "VehicleType"}
 * )
 *
 */
