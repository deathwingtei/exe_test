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
        Schema::create('item_data', function (Blueprint $table) {
            $table->integer('game_item_id')->autoIncrement();
            $table->string('name');
            $table->float('chance', 10, 2);
            $table->integer('stock');
            $table->timestamps();
        });

        DB::table('item_data')->insert(
            array (
                array (
                    'name' => 'Small Potion Heal',
                    'game_item_id' => 1050,
                    'chance' => 0.12,
                    'stock' => 1000,
                ),
                array (
                    'name' => 'Medium Potion Heal',
                    'game_item_id' => 3315,
                    'chance' => 0.08,
                    'stock' => 80,
                ),
                array (
                    'name' => 'Big Potion Heal',
                    'game_item_ id' => 5830,
                    'chance' => 0.06,
                    'stock' => 15,
                ),
                array (
                    'name' => 'Full Potion Heal',
                    'game_item_id' => 1650,
                    'chance' => 0.04,
                    'stock' => 10,
                ),
                array (
                    'name' => 'Small MP Potion',
                    'game_item_id' => 10235,
                    'chance' => 0.12,
                    'stock' => 1000,
                ),
                array (
                    'name' => 'Medium MP Potion',
                    'game_item_id' => 892,
                    'chance' => 0.08,
                    'stock' => 80,
                ),
                array (
                    'name' => 'Big MP Potion',
                    'game_item_id' => 14736,
                    'chance' => 0.06,
                    'stock' => 15,
                ),
                array (
                    'name' => 'Full MP Potion',
                    'game_item_id' => 19001,
                    'chance' => 0.04,
                    'stock' => 8,
                ),
                array (
                    'name' => 'Attack Ring',
                    'game_item_id' => 135007,
                    'chance' => 0.05,
                    'stock' => 10,
                ),
                array (
                    'name' => 'Defense Ring',
                    'game_item_id' => 68411,
                    'chance' => 0.05,
                    'stock' => 10,
                ),
                array (
                    'name' => 'Lucky Key',
                    'game_item_id' => 118930,
                    'chance' => 0.15,
                    'stock' => 1000,
                ),
                array (
                    'name' => 'Silver Key',
                    'game_item_id' => 117462,
                    'chance' => 0.15,
                    'stock' => 1000,
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
        Schema::dropIfExists('item_data');
    }
};
