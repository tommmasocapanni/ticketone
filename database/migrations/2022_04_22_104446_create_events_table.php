<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            # Con questa istruzione viene generata la colonna
            # ID, ovvero l'identificativo di ogni riga evento
            # nonchè chiave primaria della tabella.
            # La chiave primaria è unica, autoincrementante e minimale.
            $table->id();

            $table->string('name'); # Per le stringhe che vanno da 0 a 255 caratteri di lunghezza
            $table->text('description');
            $table->dateTime('date');
            $table->string('cover_url');
            $table->double('price', 8, 2);
            $table->string('address');
            $table->double('lat', 8, 2);
            $table->double('lng', 8, 2);
            $table->decimal('views_count');
            $table->decimal('comments_count');
            $table->decimal('likes_count');

            # Questa istruzione genererà due campi
            # created_at e updated_at
            # che sono due timestamp che conterranno corrispettivamente
            # la data di creazione di un evento e la data dell'ultimo
            # aggiornamento.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
