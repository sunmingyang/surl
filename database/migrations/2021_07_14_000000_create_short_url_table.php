<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (Schema::hasTable(config('surl.database.table')) === false) {
            Schema::create(config('surl.database.table'), function (Blueprint $table) {
                $table->id()->unsigned();
                $table->string('code', 90)->unique()->comment('缩短后的code');
                $table->string('url', 3000)->comment('原始url');
                $table->integer('visits')->default(0)->comment('访问次数');
                $table->timestamps();
            });
        }
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('surl.database.table'));
    }
}
