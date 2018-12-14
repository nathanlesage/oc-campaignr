<?php namespace HendrikErz\Campaignr\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHendrikerzCampaignrEvents extends Migration
{
    public function up()
    {
        Schema::create('hendrikerz_campaignr_events', function($table)
        {
            $table->engine = 'InnoDB';
            // First general information about the event
            $table->increments('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->text('description')->nullable();
            $table->dateTime('time_begin');
            $table->dateTime('time_end');
            // Should the event repeat?
            $table->boolean('repeat_event')->nullable(false)->unsigned(false)->default(0);
            $table->integer('repeat_mode')->nullable(false)->unsigned()->default(0);
            $table->dateTime('end_repeat_on')->nullable();
            // Where does the event take place?
            $table->string('location_street', 255)->nullable();
            $table->string('location_number', 255)->nullable();
            $table->string('location_zip', 255)->nullable();
            $table->string('location_city', 255)->nullable();
            $table->string('location_country', 255)->nullable();
            $table->string('location_misc', 255)->nullable();
            // Helper variables for the plugin (ease of access)
            $table->integer('dow')->unsigned()->nullable(false);  // Day of Week (1-7)
            $table->integer('wom')->unsigned()->nullable(false);  // Week of Month (1-4)
            $table->integer('dom')->unsigned()->nullable(false);  // Day of Month (1-31)
            $table->integer('mon')->unsigned()->nullable(false);  // Month (1-12)
            $table->integer('year')->unsigned()->nullable(false); // Year (4 digits)
            $table->integer('end_day')->unsigned()->nullable(false);
            $table->integer('end_mon')->unsigned()->nullable(false);
            $table->integer('end_year')->unsigned()->nullable(false);
            $table->integer('repeat_day')->unsigned()->nullable();
            $table->integer('repeat_mon')->unsigned()->nullable();
            $table->integer('repeat_year')->unsigned()->nullable();
            // Internal variables
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hendrikerz_campaignr_events');
    }
}