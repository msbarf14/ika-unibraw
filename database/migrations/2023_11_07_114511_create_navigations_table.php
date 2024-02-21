<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->integer('sort')->nullable()->index();
            $table->string('sort_hierarchy', 8)->nullable()->index();
            $table->foreignUlid('parent_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $generateTriggerSortHierarchy = fn ($name, $condition, $record) => <<<SQL
            CREATE TRIGGER $name $condition ON `navigations` FOR EACH ROW
            BEGIN
                IF NEW.parent_id IS NULL THEN
                    SET NEW.sort_hierarchy = CONCAT(NEW.sort, "-0");
                ELSE
                    SET NEW.sort_hierarchy = CONCAT((SELECT sort FROM navigations WHERE id = IFNULL(NEW.parent_id, $record.parent_id) LIMIT 1), "-", IFNULL(NEW.sort, $record.sort));
                END IF;
            END;
        SQL;

        DB::unprepared($generateTriggerSortHierarchy('navigations_before_insert', 'BEFORE INSERT', 'NEW'));
        DB::unprepared($generateTriggerSortHierarchy('navigations_before_update', 'BEFORE UPDATE', 'OLD'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigations');
    }
};
