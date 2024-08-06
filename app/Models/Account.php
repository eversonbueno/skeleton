<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Account extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account';

    protected $fillable = ['id', 'type', 'origin', 'destination', 'amount'];

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->integer('id');
            $table->string('type');
            $table->string('origin');
            $table->string('destination');
            $table->string('amount');
            $table->string('created_at');
            $table->string('updated_at');
        });

        $this->primaryKey = false;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('account');
    }




}
