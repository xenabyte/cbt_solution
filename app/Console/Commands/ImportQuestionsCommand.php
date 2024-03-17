<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;
use App\Models\Option;

class ImportQuestionsCommand extends Command
{
    protected $signature = 'import:questions {file}';

    protected $description = 'Import questions from a text file';

    public function handle()
    {
        $filePath = $this->argument('file');
        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);

        $currentQuestion = null;

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $parts = explode(':', $line);
            $key = trim($parts[0]);
            $value = trim($parts[1]);

            if ($key === 'question') {
                $currentQuestion = Question::create(['text' => $value]);
            } elseif ($key === 'answer') {
                Option::create([
                    'question_id' => $currentQuestion->id,
                    'option_text' => $value,
                    'is_correct' => true,
                ]);
            } elseif ($key === 'option') {
                Option::create([
                    'question_id' => $currentQuestion->id,
                    'option_text' => $value,
                    'is_correct' => false,
                ]);
            }
        }

        $this->info('Questions imported successfully.');
    }
}
