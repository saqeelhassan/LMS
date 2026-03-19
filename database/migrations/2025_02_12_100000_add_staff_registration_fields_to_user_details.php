<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('last_name');
            $table->string('cnic', 20)->nullable()->after('father_name');
            $table->string('contact_no', 20)->nullable()->after('mobile');
            $table->string('whatsapp', 20)->nullable()->after('contact_no');
            $table->string('emergency_contact', 20)->nullable()->after('whatsapp');
            $table->string('gender', 20)->nullable()->after('emergency_contact');
            $table->text('current_address')->nullable()->after('state');
            $table->string('last_qualification', 255)->nullable()->after('current_address');
            $table->string('domicile_district', 100)->nullable()->after('last_qualification');
            $table->string('cnic_front_path')->nullable()->after('domicile_district');
            $table->string('cnic_back_path')->nullable()->after('cnic_front_path');
            $table->string('last_degree_path')->nullable()->after('cnic_back_path');
            $table->string('domicile_prc_path')->nullable()->after('last_degree_path');
        });
    }

    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn([
                'father_name',
                'cnic',
                'contact_no',
                'whatsapp',
                'emergency_contact',
                'gender',
                'current_address',
                'last_qualification',
                'domicile_district',
                'cnic_front_path',
                'cnic_back_path',
                'last_degree_path',
                'domicile_prc_path',
            ]);
        });
    }
};
