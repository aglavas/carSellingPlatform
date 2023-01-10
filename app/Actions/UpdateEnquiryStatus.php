<?php

namespace App\Actions;


use App\Enquiry;

class UpdateEnquiryStatus
{

    public function execute(Enquiry $enquiry)
    {
        if ($enquiry->transactionsInProgress() > 0) {
            $enquiry->update(
                [
                    'status' => Enquiry::STATUS_IN_PROGRESS
                ]
            );
        } else {
            $enquiry->update(
                [
                    'status' => Enquiry::STATUS_FINISHED
                ]
            );
        }
    }
}
