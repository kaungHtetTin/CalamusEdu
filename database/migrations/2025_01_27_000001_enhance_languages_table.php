<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnhanceLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('display_name', 100)->nullable()->after('name');
            $table->string('module_code', 10)->nullable()->after('code');
            $table->string('primary_color', 20)->nullable()->after('module_code');
            $table->string('secondary_color', 20)->nullable()->after('primary_color');
            $table->string('image_path', 500)->nullable()->after('secondary_color');
            $table->string('notification_owner_id', 20)->nullable()->after('image_path');
            $table->string('firebase_topic', 100)->nullable()->after('notification_owner_id');
            $table->string('user_data_table_prefix', 20)->nullable()->after('firebase_topic');
            $table->boolean('is_active')->default(true)->after('user_data_table_prefix');
            $table->integer('sort_order')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn([
                'display_name',
                'module_code',
                'primary_color',
                'secondary_color',
                'image_path',
                'notification_owner_id',
                'firebase_topic',
                'user_data_table_prefix',
                'is_active',
                'sort_order',
            ]);
        });
    }
}

