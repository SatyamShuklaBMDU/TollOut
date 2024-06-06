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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('customer_id')->nullable()->after('id');
            $table->enum('Mr/Miss', ['Mr.','Miss','Rather not to say'])->nullable()->after('phone');
            $table->date('dob')->nullable()->after('Mr/Miss');
            $table->string('profile')->nullable()->after('dob');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('customer_id');
            $table->dropColumn('Mr/Miss');
            $table->dropColumn('dob');
            $table->dropColumn('profile');
        });
    }
};
