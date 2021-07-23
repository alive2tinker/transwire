<?php

namespace alive2tinker\TransWire\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Translate extends Command
{
    /**
     * List of all strings to be translated
     * @var array
     */
    protected $stringsToTranslate = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transwire:translate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all translatable strings and list them in {locale}.json file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //fetch all strings to be translated
        foreach (config('transwire.directories') as $directory) {
            try {
                $directory = new RecursiveDirectoryIterator($directory);
                foreach (new RecursiveIteratorIterator($directory) as $filename => $file) {
                    foreach (config('transwire.extensions') as $extension => $regex) {
                        if (str_ends_with($filename, $extension)) {
                            $file_content = file_get_contents($filename);
                            preg_match_all($regex, $file_content, $matches);
                            foreach ($matches[1] as $match)
                                if ($match !== '' && !in_array($match, $this->stringsToTranslate))
                                    $this->stringsToTranslate[$match] = "";
                            if (isset($matches[2]) && count($matches[2]) > 0)
                                foreach ($matches[2] as $match)
                                    if ($match !== '' && !in_array($match, $this->stringsToTranslate))
                                        $this->stringsToTranslate[$match] = "";
                            break;
                        }
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        //foreach defined locale, find corresponding files
        foreach (config('transwire.locales') as $locale) {
            try {
                $translated_strings = json_decode(file_get_contents('./resources/lang/' . $locale . '.json'), true);
                $this->syncStrings($translated_strings);
                $localeFile = fopen('./resources/lang/' . $locale . '.json', 'w');
                fwrite($localeFile, json_encode($this->stringsToTranslate, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
                fclose($localeFile);
            } catch (\Exception $e) {
                $localeFile = fopen('./resources/lang/' . $locale . '.json', 'w');
                fwrite($localeFile, json_encode($this->stringsToTranslate, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
                fclose($localeFile);
            }
        }
    }

    public function syncStrings($translated)
    {
        foreach ($this->stringsToTranslate as $stringToTranslate) {
            if (in_array($stringToTranslate, $translated)) {
                unset($stringsToTranslate[$stringToTranslate]);
            }
        }
    }
}
