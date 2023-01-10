<?php

return [
    'transaction_status' => [
        \App\Transaction::TRANSACTION_STATUS_DENIED => 'Denied',
        \App\Transaction::TRANSACTION_STATUS_APPROVED => 'Approved',
        \App\Transaction::TRANSACTION_STATUS_IN_PROGRESS => 'In Progress',
        \App\Transaction::TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION => 'Removed',
    ]
];
