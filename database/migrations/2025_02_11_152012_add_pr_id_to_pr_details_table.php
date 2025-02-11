<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pr_details', function (Blueprint $table) {
            $table->unsignedBigInteger('pr_id')->after('id')->nullable();
            $table->foreign('pr_id')->references('id')->on('prs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pr_details', function (Blueprint $table) {
            $table->dropForeign(['pr_id']);
            $table->dropColumn('pr_id');
        });
    }
};
