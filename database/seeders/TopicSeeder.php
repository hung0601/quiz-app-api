<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('topics')->insert([
            // Chủ đề về ngôn ngữ
            ["name" => "english"],
            ["name" => "spanish"],
            ["name" => "french"],
            ["name" => "german"],
            ["name" => "chinese"],
            ["name" => "japanese"],
            ["name" => "korean"],
            ["name" => "arabic"],
            ["name" => "portuguese"],
            ["name" => "italian"],
            ["name" => "russian"],
            ["name" => "hindi"],
            ["name" => "mandarin"],
            ["name" => "bengali"],
            ["name" => "urdu"],
            ["name" => "turkish"],
            ["name" => "vietnamese"],
            ["name" => "indonesian"],
            ["name" => "thai"],
            ["name" => "malay"],

            // Chủ đề khác
            ["name" => "animals"],
            ["name" => "mathematics"],
            ["name" => "history"],
            ["name" => "art"],
            ["name" => "music"],
            ["name" => "literature"],
            ["name" => "technology"],
            ["name" => "astronomy"],
            ["name" => "physics"],
            ["name" => "chemistry"],
            ["name" => "biology"],
            ["name" => "environmental-science"],
            ["name" => "medicine"],
            ["name" => "psychology"],
            ["name" => "sociology"],
            ["name" => "economics"],
            ["name" => "political-science"],
            ["name" => "nutrition"],
            ["name" => "fitness"],
            ["name" => "health-and-wellness"],
            ["name" => "cooking"],
            ["name" => "travel"],
            ["name" => "photography"],
            ["name" => "fashion"],
            ["name" => "architecture"],
            ["name" => "film-and-cinema"],
            ["name" => "sports"],
            ["name" => "hobbies"],
            ["name" => "gardening"],
            ["name" => "diy"],
            ["name" => "coding-and-programming"],
            ["name" => "business"],
            ["name" => "entrepreneurship"],
            ["name" => "marketing"],
            ["name" => "finance"],
            ["name" => "leadership"],
            ["name" => "communication-skills"],
            ["name" => "time-management"],
            ["name" => "personal-development"],
            ["name" => "mindfulness"],
            ["name" => "motivation-and-inspiration"],
            ["name" => "self-care"],
            ["name" => "education"],
            ["name" => "space-exploration"],
            ["name" => "robotics"],
            ["name" => "virtual-reality"],
            ["name" => "augmented-reality"],
            ["name" => "blockchain"],
            ["name" => "cybersecurity"],
            ["name" => "data-science"],
            ["name" => "machine-learning"],
            ["name" => "artificial-intelligence"],
            ["name" => "crypto-currencies"],
            ["name" => "blockchain-technology"],
            ["name" => "internet-of-things"],
            ["name" => "nanotechnology"],
            ["name" => "biotechnology"],
            ["name" => "augmented-intelligence"],
            ["name" => "quantum-computing"],
            ["name" => "bioinformatics"],
            ["name" => "neuroscience"],
            ["name" => "bioengineering"],
            ["name" => "green-energy"],
            ["name" => "renewable-energy"],
            ["name" => "sustainable-living"],
            ["name" => "climate-change"],
            ["name" => "oceanography"],
            ["name" => "archaeology"],
            ["name" => "anthropology"],
            ["name" => "sustainable-architecture"],
            ["name" => "urban-planning"],
            ["name" => "philanthropy"],
            ["name" => "nonprofit-organizations"],
            ["name" => "social-justice"],
            ["name" => "equality-and-diversity"],
            ["name" => "global-development"],
            ["name" => "community-service"],
            ["name" => "volunteering"],
            ["name" => "public-speaking"],
            ["name" => "negotiation-skills"],
            ["name" => "conflict-resolution"],
            ["name" => "emotional-intelligence"],
            ["name" => "critical-thinking"],
            ["name" => "particle-physics"],
            ["name" => "quantum-mechanics"],
            ["name" => "astrophysics"],
            ["name" => "cosmology"],
            ["name" => "astrobiology"],
            ["name" => "biochemistry"],
            ["name" => "genetics"],
            ["name" => "ecology"],
            ["name" => "marine-biology"],
            ["name" => "ornithology"],
            ["name" => "zoology"],
            ["name" => "botany"],
            ["name" => "microbiology"],
            ["name" => "virology"],
            ["name" => "psychophysics"],
            ["name" => "cognitive-neuroscience"],
            ["name" => "materials-science"],
            ["name" => "bioinformatics"],
            ["name" => "psychology"],
            ["name" => "geology"],
            ["name" => "meteorology"],
            ["name" => "oceanography"],
            ["name" => "environmental-science"],
            ["name" => "agricultural-science"],
            ["name" => "food-science"],
            ["name" => "neurobiology"],
            ["name" => "pharmacology"],
            ["name" => "immunology"],
            ["name" => "toxicology"],
            ["name" => "environmental-chemistry"],
            ["name" => "computational-science"],
            ["name" => "social-sciences"],
            ["name" => "cognitive-science"],
            ["name" => "political-economy"],
            ["name" => "systems-biology"],
            ["name" => "applied-physics"],
            ["name" => "earth-science"],
            ["name" => "nanoscience"],
            ["name" => "rainforests"],
            ["name" => "deserts"],
            ["name" => "mountains"],
            ["name" => "rivers"],
            ["name" => "oceans"],
            ["name" => "lakes"],
            ["name" => "islands"],
            ["name" => "volcanoes"],
            ["name" => "caves"],
            ["name" => "glaciers"],
            ["name" => "wildlife-conservation"],
            ["name" => "biodiversity"],
            ["name" => "ecosystems"],
            ["name" => "natural-disasters"],
            ["name" => "climate"],
            ["name" => "weather-patterns"],
            ["name" => "flora-and-fauna"],
            ["name" => "wildflowers"],
            ["name" => "birds-of-prey"],
            ["name" => "coral-reefs"],
            ["name" => "underwater-world"],
            ["name" => "tropical-fish"],
            ["name" => "butterflies"],
            ["name" => "national-parks"],
            ["name" => "countryside"],
            ["name" => "landscape-photography"],
            ["name" => "sunset"],
            ["name" => "sunrise"],
            ["name" => "stargazing"],
            ["name" => "auroras"],
            ["name" => "natural-wonders"],
            ["name" => "botanical-gardens"],
            ["name" => "environmental-conservation"],
            ["name" => "sustainable-living"],
            ["name" => "green-spaces"],
            ["name" => "forest-ecology"],
            ["name" => "biomes"],
            ["name" => "arid-regions"],
            ["name" => "marine-life"],
        ]);
    }
}
