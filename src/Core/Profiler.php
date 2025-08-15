<?php

declare(strict_types=1);

namespace Falcon\Core;

final class Profiler
{
    private const string SYMBOL_RESOLVED = '__section_resolved';
    private const int STORAGE_KEY_LENGTH = 1000;

    private static array $metadataStorage = [];

    public static function dump(mixed $data): void
    {
        $storageKey = self::generateStorageKey();
        self::$metadataStorage[$storageKey] = $data;

        self::renderBufferedStorage($storageKey);
    }

    private static function printIterable(iterable $data): void
    {
        foreach ($data as $idx => $val) {
            if (is_iterable($val)) {
                self::printIterable($val);
            } else {
                echo '<span>' . $idx . '&nbsp;&nbsp;=>&nbsp;&nbsp;' . $val . '</span><br/>';
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
