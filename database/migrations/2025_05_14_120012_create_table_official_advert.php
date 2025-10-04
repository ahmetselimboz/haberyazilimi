<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        if (Schema::hasColumn("official_advert",'clsfadmagicbox')) {
            return;
        }
        Schema::table('official_advert', function (Blueprint $table) {

            $table->json("clsfadmagicbox")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
 Schema::table('official_advert', function (Blueprint $table) {

            $table->dropColumn("clsfadmagicbox");
        });    }
};
