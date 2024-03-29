<?php

use App\Models\User;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignIdFor(User::class)
                ->unique()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->primary('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthdate')
            ->nullable();
            $table->enum('gender', ['Male', 'Female'])
                ->nullable();
            $table->string('street_address')
                ->nullable();
            $table->string('city')
            ->nullable();
            $table->string('state')
                ->nullable();
            $table->string('postal_code')
            ->nullable();
            $table->char('country', 2);
            $table->char('locale', 2)
                ->default('en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
