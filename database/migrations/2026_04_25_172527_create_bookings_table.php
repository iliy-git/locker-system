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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Связи
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cell_id')->constrained()->onDelete('cascade');

            // Время аренды
            $table->timestamp('started_at')->nullable(); // Когда начали пользоваться
            $table->timestamp('expires_at')->nullable(); // До какого времени забронировано
            $table->timestamp('finished_at')->nullable(); // Когда реально вернули доступ

            // Статус брони
            // pending - ожидает оплаты/подтверждения
            // active - ячейка сейчас занята пользователем
            // completed - аренда успешно завершена
            // cancelled - бронь отменена
            $table->string('status')->default('pending');

            // Код доступа (если нужно вводить на терминале)
            $table->string('pincode', 6)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
