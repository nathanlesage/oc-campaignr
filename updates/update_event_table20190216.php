<?php namespace HendrikErz\Campaignr\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateEventTable20190216 extends Migration
{
    public function up()
    {
      Schema::table('hendrikerz_campaignr_events', function ($table) {
          // Remove nullable attribute from a lot of columns
          $table->boolean('repeat_event')->default(0)->change();
          $table->integer('repeat_mode')->unsigned()->default(2)->change(); // New default: Weekly
          $table->integer('dow')->unsigned()->change();
          $table->integer('wom')->unsigned()->change();
          $table->integer('dom')->unsigned()->change();
          $table->integer('mon')->unsigned()->change();
          $table->integer('year')->unsigned()->change();
          $table->integer('end_day')->unsigned()->change();
          $table->integer('end_mon')->unsigned()->change();
          $table->integer('end_year')->unsigned()->change();
      });
    }

    public function down()
    {
        // Reverse the changes
        Schema::table('hendrikerz_campaignr_events', function ($table) {
          $table->boolean('repeat_event')->nullable(false)->unsigned(false)->default(0)->change();
          $table->integer('repeat_mode')->nullable(false)->unsigned()->default(0)->change();
          $table->integer('dow')->unsigned()->nullable(false)->change();
          $table->integer('wom')->unsigned()->nullable(false)->change();
          $table->integer('dom')->unsigned()->nullable(false)->change();
          $table->integer('mon')->unsigned()->nullable(false)->change();
          $table->integer('year')->unsigned()->nullable(false)->change();
          $table->integer('end_day')->unsigned()->nullable(false)->change();
          $table->integer('end_mon')->unsigned()->nullable(false)->change();
          $table->integer('end_year')->unsigned()->nullable(false)->change();
        });
    }
}