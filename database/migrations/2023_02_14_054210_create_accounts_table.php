<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->text('password');
            $table->string('username')->unique();
            $table->string('company');
            $table->string('nationality');
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert data from json resource
        DB::table('accounts')->insert(
            array(
                array (
                    'name' => 'Micah Figueroa',
                    'phone' => '(175) 897-5654',
                    'email' => 'vestibulum.ut@aol.net',
                    'password' => 'hPbID53PBJ8Yl',
                    'username' => 'Aimee',
                    'company' => 'Tempor Diam Company',
                    'nationality' => 'Norway',
                ),
                array (
                    'name' => 'Salvador Robles',
                    'phone' => '(149) 416-0327',
                    'email' => 'ut.nec.urna@aol.com',
                    'password' => 'hSfZR22LDE5Js',
                    'username' => 'Moana',
                    'company' => 'Sagittis Felis LLC',
                    'nationality' => 'Nigeria',
                ),
                array (
                    'name' => 'Daphne Solomon',
                    'phone' => '(465) 633-1234',
                    'email' => 'facilisis@hotmail.net',
                    'password' => 'kXwSX24ASJ0Eq',
                    'username' => 'Ila',
                    'company' => 'Non LLP',
                    'nationality' => 'Philippines',
                ),
                array (
                    'name' => 'Inga Dudley',
                    'phone' => '(785) 320-8427',
                    'email' => 'diam.luctus@yahoo.org',
                    'password' => 'oEeJB37YRE5Pp',
                    'username' => 'Samson',
                    'company' => 'Eu PC',
                    'nationality' => 'India',
                ),
                array (
                    'name' => 'Farrah Bartlett',
                    'phone' => '1-975-537-1622',
                    'email' => 'hendrerit.a@google.couk',
                    'password' => 'hMmHQ80SSX3Rv',
                    'username' => 'Brynne',
                    'company' => 'Consectetuer Incorporated',
                    'nationality' => 'Belgium',
                ),
                array (
                    'name' => 'Bethany Martinez',
                    'phone' => '(344) 341-3583',
                    'email' => 'dapibus.quam@outlook.couk',
                    'password' => 'eIqCV98NVL2Ft',
                    'username' => 'Dante',
                    'company' => 'Lorem Vitae Corporation',
                    'nationality' => 'Australia',
                ),
                array (
                    'name' => 'Olga Harmon',
                    'phone' => '(535) 736-8745',
                    'email' => 'vel.venenatis@yahoo.edu',
                    'password' => 'iIsNH42FEK2Gr',
                    'username' => 'Louis',
                    'company' => 'Eu Industries',
                    'nationality' => 'Peru',
                ),
                array (
                    'name' => 'Tiger Oneal',
                    'phone' => '1-330-563-3873',
                    'email' => 'a.auctor.non@aol.org',
                    'password' => 'vXqIF11GSI6Bt',
                    'username' => 'Stephanie',
                    'company' => 'Pellentesque Massa Lobortis Inc.',
                    'nationality' => 'Austria',
                ),
                array (
                    'name' => 'Adria Mcclure',
                    'phone' => '1-966-100-7223',
                    'email' => 'faucibus.ut@protonmail.couk',
                    'password' => 'iHkRY42LBR8Rw',
                    'username' => 'Gil',
                    'company' => 'Egestas Fusce Aliquet Industries',
                    'nationality' => 'Italy',
                ),
                array (
                    'name' => 'Price Watson',
                    'phone' => '1-265-555-4354',
                    'email' => 'sem.egestas@hotmail.org',
                    'password' => 'oUqRC54QPQ7Xl',
                    'username' => 'Kylynn',
                    'company' => 'Donec Ltd',
                    'nationality' => 'Australia',
                ),
                array (
                    'name' => 'Hakeem Gillespie',
                    'phone' => '1-824-119-7226',
                    'email' => 'semper.erat.in@protonmail.ca',
                    'password' => 'uHkGP44PZG1Ki',
                    'username' => 'Rowan',
                    'company' => 'Vulputate Velit Eu Incorporated',
                    'nationality' => 'Australia',
                ),
                array (
                    'name' => 'Laith Tillman',
                    'phone' => '(946) 933-3197',
                    'email' => 'purus.nullam.scelerisque@yahoo.net',
                    'password' => 'hHbMJ30BNT5Ms',
                    'username' => 'Uriah',
                    'company' => 'Gravida Molestie Company',
                    'nationality' => 'Indonesia',
                ),
                array (
                    'name' => 'Dean Clements',
                    'phone' => '1-177-836-7163',
                    'email' => 'facilisis.eget.ipsum@yahoo.com',
                    'password' => 'jKsEU25HAT2Uo',
                    'username' => 'Bryar',
                    'company' => 'Aliquet Vel Vulputate Institute',
                    'nationality' => 'Poland',
                ),
                array (
                    'name' => 'Drew Payne',
                    'phone' => '1-964-982-5491',
                    'email' => 'mauris@hotmail.com',
                    'password' => 'mJbFX15JKQ3Vu',
                    'username' => 'Adrian',
                    'company' => 'Molestie Associates',
                    'nationality' => 'Norway',
                ),
                array (
                    'name' => 'Cora Foreman',
                    'phone' => '(533) 823-6188',
                    'email' => 'eget.ipsum.suspendisse@outlook.edu',
                    'password' => 'hBxGG22QEY8Ge',
                    'username' => 'Oscar',
                    'company' => 'Vivamus Molestie LLP',
                    'nationality' => 'United States',
                ),
                array (
                    'name' => 'Nero Woodard',
                    'phone' => '1-756-145-6998',
                    'email' => 'eu@outlook.ca',
                    'password' => 'wChEM48XRS5Ps',
                    'username' => 'Aphrodite',
                    'company' => 'Vestibulum Foundation',
                    'nationality' => 'Germany',
                ),
                array (
                    'name' => 'Hanae Bond',
                    'phone' => '1-853-416-6337',
                    'email' => 'sem.consequat.nec@protonmail.net',
                    'password' => 'qCsNY75RIM0Li',
                    'username' => 'Marah',
                    'company' => 'Malesuada Consulting',
                    'nationality' => 'Philippines',
                ),
                array (
                    'name' => 'Emery Harrington',
                    'phone' => '(750) 611-1035',
                    'email' => 'ligula@aol.org',
                    'password' => 'iKiWG74WQM2Tn',
                    'username' => 'Stephanie2',
                    'company' => 'Euismod Foundation',
                    'nationality' => 'Colombia',
                ),
                array (
                    'name' => 'Mallory Reeves',
                    'phone' => '1-655-719-7060',
                    'email' => 'eleifend.nec@yahoo.com',
                    'password' => 'sIlKI65BEC0Ds',
                    'username' => 'Judah',
                    'company' => 'Aliquam Erat Industries',
                    'nationality' => 'Colombia',
                ),
                array (
                    'name' => 'Cara Arnold',
                    'phone' => '1-248-752-1173',
                    'email' => 'eu.placerat@outlook.couk',
                    'password' => 'dKcOD51TUQ3Aq',
                    'username' => 'Maris',
                    'company' => 'Neque Non Quam Incorporated',
                    'nationality' => 'Philippines',
                ),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
