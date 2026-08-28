<?php

namespace Illuminate\Tests\Integration\Database\MySql;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseExplainTest extends MySqlTestCase
{
    protected function afterRefreshingDatabase()
    {
        if (! Schema::hasTable('db_explain_tbl')) {
            Schema::create('db_explain_tbl', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->timestamps();
            });
        }
    }

    protected function destroyDatabaseMigrations()
    {
        Schema::dropIfExists('db_explain_tbl');
    }

    public function testResultIsAnObject()
    {
        DB::insert(['name' => 'taylor']);

        $result = DB::table('db_explain_tbl')->where('name', 'taylor')->explain();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertIsObject($result[0]);
    }
}
