<?php

use Illuminate\Support\Facades\Schema;
use PhpClickHouseLaravel\Migration;
use PhpClickHouseSchemaBuilder\Tables\MergeTree;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        static::createMergeTree('events', fn(MergeTree $table) => $table
            ->columns([
                $table->uInt32('id'),
                $table->string("user_id"),
                $table->string("event_type"),
                $table->datetime("happened_at"),
                $table->string("metadata")->nullable()
            ])
            ->orderBy('id')
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        static::write('DROP TABLE events');
    }
};
