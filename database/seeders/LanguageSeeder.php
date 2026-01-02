<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Language;
use App\Services\LanguageService;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if languages table exists
        if (!Schema::hasTable('languages')) {
            $this->command->error('Languages table does not exist. Please run migrations first.');
            return;
        }
        $languages = [
            [
                'name' => 'English',
                'code' => 'english',
                'display_name' => 'Easy English',
                'module_code' => 'ee',
                'primary_color' => '#2196F3',
                'secondary_color' => '#1976D2',
                'image_path' => '/img/easyenglish.png',
                'notification_owner_id' => '1002',
                'firebase_topic' => 'englishUsers',
                'user_data_table_prefix' => 'ee',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Korean',
                'code' => 'korea',
                'display_name' => 'Easy Korean',
                'module_code' => 'ko',
                'primary_color' => '#FF9800',
                'secondary_color' => '#F57C00',
                'image_path' => '/img/easykorean.png',
                'notification_owner_id' => '1001',
                'firebase_topic' => 'koreaUsers',
                'user_data_table_prefix' => 'ko',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Chinese',
                'code' => 'chinese',
                'display_name' => 'Easy Chinese',
                'module_code' => 'cn',
                'primary_color' => '#F44336',
                'secondary_color' => '#D32F2F',
                'image_path' => '/img/easychinese.png',
                'notification_owner_id' => '1003',
                'firebase_topic' => 'chineseUsers',
                'user_data_table_prefix' => 'cn',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Japanese',
                'code' => 'japanese',
                'display_name' => 'Easy Japanese',
                'module_code' => 'jp',
                'primary_color' => '#9C27B0',
                'secondary_color' => '#7B1FA2',
                'image_path' => '/img/easyjapanese.png',
                'notification_owner_id' => '1004',
                'firebase_topic' => 'japaneseUsers',
                'user_data_table_prefix' => 'jp',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Russian',
                'code' => 'russian',
                'display_name' => 'Easy Russian',
                'module_code' => 'ru',
                'primary_color' => '#4CAF50',
                'secondary_color' => '#388E3C',
                'image_path' => '/img/easyrussian.png',
                'notification_owner_id' => null,
                'firebase_topic' => null,
                'user_data_table_prefix' => 'ru',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($languages as $languageData) {
            // Check if language already exists
            $existing = Language::where('code', $languageData['code'])->first();
            
            if (!$existing) {
                // Create new language
                Language::create($languageData);
                $this->command->info("Created language: {$languageData['display_name']}");
            } else {
                // Update existing language - update all fields from seeder data
                // This ensures consistency with the seeder configuration
                try {
                    $existing->update([
                        'name' => $languageData['name'],
                        'display_name' => $languageData['display_name'],
                        'module_code' => $languageData['module_code'],
                        'primary_color' => $languageData['primary_color'],
                        'secondary_color' => $languageData['secondary_color'],
                        'image_path' => $languageData['image_path'],
                        'notification_owner_id' => $languageData['notification_owner_id'],
                        'firebase_topic' => $languageData['firebase_topic'],
                        'user_data_table_prefix' => $languageData['user_data_table_prefix'],
                        'is_active' => $languageData['is_active'],
                        'sort_order' => $languageData['sort_order'],
                    ]);
                    $this->command->info("Updated language: {$languageData['display_name']}");
                } catch (\Exception $e) {
                    $this->command->error("Failed to update language {$languageData['code']}: " . $e->getMessage());
                }
            }
        }

        // Clear cache
        LanguageService::clearCache();
        
        $this->command->info('Languages seeded successfully!');
    }
}

