<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddIsAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
        });

        // Cập nhật tài khoản hiện tại lenam3583@gmail.com thành admin
        DB::table('users')->where('email', 'lenam3583@gmail.com')->update(['is_admin' => true]);

        // Tạo thêm tài khoản admin mặc định admin@gmail.com nếu chưa có
        $adminExists = DB::table('users')->where('email', 'admin@gmail.com')->exists();
        if (!$adminExists) {
            DB::table('users')->insert([
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
}
