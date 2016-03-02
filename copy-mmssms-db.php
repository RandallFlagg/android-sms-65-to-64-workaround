<?php

// place paths to your files here
$src_path = '';
$dst_path = '';

$src = new SQLite3($src_path);
$dst = new SQLite3($dst_path);

function copy_canonical_addresses() {
    global $src, $dst;
    $q = $src->query("SELECT * FROM canonical_addresses");
    while ($row = $q->fetchArray(SQLITE3_ASSOC)) {
        $dst->query("INSERT INTO canonical_addresses (_id, address) VALUES (".$row['_id'].", '".SQLite3::escapeString($row['address'])."')");
    }
}

function copy_sms() {
    global $src, $dst;
    $q = $src->query("SELECT * FROM sms");
    while ($row = $q->fetchArray(SQLITE3_ASSOC)) {
        $keys = [];
        $values = [];
        foreach ($row as $key => $value) {
            $keys[] = "`".$key."`";
            $values[] = "'".SQLite3::escapeString($value)."'";
        }
        $dst->query("INSERT INTO sms (".implode(', ', $keys).") VALUES (".implode(', ', $values).")");
    }
}

function copy_threads() {
    global $src, $dst;
    $q = $src->query("SELECT * FROM threads");
    while ($row = $q->fetchArray(SQLITE3_ASSOC)) {
        $keys = [];
        $values = [];
        foreach ($row as $key => $value) {
            if ($key == 'unread_message_count') {
                continue;
            }
            $keys[] = "`".$key."`";
            $values[] = "'".SQLite3::escapeString($value)."'";
        }
        $dst->query("INSERT INTO threads (".implode(', ', $keys).") VALUES (".implode(', ', $values).")");
    }
}

function copy_words() {
    global $src, $dst;
    $tables = ['words', 'words_content', 'words_segments', 'words_segdir'];
    foreach ($tables as $table) {
        $q = $src->query("SELECT * FROM {$table}");
        while ($row = $q->fetchArray(SQLITE3_ASSOC)) {
            $keys = [];
            $values = [];
            foreach ($row as $key => $value) {
                $keys[] = "`".$key."`";
                $values[] = "'".SQLite3::escapeString($value)."'";
            }
            $dst->query("INSERT INTO {$table} (".implode(', ', $keys).") VALUES (".implode(', ', $values).")");
        }
    }
}

copy_threads();
copy_words();
copy_sms();
copy_canonical_addresses();
