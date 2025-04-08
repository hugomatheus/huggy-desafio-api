<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        DB::statement(
            "CREATE VIEW contacts_by_city AS
            SELECT 
                ca.state,
                ca.city,
                COUNT(*) AS total
            FROM contacts c
            INNER JOIN contact_addresses ca ON c.id = ca.contact_id
            GROUP BY ca.state, ca.city"
        );
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS contacts_by_city');
    }
};
