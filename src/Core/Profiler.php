<?php

declare(strict_types=1);

namespace Falcon\Core;

final class Profiler
{
    private const string SYMBOL_RESOLVED = '__section_resolved';
    private const int STORAGE_KEY_LENGTH = 1000;

    /** @var array<string, mixed>  */
    private static array $metadataStorage = [];

    public static function dump(mixed $data): void
    {
        $storageKey = self::generateStorageKey();
        self::$metadataStorage[$storageKey] = $data;

        self::renderBufferedStorage($storageKey);
    }

    /**
     * @param array<mixed> $data
     * @return void
     */
    private static function printIterable(iterable $data): void
    {
        /** @var int $depthLevel */
        static $depthLevel = 0;

        /**
         * @var int|string $idx
         * @var mixed $val
         */
        foreach ($data as $idx => $val) {
            if (is_iterable($val)) {
                $depthLevel++;

                echo '<span style="padding-left: ' . $depthLevel - 1 . 'rem;">' . $idx . '</span>';
                echo ' (array key)';
                echo '<br/>';

                self::printIterable($val);
            } else {
                assert(is_string($val) || is_int($val));
                if ($depthLevel > 0) {
                    echo '<span style="padding-left: ' . $depthLevel . 'rem;">' . $idx . '&nbsp;&nbsp;=>&nbsp;&nbsp;' . $val . '</span><br/>';
                } else {
                    echo '<span' . '>' . $idx . '&nbsp;&nbsp;=>&nbsp;&nbsp;' . $val . '</span><br/>';
                }
            }
        }
    }

    private static function markMetadataSectionAsResolved(string $storageKey): void
    {
        self::$metadataStorage[$storageKey] = self::SYMBOL_RESOLVED;
    }

    private static function generateStorageKey(): string
    {
        return '__storage_section_key_' . random_bytes(self::STORAGE_KEY_LENGTH);
    }

    private static function renderBufferedStorage(string $storageKey): void
    {
        ob_start();

        foreach (self::$metadataStorage as $section) {
            if ($section === self::SYMBOL_RESOLVED) {
                continue;
            }

            echo "<div style=\"position: relative; top: 0; left: 0; z-index: 999; border: 1px solid yellowgreen; border-radius: .4rem; width: 100%; background-color: lightgoldenrodyellow; margin: .5rem 0; padding: .7rem .4rem; color: black; font-size: 1rem; font-family: monospace;\">";

            if (is_string($section)) {
                echo $section;
            }

            if (is_iterable($section)) {
                self::printIterable($section);
            }

            echo "</div>";
        }

        self::markMetadataSectionAsResolved($storageKey);

        ob_end_flush();
    }
}
