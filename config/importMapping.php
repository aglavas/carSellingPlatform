<?php
return [
    \App\Imports\StockFCAImport::class => \App\Nova\StockFCA::class,
    \App\Imports\StockMercedesImport::class => \App\Nova\StockMercedes::class,
    \App\Imports\StockOpelImport::class => \App\Nova\StockOpel::class,
    \App\Imports\StockPeugeotCitroenDsImport::class => \App\Nova\StockPeugeotCitroenDs::class,
    \App\Imports\StockRetailDcmiImport::class => \App\Nova\StockRetailDcmi::class,
    \App\Imports\StockRetailGermanyImport::class => \App\Nova\StockRetailGermany::class,
    \App\Imports\StockSwitzerlandImport::class => \App\Nova\StockSwitzerland::class,
    \App\Imports\StockUsedCentralEuropeImport::class => \App\Nova\StockUsedCentralEurope::class,
    \App\Imports\UserImport::class => \App\Nova\User::class,
];
