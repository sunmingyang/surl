<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiresToShortUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->getTable()) === true) {
            Schema::table($this->getTable(), function (Blueprint $table) {
                $table->dateTime('expires_at')->nullable()->comment('过期时间');
            });
        }
    }
    
    protected function getTable()
    {
        static $table;
        
        if ($table === null) {
            $table = config('surl.database.table');
        }
        
        return $table;
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->getTable(), 'expires_at')) {
            Schema::table($this->getTable(), function (Blueprint $table) {
                $table->dropColumn('expires_at');
            });
        }
    }
}
