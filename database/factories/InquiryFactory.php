<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'subject' => fake()->sentence(rand(3, 6)), // Subjek 3-6 kata
            'message' => fake()->paragraphs(rand(2, 4), true), // Pesan 2-4 paragraf
            
            // 70% kemungkinan pesan "Belum Dibaca" (New)
            // Biar dashboard lo kelihatan sibuk ada notif baru
            'is_read' => fake()->boolean(30), 
            
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            
            // Tanggal dibuat acak dalam 3 bulan terakhir
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
}