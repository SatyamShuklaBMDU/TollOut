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
            $table->enum('gender', ['male','female','not to say'])->nullable()->after('phone');
            $table->date('dob')->nullable()->after('gender');
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
            $table->dropColumn('gender');
            $table->dropColumn('dob');
            $table->dropColumn('profile');
        });
    }
};
