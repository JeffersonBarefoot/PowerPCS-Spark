<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Your Company',
        'product' => 'Your Product',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = null;

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        //
        'JEFFERSON.L.BAREFOOT@GMAIL.COM',
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::useRoles([
            'UPNRO' => 'View Only, Positions, no costs',
            'UPFRO' => 'View Only, all Position data',
            'UINRO' => 'View Only, Positions + Incumbents, no costs',
            'UIFRO' => 'View Only, Positions + Incumbents, all data',

            'UPN' => 'Update Positions, no costs',
            'UPF' => 'Update all Position data ',
            'UIN' => 'Update Positions + Incumbents, no costs',
            'UIF' => 'Update Positions + Incumbents, all data',

            'DAT' => 'Data User:  Full access + data upload',
            'ADM' => 'Admin:  Data User + system config, team members',
            'ADMB' => 'Billing Admin:  Admin + Billing Contact',
        ]);

        Spark::noCardUpFront()->trialDays(10);

        Spark::freePlan()
            ->features([
                'First', 'Second', 'Third'
            ]);

        Spark::plan('Basic', 'provider-id-1')
            ->price(10)
            ->features([
                'First', 'Second', 'Third'
            ]);
    }
}
