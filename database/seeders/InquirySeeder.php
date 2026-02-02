<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat 1 Data Spesifik (Buat Test Search: "Client Project")
        Inquiry::create([
            'name' => 'Budi Santoso (Client VIP)',
            'email' => 'budi.vip@example.com',
            'phone' => '081234567890',
            'subject' => 'Penawaran Project Website Company Profile',
            'message' => "Halo Admin Kodebyte,\n\nSaya tertarik dengan jasa pembuatan website. Bisa minta quotation untuk company profile dengan fitur CMS custom?\n\nTerima kasih.",
            'is_read' => false, // Set UNREAD biar muncul badge NEW
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
            'created_at' => now(),
        ]);

        // 2. Buat 1 Data Spam (Buat Test Delete)
        Inquiry::create([
            'name' => 'Prince Nigeria',
            'email' => 'spam@example.com',
            'phone' => '+123456',
            'subject' => 'URGENT BUSINESS PROPOSAL $$$',
            'message' => "Dear Friend, I have 10 Million USD waiting for you...",
            'is_read' => true, // Anggap udah dibaca
            'created_at' => now()->subDays(2),
        ]);

        // 3. Generate 30 Data Random pake Factory
        Inquiry::factory(30)->create();
    }
}